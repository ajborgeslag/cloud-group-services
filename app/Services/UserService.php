<?php


namespace App\Services;

use App\Models\User;
use Illuminate\Support\Str;

class UserService
{

    public function __construct()
    {

    }


    public function delete($userDeleted): array
    {
        try {
            /*--------------- Delete User --------------------*/
            $userId = $userDeleted->id;
            $user = User::findOrFail($userId);
            $user->delete();

            $userEliminated = array("userId" => $userId);

            return $userEliminated;

        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    public function update($userNew)
    {
        try {
            /*--------------- Insert User --------------------*/
            $userId = $userNew->id;
            $user = User::findOrFail($userId);
            $user->first_name = $userNew->first_name;
            $user->last_name = $userNew->last_name;
            $user->email = $userNew->email;
            $user->address = $userNew->address;
            $user->phone_number = $userNew->phone_number;
            $user->save();

            return $user;
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    public function searchUser($search)
    {
        try {
            /*--------------- Search Role --------------------*/
            $limit = property_exists($search, 'itemsPerPage') ? $search->itemsPerPage : 20;
            $page = property_exists($search, 'page') && $search->page > 0 ? $search->page : 1;
            $skip = ($page - 1) * $limit;

            $users = null;
            if(property_exists($search, 'search') && $search->search!='')
                $users = User::where('first_name', 'LIKE', '%' . $search->search . '%')->orWhere('last_name', 'LIKE', '%' . $search->search . '%')->orWhere('email', 'LIKE', '%' . $search->search . '%')->skip($skip)->take($limit)->get();
            else
                $users = User::skip($skip)->take($limit)->get();

            $total = null;
            if(property_exists($search, 'search') && $search->search!='')
                $total = count(User::where('first_name', 'LIKE', '%' . $search->search . '%')->orWhere('last_name', 'LIKE', '%' . $search->search . '%')->orWhere('email', 'LIKE', '%' . $search->search . '%')->get());
            else
                $total = count(User::all());

            $paginate = array("total" => $total, "items" => $users);

            return $paginate;
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    public function getUserByEmail($email)
    {
        try {
            /*--------------- Get User --------------------*/
            return $user = User::where('email',$email)->where('active',1)->first();
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    public function getUserById($user_id)
    {
        try {
            /*--------------- Get User --------------------*/
            return $user = User::where('id',$user_id)->first();
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    public function setActivationCodeByEmail($email)
    {
        try {
            /*--------------- Get User --------------------*/
            $user = User::where('email',$email)->first();
            if($user==null)
                return null;

            $user->verification_code = strtolower(Str::random(30));
            $user->save();
            return $user;
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    public function getUserByIdAndVerificationCode($user_id, $verification_code)
    {
        try {
            /*--------------- Get User --------------------*/
            $user = User::where('id',$user_id)->where('verification_code', $verification_code)->first();
            $user->active = true;
            $user->verification_code = strtolower(Str::random(30));
            $user->save();
            return $user;
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    public function putUserVerificationCodePassword($user_id, $verification_code, $password)
    {
        try {
            /*--------------- Get User --------------------*/
            $user = User::where('id',$user_id)->where('verification_code', $verification_code)->first();
            $user->active = true;
            $user->verification_code = strtolower(Str::random(30));
            $user->password = bcrypt($password);
            $user->save();
            return $user;
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    public function resetPassword($userId, $password)
    {
        try {
            /*--------------- Insert User --------------------*/
            $user = User::findOrFail($userId);
            $user->password = bcrypt($password);
            $user->save();

            return $user;
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }


}
