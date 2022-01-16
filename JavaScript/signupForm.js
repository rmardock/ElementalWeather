/* JavaScript file for signupForm.php */
$(function() {
    //Hide message wrapper on page load
    $("div.errorWrapper").hide();
    //If password error hidden element exists 
    if($("#passwordError").val() == "true") {
        //Show message wrapper 
        $("div.errorWrapper").show();
        //Add error message to page
        $("h4.errorMessage").html("Passwords do not match! Please try again.");    
    }
    //If empty error hidden element exists
    if($("#emptyError").val() == "true") {
        //Show message wrapper
        $("div.errorWrapper").show();
        
        $("h4.errorMessage").html("One or more fields was left blank! Fill out all fields before submission.");
    }
});