<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserCompany extends JsonResource
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
        $data['sign_data'] = empty($data['sign_data']) ? '' : imgurl($data['sign_data'], 'uploads');
        unset($data['created_at'], $data['updated_at']);
        return $data;
    }
}
