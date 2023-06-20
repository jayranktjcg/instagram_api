<?php 
namespace App\Services;

use Exception;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;

class APIService{

    protected $client;
    public function __construct(){
        $this->client = new Client();
    }

    // Use for exchange authorize code to access token
    public function getAccessToken($requestInput){
        try {
            $url = env('INSTAGRAM_AUTH_URL')."access_token";
            $response = $this->client->post($url, [
                'form_params' => $requestInput,
            ]);
            $body = $response->getBody();
            $data = json_decode($body, true);
            if(!empty($data)){
                return ajaxResponse(true, $data,'Access token generated.');
            }else{
                return ajaxResponse(false,[],"Sorry! Something went wrong.");
            }
        } catch (ClientException $e) {
            return ajaxResponse(false,[],$e->getMessage());
        } catch (Exception $e) {
            return ajaxResponse(false,[],$e->getMessage());
        }
    }

    // Use for fetch userdata
    public function getUserNode($userId, $accessToken){
        try {
            $url = env('INSTAGRAM_GRAPH_URL').$userId;
            $response = $this->client->get($url, [
                'query' => [
                    'fields'=>'id,username',
                    'access_token'=>$accessToken
                ],
            ]);
            $body = $response->getBody();
            $data = json_decode($body, true);
            dd($data);
            if(!empty($data)){
                return ajaxResponse(true, $data,'Access token generated.');
            }else{
                return ajaxResponse(false,[],"Sorry! Something went wrong.");
            }
        } catch (ClientException $e) {
            return ajaxResponse(false,[],$e->getMessage());
        } catch (Exception $e) {
            return ajaxResponse(false,[],$e->getMessage());
        }
    }

    // Use for fetch user media
    public function getUserMediaEdge($accessToken){
        try {
            $url = env('INSTAGRAM_GRAPH_URL')."me/media/";
            $response = $this->client->get($url, [
                'query' => [
                    'fields'=>'id,caption',
                    'access_token'=>$accessToken
                ],
            ]);
            $body = $response->getBody();
            $data = json_decode($body, true);
            dd($data);
            if(!empty($data)){
                return ajaxResponse(true, $data,'Access token generated.');
            }else{
                return ajaxResponse(false,[],"Sorry! Something went wrong.");
            }
        } catch (ClientException $e) {
            return ajaxResponse(false,[],$e->getMessage());
        } catch (Exception $e) {
            return ajaxResponse(false,[],$e->getMessage());
        }
    }
}
?>