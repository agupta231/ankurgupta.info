$("document").ready(function () {
    var data = {
        "keystring" : "*",
        "keytag" : "*",
    };
    data = $(this).serialize() + "&" + $.param(data);
    $.ajax({
        type: "POST",
        dataType: "json",
        url: "/php/search_site.php",
        data: data,
        success: function(response) {
            alert(response);
        }
    });
    return false;
});