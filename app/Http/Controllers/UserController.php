<?php
namespace social_network\Http\Controllers;

use social_network\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Validator;

class UserController extends Controller
{
   public function postSignUp(Request $request)
   {
      $validator = Validator::make($request->all(),[
         'email' => 'required|email|max:30|unique:users',
         'first_name' => 'required|max:120',
         'password' => 'required|min:4',
      ]);
      if($validator->fails())
      return back()->WithErrors($validator->errors()->all())->withInput();

      $email = $request->email;
      $first_name = $request->first_name;
      $password = bcrypt($request->password);

      $user = new User();
      $user->email = $email;
      $user->first_name = $first_name;
      $user->password = $password;
      if($user->save()) {
         Auth::login($user);
         return redirect()->route('dashboard');
      }
      $alert = "Sign up failed";
      redirect()->back()->with(['alert' => $alert]);
   }

   public function postSignIn(Request $request)
   {
      $validator = Validator::make($request->all(),[
         'email' => 'required|max:30',
         'password' => 'required|min:4'
      ]);
      if($validator->fails())
      return back()->WithErrors($validator->errors()->all())->withInput();

      if (Auth::attempt(['email' => $request->email, 'password' => $request->password]))
      return redirect()->route('dashboard');

      $alert = "Email or password or both are not correct";
      return redirect()->back()->with(['alert' => $alert]);
   }

   public function getLogout()
   {
      Auth::logout();
      return redirect()->route('home');
   }

   public function getAccount()
   {
      return view('account', ['user' => Auth::user()]);
   }

   public function postSaveAccount(Request $request)
   {
      $validator = Validator::make($request->all(),[
         'first_name' => 'required|max:120'
      ]);
      if($validator->fails())
      return back()->WithErrors($validator->errors()->all())->withInput();

      $user = Auth::user();
      $old_name = $user->first_name;
      $user->first_name = $request->first_name;
      $user->update();
      $file = $request->file('image');
      $filename = $user->id . '.jpg';
      $old_filename = $user->id . '.jpg';
      $update = false;
      if (Storage::disk('local')->has($old_filename)) {
         $old_file = Storage::disk('local')->get($old_filename);
         Storage::disk('local')->put($filename, $old_file);
         $update = true;
      }
      if ($file) {
         Storage::disk('local')->put($filename, File::get($file));
      }
      if ($update && $old_filename !== $filename) {
         Storage::delete($old_filename);
      }
      return redirect()->route('account');
   }

   public function getUserImage($filename)
   {
      $file = Storage::disk('local')->get($filename);
      return new Response($file, 200);
   }
}
