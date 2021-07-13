<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BookController extends Controller
{
    // CREATE BOOK API - POST REQUEST
    public function createBook(Request $request){

       $data = $request->validate([
           'title' => 'required',
           'description' => 'required',
           'cost' => 'required'
       ]);

       $book = new Book();
       $book->create($data + ['author_id' => Auth::user()->id]);

       return response()->json([
           'status' => '1',
           'message' => 'Book created successfully'
       ]);
    }

    // CREATE LIST BOOK API - GET REQUEST
    public function ListBook(){

      // FIND AUTHOR DETAILS
      $author = Auth::user();

      // FIND CURRENT AUTHOR BOOKS
      $books = $author->books;

      // SEND RESPONSE
      if(count($books)){

        return response()->json([
            'status' => 1,
            'message' => 'list books deatils',
            'data' => $books
        ]);

      }
      return response()->json([
          'status' => 0,
          'message' => 'books not found'
      ]);

    }

    // CREATE SINGLE BOOK API - GET REQUEST
    public function singleBook($id){

        //FIND AUTHOR ID
        $author_id = Auth::user()->id;

        if(Book::where(['id' => $id, 'author_id' => $author_id])->exists()){

            $book = Book::find($id);
            return response()->json([
                'status' => 1,
                'message' => 'Get book details',
                'data' => $book
            ]);
        }
        return response()->json([
            'status' => 0,
            'message' => 'Book not found'
        ],404);
    }

    // CREATE UPDATE API - POST API
    public function updateBook(Request $request, $id){

        $data = $request->validate([
            'title' => 'required',
            'description' => 'required',
            'cost' => 'required'
        ]);

        $author_id = Auth::user()->id;
        
        if(Book::where(['id' => $id, 'author_id' => $author_id])->exists()){

            $book = Book::where(['id' => $id, 'author_id' => $author_id])->first();

            $book->update($data);

            return response()->json([
                'status' => 1,
                'message' => 'Book updated successfully'
            ]);
        }

        return response()->json([
            'status' => 0,
            'message' => 'Author book doesnt exists'
        ]);

    }

    // CREATE DELETE API - GET REQUEST
    public function deleteBook($id){
        // FIND AUTHOR ID
        $author_id = Auth::user()->id;

        if(Book::where(['id' => $id, 'author_id' => $author_id])->exists()){
            $book = Book::find($id);
            $book->delete();

            return response()->json([
                'status' => 1,
                'message' => 'Book deleted successfully'
            ]);
        }

        return response()->json([
            'status' => 0,
            'message' => 'Book not found'
        ]);
    }
}
