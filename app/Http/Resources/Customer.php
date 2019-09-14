<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Customer extends JsonResource
{
    /**
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        //Get everything

        // return parent::toArray($request);

        //or specific paramters inside the object 

        return [
            "id" => $this->id,
            "email" => $this->email,
            "firstname" => $this->firstname,
            "lastname" => $this->lastname,
            "phone" => $this->phone,
            "regtime" => $this->regtime,
        ];
    }



    public function with($request)
    {
        // This enables me to add metadata to my requests 
        // Cool trick
        return [
            'version' => '1.0.0',
            'author' => 'Liad'
        ];
    }
}
