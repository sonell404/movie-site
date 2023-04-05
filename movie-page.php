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
        <div class="movie-container single-movie-container">
        <!-- PHP to read and display data from XML file -->
        <?php
            // Load XML
            $xml = simplexml_load_file('data.xml');

            // If file did not load, inform user
            if (!$xml)
            {
                echo 'FAILED TO LOAD FILE';
            }
            // Parse XML file if it loaded successfully
            else
            {
                // Get id of current movie from URLs 'QUERY STRING'
                $current_movie = substr($_SERVER['QUERY_STRING'], -1);

                // Loop through XML file
                foreach($xml->movie as $item)
                {
                    // Display movie if movie ID matches the ID of the current movie
                    if ($item['id'] == $current_movie)
                    {
                        echo '<div class="single-movie">
                                <div class="image-container">
                                    <a id="'.$item['id'].'" href="#">
                                        <img height="385px" width="300px" src="images/'.$item->image.'">
                                    </a>
                                </div>
                                <div class="movie-text-container">
                                    <div class="title-spec-container">
                                      <div class="movie-title">'.$item->title.'</div>
                                      <div class="movie-spec">'.$item->year.' | '.$item->rating.' | '.$item->length.'</div>
                                    </div>
                                    <div class="movie-description">'.$item->description.'</div>
                                    <div class="movie-crew-container">
                                      <span class="movie-crew-title">Director </span><span class="movie-crew">'.$item->director.'</span><br/>
                                      <span class="movie-crew-title">Stars </span>
                                      <span class="movie-crew">'.$item->stars->star[0].' | '.$item->stars->star[1].' | '.$item->stars->star[2].'
                                    </div>
                                    <div>
                                      <span class="showing-at-format">Showing at: </span><span class="cinema">'.$item->cinema.'</span>
                                      <div class="btn-container">
                                        <a href="form1.php?id='.$item['id'].'">
                                          <button class="main-btn" type="submit">BOOK NOW</button>
                                        </a>
                                      </div>
                                    </div>
                                </div>
                                <div class="movie-trailer-container">
                                    <video width="513.3px" height="385px" controls autoplay muted>
                                      <source src="assets/video/'.$item->video.'" type="video/mp4">
                                    </video>
                                </div>
                                <br/>
                              </div>';
                    }
                }
            }

            // Function to allow navigation through single movie pages.
            // TRUE value moves forward and FALSE value moves forward.
            function navigateMovies($bool, $xml) {
                $movieCount = 0;

                // Loop through movies
                foreach($xml as $item)
                {
                    // movie count is equal to the id of the last movie
                    $movieCount = $item['id'];
                }

                // Get ID of current movie
                $current_movie = substr($_SERVER['QUERY_STRING'], -1);

                // If TRUE and if current movie is not last movie, move forward
                if ($bool == true && $current_movie < $movieCount)
                {
                    return $current_movie + 1;
                }
                // If TRUE and if current movie is last movie, move to first movie
                else if ($bool == true && $current_movie == $movieCount)
                {
                    $current_movie = 1;
                    return $current_movie;
                }
                // If FALSE and current movie is not first movie, move back
                else if ($bool == false && $current_movie > 1)
                {
                    return $current_movie - 1;
                }
                // If FALSE and current movie is first movie, move to last movie
                else if ($bool == false && $current_movie == 1)
                {
                    $current_movie = $movieCount;
                    return $current_movie;
                }
            }
        ?>
        </div>
        <?php
            // Display movie navigation buttons
            echo '<div class="navigation-button-container">
                    <a href="movie-page.php?id='.navigateMovies(false, $xml).'">
                        <button class="navigation-button" type="submit"><</button>
                    </a>
                    <a href="movie-page.php?id='.navigateMovies(true, $xml).'">
                        <button class="navigation-button" type="submit">></button>
                    </a>
                  </div>'
        ?>
    </body>
</html>





















