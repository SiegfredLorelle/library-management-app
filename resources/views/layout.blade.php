<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="/favicon.ico">
    <title>Duck Library App</title>

    <!-- Import Bootstrap -->
    {{-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous"> --}}
    
    {{-- Import Font Awesome --}}
    {{-- <script src="https://kit.fontawesome.com/2fa58dfbff.js" crossorigin="anonymous"></script> --}}
    {{-- <link type="text/css" rel="stylesheet" href="{{ mix('css/app.css') }}"> --}}
    
    @vite(["resources/css/app.css", "resources/js/app.js", "resources/sass/app.scss"])
</head>


<body>
{{-- <header class="p-3 bg-dark text-white">
        <div class="container">
        <div class="d-flex flex-wrap align-items-center justify-content-center justify-content-lg-start">
            <a href="/" class="d-flex align-items-center mb-2 mb-lg-0 text-white text-decoration-none">
            <svg class="bi me-2" width="40" height="32" role="img" aria-label="Bootstrap"><use xlink:href="#bootstrap"></use></svg>
            </a>

            <ul class="nav col-12 col-lg-auto me-lg-auto mb-2 justify-content-center mb-md-0">
            <li><a href="{{ url("/login") }}" class="nav-link px-2 text-secondary">Home</a></li>
            <li><a href="#" class="nav-link px-2 text-white">Page2</a></li>
            <li><a href="#" class="nav-link px-2 text-white">Page3</a></li>
            <li><a href="#" class="nav-link px-2 text-white">Page4</a></li>
            <li><a href="#" class="nav-link px-2 text-white">Page5</a></li>
            </ul>


            <div class="text-end">
                @guest
                    <a href="{{ url('login') }}"><button type="button" class="btn btn-outline-light me-2">Login</button></a>
                    <a href="{{ url('registration') }}"><button type="button" class="btn btn-warning">Sign Up</button></a>
                @else
                <a href="{{ url('logout') }}"><button type="button" class="btn btn-outline-light me-2">Logout</button></a>
                @endguest

            </div>
        </div>
        </div>
    </header> --}}
  {{-- <div class="container-fluid">
    <a class="navbar-brand" href="#">
      <img src="/docs/5.3/assets/brand/bootstrap-logo.svg" alt="Logo" width="30" height="24" class="d-inline-block align-text-top">
      Bootstrap
    </a>
  </div> --}}


    <nav class="navbar navbar-dark bg-dark fixed-top">
      <div class="container-fluid">
        <a class="navbar-brand" href="{{ url("/dashboard") }}"><img src="/images/logo.png" width="30" height="24" class="d-inline-block align-text-top" alt="Duck Library App Logo"> Duck Library App</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasDarkNavbar" aria-controls="offcanvasDarkNavbar">
          <span class="navbar-toggler-icon"></span>
        </button>
          <div class="offcanvas offcanvas-end text-bg-dark" tabindex="-1" id="offcanvasDarkNavbar" aria-labelledby="offcanvasDarkNavbarLabel">
            <div class="offcanvas-header">
              <h5 class="offcanvas-title" id="offcanvasDarkNavbarLabel">Duck Library App</h5>
              <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas" aria-label="Close"></button>
            </div>
            <div class="offcanvas-body">
              <ul class="navbar-nav justify-content-end flex-grow-1 pe-3">
                @guest
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="{{ url("/login") }}">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ url("/login") }}">Log In</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ url("/registration") }}">Sign Up</a>
                    </li>
                @else
                    <li class="nav-item">
                      <a class="nav-link active" aria-current="page" href="{{ url("/dashboard") }}">Home</a>
                    </li>
                    @if (auth()->user() != null && auth()->user()->user_level == "lvl-0")
                    <li class="nav-item">
                      <a class="nav-link" href="{{ url("/admin") }}">Admin</a>
                    </li>
                    @endif
                    <li class="nav-item">
                      <a class="nav-link" href="{{ url("/logout") }}">Log Out</a>
                    </li>
                @endguest
              </ul>
            </div>
          </div>
        </div>
      </nav>

    





      
      <div class="mt-5 pt-2">
        @yield("content")
      </div>
      
      <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>

</body>
</html>