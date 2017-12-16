<?php
namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\User;
use App\Profile;
use App\Group;

class ProfileController extends Controller
{
    public function show($user_id) {
        $user = User::find(['id' => $user_id])->first();
        $data = Auth::User()->profile;
        
        if($user){
            return view('profile.profile',compact('user','data'));
        } else {
            return view('errors.404', compact('user'));
        }       
    }

    public function updateProfile(Request $request,$user_id) {
        
        $profile = Profile::where(['user_id' => $user_id])->first();
        
        $user = Auth::user();
        $group = Group::where(['user_name'=>$user->name]);
        $city = $request->city ? $request->city : $profile->city;
        $country = $request->country ? $request->country : $profile->country;
        $about = $request->about ? $request->about : $profile->about;
        $skill = $request->skill ? $request->skill : $profile->skill;
        $profile->update([
                        'city'=> $city,
                        'country'=> $country,
                         'about'=> $about,
                         'skill'=>$skill
        ]);

        $name = $request->name ? $request->name : $user->name;
        $email = $request->email ? $request->email : $user->email;
        $user->update([
            'name'=>$name,
            'email'=>$email
        ]);
        $group->update([
            'user_name'=>$name
        ]);
        $response_profile = [
                'name' => $name,
                'email' => $email,
                'city' =>$city,
                'country' => $country,
                'skill' =>$skill,
                'about' =>$about,
                'avatar_url' => md5( strtolower( trim($email) ) )

        ];
        
            return $response_profile;
        //return redirect()->back();
           
    }

    
}