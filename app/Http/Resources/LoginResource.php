<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class LoginResource extends JsonResource
{
    //define properti
    public $status;
    public $message;
    public $resource;

    /**
     * _construct
     * 
     * @param mixed $status
     * @param mixed $message
     * @param mixed $resource
     * @return void
     */

     public function __construct($status, $message, $resource)

     {
        parent::__construct($resource);
        $this->status = $status;
        $this->message = $message;
     }

     /**
      * toArray
      * @param mixed $request
      * @return array
      */
      public function toArray(Request $request): array
      {
        return [
            'success' =>$this->status,
            'message' =>$this->message,
            'data' =>$this->resource,
        ];
    }
}
