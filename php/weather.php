<?php
    //session_start() to access $_SESSION
    if(!session_start()) {
        header("Location: error.php");
        exit;
    }

    $loggedin = empty($_SESSION["loggedin"]) ? "" : $_SESSION["loggedin"];

    if(isset($_COOKIE["imperialValues"])) {
        $imperial = "true";
    }
    if(isset($_COOKIE["metricValues"])) {
        $metric = "true";
    }
    if(isset($_COOKIE["lightmode"])) {
        $lightmode = "true";
    }
    if(isset($_COOKIE["darkmode"])) {
        $darkmode = "true";
    }
?>

<!DOCTYPE html>
<!-- 
    Ryan Mardock
    IT 2830
    Final Project
-->
<!-- Don't forget the Document (outlining project and requirements + location)-->
<!--
    References: 
       1) https://rapidapi.com/weatherbit/api/weather
       2) https://rapidapi.com/dev132/api/city-geo-location-lookup
       3) https://iconarchive.com/show/cloud-icons-by-jackietran/cloud-sun-icon.html

    Requirement #1: Utilize HTML5 for page content with 5 required tags
-->
<html lang="en">
    <head>
        <title>Final Project</title>
        <meta charset="UTF-8">
        <!-- Link to local copy of jQuery -->
        <script src="/Final-Project/jslib/jquery-3.5.1.min.js"></script>
        <!-- Meta tag from https://getbootstrap.com/docs/5.0/getting-started/introduction/ -->
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- Link to Bootstrap from https://getbootstrap.com/docs/5.0/getting-started/introduction/ -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css"
              rel="stylesheet"
              integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" 
              crossorigin="anonymous">
        <!-- End of content from https://getbootstrap.com/docs/5.0/getting-started/introduction/ -->
        <!-- Link to JavaScript file -->
        <script src="/Final-Project/JavaScript/weather.js"></script>
        <!-- Link to shared stylesheet -->
        <link rel="stylesheet" type="text/css" href="/Final-Project/stylesheets/sharedStylesheet.css">
        <!-- Link to stylesheet -->
        <link rel="stylesheet" type="text/css" href="/Final-Project/stylesheets/weather.css">
    </head>
    <body>
        <?php
            #If not logged in, add hidden element to page 
            if(!$loggedin) {
                #Add hidden element to page if not logged in 
                echo "<input type=\"hidden\" name=\"guestUser\" id=\"guestUser\" value=\"true\">"; 
            }
            if($imperial == "true") {
                echo "<input type=\"hidden\" name=\"imperialVal\" id=\"imperialVal\" value=\"true\">";
            }
            if($metric == "true") {
                echo "<input type=\"hidden\" name=\"metricVal\" id=\"metricVal\" value=\"true\">";
            }
            if($lightmode == "true") {
                echo "<input type=\"hidden\" name=\"lightmode\" id=\"lightmode\" value=\"true\">";
            }
            if($darkmode == "true") {
                echo "<input type=\"hidden\" name=\"darkmode\" id=\"darkmode\" value=\"true\">";
            }
        ?>
        <!-- Wrapper for collapsed Menu Button -->
        <div id="collapsedMenuButtonWrapper">
            <div class="menuButtonWrapper collapsed">
                <div class="bar1"></div>
                <div class="bar2"></div>
                <div class="bar3"></div>
            </div>
        </div>
        <div class="headerWrapper">
            <!-- Weather icon from https://iconarchive.com/show/cloud-icons-by-jackietran/cloud-sun-icon.html -->
            <h1 class="header"><img src="/Final-Project/images/weatherIcon.png" alt="Weather Icon" class="headerImage">Elemental Weather</h1>
            <!-- End of content from https://iconarchive.com/show/cloud-icons-by-jackietran/cloud-sun-icon.html -->
        </div>
        <div id="menuWrapper">
            <div id="expandedMenuButtonWrapper">
                <div class="menuButtonWrapper expanded right">
                    <div class="bar1"></div>
                    <div class="bar2"></div>
                    <div class="bar3"></div>
                </div>
            </div>
            <h4 id="menuHeader">Menu</h4>
            <hr>
            <ul id="menuUl">
            <li class="menuItem">
                    <span id="accountUsername"><h5>
                    <?php
                        #If user is logged in
                        if($loggedin) {
                            #Display username in menu window
                            echo "Welcome, $loggedin";
                        }
                    ?>
                    </h5></span>
                </li>
                <li class="menuItem">
                    <form id="menuForm">
                        <input type="hidden" name="action" id="action" value="updateMetric">
                        <label for="unitSwitch" id="unitSwitchLabel" class="menuLabel align-middle">Imperial Units</label>
                        <label class="toggleSwitch" name="unitSwitch" id="unitSwitch">
                            <input type="checkbox" id="unitTypeSwitch">
                            <span class="slider"></span>
                        </label>
                    </form>
                </li>
                <li class="menuItem">
                    <button type="button" name="locationSearchButton" id="locationSearchButton">Location Search</button>
                </li>
                <li class="menuItem">
                    <button type="button" name="accountSettingsLink" id="accountSettingsLink"><a href="/Final-Project/php/accountSettings.php">Account Settings</a></button>
                </li>
                <li class="menuItem">
                    <form id="logoutForm" action="/Final-Project/php/login.php" method="POST">
                        <input type="hidden" name="action" value="logout">
                        <input type="submit" name="logoutSubmit" id="logoutSubmit" value="Logout">
                    </form>
                </li>
            </ul>
        </div>
        <div id="locationSearchWrapper"> 
            <div id="locationSearch">
                <span id="closeButton">&times;</span>
                <h3 id="searchHeader">Location Search</h3>
                <p id="searchDescription">Enter the name of the city and region/state to search for a location:</p>
                <div id="searchControls">
                    <input name="searchInput" id="searchInput" placeholder="City, State/Region">
                    <button type="button" name="submitButton" id="submitButton">Search</button>
                </div>
                <div id="searchResults">

                </div>
            </div>
        </div> 
        <!-- Wrapper for card containing daily weather -->
        <!-- Use https://www.w3schools.com/bootstrap/bootstrap_grid_system.asp for device optimization in with bootstrap elements -->
        <div id="weatherWrapper" class="container-fluid">
            <!-- Possibly use bootstrap columns without borders here -->
            <div class="row align-items-start">
                <div id="mainWeather" class="col-8">
                <br><br><br>
                    <!-- HTML here is just a template -> move to JavaScript and apply from there dynamically when finished -->
                    <!-- Load correct animation at top of div -->
                    <h1 id="cityName" class="currentWeatherMainWindow"></h1>
                    <h5 id="skyCondition" class="currentWeatherMainWindow"></h5>
                    <h1 id="currentTemperature" class="currentWeatherMainWindow"></h1>
                    <p id="highLowTemps" class="currentWeatherMainWindow"></p>
                    <p id="lastUpdated" class="currentWeatherMainWindow"></p>
                </div>
                <div id="dataCol" class="col-3">
                    <br><br><br>
                    <!-- Use bootstrap columns and rows here -->
                    <p id="sunrise">Sunrise:<span class="dataVal" id="sunriseVal"></span></p>
                    <p id="precipChance">Chance of Rain:<span class="dataVal" id="precipChanceVal"></span></p>
                    <p id="wind">Wind:<span class="dataVal" id="windVal"></span></p>
                    <p id="precipitation">Precipitation:<span class="dataVal" id="precipAmountVal"></span></p>
                    <p id="visibility">Visibility:<span class="dataVal" id="visibilityVal"></span></p>
                    <p id="sunset">Sunset:<span class="dataVal" id="sunsetVal"></span></p>
                    <p id="humidity">Humidity:<span class="dataVal" id="humidityVal"></span></p>
                    <p id="feelsLike">Feels Like:<span class="dataVal" id="feelsLikeVal"></span></p>
                    <p id="pressure">Pressure:<span class="dataVal" id="pressureVal"></span></p>
                    <p id="uvIndex">UV Index:<span class="dataVal" id="uvVal"></span></p>
                </div>
                <div class="col-1">
                    <!-- Empty column for formatting -->
                </div>
            </div>
        </div>
    </body>
</html>