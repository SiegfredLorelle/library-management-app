@extends("layout")
@section("content")
    <div class="container-fluid min-vh-100 d-flex flex-column justify-content-center">
        <h1 class="text-center">Edit Users</h1>
        {{-- <h2 class="text-center">"{{ auth()->user()->name }}" is logged in</h2> --}}
        {{-- <p class="text-center red">{{ $abc }}</p> --}}
        <br><br>
        {{-- <button><p class="text-end"> + Add edituser</p> --}}
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

        <form class="row g-3 w-50 mx-auto" method="POST" action="{{ route("edituser.post", $user->id) }}">
            @csrf
            <div class="mb-3 mt-3 row">
                <label for="title" class="col-sm-4 col-form-label">Name</label>
                <div class="col-sm-8">
                    <input type="text" class="form-control" id="name" name="name" required value="{{ $user->name }}">
                </div>
            </div>
            <div class="mb-3 mt-3 row">
                <label for="publication-company" class="col-sm-4 col-form-label">User Level</label>
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
            <div class="modal-footer">
                <button type="submit" class="btn btn-dark">Edit</button>
            </div>
        </div>
    </form>



@endsection