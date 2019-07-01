<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserRealName extends JsonResource
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
        $data['face_img'] = !empty($data['face_img']) ? imgurl($data['face_img'], 'uploads') : '';
        $data['back_img'] = !empty($data['back_img']) ? imgurl($data['back_img'], 'uploads') : '';
        unset($data['created_at'], $data['updated_at']);
        return $data;
    }
}
