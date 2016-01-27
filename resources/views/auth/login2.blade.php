<!DOCTYPE html>
<html>
<head>

</head>
    <body>
        {!! Form::open(array('url' => 'auth/login', 'class' => 'form', 'role' => 'form', 'method'=>'post')) !!}
        {!! Form::email('email', null, ['class' => 'form-control', 'placeholder' => 'Enter email']) !!}
        {!! Form::password('password', ['class' => 'form-control', 'placeholder' => 'Enter password']) !!}
        {!! Form::submit('Login',  ['class' => 'btn']) !!}
        {!! Form::close() !!}
    </body>
</html>
