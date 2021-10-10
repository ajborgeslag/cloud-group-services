<?php


namespace App\Services;

use App\Models\ServicePostalCode;
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
                    ->select('postal_code.id','postal_code.province', 'postal_code.populate', 'postal_code.zip_code', 'service_postal_code.postal_code_id', 'service_postal_code.pluss_price', 'service_postal_code.id as idServicePostalCode')
                    ->leftJoin('service_postal_code', 'postal_code.id', '=', 'service_postal_code.postal_code_id')
                    ->where('postal_code.province', 'LIKE', '%' . $search->search . '%')
                    ->orWhere('postal_code.populate', 'LIKE', '%' . $search->search . '%')
                    ->orWhere('postal_code.zip_code', 'LIKE', '%' . $search->search . '%')
                    ->skip($skip)->take($limit)->get();
            else
                $zip_codes = DB::table('postal_code')
                    ->select('postal_code.id','postal_code.province', 'postal_code.populate', 'postal_code.zip_code', 'service_postal_code.postal_code_id', 'service_postal_code.pluss_price', 'service_postal_code.id as idServicePostalCode')
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

    public function updateZipCode($data)
    {

        try {

            $selected = property_exists($data, 'selected') ? $data->selected : [];
            $elements = $data->elements;

            $resul = array();

            foreach ($elements as $item)
            {
                if(property_exists($item, 'postal_code_id') && $item->postal_code_id!=null)
                {
                    $existInSelected = false;
                    foreach ($selected as $itemSelected)
                    {
                        if($itemSelected->id == $item->id)
                        {
                            $existInSelected = true;
                        }
                    }
                    if(!$existInSelected && property_exists($item, 'idServicePostalCode') && $item->idServicePostalCode!=null)
                    {
                        ServicePostalCode::where('id', $item->idServicePostalCode)->delete();
                        $resul[] = array("delete" => $item->idServicePostalCode);
                    }
                }
            }

            foreach ($selected as $itemSelected)
            {
                $existInElements = false;
                foreach ($elements as $item)
                {
                    if($item->id==$itemSelected->id  && property_exists($item, 'idServicePostalCode') && $item->idServicePostalCode!=null)
                    {
                        $existInElements = true;
                        $servicePostalCode = ServicePostalCode::where('id',$item->idServicePostalCode)->first();
                        $servicePostalCode->pluss_price = property_exists($itemSelected, 'pluss_price') ? $itemSelected->pluss_price : null;
                        $servicePostalCode->save();
                        $resul[] = array("update" => $item->id);
                    }
                }
                if(!$existInElements)
                {
                    $servicePostalCode = ServicePostalCode::create([
                        'service_id' => 1,
                        'postal_code_id' => $itemSelected->id,
                        'pluss_price' => property_exists($itemSelected, 'pluss_price') ? $itemSelected->pluss_price : null,
                    ]);
                    $resul[] = array("create" => $servicePostalCode->id);
                }
            }
            return $resul;
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

}
