<?php

namespace App\Http\Controllers;

use App\Mail\ForgotPassword;
use App\Models\UserModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    protected $message = [];

    public function login(UserModel $model, Request $request)
    {
        $data = Validator::make($request->post(), [
            'email' => 'required|email:dns,filter',
            'password' => 'required'
        ]);
        // the check exist error then call error/login
        if ($data->failed()) {
            $this->message = ['errors' => $data->errors(), 'status' => 500]; // create an array for errors
            echo response()->json($this->message)->getContent(); // call error
        } else {
            $data = array_merge($data->validated(), ['password' => Hash::make($request->input('password'))]); // merge hash password the old password
            // check the exists user
            (Auth::attempt($data)) ? $this->message = ['message' => 'This is successful login', 'status' => 200, 'callback' => $data['email']] : $this->message = ['message' => 'This is user not found', 'status' => 500, 'callback' => $data['email']];
            echo response()->json($this->message)->getContent();
        }
    }

    public function signup(UserModel $model, Request $request)
    {
        $data = Validator::make($request->post(), [
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|email:dns,filter',
            'password' => 'required'
        ]);
        // the check exist error then call error/signup
        if ($data->errors()->all()) {
            $this->message = ['errors' => $data->errors(), 'status' => 500]; // create an array for errors
            echo response()->json($this->message)->getContent(); // call error
        } else {
            $data = array_merge($data->validated(), ['password' => Hash::make($request->input('password')), 'ip' => $request->ip()]); // update data password and ip address
            // signup user
            ($model->signup($data)) ? $this->message = ['message' => 'This is successful signup', 'status' => 201, 'callback' => $data['email']] : $this->message = ['message' => 'This is unsuccessful signup', 'status' => 500, 'callback' => $data['email']];
            echo response()->json($this->message)->getContent(); // call messages
        }
    }

    public function forgotPassword(UserModel $model, Request $request)
    {
        $email = Validator::make($request->post(), [
            'email' => 'required|email:dns,filter'
        ]);
        if ($email->fails()) {
            $this->message = ['errors' => $email->errors(), 'status' => 500]; // create an array for errors
            echo response()->json($this->message)->getContent(); // call error
        } else {
            $email = $email->validate()['email']; // get email from array validator
            $userExist = UserModel::where('email', $email)->first(); // found user by email
            switch ($userExist->exists()) {
                case true:
                    Mail::to($userExist->email)->send(new ForgotPassword($userExist)); // sending email
                    $this->message = ['message' => 'Sent link reset password for your email', 'status' => 200];
                    break;
                default:
                    $this->message = ['errors' => 'The user not found', 'status' => 500];
            }
            echo response()->json($this->message)->getContent(); // call messages
        }
    }

    public function changePassword(UserModel $model, Request $request)
    {
        $data = [
            'password' => '123',
            're_password' => '123',
            'user' => 'gusikowski.braulio@dooley.org'
        ];
        $data = Validator::make($data, [
            're_password' => 'required',
            'password' => 'required',
            'user' => 'required'
        ]);
        // return errors if exist error
        if ($data->fails()) {
            echo response()->json(['errors' => $data->errors()->all(), 'status' => 500])->getContent();
            exit();
        }
        $data = $data->validated();
        // check password equals with re password
        if ($data['password'] != $data['re_password']) {
            echo response()->json(['errors' => 'The password not equals with re password', 'status' => 500])->getContent();
            exit();
        }
        $data = array_merge($data, ['password' => Hash::make($data['password'])]); // the update password hash
        ($model->changePassword($data)) ? $this->message = ['message' => 'The change password is successful', 'status' => 200] : $this->message = ['message' => 'The change password is unsuccessful', 'status' => 500]; // change password true/false
        echo response()->json($this->message)->getContent(); // call messages or error
    }
}
