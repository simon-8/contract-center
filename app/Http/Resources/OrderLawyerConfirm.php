<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class OrderLawyerConfirm extends JsonResource
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
        $data['statusText'] = (new \App\Models\OrderLawyerConfirm())->getStatusText($data['status']);
        unset($data['created_at'], $data['updated_at']);
        return $data;
    }
}
