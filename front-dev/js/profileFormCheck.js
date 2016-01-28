$(document).on('ready', function () {
    var errors = [];
    $(".clearErrors").click(function () {
        $(".textWrapper").slideDown('fast');
        $(".errorWrapper").slideUp('fast');
        $(".invalid").removeClass("invalid");
    });
    $(".profile-form .btn").click(function (e) {
        errors = [];
        $(".invalid").removeClass("invalid");
        var username = $(".profile-form input[name='name']").val(),
            email = $(".profile-form input[name='email']").val(),
            old_password = $(".profile-form input[name='old_password']").val(),
            password = $(".profile-form input[name='new_password']").val(),
            password_confirmation = $(".profile-form input[name='password_confirmation']").val();
        if (username.length < 8) {
            e.preventDefault();
            $(".profile-form input[name='name']").addClass("invalid");
            if (username.length === 0) {
                errors.push('You have to enter your name');
            } else {
                errors.push('Your name must contain more than 8 letters');
            }
        } else {
            if (/^[a-zA-Z0-9- ]*$/.test(name) === false) {
                e.preventDefault();
                errors.push('Your new name can\'t illegal characters.');
            }
        }
        if (email.length < 1) {
            e.preventDefault();
            $(".profile-form input[name='email']").addClass("invalid");
            errors.push('You have to enter an email');
        }
        if (old_password.length !== 0) {
            if(password === password_confirmation) {
                if(password.length === 0) {
                    e.preventDefault();
                    errors.push('You can\'t delete your password.');
                    $(".profile-form input[name='new_password']").addClass("invalid");
                    $(".profile-form input[name='password_confirmation']").addClass("invalid");
                } else if(password.length < 8) {
                    e.preventDefault();
                    errors.push('Your password must contain at least eight letters.');
                    $(".profile-form input[name='new_password']").addClass("invalid");
                    $(".profile-form input[name='password_confirmation']").addClass("invalid");
                } else if (/^[a-zA-Z0-9- ]*$/.test(name) === false) {
                    e.preventDefault();
                    errors.push('Your new password contains illegal characters.');
                }
            } else {
                e.preventDefault();
                $(".profile-form input[name='new_password']").addClass("invalid");
                $(".profile-form input[name='password_confirmation']").addClass("invalid");
                errors.push('Passwords don\'t match.');
            }
        } 
        e.preventDefault();
        console.log(errors);
        /*
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
        }*/
    });

});