@extends('layouts.master')
@section('content')
   <div id="wrapper" class="toggled">
      <div id="sidebar-wrapper">
         <div class="profile">
            @if (Storage::disk('local')->has($user_id . '.jpg'))
               <img src="{{ route('account.image', ['filename' => $user_id . '.jpg']) }}" alt="" class="img-profile">
            @else
               <img src="{{ route('account.image', ['filename' => 'no-pic.jpg']) }}" alt="" class="img-profile">
            @endif
            <br />
            <h1> {{ $user_name = DB::table('users')->where('id', $user_id)->first()->first_name }} </h1>
            <p>
               <strong>College: </strong>{{ $college = DB::table('users')->where('id', $user_id)->first()->college }}
               <br />
               <strong>Department: </strong>{{ $department = DB::table('users')->where('id', $user_id)->first()->department }}
            </p>
         </div>
      </div>

      <div id="page-content-wrapper">
         @include('includes.message-block')
         @if(Auth::user()->id == $user_id)
            <section class="row new-post">
               <div class="col-md-8 col-md-offset-1">
                  <header><h3>What do you have to say?</h3></header>
                  <form action="{{ route('post.create') }}" method="post">
                     <div class="form-group">
                        <textarea class="form-control" name="body" id="new-post" rows="3" placeholder="Your Post"></textarea>
                     </div>
                     <button type="submit" class="btn btn-primary">Create Post</button>
                     <input type="hidden" value="{{ Session::token() }}" name="_token">
                  </form>
               </div>
            </section>
         @endif
         <section class="row posts">
            <div class="col-md-8 col-md-offset-1">
               @if($posts->count() != 0)
                  <header><h3>Posts</h3></header>
                  @foreach($posts as $post)
                     <article class="post" data-postid="{{ $post->id }}">
                        @if (Storage::disk('local')->has($post->user->id . '.jpg'))
                           <img src="{{ route('account.image', ['filename' => $post->user->id . '.jpg']) }}" alt="" class="img-post">
                        @else
                           <img src="{{ route('account.image', ['filename' => 'no-pic.jpg']) }}" alt="" class="img-post">
                        @endif
                        <div class="margin60">
                           <p>{{ $post->body }}</p>
                           <div class="info">
                              Posted by {{ $post->user->first_name }} on {{ $post->created_at }}
                           </div>
                           <div class="interaction">
                              <div>
                                 {{ DB::table('likes')->where([['post_id', $post->id],['like', 1]])->count() }} likes this post.<br />
                              </div>
                              <a href="#" class="like">{{ Auth::user()->likes()->where('post_id', $post->id)->first() ? Auth::user()->likes()->where('post_id', $post->id)->first()->like == 1 ? 'Dislike' : 'Like' : 'Like' }}</a>
                              @if(Auth::user() == $post->user)
                                 |
                                 <a href="#" class="edit">Edit</a> |
                                 <a href="{{ route('post.delete', ['post_id' => $post->id]) }}">Delete</a>
                              @endif
                           </div>


                           <hr />

                           <div class="comments">
                              @foreach ($comments as $comment)
                                 @if($post->id == $comment->post_id)
                                    <div class="comment">
                                       @if (Storage::disk('local')->has($comment->user->id . '.jpg'))
                                          <img src="{{ route('account.image', ['filename' => $comment->user->id . '.jpg']) }}" alt="" class="img-comment">
                                       @else
                                          <img src="{{ route('account.image', ['filename' => 'no-pic.jpg']) }}" alt="" class="img-comment">
                                       @endif
                                       <a href="{{ route('userpage', ['user_id' => $comment->user->id]) }}">{{ $comment->user->first_name }}</a>
                                       <p>{{ $comment->comment}}</p>
                                       <div class="info">
                                          at {{ $comment->created_at }}
                                       </div>
                                    </div>
                                 @endif

                              @endforeach
                           </div>

                           <form action="{{ route('comment.create') }}" method="post">
                              <div class="input-group">
                                 <input class="form-control" type="text" name="comment" id="new-comment" />
                                 <span class="input-group-btn"><button type="submit" class="btn btn-primary">Comment</button></span>
                              </div>
                              <input type="hidden" value="{{ $post->id}}" name="c_post_id"/>
                              <input type="hidden" value="{{ Session::token() }}" name="_token">
                           </form>

                        </div>
                     </article>
                  @endforeach
               @else
                  <header><h3>No posts yet..</h3></header>
               @endif
            </div>
         </section>
      </div>

      <div class="modal fade" tabindex="-1" role="dialog" id="edit-modal">
         <div class="modal-dialog">
            <div class="modal-content">
               <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                  <h4 class="modal-title">Edit Post</h4>
               </div>
               <div class="modal-body">
                  <form>
                     <div class="form-group">
                        <label for="post-body">Edit the Post</label>
                        <textarea class="form-control" name="post-body" id="post-body" rows="5"></textarea>
                     </div>
                  </form>
               </div>
               <div class="modal-footer">
                  <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                  <button type="button" class="btn btn-primary" id="modal-save">Save changes</button>
               </div>
            </div><!-- /.modal-content -->
         </div><!-- /.modal-dialog -->
      </div><!-- /.modal -->

      <script>
      var token = '{{ Session::token() }}';
      var urlEdit = '{{ route('edit') }}';
      var urlLike = '{{ route('like') }}';
      </script>
   </div>
@endsection
