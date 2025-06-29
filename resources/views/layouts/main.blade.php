<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title> PASTI | {{ $title }}</title>

	<!--Boostrap-->
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet"
		integrity="sha384-SgOJa3DmI69IUzQ2PVdRZhwQ+dy64/BUtbMJw1MZ8t5HZApcHrRKUc4W0kG879m7" crossorigin="anonymous">
	<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css" rel="stylesheet">
	<!--Custom CSS-->
	<link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>

<body>

	<?php
	$roles = auth()->user()->role;

	if ($roles == 'admin') {
		$sidebar = 'partials.sidebar-admin';
	} else {
		$sidebar = 'partials.sidebar-guru';
	}
	?>

	<div class="d-flex">
		<!--Sidebar-->
		@include($sidebar)

		<!--Sidebar Overlay for mobile-->
		<div id="sidebar-overlay"></div>

		<!--Main Component-->
		<div class="main">
			<!--Main Navbar-->
			<nav class="navbar navbar-expand border-bottom">
				<!--- Sidebar Toggler -->
				<button class="toggler-btn" type="button">
					<i class="bi bi-list"></i>
				</button>
				<div class="brand ms-3">
					PASTI
				</div>
				<!--Navbar item right  -->
				<ul class="navbar-nav ms-auto d-flex align-items-center gap-3">
					<!-- Navbar Item Profile Dropdown-->
					<li class="nav-item dropdown fs-6">
						<a class="nav-link " href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown"
							aria-expanded="false">
							@if (auth()->user()->avatar)
							<img src="{{ asset('storage/' . auth()->user()->avatar) }}" alt="user"
								class="rounded-circle me-2" style="width: 40px; height: 40px;">
							@else
							<img src={{ $image=auth()->user()->gender == 'L' ? 'https://avatar.iran.liara.run/public/5'
							: 'https://avatar.iran.liara.run/public/74' }} alt="user" class="rounded-circle me-2"
							style="width: 40px; height: 40px;">
							@endif
						</a>
						<ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
							<li>
								<div class="d-flex p-3 fw-medium justify-content-center align-items-center gap-2 ">
									@if (auth()->user()->avatar)
									<img src="{{ asset('storage/' . auth()->user()->avatar) }}" alt="user"
										class="rounded-circle me-2" style="width: 54px; height: 54px;">
									@else
									<img src={{ $image=auth()->user()->gender == 'L' ?
									'https://avatar.iran.liara.run/public/5' : 'https://avatar.iran.liara.run/public/74'
									}} alt="user" class="rounded-circle me-2"
									style="width: 54px; height: 54px;">
									@endif
									{{ auth()->user()->username }}
								</div>
							</li>
							<li>
								<hr class="dropdown-divider">
							</li>
							<li><a class="dropdown-item" href="/profile">Profile</a></li>

							<li>
								<hr class="dropdown-divider">
							</li>
							<li>
								<form action="/logout" method="POST">
									@csrf
									<button type="submit" class="dropdown-item">Logout</button>
								</form>
							</li>
						</ul>
					</li>
				</ul>
			</nav>
			<main class="p-3">
				<div class="container-fluid">
					<div class="mb-3 gap-2 text-left d-flex flex-column">
						<h3>{{ $title }}</h3>
						@yield('content')
					</div>
				</div>
			</main>
		</div>
	</div>

	<script src="{{ asset('js/script.js') }}"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"
		integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g=="
		crossorigin="anonymous" referrerpolicy="no-referrer"></script>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js"
		integrity="sha384-k6d4wzSIapyDyv1kpU366/PK5hCdSbCRGRCMv+eplOQJWyd1fbcAu9OCUj5zNLiq" crossorigin="anonymous">
	</script>
</body>

</html>