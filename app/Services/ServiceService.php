<?php


namespace App\Services;

use App\Models\User;
use App\Models\ZipCode;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class ServiceService
{

    public function __construct()
    {

    }

    public function searchZipCode($search)
    {
        try {
            /*--------------- Search Role --------------------*/
            $limit = property_exists($search, 'itemsPerPage') ? $search->itemsPerPage : 20;
            $page = property_exists($search, 'page') && $search->page > 0 ? $search->page : 1;
            $skip = ($page - 1) * $limit;

            if(property_exists($search, 'search') && $search->search!='')
                $zip_codes = DB::table('postal_code')
                    ->select('postal_code.id','postal_code.province', 'postal_code.populate', 'postal_code.zip_code', 'service_postal_code.postal_code_id')
                    ->leftJoin('service_postal_code', 'postal_code.id', '=', 'service_postal_code.postal_code_id')
                    ->where('postal_code.province', 'LIKE', '%' . $search->search . '%')
                    ->orWhere('postal_code.populate', 'LIKE', '%' . $search->search . '%')
                    ->orWhere('postal_code.zip_code', 'LIKE', '%' . $search->search . '%')
                    ->skip($skip)->take($limit)->get();
            else
                $zip_codes = DB::table('postal_code')
                    ->select('postal_code.id','postal_code.province', 'postal_code.populate', 'postal_code.zip_code', 'service_postal_code.postal_code_id')
                    ->leftJoin('service_postal_code', 'postal_code.id', '=', 'service_postal_code.postal_code_id')
                    ->skip($skip)->take($limit)->get();

            if(property_exists($search, 'search') && $search->search!='')
                $total = count(DB::table('postal_code')
                    ->leftJoin('service_postal_code', 'postal_code.id', '=', 'service_postal_code.postal_code_id')
                    ->where('postal_code.province', 'LIKE', '%' . $search->search . '%')
                    ->orWhere('postal_code.populate', 'LIKE', '%' . $search->search . '%')
                    ->orWhere('postal_code.zip_code', 'LIKE', '%' . $search->search . '%')
                    ->get());
            else
                $total = count(ZipCode::all());

            $paginate = array("total" => $total, "items" => $zip_codes);

            return $paginate;
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

}
