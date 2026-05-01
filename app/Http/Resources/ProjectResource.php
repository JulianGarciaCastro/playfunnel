<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProjectResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request){
        
        return [
            'id'         => $this->id,
            'name'       => $this->name,
            'aspect'     => $this->aspect,
            'created_at' => $this->creation_date,
            'status'     => $this->project_status_id,
        ];
    }
}
