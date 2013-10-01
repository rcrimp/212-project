var changeTheme = (function () {
    var pub = {};

    function setHover(ele, c1, c2) {
        ele.onmouseover = function () {
            $(ele).css("background-color", c2);
            $(ele).css("background-color", c2);
        };
        ele.onmouseout = function () {
            $(ele).css("background-color", c1);
            $(ele).css("background-color", c1);
        };
    }

    function changeCSS(c, c1, c2) {
        $("footer").css("background-color", c1);
        $(".thread h3, .button").css("background-color", c1);
        $(".reply").css("border-left-color", c1);
        $(".username").css("color", c1);
        $(".user").css("border-color", c1);
        $(".thread h3, .button").each(function () {
            setHover(this, c1, c2);
        });
        $("#logo").attr("src", "images/logo_" + c + ".png");
    }

    pub.set = function (i) {
        cookie.set("theme", i);
        switch (i) {
        case 0:
            changeCSS("b", "#3AD", "#6CE");
            break;
        case 1:
            changeCSS("g", "#22BB22", "#33DD33"); //#6DEE66
            break;
        case 2:
            changeCSS("o", "#FFB311", "#FFCD7D");
            break;
        case 3:
            changeCSS("r", "#DD4F33", "#EE7666");
            break;
        case 4:
            changeCSS("p", "#C733DD", "#D666EE");
            break;
        }
    };

    return pub;
}());
