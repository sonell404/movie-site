<?php 
    session_start();
    
    // Extract array to use key as variable name if _SESSION variable 'info' exists
	if (isset($_SESSION['info'])) 
    {
        extract($_SESSION['info']);
	}

    // Get mySQL login details from 'login.php' file
	require_once 'login.php';
    // Load XML file
	$xml = simplexml_load_file('data.xml');
    // Get current movie
	$current_movie = substr($_SERVER['QUERY_STRING'], -1);
    // Initialise 'movie_title' variable
	$movie_title = '';
    // Initialise 'movie_show_time' variable
	$movie_show_time = '';

    // Loop through XML file
	foreach($xml->movie as $item)
    {
        // Assign movie title and show date to variables if the ID matches current movie ID
    	if ($item['id'] == $current_movie)
    	{
    		$movie_title = $item->title;
    		$movie_show_time = $item->timedate;
    	}
    }
    // Try connect to mySQL database
	try
    {
        // Start connection
        $connection = new mysqli($hn,$un,$pw,$db);
        // Create query to INSERT details into database
        $query = mysqli_query($connection, "INSERT INTO bookings (first_name, last_name, email, phone, movie, show_date_time) 
        			VALUES ('$firstname','$lastname','$email','$phone','$movie_title','$movie_show_time')");
        
        // Close connection
        mysqli_close($connection);
        unset($_POST['info']);
    }
    catch(Exception $e)
    {
        echo $e->getMessage();
    }

    session_unset();
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
    <!-- Show user successful booking message -->
    <?php 
    	$current_movie = substr($_SERVER['QUERY_STRING'], -1);
		
		foreach($xml->movie as $item)
		{
			if ($item['id'] == $current_movie)
			{
				echo '<div class="success-card">
                            <div class="success-message-container">
                                <div class="success-message">You have successfully booked: </div>
                                <h3 class="step-title">'.$item->title.'</h3>
                                <div class="show-time-container">
                                    <div class="movie-cinema">'.$item->cinema.'</div>
                                    <div class="movie-time">'.$item->timedate.'</div>
                                </div>
                            </div>
                      </div>';
			}
		}
    ?>
</body>
</html>
