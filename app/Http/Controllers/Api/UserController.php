<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterUser;
use App\Http\Requests\LogUserRequest;
use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    public function register(RegisterUser $request)
    {
        try{
            $user = new User();

        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = $request->password;
        
        $user->save();

        return response()->json([
            'status_code'=>200,  
            'status_message'=>'Lutilisateur a bien été créé',
            'user'=>$user
        ]);

        }catch(Exception $e)
        {
            return response()->json([$e]);
        }
    }

    public function login(LogUserRequest $request){
        if(auth()->attempt($request->only(['email','password']))){ /* auth permet de récup un utillisateur actuellement connecter */

            $user = auth()->user();
            
            $token = $user->createToken('MA_CLEF_SECRETE_VISIBLE_AU_BACK')->plainTextToken;

            return response()->json([
                'status_code'=>200,  
                'status_message'=>'Utilisateur connecté',
                'user'=>$user,
                'token'=>$token
            ]);

        }else{
            //si les informations ne correspond a aucun utilisateur
            return response()->json([
                'status_code'=>403,  
                'status_message'=>'Information non valide',
            ]);
        }
    }
}
