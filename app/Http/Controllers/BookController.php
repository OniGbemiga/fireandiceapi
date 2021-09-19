<?php

namespace App\Http\Controllers;

use App\Http\Resources\BookResource;
use App\Models\Book;
use Illuminate\Http\Request;
class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index()
    {
        $books = Book::all();

        return response()->json([
                'status_code' => 200,
                'status' => 'success',
                'data' => BookResource::collection($books)
            ]);

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'string|required',
            'isbn' => 'string|required',
            'authors' => 'string|required',
            'number_of_pages' => 'numeric|required',
            'publisher' => 'string|required',
            'country' => 'string|required',
            'release_date' => 'date|required'
        ]);

        $new_book_entry = Book::create([
            'name' => $data['name'],
            'isbn' => $data['isbn'],
            'authors' => $data['authors'],
            'number_of_pages' => $data['number_of_pages'],
            'publisher' => $data['publisher'],
            'country' => $data['country'],
            'release_date' => $data['release_date'],
        ]);

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

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Book  $book
     * @return \Illuminate\Http\Response
     */
    public function show(Book $book)
    {
        $book = Book::findorFail($book);
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

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Book  $book
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Book $book)
    {
        // return 'yes'.$book;
        $data = $request->validate([
            'name' => 'string|sometimes',
            'isbn' => 'string|sometimes',
            'authors' => 'string|sometimes',
            'number_of_pages' => 'numeric|sometimes',
            'publisher' => 'string|sometimes',
            'country' => 'string|sometimes',
            'release_date' => 'date|sometimes'
        ]);

        return $request->name;

        $update_book = Book::find($book->id);
        $update_book->name = $data['name'];
        $update_book->isbn = $data['isbn'];
        $update_book->authors = $data['authors'];
        $update_book->number_of_pages = $data['number_of_pages'];
        $update_book->publisher = $data['publisher'];
        $update_book->country = $data['country'];
        $update_book->release_date = $data['release_date'];

        if($update_book->save())
        {
            return response()->json([
                'status_code' => 200,
                'status' => 'success',
                'message' => 'The book '.$update_book->name.' was updated successfully',
                'data' => ['book' => new BookResource($update_book)]
            ]);
        }else {
            return response()->json(['status'=>'error']);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Book  $book
     * @return \Illuminate\Http\Response
     */
    public function destroy(Book $book)
    {
        $book_names = Book::find($book)->pluck('name');
        foreach ($book_names as $value) {
            $book_name = $value;
        }
        if($book->delete())
        {
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

}
