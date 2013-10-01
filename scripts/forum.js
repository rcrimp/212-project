/*jslint browser: true, sloppy: true */

/**
 * This is the main script which sets up the initial functionality of the forum
 * using module pattern
 */
var forum = (function () {
    var pub = {};

    function htmlEntities(str) {
        return String(str).replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;').replace(/"/g, '&quot;');
    }
    
    /** generateThreadList()
     *
     * parses that xml data in XML/forum.xml and formats a list of the contained threads
     * and adds onclick events
     */
    function generateThreadList(data, target) {
        $(target).html("<h2>Threads</h2>")
        $(data).find("thread").each(function () {	    
            $(target).append("<div class='thread'>"
                             + "<h3>" + htmlEntities($(this).find("title").text()) + "</h3>"
                             + "<p>" + htmlEntities($(this).find("OP").text()) + "</p>"
                             + "<p>" + htmlEntities($(this).find("postcount").text()) + " comments</p>"
                             + "<div>");
        });

        $(target).append(
            $('<div/>')
                .attr("id", "newThread")
                .text("New Thread")
                .click(function () {
                    $("#content").html("<h2>New Thread</h2>"
                                       + "<form id='threadform' action='thread.php' method='post'>"
                                       + "<label for='ftitle'>Title</label>"
                                       + "<input id='ftitle' type='text' name='title'>"
                                       + "<label for='fmessage'>Message</label>"
                                       + "<textarea id='fmessage' name='message' rows='4' cols='50'></textarea>"
                                       + "<input type='submit' value='submit'>"
                                       + "</form>");
                    $("#discussionNav").html("<p>Loading...</p>");
                    ajaxThreadData("#discussionNav");
                })
        );

        $("#loading").html("");

        $(target).find(".thread").each(function (i) {
            $(this).click(function () {
                $("#loading").html("<p>Loading...</p>");
                thread.get($($(data).find('thread')[i]).find("posts").text(),
                           $($(data).find("thread")[i]).find("title").text());
                ajaxThreadData("#discussionNav");
            });
        });
        if (cookie.get("theme") !== null) {
            changeTheme.set(parseInt(cookie.get("theme"), 10));
        }
        validatePosts.setup();
    }

    function ajaxThreadData(target){
        $.ajax({
            type: "GET",
            url: "XML/forum.xml",
            cache: false,
            success: function (data) { //200 status
                generateThreadList(data, target); // generates a list of threads
            },
            error: function () { //500 status
                $(target).append("Unable to load the discussion threads");
            }
        });
    }

    /** setup()
     * this function sets up all the functionality of the main index page.
     */
    pub.setup = function () {
        $("#clearButton").click(function () { //adds click event for  the "Main" button
            $("#content").html("");
            $("#loading").html("<p>Loading...</p>");
            $("#discussionNav").html("");
            ajaxThreadData("#content");
            if (cookie.get("theme") !== null) {
                changeTheme.set(parseInt(cookie.get("theme"), 10));
            }
        });
        $("#logoutButton").click(function () {
            if (confirm("Do you want to log out?")){
                window.location = "logout.php";
            }
        });
        $("#userButton").click(function () {
            users.get(); //adds click event for the "Users" button
            $("#discussionNav").html("<p>Loading...</p>");
            ajaxThreadData("#discussionNav");
        });
        
        $("#themeButtons").css("display", "none");
        $("#themeButton").click(function () {
            $("#themeButtons").slideToggle(100);
        });

        ajaxThreadData("#content");
    };

    return pub;
}());

$(document).ready(forum.setup);
