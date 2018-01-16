<!-- This page allows the user to register as a customer to enable the checkout function. -->
<?php
// We use the base file to start the session as usual.
require 'reso/base.php';
// If the form has been submitted, then we add the information to the users table in the Amaclone database.
if (isset($_POST['firstname']) && isset($_POST['lastname']) && isset($_POST['email']) && isset($_POST['password']) && isset($_POST['password_conf'])) {
// Firstly we check whether the password and the confirmation match.
	if ($_POST['password_conf'] != $_POST['password']) {
		$error='Passwords do not match.';
		// We then check if a valid email address has been provided.
	} elseif (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)){
			$error='Email address is not valid.';
	} else {
		$data = array(
  	// Escape variables for security - mysqli_real_escape_string for the sake of sanitising the input
			'firstname' => mysqli_real_escape_string($con, $_POST['firstname']),
			'lastname' => mysqli_real_escape_string($con, $_POST['lastname']),
			'email' => mysqli_real_escape_string($con, $_POST['email']),
			'password' => mysqli_real_escape_string($con, $_POST['password'])
		);
    // Encrypting the password and assigning it a salt (the email address in this case)
		$data['password'] = sha1($data['email'].$data['password']);

    // Query the DB and store the results in a var
    $q = 'INSERT IGNORE INTO users (
			firstname,
			lastname,
			email,
			password
		) VALUES (
			"'.$data['firstname'].'",
			"'.$data['lastname'].'",
			"'.$data['email'].'",
			"'.$data['password'].'"
		)';

    $query = mysqli_query($con, $q) or die(mysqli_error($con));
// We check that the email provided is unique. If it is the user is redirected to the log in page.
		if (mysqli_affected_rows($con) > 0) {
			echo '<div class="container"><div class="row"> <div class="col-lg-4 mx-auto">Thanks for signing up, you\'re being redirected to the login page</div></div></div>';
			header( "refresh:2; url=login.php" );
		} else {
			$error='Oops, that email is already taken.';
		}
	}
}
//We have the standard <head> section to our page.
require 'reso/frames/header.php';
?>
<body>

<div class="container">
	<!-- At the top fo the registration page, we display our logo. -->
	<div class="row">
		<div class="col-lg-4 mx-auto">
			<img src="reso/static/img/amaclone.png" class="mt-2 mb-2 img w-50" style="margin-left:25%" alt="Responsive image">
		</div>
	</div>
	<!-- Below is the form within the Bootstrap framework. -->
  <div class='row'>
    <div class='col-lg-4 mx-auto'>
			<div class='border rounded p-3'>
				<form action='registration.php' method='POST'>
					<div class='form-group w-100'>
						<label for='firstname'> First Name: </label>
						<input type='text' id='firstname' class='form-control' name='firstname' placeholder='First name'/>
					</div>
					<div class='form-group w-100'>
						<label for='lastname'> Last Name: </label>
						<input type='text' id='lastname' class='form-control' name='lastname' placeholder='Last name'/>
					</div>
				  <div class='form-group w-100'>
				    <label for='email'> E-mail: </label>
				    <input type='email' id='email' name='email' class='form-control' placeholder='Enter your email' />
				  </div>
				  <div class='form-group w-100'>
				    <label for='password'> Password: </label>
				    <input type='password' id='password' name='password' class='form-control' placeholder='Password'/>
				  </div>
					<div class='form-group w-100'>
						<label for='confPassword'> Confirm your password: </label>
						<input type='password' id='confPassword' name='password_conf' class='form-control' placeholder='Confirm Password'/>
					</div>
				  <input class="btn btn-primary" type="submit" value='Register' />
					<a href="frontShop.php" class="btn btn-primary" role="button">Home Page</a>
				</form>
			</div>
		</div>
	</div>
</div>
</body>
</html>
