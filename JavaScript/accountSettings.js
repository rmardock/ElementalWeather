/* JavaScript file for accountSettings.php */
$(function() {
    //Hide message wrapper on page load
    $("div.errorWrapper").hide();
    //If lightmode hidden value is present
    if($("#lightmodeVal").val() == "true") {
        //If page is in dark mode
        if($("body").hasClass("darkmode")) {
            //Remove darkmode classes
            $("body").removeClass("darkmode");
            $("#settingsWrapper").removeClass("darkmodeFormWrapper");
            //Remove selected attribute from darkmode option
            $("#darkmode").removeAttr("selected");
            //Add selected attribute to lightmode option
            $("#lightmode").attr("selected", true);
        }
    }
    //If darkmode hidden value is present
    if($("#darkmodeVal").val() == "true") {
        //Add darkmode classes 
        $("body").addClass("darkmode");
        $("#settingsWrapper").addClass("darkmodeFormWrapper");
        //Remove selected attribute from lightmode option
        $("#lightmode").removeAttr("selected");
        //Add selected attribute to darkmode option
        $("#darkmode").attr("selected", true);
    }
    //If settings saved hidden element is present
    if($("#settingsSaved").val() == "true") {
        //Change message background to green
        $("div.errorWrapper").css("background-color", "rgba(0, 128, 0, 0.7)");
        //Show message
        $("div.errorWrapper").show();
        //Add message to page
        $("h4.errorMessage").html("Settings Saved!");
    }
    //If metric value hidden element is present
    if($("#metricVal").val() == "true") {
        //Remove selected attribute from imperial option
        $("#imperial").removeAttr("selected");
        //Add selected attribute to metric option
        $("#metric").attr("selected", true);
    }
    //If imperial value hidden element is present 
    if($("#imperialVal").val() == "true") {
        //Remove selected attribute from metric option
        $("#metric").removeAttr("selected");
        //Add selected attribute to imperial option
        $("#imperial").attr("selected", true);
    }
});