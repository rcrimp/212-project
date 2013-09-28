/*jslint browser: true, sloppy: true */

/**
 * using module pattern
 */
var thread = (function () {
    var pub = {};

    /** showThread()
     *
     * this function formats and returns the data from the specified thread
     */
    function showThread(data) {
        var result = "";
        if (!$(data).children("post").text()) {
            return result; //if no posts found
        }

        //for each child post
        $(data).children("post").each(function () {
            var username = $(this).children("username").text(),

                //formatting date time data
                date = $(this).children("date"),
                time = $(this).children("time"),
                text = $(this).children("text").text(),
                day = $(date).children("day").text(),
                month = $(date).children("month").text(),
                year = $(date).children("year").text(),
                hour = $(time).children("hour").text(),
                minute = $(time).children("minute").text(),
                second = $(time).children("seconds").text(),
                datetime = day + "-" + month + "-" + year
                       + " " + hour + ":" + minute + ":" + second;

            result += "<div class='reply'><p class='hideTag'>[-]</p><p class='username'>"
                + username + "</p><p class='datetime'>"
                + datetime + "</p><div class='hide'><p class='text'>"
                + text + "</p>";

            if ($(this).children("post")) {
                result += showThread(this) + "</div>"; //recursive call for replies of replies
            } else {
                result += "</div>";
            }
            result += "</div>";
        });

        return result;
    }

    /** get()
     *
     * this function sends an ajax get request for some specified thread's xml data
     */
    pub.get = function (src, title) {
        $("#content").html("<h2>" + title + "</h2>");
        $.ajax({
            type: "GET",
            url: "XML/" + src,
            cache: false,
            dataType: "xml",
            success: function (data) { //200 status
                $("#content").append("<p id='postCount'>" + $(data).find("post").size() + " replies</p>");
                $("#content").append(showThread($(data).children("posts")));
                showHide.setup();
                if (cookie.get("theme") !== null) {
                    changeTheme.set(parseInt(cookie.get("theme"), 10));
                }
            },
            error: function () { //500 status
                $("#content").html("Unable to load the selected discussion thread");
            }
        });
    };

    return pub;
}());
