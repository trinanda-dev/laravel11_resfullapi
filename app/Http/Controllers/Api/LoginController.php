<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\LoginResource;
use App\Models\Login;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Crypt;

class LoginController extends Controller
{
    /**
     * index
     * 
     * @return void
     */
    public function index() {
        //get all posts
        $login = Login::latest()->paginate(5);
        
        //return collection of login as a resource
        return new LoginResource(true, 'List Data Login', $login);
    }

    /**
     * store
     * 
     * @param mixed $request
     * @return void
     */

    public function store(Request $request)
    {
        //define validation rules
        $validator = Validator::make($request->all(), [
            'id_karyawan' => 'required',
            'password' => 'required',  // Pastikan role dikirim melalui request
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        //Hashing password
        $hashedPassword = Hash::make($request->password);

        //create login
        $login = Login::create([
            'id_karyawan' => $request->id_karyawan,
            'password' => $hashedPassword,
        ]);

        return new LoginResource(true, 'Data Login Berhasil ditambahkan!', $login);
    }
}