<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;


class Authentication extends Controller
{
    //

    public function authenticate(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|string|min:8',
        ]);

        // Check if validation fails
        if ($validator->fails()) {
            $response['status'] ='error';
            $response['message'] =$validator->errors();

            return response()->json($response);

            // return response()->json($validator->errors());
        }

        $credentials['email'] = $request->email;
        $credentials['password'] = $request->password;

        if( Auth::attempt($credentials))
        {
            $user = User::where('email', $request->email)->first();
            $token =  $user->createToken('your-app-name')->plainTextToken;

            // return response()->json(['token' => $token]);

            $response['status'] ='success';
            $response['message'] ='Login Successfully !!!';
            $response['response'] = Auth::user();
            return response()->json($response);
        }
        else
        {
            $response['status'] ='failed';
            $response['message'] ='Please enter valid Email or Password !!!';
            return response()->json($response);
        }

    }

    public function signup(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8',
        ]);

        // Check if validation fails
        if ($validator->fails()) {
            // Redirect back with validation errors and the old input data
            // return redirect()->back()->withErrors($validator)->withInput();

            $response['status'] ='error';
            $response['message'] =$validator->errors();

            return response()->json($response);

        }

        // If validation passes, continue with the logic (e.g., create a user)
        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);

        $response['status'] ='success';
        $response['message'] ='Signup Successfully !!!';

        return response()->json($response);
    }

    public function uploadFile(Request $request)
    {
        // Validate the uploaded file
        $request->validate([
            'file' => 'required|file|mimes:jpeg,png,pdf,xlx,xlsx,mp4', // Customize the rules based on your needs
        ]);

        // Store the file in the public disk
        if ($request->hasFile('file') && $request->file('file')->isValid()) {
            $file = $request->file('file');
            $path = $file->store('uploads', 'public'); // Store the file in the 'uploads' directory

            return response()->json(['status' => 'success', 'path' => $path]);
        }

        return response()->json(['status' => 'error', 'message' => 'File upload failed']);
    }



}
