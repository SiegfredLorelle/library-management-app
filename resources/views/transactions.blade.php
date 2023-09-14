@extends("layout")
@section("content")
    <div class="container-fluid bg-dark">
        <hgroup class="py-5 text-white text-center">
            <h1>Pending Transactions</h1>
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


        <table class="table table-hover">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Borrowed by</th>
                    <th scope="col">Title</th>
                    <th scope="col">Author</th>
                    <th scope="col">Deadline</th>
                    <th scope="col">Time Before Deadline</th>
                </tr>
            </thead>
            <tbody class="table-group-divider">
                @if (auth()->user()->user_level == "lvl-3")
                
                @else
                    @foreach ($borrowedBooks as $i => $borrowedBook)
                        <tr>
                            <td>{{ $i + 1 }}</td>
                            @foreach ($books as $book)
                                @if ($book->id == $borrowedBook->book_id)
                                    <td>
                                        @foreach ($users as $user)
                                            @if ($borrowedBook->borrower_id == $user->id)
                                                {{ $user->name }}
                                            @endif
                                        @endforeach
                                    </td>
                                    <td>{{ $book->title }}</td>
                                    <td>{{ $book->author }}</td>
                                    <td>{{ $borrowedBook->deadline }}</td>
                                    <td>{{ $borrowedBook->deadline }}</td>
                                @break
                                @endif
                            @endforeach
                        </tr>
`                   @endforeach
                @endif
            </tbody>
        </table>

@endsection