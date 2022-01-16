/* JavaScript file for index.php */
$(function() {
    //Hide error message wrapper on page load
    $("div.errorWrapper").hide();
    //If logged out hidden element exists
    if($("#loggedoutMessage").val() == "true") {
        //Change error message background to green
        $("div.errorWrapper").css("background-color", "rgba(0, 128, 0, 0.7)");
        //Show error message wrapper
        $("div.errorWrapper").show();
        //Add logout success message to page
        $("h4.errorMessage").html("Logout Successful!");
    }
    //If account deleted hidden element exists
    if($("#accountDeleted").val() == "true") {
        //Change message background to green
        $("div.errorWrapper").css("background-color", "rgba(0, 128, 0, 0.7)");
        //Show message wrapper
        $("div.errorWrapper").show();
        //Add account delete success message to page 
        $("h4.errorMessage").html("Account Deleted Successfully!");
    }
});