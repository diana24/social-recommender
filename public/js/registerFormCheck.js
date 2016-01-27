$(document).on('ready', function () {
    var errors = [];
    $(".register-form .btn").click(function (e) {
        errors = [];
        $(".textWrapper").slideDown('fast');
        $(".errorWrapper").slideUp('fast');
        $(".invalid").removeClass("invalid");
        var username = $(".register-form input[name='name']").val(),
            email = $(".register-form input[name='email']").val(),
            password = $(".register-form input[name='password']").val(),
            password_confirmation = $(".register-form input[name='password_confirmation']").val();
        if (username.length < 1) {
            e.preventDefault();
            $(".register-form input[name='name']").addClass("invalid");
            errors.push('You have to enter your name');
        }
        if (email.length < 1) {
            e.preventDefault();
            $(".register-form input[name='email']").addClass("invalid");
            errors.push('You have to enter an email');
        }
        if (password.length < 1) {
            e.preventDefault();
            $(".register-form input[name='password']").addClass("invalid");
            errors.push('You have to enter a password');
        }
        if (password_confirmation.length < 1) {
            e.preventDefault();
            $(".register-form input[name='password_confirmation']").addClass("invalid");
            errors.push('You have to confirm your password');
        }
        if (!$(".register-form input[name='password_confirmation']").hasClass("invalid") && !$(".register-form input[name='password']").hasClass("invalid")) {
            if (password !== password_confirmation) {
                e.preventDefault();
                $(".register-form input[name='password']").addClass("invalid");
                $(".register-form input[name='password_confirmation']").addClass("invalid");
                errors.push('Given passwords don\'t match');
            }
        }
        $(".errorWrapper").html("");
        if(errors.length > 0) { 
            $(errors).each(function(index, val) {
                $(".errorWrapper").append("<p>"+val+"</p>");
            });
            $(".textWrapper").slideUp('fast');
            $(".errorWrapper").slideDown('fast');
        }
    });

});