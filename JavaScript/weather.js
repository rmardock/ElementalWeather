/* JavaScript file for weather.php */
//Using jQuery 

/*
    References: 
        https://rapidapi.com/weatherapi/api/weatherapi-com?endpoint=apiendpoint_bef542ef-a177-4633-aacc-ee9703945037
        https://rapidapi.com/natkapral/api/ip-geo-location 
*/

//Requirement #7: Properly use GET

//Global objects
var currentSearchObject = {};
var weatherObject = {};

$(function() {
    //If imperial value hidden element is present
    if($("#imperialVal").val() == "true") {
        //Uncheck unit switch
        $("#unitTypeSwitch").attr("checked", false);
    }
    //If metric value hidden element is present
    if($("#metricVal").val() == "true") {
        //Check unit switch
        $("#unitTypeSwitch").attr("checked", true);
    }
    //If user has lightmode enabled in settings
    if($("#lightmode").val() == "true") {
        //If page is in darkmode
        if($("body").hasClass("darkmode")) {
            //Remove darkmode classes
            $("body").removeClass("darkmode");
            $("#weatherWrapper").removeClass("darkmodeFormWrapper");
        }
    }
    //If user has darkmode enabled in settings
    if($("#darkmode").val() == "true") {
        //Add darkmode classes
        $("body").addClass("darkmode");
        $("#weatherWrapper").addClass("darkmodeFormWrapper");
    }

    //When location search button is clicked
    $("#locationSearchButton").click(function() {
        //Show pop up box
        $("#locationSearchWrapper").css("display", "block");
        //On button click, close menu
        //Change class of divs for CSS transition
        $(".bar1").removeClass("change");
        $(".bar2").removeClass("change");
        $(".bar3").removeClass("change");
        //Change wrapper class
        $(".menuButtonWrapper").removeClass("expanded");
        $(".menuButtonWrapper").addClass("collapsed");
        //Code to close menu
        $("#menuWrapper").animate({width: "toggle"});
        $("#collapsedMenuButtonWrapper").show(1500);
        //Hide page elements while location search pop-up is open here: 
        $("#weatherWrapper").hide();
        return;
    });

    //When "x" button is clicked in pop-up window 
    $("#closeButton").click(function() {
        resetPopUpWindow();
        return;
    });

    //When "Search" button is clicked in pop-up window 
    $("#submitButton").click(function() {
        var searchVal = "";
        //If input is left blank, do nothing
        if($("#searchInput").val() == "") {
            return;
        }
        else {
            //Assign user input to variable
            searchVal = $("#searchInput").val();
            //Encode URI for use in API call
            searchVal = encodeURI(searchVal);
            cityLocationAPICall(searchVal);
            //Add prompt for users
            $("#searchControls").append("<p id=\"userPrompt\">Click on one of the search results to load weather for that location.</p>");
            return;
        }
    });

    //When a search result is clicked, add data to page 
    $(document).on('click', '.citySearchResults', function() {
        //Assign id to the id of the selected result
        var id = $(this).attr("id");
        //Get lat and lon of selected option 
        var lat = currentSearchObject[id]["lat"];
        var lon = currentSearchObject[id]["lon"];
        //Format lat and lon into one string for use as API parameter
        var location = lat + "," + lon;
        //Get weather data and display to page using location from selection
        weatherAPICall(location);
        //Close and reset location pop up window
        resetPopUpWindow();
        return;
    });

    //Hide Menu Bar on page load
    $("#menuWrapper").hide();
    //When menu button is clicked 
    $(".menuButtonWrapper").click(function() {
        //If menu is collapsed 
        if($(".menuButtonWrapper").hasClass("collapsed")) {
            //Change class of divs for CSS transition
            $(".bar1").addClass("change");
            $(".bar2").addClass("change");
            $(".bar3").addClass("change");
            //Change wrapper class 
            $(".menuButtonWrapper").removeClass("collapsed");
            $(".menuButtonWrapper").addClass("expanded");
            //Code to open menu
            $("#collapsedMenuButtonWrapper").hide();
            $("#weatherWrapper").hide();
            $("div.headerWrapper").hide();
            $("#menuWrapper").animate({width: "toggle"});
            return;
        }
        //If menu is expanded 
        if($(".menuButtonWrapper").hasClass("expanded")) {
            //Change class of divs for CSS transition
            $(".bar1").removeClass("change");
            $(".bar2").removeClass("change");
            $(".bar3").removeClass("change");
            //Change wrapper class
            $(".menuButtonWrapper").removeClass("expanded");
            $(".menuButtonWrapper").addClass("collapsed");
            //Code to close menu
            $("#menuWrapper").animate({width: "toggle"});
            $("div.headerWrapper").show(1500);
            $("#weatherWrapper").show(1500);
            $("#collapsedMenuButtonWrapper").show(1500);
            return;
        }
    });

    //When unit type switch is clicked in menu 
    $("#unitTypeSwitch").click(function () {
        //If switch is on
        //Check if data is empty-> do nothing
        if($("#unitTypeSwitch").is(":checked")) {
            //Update label for unit switch
            $("#unitSwitchLabel").html("Metric Units");
            //Update page with metric values
            weatherUnitProcessor();
            return;
        }
        //If switch is off
        else {
            //Update label for unit switch
            $("#unitSwitchLabel").html("Imperial Units");
            //Update page with imperial values
            weatherUnitProcessor();
            return;
        }
    });

    //Function to make AJAX Request to Weather API 
    function weatherAPICall(location) {
        //AJAX function for calling API from https://rapidapi.com/weatherapi/api/weatherapi-com?endpoint=apiendpoint_bef542ef-a177-4633-aacc-ee9703945037
        const currentWeatherParam = {
            "async": true,
            "crossDomain": true,
            "url": "https://weatherapi-com.p.rapidapi.com/forecast.json?q=" + location + "&days=3",
            "method": "GET",
            "headers": {
                "x-rapidapi-key": "00d24d1080msh659e6e8f428db30p168dbejsn36ce38fa9ef5",
                "x-rapidapi-host": "weatherapi-com.p.rapidapi.com"
            }
        };
        
        $.ajax(currentWeatherParam).done(function (currentWeatherResponse) {
            weatherProcessor(currentWeatherResponse);
            return;
        });
    }
    //End of content from https://rapidapi.com/weatherapi/api/weatherapi-com?endpoint=apiendpoint_bef542ef-a177-4633-aacc-ee9703945037

    //Function to make AJAX Request to City Geo Location API
    function cityLocationAPICall(searchVal) {
        //AJAX function for calling API from https://rapidapi.com/weatherapi/api/weatherapi-com?endpoint=apiendpoint_d85e9c6f-fa09-410e-9068-763abecae008
        const cityLocationParam = {
            "async": true,
            "crossDomain": true,
            "url": "https://weatherapi-com.p.rapidapi.com/search.json?q=" + searchVal,
            "method": "GET",
            "headers": {
                "x-rapidapi-key": "00d24d1080msh659e6e8f428db30p168dbejsn36ce38fa9ef5",
                "x-rapidapi-host": "weatherapi-com.p.rapidapi.com"
	        }
        };
        
        $.ajax(cityLocationParam).done(function (cityLocationResponse) {
            cityLocationProcessor(cityLocationResponse);
            return;
        });
        //End of content from https://rapidapi.com/GeocodeSupport/api/forward-reverse-geocoding 
    }

    //Function to make AJAX Request to IP Geo Location API
    function ipLocationAPICall(callback) { 
        //AJAX function for calling API from https://rapidapi.com/natkapral/api/ip-geo-location?endpoint=apiendpoint_0e95eebe-5290-481c-93d8-c417de659b25
        const ipLocationParam = {
            "async": true,
            "crossDomain": true,
            "url": "https://ip-geo-location.p.rapidapi.com/ip/check?format=json",
            "method": "GET",
            "headers": {
                "x-rapidapi-key": "00d24d1080msh659e6e8f428db30p168dbejsn36ce38fa9ef5",
                "x-rapidapi-host": "ip-geo-location.p.rapidapi.com"
            }
        };
        
        $.ajax(ipLocationParam).done(function (ipLocationResponse) {
            //Get latitude and longitude for current location from API response
            var currentLocation = ipLocationProcessor(ipLocationResponse);
            //Get city name for current location from API response 
            var currentCityName = ipLocationResponse.city.name;
            //Callback function to pass data to other functions
            callback(currentLocation, currentCityName);
            return;
        });
        //End of content from https://rapidapi.com/natkapral/api/ip-geo-location?endpoint=apiendpoint_0e95eebe-5290-481c-93d8-c417de659b25
    }

    function cityLocationProcessor(response) {
        var citySearchResults = "";

        //Empty search result object if populated 
        if(currentSearchObject.length > 0){
            currentSearchObject = {};
        }

        currentSearchObject = response;

        var searchResultsString = "";
        //Iterate results from search
        for(i = 0; i < response.length; i++) {
            //Build string to add search results to pop up window
            citySearchResults = response[i]["name"];
            searchResultsString = searchResultsString + "<div id=\"" + i + "\" class=\"citySearchResults\">" + citySearchResults + "</div>";
        }
        //Add results to pop up window
        $("#searchResults").html(searchResultsString);
        return;
    }

    //Function to get latitude and longitude from API response
    function ipLocationProcessor(response) {
        //Pull current location latitude and longitude from API response
        var lat = response.location.latitude;
        var lon = response.location.longitude;
        //Assign lat and lon to string for Weather API URL
        var currentLocation = lat + "," + lon;
        //Return lat/lon string
        return currentLocation;
    }

    //Function to load weather from current location
    function loadCurrentLocationWeather() {
        //Call IP Geo Location API and use location response as parameter for weather API call
        ipLocationAPICall(function (currentLocation, currentCityName) {
            weatherAPICall(currentLocation);
            //Override city name provided by Weather API because IP Geo Location is more precise
            //Later change so that weatherAPICall doesn't add city name; it should be pulled from user input/select
            $("#cityName").html(currentCityName);
        });
        return;
    }

    //Function to clear fields in pop-up window
    function resetPopUpWindow() {
        //Hide pop-up window
        $("#locationSearchWrapper").css("display", "none");
        //Show page elements
        $("#weatherWrapper").show();
        //Clear user prompt
        $("#userPrompt").remove();
        //Clear search results
        $("#searchResults").html("");
        //Clear input box text
        $("#searchInput").val("");
        return;
    }

    //Function to get weather information from API response and add to UI elements
    function weatherProcessor(response) {
        //Variables to pull weather information from API response
        var cityName = response.location.name;
        var skyCondition = response.current.condition.text;
        var tempC = response.current.temp_c;
        var tempF = response.current.temp_f;
        var feelsLikeC = response.current.feelslike_c;
        var feelsLikeF = response.current.feelslike_f;
        var humidity = response.current.humidity;
        var precipitationMM = response.current.precip_mm;
        var precipitationIN = response.current.precip_in;
        var visMiles = response.current.vis_miles;
        var visKm = response.current.vis_km;
        var uvIndex = response.current.uv;
        var windDir = response.current.wind_dir;
        var windKph = response.current.wind_kph;
        var windMph = response.current.wind_mph;
        var pressureMb = response.current.pressure_mb;
        var pressureIn = response.current.pressure_in;
        var lastUpdated = response.current.last_updated;
        var maxTempC = response.forecast.forecastday[0].day.maxtemp_c;
        var maxTempF = response.forecast.forecastday[0].day.maxtemp_f;
        var minTempC = response.forecast.forecastday[0].day.mintemp_c;
        var minTempF = response.forecast.forecastday[0].day.mintemp_f;
        var chanceOfRain = response.forecast.forecastday[0].day.daily_chance_of_rain;
        var chanceOfSnow = response.forecast.forecastday[0].day.daily_chance_of_snow;
        var sunrise = response.forecast.forecastday[0].astro.sunrise;
        var sunset = response.forecast.forecastday[0].astro.sunset;

        //Assign relevant precipitation to precipChanceVal
        var precipChance = "";
        if(chanceOfRain == 0 && chanceOfSnow > 0) {
            precipChance = chanceOfSnow;
        }
        else if(chanceOfRain > 0 && chanceOfSnow == 0) {
            precipChance = chanceOfRain;
        }
        else if(chanceOfRain == 0 && chanceOfSnow == 0) {
            precipChance = chanceOfRain;
        }

        //Build strings
        lastUpdated = "Last updated at: " + lastUpdated;
        humidity = humidity + "%";
        precipChance = precipChance + "%";

        //Assign relevant values to global object for switching between imperial/metric values
        weatherObject = {
            tempc : tempC,
            tempf : tempF,
            feelslikec : feelsLikeC,
            feelslikef : feelsLikeF,
            maxtempc : maxTempC,
            maxtempf : maxTempF,
            mintempc : minTempC,
            mintempf : minTempF,
            precipmm : precipitationMM,
            precipin : precipitationIN,
            vismiles : visMiles,
            viskm : visKm,
            winddir : windDir,
            windkph : windKph,
            windmph : windMph, 
            pressuremb : pressureMb,
            pressurein : pressureIn
        };

        //Add values to UI
        $("#cityName").html(cityName);
        $("#skyCondition").html(skyCondition);
        $("#sunriseVal").html(sunrise);
        $("#precipChanceVal").html(precipChance);
        $("#sunsetVal").html(sunset);
        $("#humidityVal").html(humidity);
        $("#uvVal").html(uvIndex);
        $("#lastUpdated").html(lastUpdated);

        //Call function to add Imperial or Metric values based on slider option in menu
        weatherUnitProcessor();
        return;
    }

    //Function to add elements to UI based on unit selection(Imperial/Metric) in menu panel
    function weatherUnitProcessor() {
        //If switch is on, metric values
        if($("#unitTypeSwitch").is(":checked")) {
            //Metric variables
            var tempC = weatherObject.tempc;
            var feelsLikeC = weatherObject.feelslikec;
            var maxTempC = weatherObject.maxtempc;
            var minTempC = weatherObject.mintempc;
            var precipMm = weatherObject.precipmm;
            var visKm = weatherObject.viskm;
            var pressureMb = weatherObject.pressuremb;
            var windKph = weatherObject.windkph;
            var windDir = weatherObject.winddir;

            //Build strings
            var windString = windDir + " " + windKph + " kph";
            var highLowString = "| High: " + maxTempC + "° | Low: " + minTempC + "° |";
            var currentTemp = tempC + "°";
            var feelsLikeString = feelsLikeC + "°";
            var visString = visKm + " km";
            var pressureString = pressureMb + " mbar";
            var precipString = precipMm + " mm";

            //Add values to UI
            $("#windVal").html(windString);
            $("#precipAmountVal").html(precipString);
            $("#visibilityVal").html(visString);
            $("#feelsLikeVal").html(feelsLikeString);
            $("#pressureVal").html(pressureString);
            $("#highLowTemps").html(highLowString);
            $("#currentTemperature").html(currentTemp);
            return;
        }
        //If switch is off, imperial values 
        else {
            //Imperial variables
            var tempF = weatherObject.tempf;
            var feelsLikeF = weatherObject.feelslikef;
            var maxTempF = weatherObject.maxtempf;
            var minTempF = weatherObject.mintempf;
            var precipIn = weatherObject.precipin;
            var visMiles = weatherObject.vismiles;
            var windDir = weatherObject.winddir;
            var windMph = weatherObject.windmph;
            var pressureIn = weatherObject.pressurein;
        
            //Build strings with multiple values
            var windString = windDir + " " + windMph + " mph";
            var highLowString = "| High: " + maxTempF + "° | Low: " + minTempF + "° |";
            var currentTemp = tempF + "°";
            var feelsLikeString = feelsLikeF + "°";
            var visString = visMiles + " mi";
            var pressureString = pressureIn + " inHg";
            var precipString = precipIn + " in";

            //Add values to UI
            $("#windVal").html(windString);
            $("#precipAmountVal").html(precipString);
            $("#visibilityVal").html(visString);
            $("#feelsLikeVal").html(feelsLikeString);
            $("#pressureVal").html(pressureString);
            $("#highLowTemps").html(highLowString);
            $("#currentTemperature").html(currentTemp);
            return;
        }
    } 
    //Load current location weather on page load
    loadCurrentLocationWeather();

    //If user is not logged in
    if($("#guestUser").val() == "true") {
        //Change contents of menu
        $("#menuUl").html("<li class=\"menuItem\"><h4>Login to access premium features!</h4></li>" + 
        "<li class=\"menuItem\"><button type=\"button\" id=\"loginButton\"><a href=\"/Final-Project/php/loginForm.php\">Login</a></button></li>" +
        "<li class=\"menuItem\"><button type=\"button\" id=\"signupButton\"><a href=\"/Final-Project/php/signupForm.php\">Signup</a></button></li>");
        //Hide data column
        $("#dataCol").hide();
        //Center weather data by changing bootstrap class
        $("#mainWeather").removeClass("col-8");
        $("#mainWeather").addClass("col-12");
    }
});