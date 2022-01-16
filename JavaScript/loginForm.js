/* JavaScript file for loginForm.php */
$(function() {
    //Hide error message wrapper on page load
    $("div.errorWrapper").hide();
    //If incorrect login hidden element exists
    if($("#loginIncorrect").val() == "true") {
        //Change message wrapper background to red
        $("div.errorWrapper").css("background-color", "rgba(255, 0, 0, 0.3)");
        //Show error message wrapper
        $("div.errorWrapper").show();
        //Add error message to page 
        $("h4.errorMessage").html("Username or password were incorrect! Try again.");
        return;
    }
    //If sign up success hidden element exists
    if($("#signupSuccess").val() == "true") {
        //Change mesage wrapper background to green
        $("div.errorWrapper").css("background-color", "rgba(0, 128, 0, 0.7)");
        //Show message wrapper
        $("div.errorWrapper").show();
        //Add success message to page 
        $("h4.errorMessage").html("Account created successfully! Please login.");
        return;
    }
});