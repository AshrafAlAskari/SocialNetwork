@extends('layouts.master')

@section('title')
   Books
@endsection

@section('content')
   @include('includes.message-block')
   <section class="row new-post">
      <div class="col-md-8 col-md-offset-1">
         <header><h3>Offer something?</h3></header>
         <form action="{{ route('book.create') }}" method="post" enctype="multipart/form-data">
            {{csrf_field()}}
            <div class="form-group">
               <label for="title">Title</label>
               <input type="text" name="title" class="form-control" id="title" value="{{old('title')}}">
            </div>
            <div class="form-group">
               <textarea class="form-control" name="body" id="new-book" rows="3" placeholder="Offer details"></textarea>
            </div>
            <div class="form-group">
               <label for="title">Price</label>
               <input type="text" name="price" class="form-control" id="price" value="{{old('price')}}">
            </div>
            <div class="form-group">
               <label for="image">Image (only .jpg)</label>
               <input type="file" name="image" class="form-control" id="image">
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
         </form>
      </div>
   </section>
   <div class="row">
      <header><h3>Offers from other people...</h3></header>
      <br />
      @foreach($books as $book)
         <div class="col-sm-6 col-md-4">
            <div class="thumbnail" data-bookid="{{ $book->id }}">
               <div class="info">
                  Offer by <a href="{{ route('userpage', ['user_id' => $book->user->id]) }}">{{ $book->user->first_name }}</a> on {{ $book->created_at }}
               </div>
               @if (Storage::disk('local')->has($book->book_image))
                  <img src="{{ route('book.image', ['filename' => $book->book_image]) }}" class="img-responsive img-book" />
               @endif
               <div class="caption">
                  <h3>{{ $book->title }}</h3>
                  <p>{{ $book->body }}</p>
                  <div class="clearfix">
                     <div class="pull-left">
                        {{ $book->price }} IQD
                     </div>
                     @if(Auth::user() == $book->user)
                        <a href="{{ route('book.delete', ['book_id' => $book->id]) }}" class="btn btn-primary pull-right" role="button">Delete</a>
                     @endif
                  </div>
               </div>
            </div>
         </div>
      @endforeach
   </div>
@endsection
