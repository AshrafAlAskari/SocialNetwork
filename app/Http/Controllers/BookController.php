<?php
namespace social_network\Http\Controllers;

use social_network\Book;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Validator;

class BookController extends Controller
{
   public function getBooks()
   {
      $books = Book::orderBy('created_at', 'desc')->get();
      return view('books', compact('books'));
   }

   public function getBookImage($filename)
   {
      $file = Storage::disk('local')->get($filename);
      return new Response($file, 200);
   }

   public function postCreateBook(Request $request)
   {
      $validator = Validator::make($request->all(),[
         'title' => 'required|max:100',
         'body' => 'required|max:150',
         'price' => 'required|max:500000|numeric',
         'image' => 'required'
      ]);
      if($validator->fails())
      return back()->WithErrors($validator->errors()->all())->withInput();

      $book = new Book();
      $book->title = $request->title;
      $book->body = $request->body;
      $book->price = $request->price;
      $message = 'There was an error';
      $file = $request->file('image');
      $random = str_random(16);
      $filename = $random. '.jpg';
      if ($file) {
         $book->book_image = $filename;
         Storage::disk('local')->put($filename, File::get($file));
      }
      if ($request->user()->books()->save($book)) {
         $message = 'Book submitted created!';
      }
      return redirect()->route('books')->with(['message' => $message]);
   }

   public function getDeleteBook($book_id)
   {
      $book = Book::find($book_id)->first();
      if (Auth::user() != $book->user) {
         return redirect()->back();
      }
      $book->delete();
      return redirect()->route('books')->with(['message' => 'Successfully deleted!']);
   }
}
