<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Contract extends JsonResource
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
        $data['statusText'] = (new \App\Models\Contract())->getStatusText($data['status']);
        $data['path_pdf'] = $data['path_pdf'] ? resourceUrl($data['path_pdf']) : '';
        return $data;
    }
}
