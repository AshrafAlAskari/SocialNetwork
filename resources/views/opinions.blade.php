@extends('layouts.master')
@section('content')
   <div id="wrapper">
      <div id="page-content-wrapper">
         <section class="row posts">
            <div class="col-md-8 col-md-offset-1">
               <header><h3>Opinions...</h3></header>
               @foreach($opinions as $opinion)
                  <article class="post" data-postid="{{ $opinion->id }}">
                     <div>
                        <p>{{ $opinion->body }}</p>
                        <div class="info">
                           Posted by Anonymous on {{ $opinion->created_at }}
                        </div>
                     </div>
                  </article>
               @endforeach
            </div>
         </section>
      </div>
   </div>
@endsection
