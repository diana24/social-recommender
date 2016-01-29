$(document).on('ready', function () {
    jQuery.ajax({
        method: 'get',
        url: "graph/me",
        dataType: "json",
        success: function(data) {
            console.log(data);
            $(".user-box p.name").html(data.givenname);
            $("img[alt='avatar']").attr("src",data.depiction);
        },
        error: function(data) {
            console.log('Request failed');
        }
    });
    
});