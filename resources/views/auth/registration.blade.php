@extends("layout")
@section("content")

    <section class="vh-100">
        <div class="container py-5 h-100">
        <div class="row d-flex justify-content-center align-items-center h-100">
            <div class="col col-xl-10">
            <div class="card" style="border-radius: 1rem;">
                <div class="row g-0">
                <div class="col-md-6 col-lg-5 d-none d-md-block">
                    <img src="/images/duck.png"
                    alt="Cute Duck Facing Left" class="img-fluid" style="border-radius: 1rem 0 0 1rem;" />
                </div>
                <div class="col-md-6 col-lg-7 d-flex align-items-center">
                    <div class="card-body p-4 p-lg-5 text-black">
                    <form method="POST" action="{{ route("registration.post") }}">
                        @csrf
    
                        <div class="d-flex align-items-center mb-3 pb-1">
                        <i class="fas fa-cubes fa-2x me-3" style="color: #ff6219;"></i>
                        <span class="h1 fw-bold mb-0">Sign Up</span>
                        </div>
    
                        <h5 class="fw-normal mb-3 pb-3" style="letter-spacing: 1px;">to create an account</h5>
                        @if (Session::has("success"))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                {{ Session::get("success") }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @elseif($errors->any())
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            @foreach ($errors->all() as $error)
                                <span>{{ $error }}</span><br>
                            @endforeach
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif

                        <div class="form-outline mb-4">
                        <input type="text" id="form2Example17" class="form-control form-control-lg" name="name" />
                        <label class="form-label" for="form2Example17">Name</label>
                        @if ($errors->has("name"))
                            <span class="text-danger">{{ $errors->first("name") }}</span>
                        @endif
                        </div>
                        
                        <div class="form-outline mb-4">
                            <input type="email" id="form2Example17" class="form-control form-control-lg" name="email"/>
                            <label class="form-label" for="form2Example17">Email address</label>
                            @if ($errors->has("email"))
                                <span class="text-danger">{{ $errors->first("email") }}</span>
                            @endif
                        </div>
                        
                        <div class="form-outline mb-4">
                            <input type="password" id="form2Example27" class="form-control form-control-lg" name="password"/>
                            <label class="form-label" for="form2Example27">Password</label>
                            @if ($errors->has("password"))
                                <span class="text-danger">{{ $errors->first("password") }}</span>
                            @endif
                        </div>
                        
                        <div class="pt-1 mb-4">
                            <input type="submit" name="submit" class="btn btn-dark btn-lg btn-block" value="Sign Up">
                        </div>
    
                        {{-- <a class="small text-muted" href="#!">Forgot password?</a> --}}
                        <p class="mb-5 pb-lg-2" style="color: #393f81;">Already have an account? <a href="{{ url("/login") }}"
                            style="color: #393f81;">Log In Here</a></p>

                    </form>
    
                    </div>
                </div>
                </div>
            </div>
            </div>
        </div>
        </div>
    </section>
@endsection

