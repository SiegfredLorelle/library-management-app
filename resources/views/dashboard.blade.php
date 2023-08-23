@extends("layout")
@section("content")
    <div class="container-fluid min-vh-100 d-flex flex-column justify-content-center">
        <h1 class="text-center">Dashboard Here</h1>
        <h2 class="text-center">"{{ auth()->user()->name }}" is logged in</h2>
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


            <!-- Button trigger modal -->
        @if (auth()->user()->user_level == "lvl-1" || auth()->user()->user_level == "lvl-0")
            <div class="align-self-end">
                <button type="button" class="btn btn-dark w-auto m-2 me-0 " data-bs-toggle="modal" data-bs-target="#staticBackdrop">
                + Add Books
                </button>
            </div>
        @endif

            <table class="table">
                <thead class="table-dark">
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
                <tbody>
                    @for ($i = 0; $i < count($books); $i++)
                        <tr>
                            <td>{{ $i + 1 }}</td>
                            <td>{{ $books[$i]->title }}</td>
                            <td>{{ $books[$i]->author }}</td>
                            <td>{{ $books[$i]->publication_company }}</td>
                            <td>{{ $books[$i]->publication_date }}</td>

                            @if (auth()->user()->user_level == "lvl-3")
                            @elseif (auth()->user()->user_level == "lvl-2")
                                <td><a href="{{ route("bookedit", $books[$i]->id) }}"><button class="btn btn-dark">Edit</button></a></td>
                            @else
                                <td><a href="{{ route("bookedit", $books[$i]->id) }}"><button class="btn btn-dark">Edit</button></a></td>
                                <td>
                                    <form method="POST" action="{{ route("deletebook", $books[$i]->id) }}">
                                        @method("delete")
                                        @csrf
                                        <button type="button" class="btn btn-dark delete-warning-btn" data-bs-toggle="modal" data-bs-target="#deleteModal" value="{{ $books[$i]->title }}" data-value="{{ $books[$i]->id }}">Delete</button>
                                        
                                        <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                <h1 class="modal-title fs-5" id="exampleModalLabel">Warning</h1>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body delete-warning-modal">
                                                    Are you sure you want to delete "{{ $books[$i]->title }}" by {{ $books[$i]->author }}?
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
                    @endfor
                </tbody>
            </table>







    <!-- Modal for adding book -->
    <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
            <h5 class="modal-title" id="staticBackdropLabel">Add Book</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form class="row g-3" method="POST" action="{{ route("addbook.post") }}">
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
                    <button type="button" class="btn btn-dark" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-warning">Add</button>
                </div>
            </form>
        </div>
        </div>
    </div>


    {{-- Modal warning before deleting book --}}
    <!-- Button trigger modal -->

    
    <!-- Modal -->


    <script>
        // warningBtns = document.querySelectorAll(".delete-warning-btn");
        // warningModal = document.querySelector(".delete-warning-modal");

        // warningBtns.forEach(btn => {
        //     btn.addEventListener("click", () => {
        //         warningModal.innerHTML = `Are you sure you want to delete ${btn.value} ${btn.getAttribute("data-value")}`;
                
        //     });
        // });

        // window.deleteConfirm = (e) => {
        //     e.preventDefault();
        //     const form = e.target.form;
        //     if (window.confirm(`Do you want to delete ${e.target.value}?`)) {
        //         form.submit();
        //     }
        // }

    </script>
@endsection