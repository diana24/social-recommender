$(document).on('ready', function () {
    jQuery.ajax({
        method: 'get',
        url: "graph/me",
        datatype: "json",
        success: function(data) {
            console.log("success");
            console.log(data);
        },
        error: function(data) {
            console.log("error");
        }
    });
    
});