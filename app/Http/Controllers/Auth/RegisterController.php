<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Profile;
use Illuminate\Http\Request;
use Illuminate\Auth\Events\Registered;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use App\Notifications\RegisterUser;


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

    public function confirmation($id,$token) {
        $user = User::where('id', $id)->where('confirmation_token', $token)->first();
        if($user) {
            //update and erase confirmation_token
            $user->update(['confirmation_token' => null]);
            $this->guard()->login($user);
            return redirect($this->redirectPath())->with('success', 'votre compte est maintenant confirmé :)');
        } else {
            redirect('/login')->with('errors',"le lien n'est pas valide :( " );
        }
    }

    /**
     * modify register function from trait RegisterUsers
     * to send emails confirmations
     */

    public function register(Request $request)
    {
        $this->validator($request->all())->validate();

        event(new Registered($user = $this->create($request->all())));
        $user->notify(new RegisterUser());
        return redirect('/login')->with('success','votre compte a bien été creée, vous aller recevoir un email de confirmation');
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
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
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
       $user =  User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
            'confirmation_token' =>str_replace('/','', bcrypt(str_random(25)))
        ]);

        Profile::create(['user_id' => $user->id]);
        return $user;


    }
}
