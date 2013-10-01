/*jslint browser: true, sloppy: true */

/**
 * This is 
 */
var validatePosts = (function () {
    var pub = {};

    function validateThread() {
        var title, message;

        title = $("#ftitle").val();
        message = $("#fmessage").val();

        return true;
    }
    
    function validatePost() {
        return true;
    }
    
    /** setup()
     * this function sets up all the functionality of the main index page.
     */
    pub.setup = function () {
        //foreach replyform
        //$(this).submit(function ()
        //{
        //    validatePost);
        //}
        $("#threadform").submit(validateThread);
    }

    return pub;
}());

//setup called in forum.js, after the threads have been loaded
