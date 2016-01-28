$(document).on('ready', function () {
    jQuery.ajax({
        method: 'get',
        url: "graph/me",
        dataType: "json",
        success: function(data) {
            console.log("success");
            console.log(data);
        },
        error: function(data) {
            //$(".user-box p.name").html($(".profile-form input[name='name'").val());
        }
    });
    
});