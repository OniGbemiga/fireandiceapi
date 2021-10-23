<?php

namespace Tests\Feature;

use App\Models\Book;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Response;
use Tests\TestCase;

class BookApiTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_can_read_book()
    {
        $response = $this->json('get','api/v1/books');
        $response->assertStatus(Response::HTTP_OK)
                ->assertJsonStructure([
                    "status_code",
                    "status",
                    "data" => [
                        '*' => [
                            "id",
                            "name",
                            "isbn",
                            "authors",
                            "number_of_pages",
                            "publisher",
                            "country",
                            "release_date"
                        ]
                    ]
        ]);
    }

    public function test_can_search_book()
    {
        $search = 'dog';

        $response = $this->json('get','api/v1/books',['params',$search]);
        $response->assertStatus(Response::HTTP_OK)
                ->assertJsonStructure([
                    "status_code",
                    "status",
                    "data" => [
                        '*' => [
                            "id",
                            "name",
                            "isbn",
                            "authors",
                            "number_of_pages",
                            "publisher",
                            "country",
                            "release_date"
                        ]
                    ]
        ]);
    }

    public function test_can_create_book()
    {
        $books = [
            'name' => 'Timothy Ajayi',
            'isbn' => '123-3213243567',
            'authors' => 'Jane Doe',
            'number_of_pages' => '3500',
            'publisher' => 'Acme Books',
            'country' => 'United States',
            'release_date' => '2019-08-01'
        ];


        $response = $this->json('post','api/v1/books',$books);

        $response->assertStatus(Response::HTTP_CREATED)
                    ->assertJsonStructure([
                        "status_code",
                        "status",
                        "data" => [
                            "book" => [
                                "name",
                                "isbn",
                                "authors",
                                "number_of_pages",
                                "publisher",
                                "country",
                                "release_date"
                            ]
                        ]
                    ]);
        $this->assertDatabaseHas('books', $books);
    }

    public function test_can_show_book()
    {
        $books = Book::create([
            'name' => 'Bankole Emi',
            'isbn' => '123-3213243567',
            'authors' => 'Jummy Paul',
            'number_of_pages' => 30,
            'publisher' => 'Macmillian',
            'country' => 'Angola',
            'release_date' => '1290-08-01'
        ]);

        $response = $this->json('get',"api/v1/books/$books->id");

        $response->assertStatus(Response::HTTP_OK)
                ->assertExactJson([
                    "status_code" => 200,
                    "status" => 'success',
                    "data" => [
                        "id" => $books->id,
                        "name" => $books->name,
                        "isbn" => $books->isbn,
                        "authors" => (array) $books->authors,
                        "number_of_pages" => $books->number_of_pages,
                        "publisher" => $books->publisher,
                        "country" => $books->country,
                        "release_date" => $books->release_date
                    ]
                ]);
    }

    public function test_can_update_book()
    {
        $books = Book::create([
            'name' => 'Bankole Emi',
            'isbn' => '123-3213243567',
            'authors' => 'Jummy Paul',
            'number_of_pages' => 30,
            'publisher' => 'Macmillian',
            'country' => 'Angola',
            'release_date' => '1290-08-01'
        ]);

        $update = [
            'name' => 'Old Name',
            'publisher' => 'New Name',
            'release_date' => '3490-12-01'
        ];

        $response = $this->json('put',"api/v1/books/$books->id",$update);
        $books->refresh();
        $response->assertStatus(Response::HTTP_OK)
                ->assertExactJson([
                    "status_code" => 200,
                    "status" => 'success',
                    "message" => "The book $books->name was updated successfully",
                    "data" => [
                            "id" => $books->id,
                            "name" => $update['name'],
                            "isbn" => $books->isbn,
                            "authors" => (array) $books->authors,
                            "number_of_pages" => $books->number_of_pages,
                            "publisher" => $update['publisher'],
                            "country" => $books->country,
                            "release_date" => $update['release_date']
                    ]
                ]);
    }

    public function test_can_delete_book()
    {
        $books = [
            'name' => 'Delete Book',
            'isbn' => '123-3213243567',
            'authors' => 'Jummy Paul',
            'number_of_pages' => 30,
            'publisher' => 'Macmillian',
            'country' => 'Angola',
            'release_date' => '1290-08-01'
        ];

        $delete_book = Book::create($books);

        $response = $this->json('delete',"api/v1/books/$delete_book->id");
        $response->assertStatus(Response::HTTP_OK)
                ->assertExactJson([
                    "status_code" => 204,
                    "status" => 'success',
                    "message" => "The book $delete_book->name was deleted successfully",
                    "data" => []
                ]);
        $this->assertDatabaseMissing('books', $books);
    }
}
