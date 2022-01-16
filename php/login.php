<?php
    #Requirement #5: Login user with ID = "test" and password = "pass" 
    #Requirement #6: Utilize PHP and proper PHP techniques
    #Requirement #7: Properly use POST

    #Use db.conf to connect to database
    require_once "db.conf";
    
    //Call session_start() to access $_SESSION array
    if(!session_start()) {
        header("Location: error.php");
        exit;
    }

    $loggedin = empty($_SESSION["loggedin"]) ? "" : $_SESSION["loggedin"];

    $action = empty($_POST["action"]) ? "" : $_POST["action"];

    switch($action) {
        case "login":
            login($mysqli);
            break;
        case "logout":
            logout();
            break;
        case "signup":
            signup($mysqli);
            break;
        case "accSettings":
            updateSettings($mysqli);
            break;
        case "deleteUserAcc":
            deleteUserAcc($mysqli, $loggedin);
    }

    function deleteUserAcc($mysqli, $loggedin) {
        #Get username from $_SESSION
        $username = $loggedin;
        #Destory session data
        $_SESSION = array();
        #Destroy session
        session_destroy();
        #Build SQL query string
        $query = "DELETE FROM users WHERE username = \"" . $username . "\"";
        echo $query;
        #Delete entry from database
        $mysqli->query($query);
        #Redirect to index.php
        header("Location: /Final-Project/index.php?accountDeleted=success");
        exit;
    }

    function login($mysqli) {
        #Get username and password entered by user
        $username = empty($_POST['loginUsername']) ? null : $_POST['loginUsername'];
        $password = empty($_POST['loginPassword']) ? null : $_POST['loginPassword'];

        #Error check for empty values
        if($username == null || $password == null) {
            #Send error message back to index.php
            #set cookie here for error on loginForm.php
            header("Location: /Final-Project/php/loginForm.php");
            exit;
        }

        #String for querying database 
        $query = "SELECT password FROM users WHERE username = " . "\"" . $username . "\"";
        
        #Query database
        $result = $mysqli->query($query);

        #Get data from database
        $row = $result->fetch_assoc();
        $passwd = $row['password'];
        #Close result
        $result->close();

        #If user input for 'password' matches the password in the database 
        if(sha1($password) == $passwd) {
            $_SESSION["loggedin"] = $username;
            #Query to get metric and darkmode values from database
            $query = "SELECT metric, darkmode FROM users WHERE username = " . "\"". $username . "\"";
            #Query database
            $result = $mysqli->query($query);
            #Get data from database
            $row = $result->fetch_assoc();
            $metric = $row['metric'];
            $darkmode = $row['darkmode'];
            #Send db metric and darkmode values to front end for updating page 
            switch($metric) {
                #If metric value is 0 (false)
                case 0:
                    $imperialValues = "imperial";
                    setcookie("imperialValues", $imperialValues);
                    break;
                #If metric value is 1 (true)
                case 1:
                    $metricValues = "metric";
                    setcookie("metricValues", $metricValues);
                    break;
            }

            switch($darkmode) {
                #If darkmode value is 0 (false)
                case 0:
                    $lightmodeValues = "lightmode";
                    setcookie("lightmode", $lightmodeValues);
                    break;
                #If darkmode value is 1 (true)
                case 1: 
                    $darkmodeValues = "darkmode";
                    setcookie("darkmode", $darkmodeValues);
                    break;
            }
            #Redirect to weather.php
            header("Location: /Final-Project/php/weather.php");
            #Close Result
            $result->close();
            #Close database connection
            $mysqli->close();
            exit;
        }
        else {
            $loginIncorrect = "incorrect";
            #Set cookie for incorrect login credentials
            setcookie("loginIncorrect", $loginIncorrect);
            #Redirect to loginForm.php
            header("Location: /Final-Project/php/loginForm.php");   
            $result->close();
            $mysqli->close();
            exit;
        }
    }

    function logout() {
        #Unset user preferences cookies that were set during log in
        if(isset($_COOKIE["imperialValues"])) {
            #Unset cookie
            setcookie("imperialValues", "", 1);
        }
        if(isset($_COOKIE["metricValues"])) {
            #Unset cookie
            setcookie("metricValues", "", 1);
        }
        if(isset($_COOKIE["lightmode"])) {
            #Unset cookie
            setcookie("lightmode", "", 1);
        }
        if(isset($_COOKIE["darkmode"])) {
            #Unset cookie
            setcookie("darkmode", "", 1);
        }
        #Destroy session data
        $_SESSION = array();
        #Destroy session
        session_destroy();
        #Redirect to login
        header("Location: /Final-Project/index.php?loggedout=success");
        exit;
    }

    function signup($mysqli) {
        #If cookie is set
        if(isset($_COOKIE["signupEmptyError"])) {
            #Unset cookie
            setcookie("signupEmptyError", "", 1);
        }
        #If cookie is set
        if(isset($_COOKIE["signupPasswordError"])) {
            #Unset cookie
            setcookie("signupPasswordError", "", 1);
        }

        #Get values from form
        $username = empty($_POST['signupUsername']) ? "" : $_POST['signupUsername'];
        $fname = empty($_POST['fname']) ? "" : $_POST['fname'];
        $lname = empty($_POST['lname']) ? "" : $_POST['lname'];
        $password = empty($_POST['signupPassword']) ? "" : $_POST['signupPassword'];
        $passwordConf = empty($_POST['signupPasswordConf']) ? "" : $_POST['signupPasswordConf'];

        #If any fields are left blank on submission
        if($username == "" || $fname == "" || $lname == "" || $password == "" || $passwordConf == "") {
            $signupError = "emptyField";
            #Set cookie
            setcookie("signupEmptyError", $signupError);
            #Redirect to signupForm.php
            header("Location: /Final-Project/php/signupForm.php");
        }

        #If passwords do not match
        if($password != $passwordConf) {
            $signupError = "pwdNoMatch";
            #Set cookie
            setcookie("signupPasswordError", $signupError);
            #Redirect to signupForm.php
            header("Location: /Final-Project/php/signupForm.php");
        }
        #If no errors
        else {
            #Encrypt password
            $password = sha1($password);
            #Build SQL query string to add new user data to database
            $query = "INSERT INTO users VALUES (" . "\"" . $username . "\", \"" . $password . "\", \"" . $fname . "\", \"" . $lname . "\", false, false)";
            #Query database
            $mysqli->query($query);
            #Set cookie
            $signupSuccess = "success";
            setcookie("signupSuccess", $signupSuccess);
            #Redirect to login page
            header("Location: /Final-Project/php/loginForm.php");
        }
    }

    function updateSettings($mysqli) {

        #Get user session
        $loggedin = empty($_SESSION["loggedin"]) ? "" : $_SESSION["loggedin"];

        #If user is logged in 
        if($loggedin) {
            #If lightmode cookie is set 
            if(isset($_COOKIE['lightmode'])) {
                #Unset cookie
                setcookie("lightmode", "", 1);
            }
            #If darkmode cookie is set
            if(isset($_COOKIE['darkmode'])) {
                #Unset cookie
                setcookie("darkmode", "", 1);
            }
            #If metric cookie is set
            if(isset($_COOKIE['metricValues'])) {
                #Unset cookie
                setcookie("metricValues", "", 1);
            }
            #If imperial cookie is set
            if(isset($_COOKIE['imperialValues'])) {
                #Unset cookie
                setcookie("imperialValues", "", 1);
            }
            #If settings saved cookie is set 
            if(isset($_COOKIE['settingsSaved'])) {
                #Unset cookie
                setcookie('settingsSaved', '', 1);
            }
            #Get metric value from
            $metric = empty($_POST["unitValueType"]) ? "" : $_POST["unitValueType"];
            #Get darkmode value 
            $darkmode = empty($_POST["darkmodeSelection"]) ? "" : $_POST["darkmodeSelection"];

            #Switch statement for metric variable
            switch($metric) {
                case "metric":
                    $metric = 1;
                    #Set metric cookie
                    $metricVal = "metric";
                    setcookie("metricValues", $metricVal);
                    break;
                case "imperial":
                    $metric = 0;
                    #Set imperial cookie
                    $imperialVal = "imperial";
                    setcookie("imperialValues", $imperialVal);
                    break;
            }

            #Switch statement for darkmode variable
            switch($darkmode) {
                case "darkmode":
                    $darkmode = 1;
                    #Set darkmode cookie
                    $darkmodeVal = "darkmode";
                    setcookie("darkmode", $darkmodeVal);
                    break;
                case "lightmode": 
                    $darkmode = 0;
                    #Set lightmode cookie
                    $lightmodeVal = "lightmode";
                    setcookie("lightmode", $lightmodeVal);
                    break;
            }

            #Get username from $_SESSION superglobal array
            $username = $loggedin;
            #Build query string to pass to database
            $query = "UPDATE users SET metric = " . $metric . ", darkmode = ". $darkmode . " WHERE username = \"" . $username . "\"";
            #Update database
            $mysqli->query($query);
            #Set settings saved cookie
            $settingsSaved = "settingsSaved";
            setcookie("settingsSaved", $settingsSaved);
            #Redirect to account settings page 
            header("Location: /Final-Project/php/accountSettings.php");
            $mysqli->close();
            exit;
        }
        #If user not logged in 
        else if(!$loggedin) {
            #Redirect to weather.php
            header("Location: /Final-Project/php/weather.php");
            exit;
        }
    }
?>