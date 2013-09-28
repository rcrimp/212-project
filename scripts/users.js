/*jslint browser: true, sloppy: true */

/**
 * using module pattern
 */
var users = (function () {
    var pub = {};

    /** loadImage()
     *
     * this function replaces the default user icon if the image at "path" exists
     * this might seem like a weird way to load images but,
     * it's the best way I found to get around caching AND asynchronus image loading.
     */
    function loadImage(path, i) {
        var img = new Image();
        img.onload = function () {
            var target = $("#content").children(".user")[i];
            $(target).find("img").prop("src", img.src);
        };
        img.src = path;
    }

    /** showUsers()
     *
     * this function formats the users.xml data
     */
    function showUsers(data, target) {
        var result = "<div id='userList'>";
        $(target).html("<h2>Registered Users</h2>");

        $(data).find('user').each(function (i) {
            var username = $(this).find('username').text(), src;

            if ($(this).find('gender').text() === "Male") {
                src = "userImages/default_male.png";
            } else {
                src = "userImages/default_female.png";
            }

            result = "<div class='user'><img alt='" + username
                + "s icon' src='" + src
                + "'><p >User: <p class='username'>" + ($(this).find('username').text())
                + "</p></p><br><p>Name: <p class='username'>" + $(this).find('firstname').text()
                + " " + $(this).find('lastname').text()
                + "</p></p><div class='sig'>" + $(this).find('signature').text()
                + "</div></div>";

            $(target).append(result);

            loadImage("userImages/" + username + ".png", i);
            loadImage("userImages/" + username + ".jpg", i);
        });
    }

    /** get() function gets the users.xml data
     *
     * this function is called when the page loads and passes the XML data
     * to the parseData function
     */
    pub.get = function () {
        $.ajax({
            type: "GET",
            url: "XML/users.xml",
            cache: false,
            dataType: "xml",
            success: function (data) { //200 status
                showUsers(data, "#content");
                if (cookie.get("theme") !== null) {
                    changeTheme.set(parseInt(cookie.get("theme"), 10));
                }
            },
            error: function () { //500 status
                $("#content").html("Unable to load the list of users");
            }
        });
    };

    return pub;
}());
