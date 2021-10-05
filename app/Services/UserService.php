<?php


namespace App\Services;

use App\Models\ReUserLocationRole;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class UserService
{

    public $roleService;

    public function __construct()
    {
        $this->roleService = new RoleService();
    }


    public function getUser($userId)
    {
        try {
            /*--------------- Get User --------------------*/
            return $user = User::where('id',$userId)->where('active',1)->firstOrFail();
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

    public function update($userId, $userNew)
    {
        try {
            /*--------------- Insert User --------------------*/
            $user = User::findOrFail($userId);
            $user->name = $userNew->name;
            $user->email = $userNew->email;
            $user->save();

            return $user;
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    public function updateFull($userNew)
    {
        try {
            /*--------------- Insert User --------------------*/
            $user = User::findOrFail($userNew->id);
            $user->name = $userNew->name;
            $user->email = $userNew->email;
            $user->password = bcrypt($userNew->password);
            $user->save();

            /*-----------Delete and create new localtions and roles--------------------*/
            ReUserLocationRole::where('user_id', $userNew->id)->delete();
            $this->storeLocationsRoles($user, $userNew->locations);

            return $user;
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    public function activate($userNew)
    {
        try {
            /*--------------- update User --------------------*/
            $user = User::findOrFail($userNew->id);
            $user->active = $userNew->active;
            $user->save();

            return $user;
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    public function delete($userNew)
    {
        try {
            /*--------------- Delete User --------------------*/
            $userId = $userNew->id;
            $user = User::findOrFail($userNew->id);
            $user->delete();

            return $userId;
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    public function searchUser($search)
    {
        try {
            /*--------------- Search Role --------------------*/
            $limit = property_exists($search, 'limit') ? $search->limit : 20;
            $page = property_exists($search, 'page') && $search->page > 0 ? $search->page : 1;
            $skip = ($page - 1) * $limit;

            $users = null;
            if(property_exists($search, 'search'))
                $users = User::where('name', 'LIKE', '%' . $search->search . '%')->orWhere('email', 'LIKE', '%' . $search->search . '%')->skip($skip)->take($limit)->get();
            else
                $users = User::skip($skip)->take($limit)->get();

            foreach ($users as $user)
            {
                $user['locations'] = $this->getLocations($user);
            }

            return $users;
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

}
