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
        /*
         * 图片文件名用的userid 当图片变更后 地址不会变
         * 客户端不会主动刷新 需要增加rand参数
         * */
        $data['face_img'] = !empty($data['face_img']) ? imgurl($data['face_img'], 'uploads').'?rand='.mt_rand(0, 1000) : '';
        $data['back_img'] = !empty($data['back_img']) ? imgurl($data['back_img'], 'uploads').'?rand='.mt_rand(0, 1000) : '';
        unset($data['created_at'], $data['updated_at']);
        return $data;
    }
}
