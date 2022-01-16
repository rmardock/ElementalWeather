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
        <title>Signup</title>
        <meta charset="UTF-8">
        <!-- Link to local copy of jQuery -->
        <script src="/Final-Project/jslib/jquery-3.5.1.min.js"></script>
        <!-- Link to JavaScript file -->
        <script src="/Final-Project/JavaScript/signupForm.js"></script>
        <!-- Link to shared stylesheets -->
        <link rel="stylesheet" type="text/css" href="/Final-Project/stylesheets/sharedStylesheet.css">
        <link rel="stylesheet" type="text/css" href="/Final-Project/stylesheets/login.css">
        <link rel="stylesheet" type="text/css" href="/Final-Project/stylesheets/loginSignupForm.css">
    </head>
    <body>
        <?php
            #If password error cookie exists
            if(isset($_COOKIE["signupPasswordError"])) {
                #Add hidden element to page
                echo "<input type=\"hidden\" name=\"passwordError\" id=\"passwordError\" value=\"true\">";
                #Unset cookie
                setcookie("signupPasswordError", "", 1);
            }
            #If empty error cookie exists
            if(isset($_COOKIE["signupEmptyError"])) {
                #Add hidden element to page
                echo "<input type=\"hidden\" name=\"emptyError\" id=\"emptyError\" value=\"true\">";
                #Unset cookie
                setcookie("signupEmptyError", "", 1);
            }
        ?>
        <div id="headerWrapper">
            <!-- Weather icon from https://iconarchive.com/show/cloud-icons-by-jackietran/cloud-sun-icon.html -->
            <h1 class="header"><img src="/Final-Project/images/weatherIcon.png" alt="Weather Icon" class="headerImage">Elemental Weather</h1>
            <!-- End of content from https://iconarchive.com/show/cloud-icons-by-jackietran/cloud-sun-icon.html -->
        </div>
        <div id="signupWrapper" class="formWrapper">
            <span class="formCloseButton"><a class="closeLink" href="/Final-Project/index.php">&times;</a></span>
            <br><br><br><br>
            <h3 id="signupHeader">Sign Up</h3>
            <div class="errorWrapper">
                <h4 class="errorMessage"></h4>
            </div>
            <div class="formWrapperClass">
                <form id="signupForm" action="/Final-Project/php/login.php" method="POST">
                    <input type="hidden" name="action" value="signup">
                    <input name="signupUsername" id="signupUsername" class="formElement input" placeholder="Username" autofocus required>
                    <br>
                    <input name="fname" id="fname" class="formElement input" placeholder="First Name" required>
                    <br>
                    <input name="lname" id="lname" class="formElement input" placeholder="Last Name" required>
                    <br>
                    <input type="password" name="signupPassword" id="signupPassword" class="formElement input" placeholder="Password" required>
                    <br>
                    <input type="password" name="signupPasswordConf" id="signupPasswordConf" class="formElement input" placeholder="Confirm Password" required>
                    <br>
                    <input type="submit" id="signupSubmit" class="formElement">
                    <br>
                </form>
            </div>
        </div>
    </body>
</html>