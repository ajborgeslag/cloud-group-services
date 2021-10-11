<?php

namespace App\Http\Controllers;

use App\Services\ServiceService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Validator;
use App\Http\Request\SearchRequest;
use App\Http\Request\service\UpdateZipCodeRequest;

class ServiceController extends Controller
{
    public $serviceService;

    public function __construct()
    {
        $this->serviceService = new ServiceService();
    }

    public function searchZipCode(SearchRequest $request)
    {
        try{
            $request->validated();

            $data = $this->serviceService->searchZipCode(json_decode($request->getContent()));
            return response(["success"=>!!$data, "data" => $data, "message" => trans('messages.success')], JsonResponse::HTTP_CREATED);
        }
        catch (\Exception $e) {
            return response(["success"=>false, "message" => $e->getMessage()/*trans('messages.internal_server_error')*/], JsonResponse::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function updateZipCode(UpdateZipCodeRequest $request)
    {
        try{
            $request->validated();

            $data = $this->serviceService->updateZipCode(json_decode($request->getContent()));
            return response(["success"=>!!$data, "data" => $data, "message" => trans('messages.success')], JsonResponse::HTTP_CREATED);
        }
        catch (\Exception $e) {
            return response(["success"=>false, "message" => $e->getMessage()/*trans('messages.internal_server_error')*/], JsonResponse::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

}
