<?php
namespace social_network\Http\Controllers;

use social_network\Opinion;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Validator;

class OpinionController extends Controller
{
   public function getOpinions()
   {
      if(Auth::user()->id == 1) {
         $opinions = Opinion::orderBy('created_at', 'desc')->get();
         return view('opinions', compact('opinions'));
      }
      else{
         return redirect()->route('dashboard');
      }
   }

   public function postCreateOpinion(Request $request)
   {
      $validator = Validator::make($request->all(),[
         'body' => 'required|max:1000'
      ]);
      $opinion = new Opinion();
      $opinion->body = $request->body;
      $opinion->save();
   }
}
