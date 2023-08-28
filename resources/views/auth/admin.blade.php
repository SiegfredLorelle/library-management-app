@extends("layout")
@section("content")
    <div class="container-fluid bg-dark mb-5">
        <hgroup class="py-5 text-white">
            <h1 class="text-center">Admin Panel</h1>
            <p class="text-center fs-4">"{{ auth()->user()->name }}" is logged in ({{ auth()->user()->user_level }})</p>
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

    <div class="container-fluid d-flex flex-column">
        <table class="table">
            <thead class="table-dark">
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
            <tbody>
                @foreach ($users as $user)
                    <tr>
                        <td>{{ $user->id }}</td>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->user_level }}</td>
                        @if ($user->user_level != "lvl-0")
                            <td><a href="{{ route("edituser", $user->id) }}"><button class="btn btn-dark">Edit</button></a></td>
                            <td>
                                <form method="POST" action="{{ route("deleteuser", $user->id) }}">
                                    @method("delete")
                                    @csrf
                                    <button type="button" class="btn btn-dark delete-warning-btn" data-bs-toggle="modal" data-bs-target="#modalid{{ $user->id }}">Delete</button>
                                    <div class="modal fade" id="modalid{{ $user->id }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                        <td><a href="{{ route("edituser", $user->id) }}"><button class="btn btn-dark">Edit</button></a></td>
                            <td><a class="invisible" href="{{ route("edituser", $user->id) }}"><button class="btn btn-dark">Edit</button></a></td>
                        @else
                            <td><a class="invisible" href="{{ route("edituser", $user->id) }}"><button class="btn btn-dark">Edit</button></a></td>
                            <td><a class="invisible" href="{{ route("edituser", $user->id) }}"><button class="btn btn-dark">Edit</button></a></td>
                    @endif
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection