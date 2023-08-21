<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Session;


class AuthController extends Controller
{
    public function index() 
    {
        return view("auth.login");
    }

    public function registration() 
    {
        return view("auth.registration");
    }

    public function logout()
    {
        Session::flush();
        Auth::logout();
        return redirect("login");
    }

    public function postRegistration(Request $request)
    {
        // dd($request->all());
        $request->validate([
            "name" => "required",
            "email" => "required|email|unique:users",
            "password" => "required|min:6",
        ]);
        $data = $request->all();
        $createUser = $this->create($data);
        return redirect("login")->withSuccess("You are registered successfully!");
    }

    public function create(array $data)
    {
        return User::create([
            "name" => $data["name"],
            "email" => $data["email"],
            "password" => $data["password"],
        ]);
    }

    public function postLogin(Request $request)
    {
        $request->validate([
            "email" => "required|email",
            "password" => "required",
        ]);

        $checkLoginCredentials = $request->only("email", "password");
        if (Auth::attempt($checkLoginCredentials)) {
            return redirect("dashboard")->withSuccess("You are registered logged in!");
        }
        return redirect("login")->withErrors("Login credentials are incorrect.");
    }

    public function dashboard()
    {
        if(Auth::check()) {
            return view("dashboard");
        }
        else {
            return redirect("login")->withSuccess("Login to access the dashboard page.");
        }
    }

}
