@extends("layout")
@section("content")
    <div class="container-fluid bg-dark">
        <hgroup class="py-5 text-white text-center">
            <h1>Books</h1>
            <p class="fs-4">"{{ auth()->user()->name }}" is logged in ({{ auth()->user()->user_level }})</p>
        </hgroup>
    </div>
    {{-- <br><br> --}}
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
        {{-- <button><p class="text-end"> + Add Books</p> --}}


            <!-- Button trigger modal -->
        @if (auth()->user()->user_level == "lvl-1" || auth()->user()->user_level == "lvl-0")
            <div class="align-self-end">
                <button type="button" class="btn btn-dark w-auto m-2 me-0 " data-bs-toggle="modal" data-bs-target="#addBookModal">
                + Add Books
                </button>
            </div>
        @endif

            <table class="table table-hover">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Title</th>
                        <th scope="col">Author</th>
                        <th scope="col">Publication Company</th>
                        <th scope="col">Publication Date</th>
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
                    @foreach ($books as $i => $book)
                        <tr>
                            <td>{{ $i + 1 }}</td>
                            <td>{{ $book->title }}</td>
                            <td>{{ $book->author }}</td>
                            <td>{{ $book->publication_company }}</td>
                            <td>{{ $book->publication_date }}</td>

                            @if (auth()->user()->user_level == "lvl-3")
                            @elseif (auth()->user()->user_level == "lvl-2")
                                <td><a href="{{ route("bookedit", $book->id) }}"><button class="btn btn-dark">Edit</button></a></td>
                            @else
                                <td><a href="{{ route("bookedit", $book->id) }}"><button class="btn btn-dark">Edit</button></a></td>
                                <td>
                                    <form method="POST" action="{{ route("deletebook", $book->id) }}">
                                        @method("delete")
                                        @csrf
                                        
                                        <button type="button" class="btn btn-dark delete-warning-btn" data-bs-toggle="modal" data-bs-target="#modalid{{ $book->id }}">Delete</button>
                                        <div class="modal fade" id="modalid{{ $book->id }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                <h1 class="modal-title fs-5" id="exampleModalLabel">Warning</h1>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body delete-warning-modal">
                                                    Are you sure you want to delete "{{ $book->title }}" by {{ $book->author }}?
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
                            @endif

                        </tr>
                    @endforeach
                </tbody>
            </table>

            {{-- TODO: Modal for edit --}}
            <!-- Button trigger modal -->
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
                Edit
            </button>
            <!-- Modal -->
            <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                    <h1 class="modal-title fs-5" id="staticBackdropLabel">Edit Book</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form class="row g-3" method="POST" action="{{ route("editbook.post", $book->id) }}">
                            @csrf
                            <div class="modal-body">
                                <div class="mb-3 mt-3 row">
                                    <label for="title" class="col-sm-4 col-form-label">Title</label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" id="title" name="title" required value="{{ $book->title }}">
                                    </div>
                                </div>
                                <div class="mb-3 mt-3 row">
                                    <label for="author" class="col-sm-4 col-form-label">Author</label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" id="author" name="author" required value="{{ $book->author }}">
                                    </div>
                                </div>
                                <div class="mb-3 mt-3 row">
                                    <label for="publication-company" class="col-sm-4 col-form-label">Publication Co.</label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" id="publication_company" name="publication_company" required value="{{ $book->publication_company }}">
                                    </div>
                                </div>
                                <div class="mb-3 mt-3 row">
                                    <label for="publication-date" class="col-sm-4 col-form-label">Publication Date</label>
                                    <div class="col-sm-8">
                                        <input type="date" class="form-control" id="publication_date" name="publication_date" max="9999-12-31" required value="{{ $book->publication_date }}">
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
    </div>







    <!-- Modal for adding book -->
    <div class="modal fade" id="addBookModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
            <h5 class="modal-title" id="addBookModalLabel">Add Book</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form class="row g-3" method="POST" action="{{ route("addbook.post") }}">
                @csrf
                <div class="modal-body">
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
                    <button type="button" class="btn btn-dark" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-warning">Add</button>
                </div>
            </form>
        </div>
        </div>
    </div>

@endsection