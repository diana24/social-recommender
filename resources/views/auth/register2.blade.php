<!DOCTYPE html>
<html>
    <head>

    </head>
    <body>
        {{--<form action="http://social-recommender.ro/auth/register" method="POST">--}}
            {{--<input type="text" name="name" placeholder="Enter name">--}}
            {{--<input type="email" name="email" placeholder="Ënter email">--}}
            {{--<input type="password" name="password">--}}
            {{--<input type="password" name="password_confirmation">--}}
            {{--<input type="submit" value="Register">--}}
        <p>s</p>
        {{--</form>--}}
        {!! Form::open(array('url' => 'auth/register', 'class' => 'form', 'role' => 'form', 'method'=>'post')) !!}
        {!! Form::text('name', null, ['class' => 'form-control', 'placeholder' => 'Enter name']) !!}
        {!! Form::email('email', null, ['class' => 'form-control', 'placeholder' => 'Enter email']) !!}
        {!! Form::password('password', ['class' => 'form-control', 'placeholder' => 'Enter password']) !!}
        {!! Form::password('password_confirmation', ['class' => 'signin_input_password form-control', 'placeholder' => 'Re-enter password']) !!}
        {!! Form::submit('Register',  ['class' => 'btn']) !!}
        {!! Form::close() !!}
    </body>
</html>
