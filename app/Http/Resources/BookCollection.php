<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class BookCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'name' => $this['name'],
            'isbn' => $this['isbn'],
            'authors' => array($this['authors']),
            'number_of_pages' => $this['numberOfPages'],
            'publisher' => $this['publisher'],
            'country' => $this['country'],
            'release_date' => date('Y-m-d',strtotime($this['released'])),
        ];
    }
}
