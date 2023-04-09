<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\User; //panggil model user
use Firebase\JWT\JWT; //panggil library jwt
use Illuminate\Support\Facades\Validator; //panggil library validator untuk validasi inputan
use Illuminate\Support\Facades\Auth; //panggil library untuk otentikasi
use Illuminate\Http\Exceptions\HttpResponseException;

class AuthController extends Controller
{
    //
}
