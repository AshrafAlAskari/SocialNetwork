<?php
namespace social_network\Http\Controllers;

use social_network\User;
use social_network\Opinion;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Session;

use Illuminate\Support\Facades\Log;

class OpinionController extends Controller
{
   public function getOpinions()
   {
      if(Auth::user()->id == 1) {
         $opinions = Opinion::orderBy('created_at', 'desc')->get();
         return view('opinions', ['opinions' => $opinions]);
      }
      else{
         return redirect()->route('dashboard');
      }
   }

   public function postCreateOpinion(Request $request)
   {
      $this->validate($request, [
         'body' => 'required'
      ]);

      $opinion = new Opinion();
      $opinion->body = $request['body'];
      $opinion->save();
   }
}
