<?php

namespace App\Http\Controllers\API\Auth;

use App\Http\Controllers\API\ResponseController;
use App\Http\Resources\API\User\UserPrivateIndexResource;
use App\Http\Resources\API\User\UserPrivateInfoResource;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class AuthController extends ResponseController
{
    public function check(Request $request)
    {
        $data = Validator::make($request->all(), [
            'mobile' => 'required|size:9',
        ]);
        if ($data->fails()) {
            $message['error'] = $data->errors();
            return $this->error($message);
        }
        $user = User::where('mobile', $request->mobile)->first();
        if ($user == null) {
            return response()->json([
                'status' => false,
                'result' => $request->mobile
            ]);
        }
        $message['result'] = $request->mobile;
        return $this->response($message);
    }

    public function register(Request $request)
    {
        $data = Validator::make($request->all(), [
            'mobile' => 'required|size:9|unique:users',
            'password' => 'required'
        ]);
        if ($data->fails()) {
            $message['error'] = $data->errors();
            return $this->error($message);
        }
        $user = User::create($request->only('mobile', 'password'));
        $otp = $user->setOTP();
        if (!$otp){
            $message['error'] = 'cant sent the otp';
            return $this->error($message);
        }
        $message['result'] = [
            'mobile' => $user->mobile,
        ];
        return $this->response($message, 200);
    }

    public function login(Request $request)
    {
        $data = Validator::make($request->all(), [
            'mobile' => 'required|size:9|exists:users',
            'password' => 'required|string'
        ]);

        if ($data->fails()) {
            $message['error'] = $data->errors();
            return $this->error($message);
        }


        $credentials = request(['mobile', 'password']);

        if (!Auth::attempt($credentials)) {
            $message['error'] = 'Password or phone number is wrong';
            return $this->error($message, 200);
        }

        $user = $request->user();

        $otp_is_sent = $user->setOTP();
        //sent otp to the registered number and return true or false

        if ($otp_is_sent == false) {
            $message['error'] = 'error';
            return $this->error($message);
        }

        $message['result'] = [
            'mobile' => $user->mobile
        ];

        return $this->response($message, 200);
    }

    public function confirm(Request $request)
    {
        $data = Validator::make($request->all(), [
            'mobile' => 'required|size:9|exists:users',
            'otp' => 'required|size:6'
        ]);

        if ($data->fails()) {
            $message['error'] = $data->errors();
            return $this->error($message);
        }

        $user = User::where('mobile', $request->mobile)->where('otp', $request->otp)->first();

        if ($user == null) {
            $message['error'] = 'Otp is wrong';
            return $this->error($message);
        }

        //this ensures that once user logged you are not going to use that old otp again
//        $user->otp = random_int(100000, 999999);
//        $user->save();

        $message['result'] = new UserPrivateIndexResource($user);

        return $this->response($message, 200);
    }

    public function update(Request $request)
    {

        $data = Validator::make($request->all(), [
            'name' => 'required|string',
            /*'mobile' => [
                'size:9', 'required',
                Rule::unique('users')->ignore($request->user()->id),
            ],*/
            'email' => [
                'email',
                Rule::unique('users')->ignore($request->user()->id),
            ]
        ]);

        if ($data->fails()) {
            $message['error'] = $data->errors();
            return $this->error($message);
        }

        $user = $request->user();
        $user->renew($request->all());

        $message['result'] = new UserPrivateInfoResource($user);
        return $this->response($message, 200);

    }

    public function user(Request $request)
    {
        $message['result'] = new UserPrivateInfoResource($request->user());

        return $this->response($message, 200);
    }

    public function logout(Request $request)
    {
        $request->user()->token()->revoke();
        $message['result'] = 0;
        return $this->response($message, 201);
    }
}