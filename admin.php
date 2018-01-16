<?php
// We first require the connection from the base file
require 'reso/base.php';

// Once the fields have been submitted, we need to put these into our peoducts database
if (isset($_POST['title']) && isset($_POST['author']) && isset($_POST['description']) && isset($_POST['price']) && isset($_POST['img'])) {
		$data = array(
  	// Escape variables for security - mysqli_real_escape_string for the sake of sanitising the input
			'title' => mysqli_real_escape_string($con, $_POST['title']),
			'author' => mysqli_real_escape_string($con, $_POST['author']),
			'description' => mysqli_real_escape_string($con, $_POST['description']),
			'price' => mysqli_real_escape_string($con, $_POST['price']),
      'img' => mysqli_real_escape_string($con, $_POST['img']),
			'genre_id' => mysqli_real_escape_string($con, $_POST['genre_id'])
		);
    // Query the database to input the new values
    $q = 'INSERT INTO products (
			title,
			author,
			description,
			price,
      img,
			genre_id
		) VALUES (
			"'.$data['title'].'",
			"'.$data['author'].'",
			"'.$data['description'].'",
			"'.$data['price'].'",
      "'.$data['img'].'",
			"'.$data['genre_id'].'"

		)';
    $query = mysqli_query($con, $q) or die(mysqli_error($con));
		header('location: admin.php');
	}
// insert the header files here
	require 'reso/frames/header.php';
// Save in the vairable $genres the current collection of genres in the database
	$genreQuery = 'SELECT * FROM genres';
	$genreSQLQuery = mysqli_query($con, $genreQuery) or die(mysqli_error($con));
	$genres = mysqli_fetch_all($genreSQLQuery, MYSQLI_ASSOC);
?>
<!-- The container below contains the form for adding a new product.
It is constructed in Bootstrap style with form groups at 100% width. -->
<div class="container">
  <div class='row'>
    <div class='col-lg-4 mx-auto'>
			<div class='border rounded  p-3'>
				<h3> Add a new product: </h3>
				<form action='admin.php' method='POST'>
  				<div class='form-group w-100'>
    				<label for='title'> Title: </label>
    				<input type='text' id='title' name='title' class='form-control' placeholder='Title' />
  				</div>
					<div class='form-group w-100'>
						<label for='author'> Author: </label>
						<input type='text' id='author' name='author' class='form-control' placeholder='Author' />
					</div>
					<div class='form-group w-100'>
						<label for='description'> Description: </label>
						<input type='text' id='description' name='description' class='form-control' placeholder='Description' />
					</div>
					<div class='form-group w-100'>
						<label for='price'> Price: </label>
						<input type='text' id='price' name='price' class='form-control' placeholder='Price' />
					</div>
					<div class='form-group w-100'>
						<label for='img'> Image URL: </label>
						<input type='text' id='img' name='img' class='form-control' placeholder='Image URL' />
					</div>
					<div class='form-group w-100'>
						<label for='genre_id'> Genre: </label>
<!-- This is a drop-down selector. We run through all of the genre names to give as options for this drop-down list. -->
						<select id='genre_id' name="genre_id" class='form-control'>
							<?php for ($i=0; $i<sizeof($genres); $i++){
								echo "<option value='".$genres[$i]['genre_id']."'>".$genres[$i]['genre']."</option>";
							} ?>
						</select>
					</div>
  				<input class="btn btn-primary" type="submit" value='Add Product' />
				</form>
			</div>
		</div>
	</div>
</div>
</body>
</html>
