<?php

namespace App\Http\Controllers\Auth;

use App\Customer;
use App\Photographer;
use App\Role;
use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        DB::beginTransaction();

        try{
            $user = User::create([
                'email' => $data['email'],
                'password' => Hash::make($data['password']),
                'role_id' => $data['role'],
            ]);

            switch ($user->role_id) {
                case Role::customer():
                    $customer = Customer::create([
                        'user_id' => $user->id,
                    ]);
                    break;
                case Role::photographer():
                    $photographer = Photographer::create([
                        'user_id' => $user->id,
                    ]);
                    break;
            }

            DB::commit();

            return $user;
        }
        catch (\Exception $e){
            DB::rollback();
            return back();
        }
    }
}
