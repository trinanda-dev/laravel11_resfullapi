<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attribute;

class Login extends Model
{
    use HasFactory;

    /**
     * fillable
     * 
     * @var array
     */

     protected $fillable = [
        'id_karyawan',
        'password',
    ];
}
