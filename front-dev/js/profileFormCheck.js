$(document).on('ready', function () {
    
    jQuery.ajax({
        method: 'get',
        url: "graph/me",
        dataType: "json",
        success: function (data) {
            $(".loader").remove();
            $(".googlePlusData").append("<p>Name: " + data.name + "</a>");
            $(".googlePlusData").append("<p>Gender: " + data.gender + "</a>");
            $(".googlePlusData").append("<p><a href='" + data.homepage + "'>Homepage</p>");
            $(".googlePlusData").append("<img src='" + data.depiction + "' alt='avatar' class='tabAvatar'>");
        },
        error: function (data) {
            $(".loader").remove();
            $(".googlePlusData").append("<p>Failed to retrieve user data..</p>");
        }
    });
    $(".clearErrors").click(function () {
        $(".textWrapper").slideDown('fast');
        $(".errorWrapper").slideUp('fast');
        $(".invalid").removeClass("invalid");
    });
    $(".profile-form .btn").click(function (e) {
        $("p.error").addClass('hidden');
        $("p.error").html("");
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
                $("p.error#nameError").html('You have to enter your name');
                $("p.error#nameError").removeClass('hidden');
            } else {
                $("p.error#nameError").html('Your name must contain more than 8 letters.');
                $("p.error#nameError").removeClass('hidden');
            }
        } else {
            if (/^[a-zA-Z0-9- ]*$/.test(name) === false) {
                e.preventDefault();
                $("p.error#nameError").html('Your new name can\'t illegal characters.');
                $("p.error#nameError").removeClass('hidden');
            }
        }
        if (email.length < 1) {
            e.preventDefault();
            $(".profile-form input[name='email']").addClass("invalid");
            $("p.error#emailError").html('You can\'t delete your email');
            $("p.error#emailError").removeClass('hidden');
        }
        if (old_password.length !== 0) {
            if (password === password_confirmation) {
                if (password.length === 0) {
                    e.preventDefault();
                    $("p.error#old_passwordError").html('You can\'t delete your password');
                    $("p.error#old_passwordError").removeClass('hidden');
                    $(".profile-form input[name='new_password']").addClass("invalid");
                    $(".profile-form input[name='password_confirmation']").addClass("invalid");
                } else if (password.length < 8) {
                    e.preventDefault();
                    $("p.error#old_passwordError").html('Your password must contain at least eight letters.');
                    $("p.error#old_passwordError").removeClass('hidden');
                    $(".profile-form input[name='new_password']").addClass("invalid");
                    $(".profile-form input[name='password_confirmation']").addClass("invalid");
                } else if (/^[a-zA-Z0-9- ]*$/.test(name) === false) {
                    e.preventDefault();
                    $("p.error#old_passwordError").html('Your new password contains illegal characters.');
                    $("p.error#old_passwordError").removeClass('hidden');
                }
            } else {
                e.preventDefault();
                $(".profile-form input[name='new_password']").addClass("invalid");
                $(".profile-form input[name='password_confirmation']").addClass("invalid");
                $("p.error#old_passwordError").html('Passwords don\'t match.');
                $("p.error#old_passwordError").removeClass('hidden');
            }
        }
    });

});