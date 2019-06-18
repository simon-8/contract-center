<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ContractFile extends JsonResource
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
        $data['linkurl'] = config('filesystems.disks.uploads.url') . $data['linkurl'];
        unset($data['created_at'], $data['updated_at']);
        return $data;
    }
}
