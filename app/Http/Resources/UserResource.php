<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'=>$this->id,
            'name' => $this->name,
            'phone' => $this->phone,
            'email' => $this->email,
            'password' => $this->password,
            'company_id'=> $this->company_id,
            'company'=>$this->company,
           // 'subscription'=> ($this->company_id==null)? new SubscriptionResource($this->subscription) : new SubscriptionResource($this->company->subscription),

            'accepted_terms'=> $this->accepted_terms,
            'role_id' => $this->role_id,
            'role'=>$this->role,
            'image'=> ($this->getMedia('profiles')->first()) ? $this->getMedia('profiles')->last()->getUrl() : null,
            'permissions'=>$this->simple_permissions,
            'signature'=> ($this->getMedia('signatures')->first()) ? $this->getMedia('signatures')->last()->getUrl() : null
        ];
    }
}