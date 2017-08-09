@extends('layouts.master')
@section('content')
   <div id="wrapper">
      <div id="sidebar-wrapper">
         <div class="birthdays">
            <ul>
               <li>
                  <strong>Birthdays today:</strong>
               </li>
               @if($filteredbdays[0] != "No birthdays")
                  @foreach ($filteredbdays as $bdays)
                     <li>
                        @if (Storage::disk('local')->has($bdays . '.jpg'))
                           <img src="{{ route('account.image', ['filename' => $bdays . '.jpg']) }}" alt="" class="img-bday">
                        @else
                           <img src="{{ route('account.image', ['filename' => 'no-pic.jpg']) }}" alt="" class="img-bday">
                        @endif
                        <a href="{{ route('userpage', ['user_id' => $bdays]) }}"><strong>{{ DB::table('users')->where('id', $bdays)->first()->first_name }}</strong></a>
                     </li>
                  @endforeach
               @else
                  <li>
                     {{ $filteredbdays[0] }}
                  </li>
               @endif
            </ul>
         </div>
      </div>
      <div id="page-content-wrapper">
         @include('includes.message-block')
         <div id="menu-toggle" class="glyphicon glyphicon-menu-left" aria-hidden="true"></div>
         <section class="row new-post">
            <div class="col-md-8 col-md-offset-1">
               <header><h3>Create event</h3></header>
               <form action="{{ route('event.create') }}" method="post">
                  <div class="form-group">
                     <textarea class="form-control" name="body" id="new-event" rows="3" placeholder="Your Event Description"></textarea>
                  </div>

                  <div id="datepicker" class="input-group date">
                     <input type="text" class="form-control" name="date"><span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
                  </div>

                  <br />
                  <button type="submit" class="btn btn-primary">Create Event</button>

                  <input type="hidden" value="{{ Session::token() }}" name="_token">
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
                           |
                           <a href="{{ route('event.delete', ['event_id' => $event->id]) }}">Delete</a>
                        </div>
                     </div>
                  </article>
               @endforeach
            </div>
         </section>
      </div>

      <script>
      var token = '{{ Session::token() }}';
      var urlGoing = '{{ route('going') }}';
      </script>
   </div>
@endsection
