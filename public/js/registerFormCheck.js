$(document).on('ready', function () {
    var errors = [];
    $(".clearErrors").click(function () {
        $(".textWrapper").slideDown('fast');
        $(".errorWrapper").slideUp('fast');
        $(".invalid").removeClass("invalid");
    });
    $(".register-form .btn").click(function (e) {
        errors = [];
        $(".textWrapper").slideDown('fast');
        $(".errorWrapper").slideUp('fast');
        $(".invalid").removeClass("invalid");
        var username = $(".register-form input[name='name']").val(),
            email = $(".register-form input[name='email']").val(),
            password = $(".register-form input[name='password']").val(),
            password_confirmation = $(".register-form input[name='password_confirmation']").val();
        if (username.length < 8) {
            e.preventDefault();
            $(".register-form input[name='name']").addClass("invalid");
            if (username.length === 0) {
                errors.push('You have to enter your name');
            } else {
                errors.push('Your name must contain more than 8 letters');
            }
        } else {
            if (/^[a-zA-Z0-9- ]*$/.test(name) === false) {
                e.preventDefault();
                errors.push('Your name contains illegal characters.');
            }
        }
        if (email.length < 1) {
            e.preventDefault();
            $(".register-form input[name='email']").addClass("invalid");
            errors.push('You have to enter an email');
        }
        if (password.length < 8) {
            e.preventDefault();
            $(".register-form input[name='password']").addClass("invalid");
            $(".register-form input[name='password_confirmation']").addClass("invalid");
            if (email.length === 0) {
                errors.push('You have to enter a password');
            } else {
                errors.push('Your password must contain at least 8 letters');
            }
        }
        if (password.length > 7 && password_confirmation.length < 1) {
            e.preventDefault();
            $(".register-form input[name='password_confirmation']").addClass("invalid");
            errors.push('You have to confirm your password');
        }
        if (password.length > 7 && password === password_confirmation) {
            if (/^[a-zA-Z0-9- ]*$/.test(name) === false) {
                e.preventDefault();
                errors.push('Your name contains illegal characters.');
            }
        }
        if (!$(".register-form input[name='password_confirmation']").hasClass("invalid") && !$(".register-form input[name='password']").hasClass("invalid")) {
            if (password !== password_confirmation) {
                e.preventDefault();
                $(".register-form input[name='password']").addClass("invalid");
                $(".register-form input[name='password_confirmation']").addClass("invalid");
                errors.push('Given passwords don\'t match');
            }
        }
        if (/^[a-zA-Z0-9- ]*$/.test(password) === false) {
            e.preventDefault();
            errors.push('Your password contains illegal characters.');
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