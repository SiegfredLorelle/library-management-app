@extends("layout")
@section("content")
    <div class="container-fluid min-vh-100 d-flex flex-column justify-content-center">
        <h1 class="text-center">Dashboard Here</h1>
        <h2 class="text-center">"{{ auth()->user()->name }}" is logged in</h2>
        <p class="text-center red">{{ $abc }}</p>
        <br><br>
        {{-- <button><p class="text-end"> + Add Books</p> --}}


            <!-- Button trigger modal -->
        <div class="align-self-end">
            <button type="button" class="btn btn-dark w-auto m-2 me-0 " data-bs-toggle="modal" data-bs-target="#staticBackdrop">
            + Add Books
            </button>
        </div>
    
        <button type="button" class="btn btn-dark w-auto m-2 me-0">+ Add Books</button>
        <table class="table">
            <thead class="table-dark">
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Title</th>
                    <th scope="col">Author</th>
                    <th scope="col">Publication Company</th>
                    <th scope="col">Publication Date</th>
                    <th scope="col"></th>
                    <th scope="col"></th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>{{ $abc }}</td>
                    <td>{{ $abc }}</td>
                    <td>{{ $abc }}</td>
                    <td>{{ $abc }}</td>
                    <td>{{ $abc }}</td>
                    <td><button class="btn btn-primary">Edit</button></td>
                    <td><button class="btn btn-primary">Delete</button></td>
                </tr>
            </tbody>
          </table>







    <!-- Modal -->
    <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
            <h5 class="modal-title" id="staticBackdropLabel">Modal title</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
            ...
            </div>
            <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            <button type="button" class="btn btn-primary">Understood</button>
            </div>
        </div>
        </div>
    </div>
@endsection