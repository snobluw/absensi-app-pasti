<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Login | PASTI</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" integrity="sha384-SgOJa3DmI69IUzQ2PVdRZhwQ+dy64/BUtbMJw1MZ8t5HZApcHrRKUc4W0kG879m7" crossorigin="anonymous">
    <link rel="stylesheet" href="css/style.css">

  </head>

<body class=" d-flex text-center vh-100  flex-column p-5">

    @if(session()->has('loginError'))
    <div class="alert alert-danger alert-dismissible fade show pb-3" role="alert">
      {{ session('loginError') }}
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif
    
<main class="form-signin">

  <form action ="/login" method="post">
    @csrf
    <img class="mb-4" src="img/logo-sekolah.png" alt="" width="72" height="72">
    <h1 class="h3 mb-3 fw-normal">Selamat Datang</h1>

    <div class="form-floating">
        <input type="text" class="form-control" id="username" name="username" placeholder="Username" autofocus required>
        <label for="username">Username</label>
      </div>
      <div class="form-floating">
        <input type="password" class="form-control" id="password" name="password" placeholder="Password" required>
        <label for="password">Password</label>
      </div>
    <div class="pt-3 d-flex flex-column justify-content-between">
        <button class="w-100 btn btn-lg btn-primary" type="submit">Sign in</button>
        <a href="/lupa-password" class="pt-3"><small>Lupa password </small></a>
    </div>
  </form>
</main>

<small class="text-muted ">PASTI - Presensi dan Administrasi Sistem Terpadu Inovatif MTs Cahaya Harapan <br>&copy;  2024-2025</small>


    
  </body>
</html>
