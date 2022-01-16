<?php
    //session_start() to access $_SESSION
    if(!session_start()) {
        header("Location: error.php");
        exit;
    }

    $loggedin = empty($_SESSION["loggedin"]) ? "" : $_SESSION["loggedin"];

    #If dark or light mode cookies are set
    if(isset($_COOKIE["lightmode"])) {
        $lightmode = "true";
    }
    if(isset($_COOKIE["darkmode"])) {
        $darkmode = "true";
    }
    if(isset($_COOKIE['metricValues'])) {
        $metricVal = "true";
    }
    if(isset($_COOKIE['imperialValues'])) {
        $imperialVal = "true";
    }
    if(isset($_COOKIE['settingsSaved'])) {
        $settingsSaved = "true";
    }
?>


<!DOCTYPE html>
<html>
    <head>
        <title>Account Settings</title>
        <meta charset="UTF-8">
        <!-- Link to local copy of jQUery -->
        <script src="/Final-Project/jslib/jquery-3.5.1.min.js"></script>
        <!-- Link to JavaScript file -->
        <script src="/Final-Project/JavaScript/accountSettings.js"></script>
        <!-- Link to shared stylesheet -->
        <link rel="stylesheet" type="text/css" href="/Final-Project/stylesheets/sharedStylesheet.css">
        <link rel="stylesheet" type="text/css" href="/Final-Project/stylesheets/login.css">
        <!-- Link to stylesheet -->
        <link rel="stylesheet" type="text/css" href="/Final-Project/stylesheets/accountSettings.css">
    </head>
    <body>
        <?php
            if(isset($lightmode)) {
                #Add hidden element to page
                echo "<input type=\"hidden\" name=\"lightmodeVal\" id=\"lightmodeVal\" value=\"true\">";
            }
            if(isset($darkmode)) {
                #Add hidden element to page 
                echo "<input type=\"hidden\" name=\"darkmodeVal\" id=\"darkmodeVal\" value=\"true\">";
            }
            if(isset($settingsSaved)) {
                #Add hidden element to page 
                echo "<input type=\"hidden\" name=\"settingsSaved\" id=\"settingsSaved\" value=\"true\">";
                #Unset cookie
                setcookie("settingsSaved", "", 1);
            }
            if(isset($metricVal)) {
                #Add hidden element to page 
                echo "<input type=\"hidden\" name=\"metricVal\" id=\"metricVal\" value=\"true\">";
            }
            if(isset($imperialVal)) {
                #Add hidden element to page 
                echo "<input type=\"hidden\" name=\"imperialVal\" id=\"imperialVal\" value=\"true\">";
            }
        ?>
        <div class="headerWrapper">
            <?php
                #Get username from $_SESSION
                $username = $loggedin;
                #Add custom welcome message
                echo "<h2 id=\"accSettingsHeader\" class=\"header\">Welcome back, " . $username . "!</h2>"
            ?>
        </div>
        <div id="settingsWrapper" class="formWrapper">
            <div class="formWrapperClass">
                <div class="headerWrapper" id="settingsHeader">
                    <h3 class="header">Account Settings</h3>
                </div>
                <div class="errorWrapper">
                    <h4 class="errorMessage"></h4>
                </div>
                <form name="accSettingsForm" id="accSettingsForm" action="/Final-Project/php/login.php" method="POST">
                    <input type="hidden" name="action" value="accSettings">
                    <select name="unitValueType" id="unitValueType" class="formElement">
                        <option name="imperial" id="imperial" value="imperial" selected>Imperial Values</option>
                        <option name="metric" id="metric" value="metric">Metric Values</option>
                    </select>
                    <br>
                    <select name="darkmodeSelection" id="darkmodeSelection" class="formElement">
                        <option name="lightmode" id="lightmode" value="lightmode" selected>Light Mode</option>
                        <option name="darkmode" id="darkmode" value="darkmode">Dark Mode</option>
                    </select>
                    <br>
                    <input type="submit" name="accSettingsSubmit" id="accSettingsSubmit" class="formElement" value="Save Settings">
                    <br>
                </form>
                <form id="deleteUserAccForm" name="deleteUserAccForm" action="/Final-Project/php/login.php" method="POST">
                    <input type="hidden" name="action" value="deleteUserAcc">
                    <input type="submit" name="deleteUserAccSubmit" id="deleteUserAccSubmit" class="formElement" value="Delete Account">
                </form>
                <div class="formElement" id="homeLink">
                    <a id="weatherLink" href="/Final-Project/php/weather.php">Back to Home</a>
                </div>
            </div>
        </div>
    </body>
</html>