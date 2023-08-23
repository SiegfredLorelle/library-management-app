@extends("layout")
@section("content")
    <div class="container-fluid min-vh-100 d-flex flex-column justify-content-center">
        <h1 class="text-center">Admin Panel</h1>
        <h2 class="text-center">"{{ auth()->user()->name }}" is logged in ({{ auth()->user()->user_level }})</h2>
        <br><br>
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
                                            Are you sure you want to delete user: {{ $user->name }} {{ $user->id }}? 
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
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection