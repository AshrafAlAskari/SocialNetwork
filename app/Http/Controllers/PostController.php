<?php
namespace social_network\Http\Controllers;

use social_network\Like;
use social_network\Post;
use social_network\User;
use social_network\Comment;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{
   public function getDashboard()
   {
      $posts = Post::orderBy('created_at', 'desc')->get();
      $comments = Comment::orderby('created_at', 'asc')->get();

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
   return view('dashboard', ['posts' => $posts], ['comments' => $comments])->with('filteredbdays', $filteredbdays);
}

public function getPostImage($filename)
{
    $file = Storage::disk('local')->get($filename);
    return new Response($file, 200);
}

public function getUserPage($user_id)
{
   $posts = Post::orderBy('created_at', 'desc')->where('user_id', $user_id)->get();
   $comments = Comment::orderby('created_at', 'asc')->get();
   return view('userpage', ['posts' => $posts], ['comments' => $comments])->with(['user_id' => $user_id]);
}

public function postCreatePost(Request $request)
{
   $this->validate($request, [
      'body' => 'required|max:1000'
   ]);
   $post = new Post();
   $post->body = $request['body'];
   $message = 'There was an error';
   $file = $request->file('image');
   $random = str_random(16);
   $filename = $random. '.jpg';
   if ($file) {
      $post->post_image = $filename;
       Storage::disk('local')->put($filename, File::get($file));
   }
   if ($request->user()->posts()->save($post)) {
      $message = 'Post successfully created!';
   }
   return redirect()->route('dashboard')->with(['message' => $message]);
}

public function getDeletePost($post_id)
{
   $post = Post::where('id', $post_id)->first();
   if (Auth::user() != $post->user) {
      return redirect()->back();
   }
   $post->delete();
   return redirect()->route('dashboard')->with(['message' => 'Successfully deleted!']);
}

public function postEditPost(Request $request)
{
   $this->validate($request, [
      'body' => 'required'
   ]);
   $post = Post::find($request['postId']);
   if (Auth::user() != $post->user) {
      return redirect()->back();
   }
   $post->body = $request['body'];
   $post->update();
   return response()->json(['new_body' => $post->body], 200);
}

public function postLikePost(Request $request)
{
   $post_id = $request['postId'];
   $is_like = $request['isLike'];
   if ($is_like == "Like") {
      $is_like = 0;
   } else {
      $is_like = 1;
   }
   $post = Post::find($post_id);
   $user = Auth::user();
   $like = $user->likes()->where('post_id', $post_id)->first();
   if ($like) {
      $already_like = $like->like;
      if ($already_like == $is_like) {
         $like->like = !$is_like;
         $like->update();
      }
   } else {
      $like = new Like();
      $like->like = 1;
      $like->user_id = $user->id;
      $like->post_id = $post->id;
      $like->save();
   }

   $liked = $post->likes()->where('post_id', $post_id)->first();
   if($liked) {
      $num_likes = $post->likes()->where('like', 1)->count();
   }
   return response()->json(['num_likes' => $num_likes], 200);
}

public function postCreateComment(Request $request)
{
   $this->validate($request, [
      'comment' => 'required|max:1000'
   ]);
   $comment = new Comment();
   $comment->comment = $request['comment'];
   $comment->post_id = $request['c_post_id'];
   $message = 'There was an error';
   if ($request->user()->comments()->save($comment)) {
      $message = 'Commented  successfully!';
   }
   return redirect()->route('dashboard')->with(['message' => $message]);
}
}
