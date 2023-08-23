@extends("layout")
@section("content")
    <div class="container-fluid min-vh-100 d-flex flex-column justify-content-center">
        <h1 class="text-center">Admin Page</h1>
        <h2 class="text-center">"{{ auth()->user()->name }}" is logged in</h2>
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
                        <td scope="col"><button type="submit" class="btn btn-danger">Delete</button></td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection