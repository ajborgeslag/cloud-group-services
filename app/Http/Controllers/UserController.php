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
use Validator;
use App\Http\Request\SearchRequest;

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

    public function search(SearchRequest $request)
    {
        try{
            $request->validated();

            $data = $this->userService->searchUser(json_decode($request->getContent()));
            return response(["success"=>!!$data, "data" => $data, "message" => trans('messages.success')], JsonResponse::HTTP_CREATED);
        }
        catch (\Exception $e) {
            return response(["success"=>false, "message" => $e->getMessage()/*trans('messages.internal_server_error')*/], JsonResponse::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

}
