<?php
    if(!session_start()) {
        header("Location: error.php");
        exit;
    }

    $loggedin = empty($_SESSION["loggedin"]) ? "" : $_SESSION["loggedin"];
    #If logged in, logout
    if($loggedin) {
        #Destroy session data
        $_SESSION = array();
        #Destroy session
        session_destroy();
        #Redirect to login
        header("Location: /Final-Project/index.php?loggedout=success");
        exit;
    } 
 
    #If cookies are set, unset cookies
    if(isset($_COOKIE['lightmode'])) {
        setcookie("lightmode", "", 1);
    }
    if(isset($_COOKIE['darkmode'])) {
        setcookie("darkmode", "", 1);
    }
    if(isset($_COOKIE['metricValues'])) {
        setcookie("metricValues", "", 1);
    }
    if(isset($_COOKIE['imperialValues'])) {
        setcookie("imperialValues", "", 1);
    }
    if(isset($_COOKIE['settingsSaved'])) {
        setcookie("settingsSaved", "", 1);
    }
?>

<!DOCTYPE html>
<!-- 
    References: 
        1) https://iconarchive.com/show/cloud-icons-by-jackietran/cloud-sun-icon.html
-->
<html lang="en">
    <head>
        <title>Login Page</title>
        <meta charset="UTF-8">
        <!-- Link to local copy of jQuery -->
        <script src="/Final-Project/jslib/jquery-3.5.1.min.js"></script>
        <!-- Link to JavaScript file -->
        <script src="/Final-Project/JavaScript/login.js"></script>
        <!-- Link to shared stylesheets -->
        <link rel="stylesheet" type="text/css" href="/Final-Project/stylesheets/sharedStylesheet.css">
        <link rel="stylesheet" type="text/css" href="/Final-Project/stylesheets/login.css">
        <!-- Link to stylesheet -->
        <link rel="stylesheet" type="text/css" href="/Final-Project/stylesheets/index.css">
    </head>
    <body>
        <?php
            $url = "http://$_SERVER[HTTP_POST]$_SERVER[REQUEST_URI]";
            #If redirected from logging out
            if(strpos($url, "loggedout=success") == true) {
                #Add hidden element to page
                echo "<input type=\"hidden\" name=\"loggedoutMessage\" id=\"loggedoutMessage\" value=\"true\">";
            }
            #If redirected from deleting account
            if(strpos($url, "accountDeleted=success") == true) {
                #Add hidden element to page
                echo "<input type=\"hidden\" name=\"accountDeleted\" id=\"accountDeleted\" value=\"true\">";
            }
        ?>
        <div id="headerWrapper">
            <!-- Weather icon from https://iconarchive.com/show/cloud-icons-by-jackietran/cloud-sun-icon.html -->
            <h1 class="header"><img src="/Final-Project/images/weatherIcon.png" alt="Weather Icon" class="headerImage">Elemental Weather</h1>
            <!-- End of content from https://iconarchive.com/show/cloud-icons-by-jackietran/cloud-sun-icon.html -->
        </div>
        <div id="loginSignUpWrapper" class="formWrapper">
            <div class="formWrapperClass">
                <br><br><br><br>
                <h3 id="mainFormHeader">Log In or Sign Up to use our premium features!</h3>
                <div class="errorWrapper">
                    <h4 class="errorMessage"><!-- This header is populated when necessary using JavaScript --></h4>
                </div>
                <div class="formElement">
                    <a id="loginLink" href="/Final-Project/php/loginForm.php">Log In</a>
                </div>
                <br>
                <div class="formElement">
                    <a id="signupLink" href="/Final-Project/php/signupForm.php">Sign Up</a>
                </div>
                <br>
                <div class="formElement">
                    <a id="weatherLink" href="/Final-Project/php/weather.php">Continue as Guest</a>
                </div>
                <br>
                <div class="formElement">
                    <a id="tutorialLink" href="/Final-Project/tutorial.html">View Video Tutorial</a>
                </div>
            </div>
        </div>
    </body>
</html>