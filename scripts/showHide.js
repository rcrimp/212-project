/*jslint browser: true, sloppy: true */

/**
 * this showHide function collapes/expands the thread posts
 */
var showHide = (function () {
    var pub = {};

    pub.setup = function () {
        $("#content").find(".hideTag").each(function () {
            $(this).css("cursor", "pointer");
            $(this).click(function () {
                $(this).siblings(".hide").slideToggle(100);
                //.slideToggle($(this).parent().html().length/2);
                if ($(this).html() === "[-]") {
                    $(this).html("[+]");
                } else {
                    $(this).html("[-]");
                }
            });
        });
		
		$("#content").find(".replybutton").each(function () {
            $(this).css("cursor", "pointer");
            $(this).click(function () {
                $(this).siblings(".replyform").slideToggle(100);
                //.slideToggle($(this).parent().html().length/2);
            });
        });
    };

    return pub;
}());
