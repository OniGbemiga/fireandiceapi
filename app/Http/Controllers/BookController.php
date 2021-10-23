<?php

namespace App\Http\Controllers;

use App\Http\Resources\BookResource;
use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class BookController extends Controller
{
    public function index(Request $request)
    {
        //Query the database and store it in cache to make it faster
        // return Cache::remember('books', 300, function () use ($request) {

            $search = $request->search;

            $books = Book::query()
                    ->where('name', 'LIKE', "%{$search}%")
                    ->orWhere('country', 'LIKE', "%{$search}%")
                    ->orWhere('publisher', 'LIKE', "%{$search}%")
                    ->orWhere('release_date', 'LIKE', "%{$search}%")
                    ->get();

            return response()->json([
                    'status_code' => 200,
                    'status' => 'success',
                    'data' => BookResource::collection($books)
                ]);
        // });

    }

    public function store()
    {
        //create a new entry of the form request in the database
        $new_book_entry = Book::create($this->validateRequest());

        //return a response on created
        if ($new_book_entry) {
            return response()->json([
                'status_code' => 201,
                'status' => 'success',
                'data' => ['book' => new BookResource($new_book_entry)]
            ],201);
        } else {
            return response()->json(['status'=>'error']);
        }

    }

    public function show(Book $book)
    {
        //find a specific book
        $book = Book::find($book)->first();

        //if the book does not exist return a response
        if(is_null($book))
        {
            return $this->sendError('Book not found.');
        }

        //return a success status if the book exist
        return response()->json([
            'status_code' => 200,
            'status' => 'success',
            'data' => new BookResource($book)
        ]);

    }

    public function update(Book $book)
    {
        //find a book and update it
        $update_book = Book::find($book->id)->update($this->validateRequest());

        //return a response if book was updated
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
        //get the name of the book to be deleted
        $book_names = Book::find($book)->pluck('name');
        foreach ($book_names as $value) {
            $book_name = $value;
        }

        //delete the book and return a response
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
