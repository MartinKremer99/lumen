<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\Information;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Response;

class AdminController extends Controller
{

    // Create a new admin with this request json:
    /*
        {
            "first_name": "",
            "last_name": "",
            "email": "",
            "password": ""
        }
    */
    public function create(Request $request)
    {
        // Check if all required fields are in the request
        // with extra checks for email and password length
        $validator = Validator::make($request->all(), [
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:8'
        ]);

        // if the validator failed send back the error itself
        // so if the email has the wrong format you get something like this
        /*
            {
                "email": [
                    "The email must be a valid email address."
                ]
            }
        */
        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        // check if the email is already in use
        $information = Information::where('email', $request->input('email'))->first();
        if ($information) {
            return response()->json(['msg' => 'Email already in use'], 400);
        }

        // create the information with all the input that has the property fillable
        $information = Information::create($request->all());

        // hash the password
        $information->password = Hash::make($request->input('password'));

        $information->save();

        // create the admin with his new information
        $admin = Admin::create(['information_id' => $information->id]);

        // get the admin with his relation to information
        $admin = Admin::with('information')->find($admin->id);

        // return the admin as json, the hidden property on the model 
        // removes these fields from the respone
        return Response::json($admin, 201);
    }
}