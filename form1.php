<?php 
	// Start session
	session_start();
	// Valid input variable
	$isValid = true;
	// Declare error variable
	$firstnameErr = $lastnameErr = $emailErr = $phoneErr = "";
	// Get current movie
	$current_movie = substr($_SERVER['QUERY_STRING'], -1);

	// Check if submit button has been pressed
	if (isset($_POST['submit'])) 
	{
		// Initiate _SESSION variable 'info' and assign key/values from _POST
		foreach ($_POST as $key => $value) 
		{
			$_SESSION['info'][$key] = $value;
		}
		
		// Assign keys to variable
		$keys = array_keys($_SESSION['info']);

		// Remove 'submit' from _SESSION
		if (in_array('submit', $keys)) 
		{
			unset($_SESSION['info']['submit']);
		}

		// Extract variables from 'info' _SESSION variable
		extract($_SESSION['info']);

		// Validate input before submission. Set 'isValid' to false and set error messages if invalid
		if (!preg_match("/^[a-zA-Z-' ]*$/",$firstname)) 
	    {
	    	$firstnameErr = "Only letters and whitespace allowed";
	  		$isValid = false;
		}
		if (!preg_match("/^[a-zA-Z-' ]*$/",$lastname)) 
	    {
	    	$lastnameErr = "Only letters and white space allowed";
      		$isValid = false;
    	}
    	if (!filter_var($email, FILTER_VALIDATE_EMAIL)) 
	    {
	    	$emailErr = "Invalid email format";
      		$isValid = false;
    	}
    	if(!preg_match('/^[0-9]{10}+$/', $phone))
	  	{
	  		$phoneErr = "Invalid phone number";
	  		$isValid = false;
	  	}

	  	// If everything is valid, set 'goalPage' to next page 
	  	if ($isValid)
	  	{
	  		$goalPage = "Location: submit.php?id=$current_movie";
	  	}
	  	// Else set 'goalPage' to current page 
	  	else
	  	{
	  		$goalPage = htmlspecialchars($_SERVER["PHP_SELF"]."?id=".substr($_SERVER['QUERY_STRING'], -1));
	  	}

	  	// Redirect to 'goalPage'
		header($goalPage);
	}

	// Function to trim data of excess characters/slashes/special characters
	function test_input($data) 
	{
  		$data = trim($data);
  		$data = stripslashes($data);
  		$data = htmlspecialchars($data);
  		return $data;
	}
?>
<!DOCTYPE html>
<html>
<head>
    <!-- Link CSS stylesheet -->
    <link rel="stylesheet" href="assets/styles/styles.css">
    <!-- Link JavaScript file -->
    <script src="assets/scripts/script.js"></script>
    <meta name="description" content="Rent your favourite movies">
    <title>Movie Mania</title>
    </head>
<body>
	<!-- Navigation bar for logo and navigation items -->
    <header class="main-header">
        <nav class="navbar">
            <!-- Main Logo redirects to home -->
            <a href="index.php" class="logo-link"><div class="brand-title">Movie Mania</div></a>
            <!-- Burger menu for smaller screen size -->
            <a href="#" class="toggle-button">
                <div class="bar"></div>
                <div class="bar"></div>
                <div class="bar"></div>
            </a>
            <!-- Regular screen size navigation items -->
            <div class="navbar-links">
                <ul>
                    <li><a href="index.php">Home</a></li>
                    <li><a href="about.html">About</a></li>
                    <li><a href="contact.html">Contact</a></li>
                </ul>
            </div>
        </nav>
    </header>
	<form method="POST" class="user-form" >
		<!-- Container to display movie being booked and user input fields for booking -->
	    <div class="card" data-step>
	    	<?php
	    		// Load XML file
	    		$xml = simplexml_load_file('data.xml');
	    		// Get ID of current movie from 'QUERY_STRING' _SERVER variable
	    		$current_movie = substr($_SERVER['QUERY_STRING'], -1);

	    		// Loop through XML file
	    		foreach ($xml->movie as $item) 
	    		{
	    			// Display if movie ID mathces ID of current movie
	    			if ($item['id'] == $current_movie)
	    			{
	    				echo '<h3 class="step-title">'.$item->title.'</h3>
	    					  <div class="show-time-container">
                              	<div class="movie-cinema">'.$item->cinema.'</div>
                                <div class="movie-time">'.$item->timedate.'</div>
                              </div>';
	    			}
	    		}
	    	?>
	    	<!-- User input fields -->
	      	<div class="form-group">
	        	<label for="">First Name</label>
	        	<input type="text" name="firstname" id="firstname" required>
	        	<span class="error">* <?php echo $firstnameErr;?></span>
	      	</div>
	      	<div class="form-group">
	        	<label for="">Last Name</label>
	        	<input type="text" name="lastname" id="lastname" required>
	        	<span class="error">* <?php echo $lastnameErr;?></span>
	      	</div>
	      	<div class="form-group">
	        	<label for="">Email</label>
	        	<input type="text" name="email" id="email" required>
	        	<span class="error">* <?php echo $emailErr;?></span>
	      	</div>
	      	<div class="form-group">
	        	<label for="">Phone</label>
	        	<input type="text" name="phone" id="phone" required>
	        	<span class="error">* <?php echo $phoneErr;?></span>
	      	</div>
            <!-- Anti-spam field -->
            <div style="display:none">
	        	<label for="">Phone</label>
	        	<input type="text" name="phone" id="phone" required>
	        	<span class="error">* <?php echo $phoneErr;?></span>
	      	</div>
	      	<!-- Submit button -->
	      	<input class="submit-btn" type="submit" name="submit" value="Submit">
	    </div>
  	</form>
</body>
</html>