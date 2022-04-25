<?php

namespace App\Http\Controllers;

use App\Models\User; 
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;


class UserController extends Controller
{ 
    /**
     * @OA\Get(
     *     path="/greet",
     *     tags={"greeting"},
     *     summary="Returns a Sample API response",
     *     description="A sample greeting to test out the API",
     *     operationId="greet",
     *     @OA\Parameter(
     *          name="firstname",
     *          description="nama depan",
     *          required=true,
     *          in="query",
     *          @OA\Schema(
     *              type="string"
     *          )
     *     ),
     *     @OA\Parameter(
     *          name="lastname",
     *          description="nama belakang",
     *          required=true,
     *          in="query",
     *          @OA\Schema(
     *              type="string"
     *          )
     *     ),
     *     @OA\Response(
     *         response="default",
     *         description="successful operation"
     *     )
     * )
     */
    
    public function index()
    {
        $user = User::all();

        return response()->json([
            'success' => true,
            'message' =>'List User',
            'data'    => $user
        ], 200);
    }

    public function show($id)
    {
        $user = User::find($id);

        return response()->json([
            'success' => true,
            'message' =>'Data User',
            'data'    => $user
        ], 200);
    }

    public function create(Request $request)
    {
        $this->validate($request, [
            "email" => "required",
            "username" => "required",
            "password" => "required"
        ]);
        
        $user = User::create([
            'email'         => $request->input('email'),
            'username'      => $request->input('username'),
            'password'      => Hash::make($request->input('password')),
        ]);
       
        return response()->json($user);
    }
    public function update(Request $request, $id)
    {
        $user = User::find($id);
        
        if (!$user) {
            return response()->json(['message' => 'Data not found'], 404);
        }
        
        $this->validate($request, [
            "email" => "required",
            "username" => "required",
            "password" => "required"
        ]);

        $data = [
            'email'         => $request->input('email'),
            'username'      => $request->input('username'),
            'password'      => Hash::make($request->input('password')),
        ];

        $user->fill($data);
        $user->save();

        return response()->json($user);
    }
    
    public function delete($id)
    {
        $user = User::find($id);
        
        if (!$user) {
            return response()->json(['message' => 'Data not found'], 404);
        }

        $user->delete();

        return response()->json(['message' => 'Data deleted successfully'], 200);
    }

    public function denom(Request $request)
    {
        $url        = 'https://gist.githubusercontent.com/Loetfi/fe38a350deeebeb6a92526f6762bd719/raw/9899cf13cc58adac0a65de91642f87c63979960d/filter-data.json';

        $response   = file_get_contents($url);
        $json       = json_decode($response);
        $bill       = $json->data->response->billdetails;
        $empty      = [];
        
        for($i = 0; $i < count($bill); $i++) {
            foreach ($bill[$i]->body as $new => $value) {
                $mboh = substr($value, 18);
                if($mboh >= 100000)
                   array_push($empty, $mboh);
            }
        }
        return var_dump($empty);         
    }

    public function reqres_register(Request $request)
    {
        $response = Http::post('https://reqres.in/api/register', [
            'email'     => "eve.holt@reqres.in",
            'password'  => "pistol",
        ]);

        return response()->json($response);
    }

    public function reqres_login(Request $request)
    {
        $response = Http::post('https://reqres.in/api/register', [
            'email'     => "eve.holt@reqres.in",
            'password'  => "cityslicka",
        ]);

        return response()->json($response);
    }
}
