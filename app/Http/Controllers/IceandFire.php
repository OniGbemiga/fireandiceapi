<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Http\Resources\IceFireResource;

class IceandFire extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        //validate the incoming query
        $data = $request->validate([
            'name' => 'sometimes|string'
        ]);

        //query ice and fire external api
        $response = Http::get('https://www.anapioficeandfire.com/api/books',[
            'name' => $data['name']
        ]);

        //get response from external api and convert into an array
        //and format into the necessary data
        if ($response->successful()) {
            $new_response = json_decode($response, true);
            return response()->json([
                'status_code' => 200,
                'status' => 'success',
                'data' => IceFireResource::collection($new_response)
            ]);
        }
        else{
            return response()->json(['status'=>'error']);
        }
    }
}
