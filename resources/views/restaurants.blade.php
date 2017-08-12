@extends('layouts.master')

@section('title')
   restaurants
@endsection

@section('content')
   @include('includes.message-block')
   @if(Auth::user()->id == 1)
      <section class="row new-post">
         <div class="col-md-8 col-md-offset-1">
            <header><h3>Add a restaurant</h3></header>
            <form action="{{ route('restaurant.create') }}" method="post" enctype="multipart/form-data">
               {{csrf_field()}}
               <div class="form-group">
                  <label for="title">Title</label>
                  <input type="text" name="title" class="form-control" id="title">
               </div>
               <div class="form-group">
                  <textarea class="form-control" name="address" id="new-restaurant" rows="3" placeholder="Restaurant address"></textarea>
               </div>
               <div class="form-group">
                  <label for="title">Mobile</label>
                  <input type="text" name="mobile" class="form-control" id="mobile">
               </div>
               <button type="submit" class="btn btn-primary">Add</button>
            </form>
         </div>
      </section>
   @endif
   <section class="row posts">
      <div class="col-md-8 col-md-offset-1">
         <header><h3>Restaurants...</h3></header>
         @foreach($restaurants as $restaurant)
            <article class="post" data-postid="{{ $restaurant->id }}">
               <div>
                  <p><strong>Restaurant name: </strong>{{ $restaurant->title }}</p>
                  <p><strong>Address: </strong>{{ $restaurant->address}}</p>
                  <p><strong>Mobile: </strong>{{ $restaurant->mobile}}</p>
                  <div class="interaction">
                     @if(Auth::user()->id == 1)
                        <a href="{{ route('restaurant.delete', ['restaurant_id' => $restaurant->id]) }}">Delete</a>
                     @endif
                  </div>
               </div>
            </article>
         @endforeach
      </div>
   </section>
@endsection
