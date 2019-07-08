<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class SinglePage extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $data = parent::toArray($request);
        if ($data['content']) {
            preg_match_all('#<img.*?src="([^"]*)"[^>]*>#i', $data['content'], $match);
            $oldImgs = [];
            $newImgs = [];
            foreach($match[1] as $imgurl) {
                if (substr($imgurl, 0, 4) === 'http') {
                    continue;
                }
                $oldImgs[] = $imgurl;
                $newImgs[] = imgurl($imgurl);
            }
            if ($oldImgs && $newImgs) {
                $data['content'] = str_replace($oldImgs, $newImgs, $data['content']);
            }
        }

        unset($data['created_at'], $data['updated_at']);
        return $data;
    }
}
