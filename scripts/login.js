var Login = (function () {

    var pub = {};

    function isValidUsername(str) {
        var pattern;
        pattern = /^[A-Za-z0-9_]+$/;
        return pattern.test(str);
    }

    function setUsername(username) {
        Cookie.set("username", username);
    }

    function clearUsername() {
        Cookie.clear("username");
    }

    function doRegister() {
        var username, password;
        username = $("#reguser").value;
        fname = $("#regfname").value;
        lname = $("#reglname").value;
        pass = $("#regpass").value;
        pass2 = $("#regpass2").value;
        email = $("#regemail").value;
        
        if (!isValidUsername(username)) {
            alert("You need to enter a valid username");
        } else if (username === password) {
            //setUsername(username);
            alert("validation successfull");
        } else {
            alert("Username and Password don't match");
        }
        return false;
    }

    /*
    function doLogout() {
        clearUsername();
        return false;
    }
    */

    pub.setup = function () {
        //$("#loginform").onsubmit = doLogin;
        //$("#logoutform").onsubmit = doLogout;
        $("#registerform").onsubmit = doRegister;
    };

    return pub;
}());

$(document).ready(login.setup);
