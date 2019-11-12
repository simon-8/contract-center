<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CompanyStaff extends JsonResource
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
        $data['truename'] = $data['user']['truename'];
        $data['mobile'] = $data['user']['mobile'];

        unset($data['user'], $data['updated_at']);
        return $data;
    }
}
