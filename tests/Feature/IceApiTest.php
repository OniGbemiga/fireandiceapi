<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Response;
use Tests\TestCase;

class IceApiTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_query_iceandfireapi()
    {
        $name = 'A Clash of Kings';

        $response = $this->json('get','api/external-books',['name' => $name]);

        $response->assertStatus(Response::HTTP_OK)
                ->assertJsonStructure([
                    "status_code",
                    "status",
                    "data" => [
                        '*' => [
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
}
