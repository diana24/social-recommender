<!DOCTYPE html><html lang="en"><head><meta charset="utf-8"><meta http-equiv="X-UA-Compatible" content="IE=edge"><meta name="viewport" content="width=device-width, initial-scale=1"><title>SoR</title>{!! HTML::style('css/bootstrap.min.css') !!}
{!! HTML::style('css/stylesheet.css') !!}
{!! HTML::style('https://fonts.googleapis.com/css?family=Raleway:400,300,500,700') !!}
{!! HTML::style('https://fonts.googleapis.com/css?family=Roboto') !!}  
{!! HTML::script("https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js") !!}</head><body></body></html><div class="container-fluid top-side"><div class="row"><div class="col-md-12"><h1 class="logo">{!! HTML::image('images/logo.png', 'Social Recommender') !!}<span>Social Recommender</span></h1></div><div class="col-md-12"><ul class="menu"><li><a href=<?php echo url('auth/register') ?>> Register </a></li></ul></div></div></div><div class="container-fluid specification-side"><div class="row"><div class="col-md-12"><h2>Start using SoR today!</h2></div><div class="col-md-7"><div class="row"><div class="col-md-12"><div class="textWrapper"> <p>SoR is an application able to recommend certain people/events/things of interest according to a given FOAF graph built for a specific user based on its social media profile(s).</p><p>For example, suggesting the members of an IT team based on desired skills (excellent knowledge of Web technologies + software engineering + open hardware), geolocation (i.e. from Romania and UK only), preferences, hobbies (i.e. horror movies + classical music), aversions (e.g., communication by phone, football, politics) and so on.</p></div></div><div class="col-md-12 errorColumn"><div class="errorWrapper"><h4>Form issues <a href="javascript:void(0)"> <span class="glyphicon glyphicon-remove-circle clearErrors"></span></a></h4><div class="errors"><?php if (count($errors) > 0) {?>
@foreach ($errors->all() as $error)
<p>{!! $error !!}</p>
@endforeach
<?php } ?></div></div></div></div></div><div class="col-md-5"><div class="row">{!! Form::open(array('url' => 'auth/login', 'class' => 'form login-form', 'role' => 'form', 'method'=>'post')) !!}<div class="col-md-12"><div class="form-group">{!! Form::email('email', null, ['class' => 'form-control', 'placeholder' => 'email..']) !!}</div></div><div class="col-md-12"><div class="form-group">{!! Form::password('password', ['class' => 'form-control', 'placeholder' => 'password..']) !!}</div></div><div class="col-md-12 text-right">{!! Form::submit('Login',  ['class' => 'btn']) !!}</div></div>{!! Form::close() !!}</div></div></div>{!! HTML::script('js/loginFormCheck.js') !!}<footer class="container-fluid footer-side"><div class="row"><div class="col-md-12"><p>Web Application Development Project</p><a href="http://profs.info.uaic.ro/~busaco/teach/courses/wade/">Course Page</a></div></div></footer>{!! HTML::script('js/bootstrap.min.js')  !!}