<?php

namespace App\Http\Controllers;

use App\Http\Resources\BookResource;
use App\Models\Book;
use Illuminate\Http\Request;
class BookController extends Controller
{
    public function index()
    {
        $books = Book::all();

        return response()->json([
                'status_code' => 200,
                'status' => 'success',
                'data' => BookResource::collection($books)
            ]);

    }

    public function store()
    {
        //create a new entry of the form request in the database
        $new_book_entry = Book::create($this->validateRequest());

        //return a response on
        if ($new_book_entry) {
            return response()->json([
                'status_code' => 201,
                'status' => 'success',
                'data' => ['book' => new BookResource($new_book_entry)]
            ]);
        } else {
            return response()->json(['status'=>'error']);
        }

    }

    public function show(Book $book)
    {
        $book = Book::find($book);
        if(is_null($book))
        {
            return $this->sendError('Book not found.');
        }

        return response()->json([
            'status_code' => 200,
            'status' => 'success',
            'data' => BookResource::collection($book)
        ]);

    }

    public function update(Book $book)
    {
        $update_book = Book::find($book->id)->update($this->validateRequest());

        if($update_book)
        {
            $book->refresh();
            return response()->json([
                'status_code' => 200,
                'status' => 'success',
                'message' => 'The book '.$book->name.' was updated successfully',
                'data' => new BookResource($book)
            ]);
        }else {
            return response()->json(['status'=>'error']);
        }
    }

    public function destroy(Book $book)
    {
        $book_names = Book::find($book)->pluck('name');
        foreach ($book_names as $value) {
            $book_name = $value;
        }
        if($book->delete())
        {
            $book->refresh();
            return response()->json([
                'status_code' => 204,
                'status' => 'success',
                'message' => 'The book '.$book_name.' was deleted successfully',
                'data' => []
            ]);
        }else {
            return response()->json(['status'=>'error']);
        }
    }

    //validation function
    private function validateRequest(){
        return request()->validate([
            'name' => 'string|sometimes',
            'isbn' => 'string|sometimes',
            'authors' => 'string|sometimes',
            'number_of_pages' => 'numeric|sometimes',
            'publisher' => 'string|sometimes',
            'country' => 'string|sometimes',
            'release_date' => 'date|sometimes'
        ]);
    }

}
