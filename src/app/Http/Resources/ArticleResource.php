<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ArticleResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return array
     */
    public function toArray($request)
    {
        return [
            'articleId'       => $this->article_id,
            'title'           => $this->title,
            'content'         => $this->content,
            'shortDescription'=> $this->shortDescription,
            'image'           => $this->image,
            'author'          => $this->author,
            'category'        => $this->category,
            'tags'            => $this->tags ? $this->tags : [],
            'created_at'      => $this->created_at,
            'updated_at'      => $this->updated_at,
        ];
    }
}
