$(document).on('ready', function () {
    var errors = [];
    $(".clearErrors").click(function () {
        $(".textWrapper").slideDown('fast');
        $(".errorWrapper").slideUp('fast');
        $(".invalid").removeClass("invalid");
    });
    $(".login-form .btn").click(function (e) {
        errors = [];
        $(".textWrapper").slideDown('fast');
        $(".errorWrapper").slideUp('fast');
        $(".invalid").removeClass("invalid");
        var email = $(".login-form input[name='email']").val(),
            password = $(".login-form input[name='password']").val();
        if (email.length === 0) {
            e.preventDefault();
            errors.push('You have to enter your email');
        }
        if (password.length === 0) {
            e.preventDefault();
            errors.push('You have to enter your password'); 
        }
        $(".errorWrapper .errors").html("");
        if (errors.length > 0) {
            $(errors).each(function (index, val) {
                $(".errorWrapper .errors").append("<p>" + val + "</p>");
            });
            $(".textWrapper").slideUp('fast');
            $(".errorWrapper").slideDown('fast');
        }
    });

});