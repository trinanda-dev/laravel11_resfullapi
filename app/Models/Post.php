<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attribute;

class Post extends Model
{
    use HasFactory;

    /**
     * fillable
     * 
     * @var array
     */

     protected $fillable = [
        'image',
        'title',
        'content',
     ];

     /**
      * image
      * @return Atrribute
      */
      protected function image(): Attribute
      {
        return Attribute::make(
            get: fn($image) => url('/storage/posts/', $image)
        );
    }
}
