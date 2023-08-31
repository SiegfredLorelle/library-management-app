@extends("layout")
@section("content")
    <div class="container-fluid bg-dark">
        <hgroup class="py-5 text-white text-center">
            <h1>Admin Panel</h1>
            <p class="fs-4">"{{ auth()->user()->name }}" is logged in ({{ auth()->user()->user_level }})</p>
        </hgroup>
    </div>
    
    @if ($errors->any())
        <div>
            {{-- <li>{{ $error }}</li> --}}
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                @foreach ($errors->all() as $error)
                    <span>{{ $error }}</span>
                @endforeach
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        </div>

    @elseif (Session::has("success"))
        <div>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ Session::get("success") }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        </div>
    @endif

    <div class="container-fluid d-flex flex-column mt-5">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Name</th>
                    <th scope="col">Email</th>
                    <th scope="col">User Level</th>
                    @if (auth()->user() != null)
                        @if (auth()->user()->user_level == "lvl-3")
                        @elseif (auth()->user()->user_level == "lvl-2")
                            <th scope="col"></th>
                        @else
                            <th scope="col"></th>
                            <th scope="col"></th>
                        @endif
                    @endif
                </tr>
            </thead>
            <tbody class="table-group-divider">
                @foreach ($users as $user)
                    <tr>
                        <td>{{ $user->id }}</td>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->user_level }}</td>
                        @if ($user->user_level != "lvl-0")
                        <td><button type="button" class="btn btn-dark" data-bs-toggle="modal" data-bs-target="#edit{{ $user->id }}">
                            <i class="fa-solid fa-user-pen"></i> Edit
                        </button></td>
                            <!-- Modal for edding books -->
                            <div class="modal fade" id="edit{{ $user->id }}" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                    <h1 class="modal-title fs-5" id="staticBackdropLabel">Edit Book</h1>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <form class="row g-3" method="POST" action="{{ route("edituser.post", $user->id) }}">
                                            @csrf
                                            <div class="modal-body">
                                                <div class="mb-3 mt-3 row">
                                                    <label for="title" class="col-sm-4 col-form-label">Name</label>
                                                    <div class="col-sm-8">
                                                        <input type="text" class="form-control" id="name" name="name" required value="{{ $user->name }}">
                                                    </div>
                                                </div>
                                                <div class="mb-3 mt-3 row">
                                                    <label for="author" class="col-sm-4 col-form-label">User Level</label>
                                                    <div class="col-sm-8">
                                                        @if ($user->user_level != "lvl-0")
                                                            <select class="form-select" aria-label="Default select example" id="user_level" name="user_level">
                                                                @if ($user->user_level == "lvl-1")
                                                                    <option value="lvl-1" selected>lvl-1 (view, add, edit, & delete)</option>
                                                                @else
                                                                    <option value="lvl-1">lvl-1 (view, add, edit, & delete)</option>
                                                                @endif
                                    
                                                                @if ($user->user_level == "lvl-2")
                                                                    <option value="lvl-2" selected>lvl-2 (view & edit)</option>
                                                                @else
                                                                    <option value="lvl-2">lvl-2 (view & edit)</option>
                                                                @endif
                                    
                                                                @if ($user->user_level == "lvl-3")
                                                                    <option value="lvl-3" selected>lvl-3 (view only)</option>
                                                                @else
                                                                    <option value="lvl-3">lvl-3 (view only)</option>
                                                                @endif
                                                            </select>
                                                        @else
                                                            <select class="form-select" aria-label="Default select example" id="user_level" name="user_level">
                                                                <option value="lvl-0" selected>lvl-0 (admin)</option>
                                                            </select>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-dark" data-bs-dismiss="modal">Close</button>
                                                <button type="submit" class="btn btn-warning">Edit</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                                </div>
                            </div>
                            <td>
                                <form method="POST" action="{{ route("deleteuser", $user->id) }}">
                                    @method("delete")
                                    @csrf
                                    <button type="button" class="btn btn-dark delete-warning-btn" data-bs-toggle="modal" data-bs-target="#delete{{ $user->id }}"><i class="fa-solid fa-user-xmark"></i> Delete</button>
                                    <div class="modal fade" id="delete{{ $user->id }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h1 class="modal-title fs-5" id="exampleModalLabel">Warning</h1>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body delete-warning-modal">
                                                    Are you sure you want to delete user: {{ $user->name }} (id: {{ $user->id }})? 
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-dark" data-bs-dismiss="modal">Cancel</button>
                                                    <button type="submit" class="btn btn-danger">Delete</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </td>
                        @elseif ($user == auth()->user())
                        <td><button type="button" class="btn btn-dark" data-bs-toggle="modal" data-bs-target="#edit{{ $user->id }}">
                            <i class="fa-solid fa-user-pen"></i> Edit
                        </button></td>
                            <!-- Modal for edding books -->
                            <div class="modal fade" id="edit{{ $user->id }}" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                    <h1 class="modal-title fs-5" id="staticBackdropLabel">Edit Book</h1>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <form class="row g-3" method="POST" action="{{ route("edituser.post", $user->id) }}">
                                            @csrf
                                            <div class="modal-body">
                                                <div class="mb-3 mt-3 row">
                                                    <label for="title" class="col-sm-4 col-form-label">Name</label>
                                                    <div class="col-sm-8">
                                                        <input type="text" class="form-control" id="name" name="name" required value="{{ $user->name }}">
                                                    </div>
                                                </div>
                                                <div class="mb-3 mt-3 row">
                                                    <label for="author" class="col-sm-4 col-form-label">User Level</label>
                                                    <div class="col-sm-8">
                                                        @if ($user->user_level != "lvl-0")
                                                            <select class="form-select" aria-label="Default select example" id="user_level" name="user_level">
                                                                @if ($user->user_level == "lvl-1")
                                                                    <option value="lvl-1" selected>lvl-1 (view, add, edit, & delete)</option>
                                                                @else
                                                                    <option value="lvl-1">lvl-1 (view, add, edit, & delete)</option>
                                                                @endif
                                    
                                                                @if ($user->user_level == "lvl-2")
                                                                    <option value="lvl-2" selected>lvl-2 (view & edit)</option>
                                                                @else
                                                                    <option value="lvl-2">lvl-2 (view & edit)</option>
                                                                @endif
                                    
                                                                @if ($user->user_level == "lvl-3")
                                                                    <option value="lvl-3" selected>lvl-3 (view only)</option>
                                                                @else
                                                                    <option value="lvl-3">lvl-3 (view only)</option>
                                                                @endif
                                                            </select>
                                                        @else
                                                            <select class="form-select" aria-label="Default select example" id="user_level" name="user_level">
                                                                <option value="lvl-0" selected>lvl-0 (admin)</option>
                                                            </select>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-dark" data-bs-dismiss="modal">Close</button>
                                                <button type="submit" class="btn btn-warning">Edit</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                                </div>
                            </div>
                            <td><a class="invisible" href="#"><button class="btn btn-dark">Delete</button></a></td>
                        @else
                            <td><a class="invisible" href="#"><button class="btn btn-dark">Edit</button></a></td>
                            <td><a class="invisible" href="#"><button class="btn btn-dark">Delete</button></a></td>
                    @endif
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection