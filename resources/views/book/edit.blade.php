@extends("layout")
@section("content")
    <div class="container-fluid min-vh-100 d-flex flex-column justify-content-center">
        <h1 class="text-center">Edit Book</h1>
        {{-- <h2 class="text-center">"{{ auth()->user()->name }}" is logged in</h2> --}}
        {{-- <p class="text-center red">{{ $abc }}</p> --}}
        <br><br>
        {{-- <button><p class="text-end"> + Add Books</p> --}}
        @if ($errors->any())
            <div>
                {{-- <li>{{ $error }}</li> --}}
                <div class="alert alert-danger">
                    @foreach ($errors->all() as $error)
                        <span>{{ $error }}</span>
                    @endforeach
                </div>
            </div>

        @elseif (Session::has("success"))
            <div>
                <div class="alert alert-success ">{{ Session::get("success") }}</div>
            </div>
        @endif

        <form class="row g-3 w-50 mx-auto" method="POST" action="{{ route("addbook.post") }}">
            @csrf
            <div class="mb-3 mt-3 row">
                <label for="title" class="col-sm-4 col-form-label">Title</label>
                <div class="col-sm-8">
                    <input type="text" class="form-control" id="title" name="title" required>
                </div>
            </div>
            <div class="mb-3 mt-3 row">
                <label for="author" class="col-sm-4 col-form-label">Author</label>
                <div class="col-sm-8">
                    <input type="text" class="form-control" id="author" name="author" required>
                </div>
            </div>
            <div class="mb-3 mt-3 row">
                <label for="publication-company" class="col-sm-4 col-form-label">Publication Co.</label>
                <div class="col-sm-8">
                    <input type="text" class="form-control" id="publication_company" name="publication_company" required>
                </div>
            </div>
            <div class="mb-3 mt-3 row">
                <label for="publication-date" class="col-sm-4 col-form-label">Publication Date</label>
                <div class="col-sm-8">
                    <input type="date" class="form-control" id="publication_date" name="publication_date" max="9999-12-31" required>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary">Add</button>
        </div>
    </form>








@endsection