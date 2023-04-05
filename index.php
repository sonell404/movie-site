<!DOCTYPE html>
<?php 
	// Start session
	session_start();
	// Valid input variable
	$isValid = true;
	// Declare error variable
	$firstnameErr = $lastnameErr = $emailErr = $phoneErr = "";

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
	  		$goalPage = "Location: register_user.php";
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
        <?php
            if (!isset($_SESSION['registered']))
            {
                echo 
                    '<div class="registration-section">
                    <form method="POST" class="user-form" >
                    <!-- Container to display movie being booked and user input fields for booking -->
                        <div class="card" data-step>
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
                                <input type="email" name="email" id="email" required>
                                <span class="error">* <?php echo $emailErr;?></span>
                            </div>
                            <div class="form-group">
                                <label for="">Phone</label>
                                <input type="phone" name="phone" id="phone" required>
                                <span class="error">* <?php echo $phoneErr;?></span>
                            </div>
                            <div class="form-group">
                                <label for="">Password</label>
                                <input type="password" name="password" id="password" required>
                                <span class="error">* <?php echo $phoneErr;?></span>
                            </div>
                            <!-- Anti-spam field -->
                            <div style="display:none">
                                <label for="">Phone</label>
                                <input type="text" name="phone" id="phone" required>
                                <span class="error">* <?php echo $phoneErr;?></span>
                            </div>
                            <!-- Submit button -->
                            <input class="submit-btn" type="submit" name="submit" value="Register">
                        </div>
                      </form>
                </div>';
            }
        ?>
        <div class="movie-container container">
            <!-- Header text -->
            <div class="movie-container-header">
                <h2 class="movie-container-header-text">Movies Showing</h2>
                <!-- JavaScript to perform search on movies showing -->
                <script type="text/javascript">
                    function searchFunction() {
                        // Declare variables
                        var input, filter, movies, title, cinema, txtValue, div;

                        // Assign search bar to input variable
                        input = document.getElementById('search-bar');
                        // Convert all input to upper case so search isn't case-sensitive
                        filter = input.value.toUpperCase();
                        // Assign elements with class, 'movie' to 'movies' variable
                        movies = document.getElementsByClassName('movie');

                        // Loop through movie elements
                        for (i = 0 ; i < movies.length ; i++)
                        {
                            // Assign current movie element to 'div' variable
                            div = movies[i];
                            // Take text contents from div and assign to 'txtValue' variable
                            txtValue = div.textContents || div.innerText;

                            // If any keys pressed are present in elements text value, display
                            if (txtValue.toUpperCase().indexOf(filter) > -1)
                            {
                                movies[i].style.display = "flex";
                            }
                            // Hide display if not
                            else
                            {
                                movies[i].style.display = "none";
                            }
                        }
                    }
                </script>
                <!-- Call JavaScript function above for any key pressed -->
                <input id="search-bar" type="text" onkeyup="searchFunction()" placeholder="Search.."/>
            </div>
            
            <!-- Use PHP to read and display data from XML file -->
            <?php
                // Load XML file
                $xml = simplexml_load_file('data.xml');
                // Inform user if XML file did not load
                if (!$xml)
                {
                    echo 'FAILED TO LOAD FILE';
                }
                else
                {
                  // Loop through file and display data
                  foreach($xml->movie as $item)
                  {
                    echo '<div id="'.$item['id'].'" class="movie">
                            <div class="image-container">
                                <a target="_blank" href="movie-page.php?id='.$item['id'].'">
                                    <img class="movie-image" height="155px" width="100px" src="images/'.$item->image.'">
                                </a>
                            </div>
                            <div class="movie-text-container">
                                <div class="movie-title">'.$item->title.'</div>
                                <div class="movie-description">'.$item->description.'</div>
                                <div><span class="showing-at-format">Showing at: </span><span class="cinema">'.$item->cinema.'</span></div>
                                <a href="form1.php?id='.$item['id'].'"><button class="main-btn" type="submit">BOOK NOW</button></a>
                            </div>
                            <br/>
                          </div><br/><br/>';
                  }
                }
            ?>
            <div class="previously-booked">
                <button class="submit-btn" type="button" name="button"><a href="previously-booked.php">Previously booked</a></button>
            </div>
        </div>
    </body>
</html>



















