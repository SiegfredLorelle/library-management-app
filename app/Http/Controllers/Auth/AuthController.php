<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Book;
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
            $books = Book::orderby("title")->get();
            return view("dashboard", ["books" => $books]);
        }
        else {
            return redirect("login")->withErrors("Login to access the dashboard page.");
        }
    }

    // public function bookAdd() 
    // {
        
    // }

    public function postAddBook(Request $request)
    {
        $request->validate([
            "title" => "required",
            "author" => "required",
            "publication_company" => "required",
            'publication_date' => 'required|before:tomorrow'
        ]);

        $book = new Book;
        $book->title = $request->title;
        $book->author = $request->author;
        $book->publication_company = $request->publication_company;
        $book->publication_date = $request->publication_date;

        $book->save();
        return redirect("dashboard")->withSuccess("Book added!");
    }
    
    
    public function editBook(int $id)
    {
        $book = Book::findOrFail($id);
        return view("book.edit", ["book"=>$book]);
    }
    
    public function postEditBook(Request $request, int $id)
    {
        $request->validate([
            "title" => "required",
            "author" => "required", 
            "publication_company" => "required",
            'publication_date' => 'required|before:tomorrow'
        ]);

        $book = Book::findOrFail($id);
        $book->title = $request->title;
        $book->author = $request->author;
        $book->publication_company = $request->publication_company;
        $book->publication_date = $request->publication_date;
        $book->save();
        return redirect("dashboard")->withSuccess("Book edited!");
    }

    public function deleteBook($id) 
    {
        $book = Book::findOrFail($id);
        $book->delete();
        // return redirect("dashboard")->withSuccess("Book edited!");
        return redirect("dashboard")->withSuccess("Book deleted!");
    }


    public function admin() 
    {   
        if (!Auth::check()) {
            // return $this->login();
            return redirect("login")->withErrors("Login to access dashboard.");
        }
        if (Auth::user()->user_level != "lvl-0") {
            return $this->dashboard();
        }

        $users = User::orderby("id")->get();
        return view("auth.admin", ["users" => $users]);
    }

    public function editUser(int $id)
    {
        $user = User::findOrFail($id);
        return view("auth.edit_users", ["user"=>$user]);
    }

    public function postEditUser(Request $request, int $id)
    {
        $request->validate([
            "name" => "required",
            "user_level" => "required|starts_with:lvl-|ends_with:1,2,3|size:5",
        ]);

        $user = User::findOrFail($id);
        $user->name = $request->name;
        $user->user_level = $request->user_level;

        $user->save();
        return redirect("admin")->withSuccess("User edited!");

        // $user = User::findOrFail($id);
        // return view("auth.edit_users", ["user"=>$user]);
    }

    public function deleteUser($id)
    {
        $user = User::findOrFail($id);
        $user->delete();
        return redirect("admin")->withSuccess("User deleted!");
    }
}
