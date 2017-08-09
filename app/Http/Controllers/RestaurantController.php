<?php
namespace social_network\Http\Controllers;

use social_network\Restaurant;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Session;

use Illuminate\Support\Facades\Log;

class RestaurantController extends Controller
{
   public function getRestaurants()
   {
      $restaurants = Restaurant::orderBy('created_at', 'desc')->get();
      return view('restaurants', ['restaurants' => $restaurants]);
   }

   public function postCreateRestaurant(Request $request)
   {
      $this->validate($request, [
         'title' => 'required|max:100',
         'address' => 'required|max:150',
         'mobile' => 'required|max:50'
      ]);
      $restaurant = new Restaurant();
      $restaurant->title = $request['title'];
      $restaurant->address = $request['address'];
      $restaurant->mobile = $request['mobile'];
      $message = 'There was an error';
      if ($restaurant->save()) {
         $message = 'Restaurant added created!';
      }
      return redirect()->route('restaurants')->with(['message' => $message]);
   }

   public function getDeleteRestaurant($restaurant_id)
   {
      $restaurant = Restaurant::where('id', $restaurant_id)->first();
      if (Auth::user() != 1) {
         return redirect()->back();
      }
      $restaurant->delete();
      return redirect()->route('restaurants')->with(['message' => 'Successfully deleted!']);
   }
}
