<?php 
    session_start();
   
    // Extract array to use key as variable name if _SESSION variable 'info' exists
	if (isset($_SESSION['info'])) 
    {
        extract($_SESSION['info']);
	}

    // Get mySQL login details from 'login.php' file
	require_once 'login.php';

    // Try connect to mySQL database
	try
    {
        // Start connection
        $connection = new mysqli($hn,$un,$pw,$db);
        // Create query to INSERT details into database
        $query = mysqli_query($connection, "INSERT INTO user_details (first_name, last_name, email, phone, password) 
        			VALUES ('$firstname','$lastname','$email','$phone','$password')");
        
        // Close connection
        mysqli_close($connection);
        unset($_POST['info']);

        // Set cookie to show user is registered
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
        $_SESSION['registered'] = true;
    	echo 
        '<div class="success-card">
            <div class="success-message-container">
                <div class="success-message">You have successfully registered!</div>
                <button class="submit-btn" type="button" name="button"><a href="index.php">Homepage</a></button>
            </div>
        </div>';
    ?>
</body>
</html>
