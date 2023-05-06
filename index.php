<?php
    require("config/config.php");
?> 
<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="icon" href="resources/img/logo2.png" type="image/x-icon">
	<title>Katiga Carwash Booking System</title>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.0.1/css/bootstrap.min.css" integrity="sha512-Ez0cGzNzHR1tYAv56860NLspgUGuQw16GiOOp/I2LuTmpSK9xDXlgJz3XN4cnpXWDmkNBKXR/VDMTCnAaEooxA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>

<body>
	<section class="h-100">
		<div class="container h-100">
			<div class="row justify-content-sm-center h-100">
				<div class="col-xxl-4 col-xl-5 col-lg-5 col-md-7 col-sm-9 my-3">
					<div class="text-center">
						<img src="resources/img/logo2.png" alt="logo" height="150" width="150">
					</div>
					<!-- Nav tabs -->
					<ul class="nav nav-tabs" role="tablist">
						<li class="nav-item">
							<a class="nav-link active" href="#login-tab" data-bs-toggle="tab" role="tab" aria-controls="login-tab" aria-selected="true">Login</a>
						</li>
						<li class="nav-item">
							<a class="nav-link" href="#register-tab" data-bs-toggle="tab" role="tab" aria-controls="register-tab" aria-selected="false">Register</a>
						</li>
					</ul>

					<!-- Tab panes -->
					<div class="tab-content">
						<div class="tab-pane show active" id="login-tab" role="tabpanel" aria-labelledby="login-tab">
							<div class="card shadow-lg">
								<div class="card-body p-4">
									<form method="POST" action="config/session-login.php" class="needs-validation" novalidate="" autocomplete="off">
										<div class="mb-3">
											<label class="mb-2 text-muted" for="email">Email Address</label>
											<input id="email" type="email" class="form-control" name="email" value="" required autofocus>
											<div class="invalid-feedback">
												Email is invalid
											</div>
										</div>
		
										<div class="mb-3">
											<div class="mb-2 w-100">
												<label class="text-muted" for="password">Password</label>
												<!-- <a href="forgot.html" class="float-end">
													Forgot Password?
												</a> -->
											</div>
											<input id="password" type="password" class="form-control" name="password" required data-eye>
											<div class="invalid-feedback">
												Password is required
											</div>
										</div>
		
										<div class="d-flex align-items-center">
											<div class="form-check">
												<input type="checkbox" name="remember" id="remember" class="form-check-input">
												<label for="remember" class="form-check-label">Remember Me</label>
											</div>
											<button type="submit" class="btn btn-primary ms-auto">
												Login
											</button>
										</div>
									</form>
								</div>
							</div>	
							
						</div>
						<div class="tab-pane fade" id="register-tab" role="tabpanel" aria-labelledby="register-tab">
							<div class="card shadow-lg">
								<div class="card-body p-4">
									<form method="POST" action="config/register.php" class="needs-validation" novalidate="" autocomplete="off">
										<div class="mb-3">
											<label class="mb-2 text-muted" for="nama_lengkap">Name</label>
											<input id="nama_lengkap" type="text" class="form-control" name="nama_lengkap" value="" required autofocus>
											<div class="invalid-feedback">
												Name is required	
											</div>
										</div>
		
										<div class="mb-3">
											<label class="mb-2 text-muted" for="email">Email Address</label>
											<input id="email" type="email" class="form-control" name="email" value="" required>
											<div class="invalid-feedback">
												Email is invalid
											</div>
										</div>
		
										<div class="mb-3">
											<label class="mb-2 text-muted" for="password">Password</label>
											<input id="password" type="password" class="form-control" name="password" required>
											<div class="invalid-feedback">
												Password is required
											</div>
										</div>
		
										<!-- <p class="form-text text-muted mb-3">
											By registering you agree with our terms and condition.
										</p> -->
		
										<div class="align-items-center d-flex">
											<button type="submit" class="btn btn-primary ms-auto">
												Register	
											</button>
										</div>
									</form>
								</div>
							</div>
						</div>
					</div>

				</div>
			</div>
		</div>
	</section>
	
	<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.0.2/js/bootstrap.bundle.min.js"></script>

</body>

</html>