<?php

namespace App\Http\Controllers;

use App\Http\Request\user\UserRequest;
use App\Http\Requests\user\UserWithOutPasswordRequest;
use App\Mail\UserActivationCodeNotification;
use App\Models\User;
use App\Services\UserService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class UserController extends Controller
{
    public $userService;

    public function __construct()
    {
        $this->userService = new UserService();
    }

    public function show($user){

        $user = User::all();
        return view('manage').compact('user');
    }


}
