@extends('layouts.master')

@section('title')
   Events
@endsection

@section('content')
   @include('includes.message-block')
   <section class="row new-post">
      <div class="col-md-8 col-md-offset-1">
         <header><h3>Create event</h3></header>
         <form action="{{ route('event.create') }}" method="post">
            {{csrf_field()}}
            <div class="form-group">
               <textarea class="form-control" name="body" id="new-event" rows="3" placeholder="Your Event Description"></textarea>
            </div>
            <div id="datepicker" class="input-group date">
               <input type="text" class="form-control" name="date"><span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
            </div>
            <br />
            <button type="submit" class="btn btn-primary">Create Event</button>
         </form>
      </div>
   </section>
   <section class="row posts">
      <div class="col-md-8 col-md-offset-1">
         <header><h3>Events...</h3></header>
         @foreach($events as $event)
            <article class="post" data-eventid="{{ $event->id }}">
               @if (Storage::disk('local')->has($event->user->id . '.jpg'))
                  <img src="{{ route('account.image', ['filename' => $event->user->id . '.jpg']) }}" alt="" class="img-post">
               @else
                  <img src="{{ route('account.image', ['filename' => 'no-pic.jpg']) }}" alt="" class="img-post">
               @endif
               <div class="margin60">
                  <p>{{ $event->body }}</p>
                  <p>Event Date: {{ $event->date }}</p>
                  <div class="info">
                     Posted by <a href="{{ route('userpage', ['user_id' => $event->user->id]) }}">{{ $event->user->first_name }}</a> on {{ $event->created_at }}
                  </div>
                  <div class="interaction">
                     <div>
                        {{ DB::table('goings')->where([['event_id', $event->id],['going', 1]])->count() }} will go to this event.<br />
                     </div>
                     <a href="#" class="going">{{ Auth::user()->goings()->where('event_id', $event->id)->first() ? Auth::user()->goings()->where('event_id', $event->id)->first()->going == 1 ? 'Going' : 'Will go' : 'Will go' }}</a>
                     @if(Auth::user() == $event->user)
                        |
                        <a href="{{ route('event.delete', ['event_id' => $event->id]) }}">Delete</a>
                     @endif
                  </div>
               </div>
            </article>
         @endforeach
      </div>
   </section>

   <script>
   var urlGoing = '{{ route('going') }}';
   </script>
@endsection
