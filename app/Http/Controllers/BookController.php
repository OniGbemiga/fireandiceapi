<?php

namespace App\Http\Controllers;

use App\Http\Resources\BookCollection;
use App\Http\Resources\BookResource;
use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    // public function index(Request $request)
    // {
    //     //validate the incoming query
    //     $data = $request->validate([
    //         'name' => 'required|string'
    //     ]);

    //     //query ice and fire external api
    //     $response = Http::get('https://www.anapioficeandfire.com/api/books',[
    //         'name' => $data['name']
    //     ]);

    //     //get response from external api and convert into an array
    //     //and format into the necessary data
    //     if ($response->successful()) {
    //         $new_response = json_decode($response, true);
    //         return response()->json([
    //             'status_code' => 200,
    //             'status' => 'success',
    //             'data' => BookResource::collection($new_response)
    //         ]);
    //     }
    //     else{
    //         return response()->json(['status'=>'error']);
    //     }
    // }

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
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Book  $book
     * @return \Illuminate\Http\Response
     */
    public function destroy(Book $book)
    {
        //
    }
}
