<?php
namespace social_network\Http\Controllers;

use social_network\Event;
use social_network\User;
use social_network\Going;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class EventController extends Controller
{
   public function getEvent()
   {
      $events = Event::orderBy('created_at', 'desc')->get();

      $bdays = User::orderBy('bday', 'asc')->select('bday', 'id')->get();
      $filteredbdays[0] = "No birthdays";
      if($bdays){
         $j = 0;
         for($i = 0 ; $i < count($bdays) ; $i++) {
            $bdays[$i]->bday = date("d-m", strtotime($bdays[$i]->bday));
            if($bdays[$i]->bday == date('d-m')) {
               $filteredbdays[$j] = $bdays[$i]->id;
               $j++;
            }
         }
      }

      return view('event', ['events' => $events])->with('filteredbdays', $filteredbdays);
   }

   public function postCreateEvent(Request $request)
   {
      $this->validate($request, [
         'body' => 'required|max:1000',
         'date' => 'required|date_format:Y-m-d'
      ]);

      $event = new Event();
      $event->body = $request['body'];
      $event->date = $request['date'];
      $message = 'There was an error';
      if ($request->user()->posts()->save($event)) {
         $message = 'Event successfully created!';
      }
      return redirect()->route('events')->with(['message' => $message]);
   }

   public function getDeleteEvent($event_id)
   {
      $event = Event::where('id', $event_id)->first();
      if (Auth::user() != $event->user) {
         return redirect()->back();
      }
      $event->delete();
      return redirect()->route('events')->with(['message' => 'Successfully deleted!']);
   }

   public function postGoingEvent(Request $request)
   {
      $event_id = $request['eventId'];
      $is_going = $request['isGoing'];

      if ($is_going == "Will go") {
         $is_going = 0;
      } else {
         $is_going = 1;
      }
      $event = Event::find($event_id);
      $user = Auth::user();
      $going = $user->goings()->where('event_id', $event_id)->first();

      if ($going) {
         $already_going = $going->going;
         if ($already_going == $is_going) {
            $going->going = !$is_going;
            $going->update();
         }
      } else {
         $going = new Going();
         $going->going = 1;
         $going->user_id = $user->id;
         $going->event_id = $event->id;
         $going->save();
      }

      $willgo = $event->goings()->where('event_id', $event_id)->first();
      if($willgo) {
         $num_goings = $event->goings()->where('going', 1)->count();
      }
      return response()->json(['num_goings' => $num_goings], 200);
   }
}
