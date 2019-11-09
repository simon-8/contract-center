<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Company extends JsonResource
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
        // todo 20190917 本次更新保留sign_data字段
        //$data['sign_data'] = empty($data['seal_img']) ? '' : imgurl($data['seal_img'], 'uploads');
        unset($data['sign_data']);
        $data['seal_img'] = imgurl($data['seal_img'], 'uploads');
        unset($data['created_at'], $data['updated_at']);
        if (!empty($data['user'])) {
            $data['truename'] = $data['user']['truename'];
            unset($data['user']);
        }
        return $data;
    }
}
