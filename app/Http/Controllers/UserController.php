<?php

namespace App\Http\Controllers;

use App\Http\Request\user\UserRequest;
use App\Http\Requests\user\UserWithOutPasswordRequest;
use App\Mail\UserActivationCodeNotification;
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

    /**
     * @OA\Post(
     * path="/register",
     * summary="Register(add) a new user",
     * description="Register(add) a new user",
     * operationId="register",
     * tags={"User"},
     * @OA\RequestBody(
     *    required=true,
     *    description="Insert a new User. Send to to mailbox a URL to finish the registration process",
     *    @OA\JsonContent(
     *       required={"name","email","user_name","password","location_id","locations",},
     *       @OA\Property(property="name", type="string", example="User1"),
     *       @OA\Property(property="email", type="string", example="user1@mail.com"),
     *       @OA\Property(property="user_name", type="string", example="user1"),
     *       @OA\Property(property="password", type="string", example="PassWord12345"),
     *       @OA\Property(property="location_id", type="integer", example=1),
     *       @OA\Property(property="locations", type="object",
     *              type="array",
     *              @OA\Items(
     *                  @OA\Property(property="id", type="integer", example = 1),
     *                  @OA\Property(property="roles", type="array",
     *                      @OA\Items(
     *                        type="integer", format="int64", example = 2,
     *                      )
     *                  ),
     *              )
     *     ),
     *  )
     * ),
     * @OA\Response(
     *    response=200,
     *    description="User information",
     *             @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="success", type="boolean", example="true"),
     *             @OA\Property(
     *                property="data",
     *                type="array",
     *                example={{
     *                  "name": "User1",
     *                  "email": "user1@mail.com",
     *                  "user_name": "user1",
     *                  "id": 3
     *                  }},
     *                @OA\Items(
     *                )
     *             ),
     *			   @OA\Property(property="message", type="string", example="ok"),
     *        )
     * )
     * )
     */
    public function register(UserRequest $request)
    {
        try{
            $request->validated();
            $data = $this->userService->store(json_decode($request->getContent()));
            $url = Config::get('app.url').'/activation_code/'.$data->id.'/'.$data->verification_code;
            //Send user email with verification code
            Mail::to($data->email)->send(new UserActivationCodeNotification($data->name, $url));
            return response(["success"=>!!$data, "data" => $data, "message" => trans('messages.success')], JsonResponse::HTTP_CREATED);
        }
        catch (\Exception $e) {
            return response(["success"=>false, "message" => trans('messages.internal_server_error')], JsonResponse::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function addUser(UserWithOutPasswordRequest $request)
    {
        try{
            $request->validated();

            //Verify is token is valid
            $this->verifyToken();

            //Verify locations from request are valids
            $payload = JWTAuth::parseToken()->getPayload();
            $user['locations'] = $payload['locations'];
            $verifyLocationsAcces = $this->verifyLocationsAcces($payload['locations'], json_decode($request->getContent())->locations);
            if(!$verifyLocationsAcces)
                return response(["success"=>false, "message" => trans('messages.access_error')], JsonResponse::HTTP_BAD_REQUEST);

            $location = json_decode($request->getContent())->locations[0]->id;
            $data = $this->userService->store(json_decode($request->getContent()));
            $url = Config::get('app.url').'/activation_code_set_password/'.$data->id.'/'.$data->verification_code.'/'.$location;
            //Send user email with verification code
            Mail::to($data->email)->send(new UserActivationCodeNotification($data->name, $url));
            return response(["success"=>!!$data, "data" => $data, "message" => trans('messages.success')], JsonResponse::HTTP_CREATED);
        }
        catch (\Exception $e) {
            return response(["success"=>false, "message" => $e->getMessage()/*trans('messages.internal_server_error')*/], JsonResponse::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

}
