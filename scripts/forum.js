/*jslint browser: true, sloppy: true */

/**
 * This is the main script which sets up the initial functionality of the forum
 * using module pattern
 */
var forum = (function () {
    var pub = {};

    /** generateThreadList()
     *
     * parses that xml data in XML/forum.xml and formats a list of the contained threads
     * and adds onclick events
     */
    function generateThreadList(data, target) {
        $(data).find("thread").each(function () {
            $(target).append("<div class='thread'><h3>"
                             + $(this).find("title").text() + "</h3></div>");
        });

        $(target).find(".thread").each(function (i) {
            $(this).click(function () {
                thread.get($($(data).find('thread')[i]).find("posts").text(),
                           $($(data).find("thread")[i]).find("title").text());
            });
        });
        if (cookie.get("theme") !== null) {
            changeTheme.set(parseInt(cookie.get("theme"), 10));
        }
    }

    /** setup()
     *
     * this function sets up all the functionality of the main index page.
     *
     */
    pub.setup = function () {
        var startupMsg = "<h2>Main Page</h2><p class='reply'>Select a discusssion thread from the Discussions Pane.</p>",
            target = "nav";

        $("#content").html(startupMsg); //sets the intial welcome message
        $("#clearButton").click(function () { //adds click event for  the "Main" button
            $("#content").html(startupMsg);
            if (cookie.get("theme") !== null) {
                changeTheme.set(parseInt(cookie.get("theme"), 10));
            }
        });
        $("#userButton").click(users.get); //adds click event for the "Users" button
        $("#themeButtons").css("display", "none");
        $("#themeButton").click(function () {
            $("#themeButtons").slideToggle(100);
        });

        $.ajax({
            type: "GET",
            url: "XML/forum.xml",
            cache: false,
            //dataType: "xml",
            success: function (data) { //200 status
                generateThreadList(data, target); // generates a list of threads
            },
            error: function () { //500 status
                $(target).append("Unable to load the discussion threads");
            }
        });

        //changeTheme.setup();
    };

    return pub;
}());

$(document).ready(forum.setup);
