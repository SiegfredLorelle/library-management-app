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
        return redirect("login")->withSuccess("Account registered!");
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
            return redirect("dashboard")->withSuccess("Login successful, welcome!");
        }
        return redirect("login")->withErrors("Incorrect login credentials.");
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
    
    
    // public function editBook(int $id)
    // {
    //     if (!Auth::check()) {
    //         return redirect("login")->withErrors("Login to access dashboard.");
    //     }
        
    //     $book = Book::findOrFail($id);
    //     if (Auth::user()->user_level == "lvl-3") {
    //         return redirect("dashboard")->withErrors("No permission to edit books.");;
    //     }
    //     return view("book.edit", ["book"=>$book]);
    // }
    
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
            return redirect("login")->withErrors("Login to access dashboard.");
        }
        if (Auth::user()->user_level != "lvl-0") {
            return redirect("dashboard")->withErrors("No permission.");;
        }
        
        $users = User::orderby("user_level")->get();
        return view("auth.admin", ["users" => $users]);
    }
    
    // public function editUser(int $id)
    // {
    //     // Ensure user is logged in
    //     if (!Auth::check()) {
    //         return redirect("login")->withErrors("Login to access dashboard.");
    //     }

    //     $logged_user = Auth::user();
    //     $user_to_edit = User::findOrFail($id);

    //     // Ensure the user is an admin (allowed to edit users)
    //     if ($logged_user->user_level != "lvl-0") {
    //         return redirect("admin")->withErrors("No permission to edit users.");;
    //     }
        
    //     // Ensure the user is editing non-admin users (except self, admins are allowed to edit his/her self)
    //     if ($user_to_edit->user_level == "lvl-0" && $logged_user->id != $user_to_edit->id) {
    //         return redirect("admin")->withErrors("No permission to edit other admins.");;
    //     }

    //     return view("auth.edit_users", ["user"=>$user_to_edit]);
    // }

    public function postEditUser(Request $request, int $id)
    {
        $request->validate([
            "name" => "required",
            "user_level" => "required|starts_with:lvl-|ends_with:0,1,2,3|size:5",
        ]);

        $user = User::findOrFail($id);
        
        // Ensure that admins' user level wasn't changed
        if ($user->user_level == "lvl-0" && $request->user_level != "lvl-0") {
            return redirect("/edit-user/$id")->withErrors("No permission to edit admins' user levels.");
        }
        
        // Ensure that user level aren't edited into admin
        if ($user->user_level != "lvl-0" && $request->user_level == "lvl-0") {
            return redirect("/dashboard")->withErrors("No permission to edit users into admin.");
        }

        // Update database
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


// TODO:
// style table (center elements, add icons to edit n delete btn)
// fix highlight in nav
// check if editing books/user changed smth
// Add back btn in edit pgs?
// delete comments in views
// add text when admin/book table is empty
// disable btns for edit and delete in admin pg