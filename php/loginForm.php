<?php 
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
?>

<!DOCTYPE html>
<!-- 
    References: 
        1) https://iconarchive.com/show/cloud-icons-by-jackietran/cloud-sun-icon.html
-->
<html lang="en">
    <head>
        <title>Login</title>
        <meta charset="UTF-8">
        <!-- Link to local copy of jQuery -->
        <script src="/Final-Project/jslib/jquery-3.5.1.min.js"></script>
        <!-- Link to JavaScript file --> 
        <script src="/Final-Project/JavaScript/loginForm.js"></script>
        <!-- Link to shared stylesheets -->
        <link rel="stylesheet" type="text/css" href="/Final-Project/stylesheets/sharedStylesheet.css">
        <link rel="stylesheet" type="text/css" href="/Final-Project/stylesheets/login.css">
        <link rel="stylesheet" type="text/css" href="/Final-Project/stylesheets/loginSignupForm.css">
        <!-- Link to stylesheet -->
        <link rel="stylesheet" type="text/css" href="/Final-Project/stylesheets/loginForm.css">
    </head>
    <body>
        <?php
            #If incorrect login cookie is set
            if(isset($_COOKIE["loginIncorrect"])) {
                echo "<input type=\"hidden\" name=\"loginIncorrect\" id=\"loginIncorrect\" value=\"true\">";
                #Unset cookie
                setcookie("loginIncorrect", "", 1);
            }
            #If signup success cookie is set
            if(isset($_COOKIE["signupSuccess"])) {
                echo "<input type=\"hidden\" name=\"signupSuccess\" id=\"signupSuccess\" value=\"true\">";
                #Unset cookie
                setcookie("signupSuccess", "", 1);
            }
        ?>
        <div class="headerWrapper">
            <!-- Weather icon from https://iconarchive.com/show/cloud-icons-by-jackietran/cloud-sun-icon.html -->
            <h1 class="header"><img src="/Final-Project/images/weatherIcon.png" alt="Weather Icon" class="headerImage">Elemental Weather</h1>
            <!-- End of content from https://iconarchive.com/show/cloud-icons-by-jackietran/cloud-sun-icon.html -->
        </div>
        <div id="loginFormWrapper" class="formWrapper">
            <span class="formCloseButton"><a class="closeLink" href="/Final-Project/index.php">&times;</a></span>
            <br><br><br><br>
            <h3 id="loginHeader">Log In</h3>
            <div class="errorWrapper">
                <h4 class="errorMessage"></h4>
            </div>
            <div class="formWrapperClass">
                <form id="loginForm" action="/Final-Project/php/login.php" method="POST">
                    <input type="hidden" name="action" value="login">
                    <input name="loginUsername" id="loginUsername" class="formElement input" placeholder="Username" autofocus required>
                    <br>
                    <input type="password" name="loginPassword" id="loginPassword" class="formElement input" placeholder="Password" required>
                    <br>
                    <input type="submit" id="loginSubmit" class="formElement">
                    <br>
                </form>
            </div>
            <div class="switchFormWrapper">
                <span class="formElement"><a class="switchFormLink" href="/Final-Project/php/signupForm.php">Sign Up</a></span>
            </div>
        </div>
    </body>
</html>