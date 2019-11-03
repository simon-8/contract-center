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
        if (!empty($data['content'])) {
            // image
            preg_match_all('#<img.*?src="([^"]*)"[^>]*>#i', $data['content'], $match);
            $oldImgs = [];
            $newImgs = [];
            foreach($match[1] as $url) {
                if (substr($url, 0, 4) === 'http') {
                    continue;
                }
                $oldImgs[] = $url;
                $newImgs[] = imgurl($url);
            }
            if ($oldImgs && $newImgs) {
                $data['content'] = str_replace($oldImgs, $newImgs, $data['content']);
            }

            preg_match_all('#<video.*?src="([^"]*)"[^>]*>#i', $data['content'], $match);
            $oldVideos = [];
            $newVideos = [];
            foreach($match[1] as $url) {
                if (substr($url, 0, 4) === 'http') {
                    continue;
                }
                $oldVideos[] = $url;
                $newVideos[] = imgurl($url);
            }
            if ($oldVideos && $newVideos) {
                $data['content'] = str_replace($oldVideos, $newVideos, $data['content']);
            }
        }

        //unset($data['created_at'], $data['updated_at']);
        return $data;
    }
}
