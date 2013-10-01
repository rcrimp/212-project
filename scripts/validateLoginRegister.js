/*jslint browser: true, sloppy: true */

/**
 * This is the portal script which sets up the login/register funcionality
 * including client side validation.
 * using module pattern
 */
var portal = (function () {
    var pub = {};

    function isAlphaNumeric(str) {
        return /^[A-Za-z0-9_]+$/.test(str);
    }

    function isAlphaWhitespace(str) {
        return /^[A-Za-z\s-_]+$/.test(str);
    }

    function isEmail(str) { 
        var pattern = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
        return pattern.test(str);
    }

    function validateRegistration() {
        var username, fname, lname, pass, pass2, email;

        username = $("#reguser").val();
        fname = $("#regfname").val();
        lname = $("#reglname").val();
        pass = $("#regpass").val();
        pass2 = $("#regpass2").val();
        email = $("#regemail").val();

        
        if (username.length < 1) {
            alert("please enter a username");
        } else if (!isAlphaNumeric(username)) {
            alert("Please only valid characters (username)");
        } else if (username.length < 2) {
            alert("min username size is 2")
        } else if (fname.length < 1) {
            alert("please enter a name");
        } else if (!isAlphaWhitespace(fname)) {
            alert("Please only valid characters (name)");
        } else if (lname.length < 1) {
            alert("please enter a surname");
        } else if (!isAlphaWhitespace(lname)){
            alert("Please only valid characers (surname)");
        } else if (pass.length < 1) {
            alert("please enter a password");
        } else if (pass.length < 6) {
            alert("min password size is 6");
        } else if (pass !== pass2) {
            alert("Passwords dont match");
        } else if (!isEmail(email)) {
            alert("please enter a valid email");
        } else {
            return true;
        }
        return false;
    }
    
    /** setup()
     * this function sets up all the functionality of the main index page.
     */
    pub.setup = function () {
        $("#registerform").submit(validateRegistration);

        $("#lbutton").click(function () {
            $("#loginform").slideToggle(300);
            $("#registerform").slideUp(600);
        });
        $("#rbutton").click(function () {
            $("#registerform").slideToggle(300);
            $("#loginform").slideUp(600);
            
        });
    }

    return pub;
}());

$(document).ready(portal.setup);
