<!DOCTYPE html><html lang="en"><head><meta charset="utf-8"><meta http-equiv="X-UA-Compatible" content="IE=edge"><meta name="viewport" content="width=device-width, initial-scale=1"><title>SoR</title>{!! HTML::style('css/bootstrap.min.css') !!}
{!! HTML::style('css/stylesheet.css') !!}
{!! HTML::style('https://fonts.googleapis.com/css?family=Raleway:400,300,500,700') !!}
{!! HTML::style('https://fonts.googleapis.com/css?family=Roboto') !!}</head><body></body></html><div class="container-fluid top-side"><div class="row"><div class="col-md-12"><h1 class="logo"><img src="images/logo.png" alt="sor"><span>Social Recommender</span></h1></div><div class="col-md-12"><ul class="menu"><li>{!! HTML::linkRoute('auth/register', 'Register') !!}</li><li><a href="about_us">About us</a></li></ul></div></div></div><div class="container-fluid specification-side"><div class="row"><div class="col-md-7"><h2>Start using SoR today!</h2><p>SoR is an application able to recommend certain people/events/things of interest according to a given FOAF graph built for a specific user based on its social media profile(s).</p><p>For example, suggesting the members of an IT team based on desired skills (excellent knowledge of Web technologies + software engineering + open hardware), geolocation (i.e. from Romania and UK only), preferences, hobbies (i.e. horror movies + classical music), aversions (e.g., communication by phone, football, politics) and so on.</p></div><div class="col-md-5"><div class="row">{!! Form::open(array('url' => 'auth/login', 'class' => 'form', 'role' => 'form', 'method'=>'post')) !!}<div class="col-md-12"><div class="form-group">{!! Form::email('email', null, ['class' => 'form-control', 'placeholder' => 'email..']) !!}</div></div><div class="col-md-12">{!! Form::password('password', ['class' => 'form-control', 'placeholder' => 'password..']) !!}</div><div class="col-md-12 text-right"><div class="checkbox"><input type="checkbox" value="">Remember me</div></div><div class="col-md-12 text-right"><a href="forgottenPassword.html">Forgotten password? </a><button type="submit" class="btn">Login</button></div>{!! Form::close() !!}</div></div></div></div><footer class="container-fluid footer-side"><div class="row"><div class="col-md-12"><p>This is the footer. Information soon to be added here</p></div></div></footer><script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script><script src="js/bootstrap.min.js"></script>