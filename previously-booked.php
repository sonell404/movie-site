<!DOCTYPE html>
<?php
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
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
        
        <div class="movie-container container">
            <!-- List Header -->
            <div class="movie-container-header">
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
                // Get mySQL login details from 'login.php' file
	            require_once 'login.php';
                // Initialize an empty array to hold the movie titles
                $movie_titles = array();
                // Try connect to mySQL database
                try
                {
                    // Start connection
                    $connection = new mysqli($hn,$un,$pw,$db);
                    // Create query to INSERT details into database
                    $query = mysqli_query($connection, "SELECT movie FROM bookings");

                    while ($row = mysqli_fetch_assoc($query))
                    {
                        $movie_titles[] = $row["movie"];
                    }
                }
                catch(Exception $e)
                {
                    echo $e->getMessage();
                }
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
                        for ($i = 0 ; $i < count($movie_titles) ; $i++)
                        {
                            if ($movie_titles[$i] == $item->title)
                            {
                                if ($item->title == $movie_titles[$i])
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
                        }
                    }
                }
            ?>
        </div>
    </body>
</html>



















