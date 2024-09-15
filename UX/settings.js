

$(document).ready(function () {

    let theme_selected = "";




    // localStorage.setItem('theme', 'light');

    const theme = localStorage.getItem('theme');
    if (!theme) {
        localStorage.setItem('theme', 'light');
        const themeempt = localStorage.getItem('theme');
        document.getElementById(themeempt).checked = true;
        $("#" + themeempt).closest("label").addClass("selected_class");
    } else {
        document.getElementById(theme).checked = true;
        // console.log(theme);
        $(".themes_select label").removeClass("selected_class");
        $("#" + theme).closest("label").addClass("selected_class");


    }



    $(".themes_select label").click(function (e) {
        e.preventDefault();
        theme_selected = ""

        let hasclass = $(this).hasClass("selected_class");
        let rad = $(this).find("input").attr("id");

        if (hasclass) {

        } else {
            $(".themes_select label").removeClass("selected_class");
            $(this).addClass("selected_class");
            document.getElementById(rad).checked = true;


        }
        if (findTrue()) {
            theme_selected = findTrue();
            $("#save_theme").addClass("inv");

        } else {
            $("#save_theme").removeClass("inv");

        }
    });

    $("#save_theme").click(function (e) {
        e.preventDefault();

        if (theme_selected != "") {

            localStorage.setItem('theme', theme_selected);
            // console.log("good" + theme_selected);
            theme_selected = ""
            $("#save_theme").removeClass("inv");



        } else {
            // console.log("error");
            // console.log("jjjjjjjj" + theme_selected);

        }







    });







    function findTrue() {
        const theme = localStorage.getItem('theme');


        let isTheme1 = document.getElementById("light");
        let isTheme2 = document.getElementById("monokai");
        let isTheme3 = document.getElementById("dark_modern");


        if ((isTheme1.checked) && isTheme1.value != theme) {
            return "light"

        } else if ((isTheme2.checked) && isTheme2.value != theme) {
            return "monokai"

        } else if ((isTheme3.checked) && isTheme3.value != theme) {
            return "dark_modern"
        }


        return false

    }

});




function getid(s) {
    return document.getElementById(s)
}



