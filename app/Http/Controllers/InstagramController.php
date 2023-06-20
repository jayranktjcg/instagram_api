<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Services\APIService;
use Illuminate\Http\Request;

class InstagramController extends Controller
{
    protected $APIService;
    public function __construct(){
        $this->APIService = new APIService();
    }

    public function success(Request $request)
    {
        $code = $request->input('code');
        $authorizedUserId = session()->get('user_id');
        if(empty($authorizedUserId)){
            $request = [
                'client_id' => env('INSTAGRAM_APP_ID'),
                'client_secret' => env('INSTAGRAM_APP_SECRET'),
                'grant_type' => 'authorization_code',
                'redirect_uri' => env('INSTAGRAM_REDIRECT_URI'),
                'code' => $code,
            ];
            
            $accessTokenResponse = $this->APIService->getAccessToken($request);
            if($accessTokenResponse['status'] == true){
                $response = $accessTokenResponse['data'];
                $access_token = $response['access_token'];
                $user_id = $response['user_id'];
                $checkExistsUser = User::where('user_id', $user_id)->first();
                if(empty($checkExistsUser)){
                    $userData = User::create([
                        'code' => $code,
                        'user_id' => $user_id,
                        'access_token' => $access_token
                    ]);
                }else{
                    $userData = User::where('user_id', $user_id)->update([
                        'code' => $code,
                        'access_token' => $access_token
                    ]);
                }
                session()->put('user_id', $userData->id);
            }else{
                return ajaxResponse(false,[],$accessTokenResponse['message']);
            }
        }else{

            return redirect('/user_media');
        }
    }

    public function user_media()
    {
        $authorizedUserId = session()->get('user_id');
        $userData = User::where('id', $authorizedUserId)->first();
        if(!empty($userData)){
            $userMedia = $this->APIService->getUserMediaEdge($userData->access_token);
            dd($userMedia);
        }else{
            return redirect('/');
        }
        dd($userData);
    }
}
