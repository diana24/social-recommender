<!DOCTYPE html><html lang="en"><head><meta charset="utf-8"><meta http-equiv="X-UA-Compatible" content="IE=edge"><meta name="viewport" content="width=device-width, initial-scale=1"><title>SoR</title>{!! HTML::style('css/bootstrap.min.css') !!}
{!! HTML::style('css/stylesheet.css') !!}
{!! HTML::style('https://fonts.googleapis.com/css?family=Raleway:400,300,500,700') !!}
{!! HTML::style('https://fonts.googleapis.com/css?family=Roboto') !!}  
{!! HTML::style('https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css') !!}
{!! HTML::script("https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js") !!}
{!! HTML::script('js/userHeaderAjax.js') !!}</head><body><div class="container-fluid top-side"><div class="row"><div class="col-md-8"><h1 class="logo"><a href="index.html"><img src="images/logo.png" alt="sor"></a><span>Social Recommender</span></h1></div><div class="col-md-4"><div class="user-box"><img src="images/avatar.jpg" alt="avatar"><p class="name">Fermuș V. Vasile-Octavian</p><ul class="usermenu"><li><a href="{{url('profile')}}"> <span class="glyphicon glyphicon-user"> </span>Profile</a></li><li><a href="{{url('auth/logout')}}"> <span class="glyphicon glyphicon-log-out"> </span>Logout</a></li></ul></div></div></div></div></body></html><div class="container-fluid main"><div class="row row-eq-height"><div class="col-md-2 col-sm-12 sidebar"><ul><li><span class="glyphicon glyphicon-search"></span><a href="{{url('home')}}">Search</a></li><li><span class="glyphicon glyphicon-list-alt"></span><a href="javascript:void(0)">Search History</a></li><li><span class="glyphicon glyphicon-star"></span><a href="javascript:void(0)">Favorites</a></li><li><span class="glyphicon glyphicon-unchecked"></span><a href="graph.html">Graph</a></li><li><span class="glyphicon glyphicon-file"></span><a href="report.html">Report</a></li></ul></div><div class="col-md-7 col-sm-6 application"><h2>Profile Settings</h2><div class="row"> 
{!! Form::open(array('url' => 'update', 'class' => 'profile-form', 'role' => 'form', 'method'=>'put')) !!}<div class="col-md-12"><label>Change username</label></div><div class="col-md-12"><div class="form-group">{!! Form::text('name', Auth::user()->name, ['class' => 'form-control', 'placeholder' => 'username..']) !!}<p id="nameError" class="error hidden"></p></div></div><div class="col-md-12"><label>Change email</label></div><div class="col-md-12"><div class="form-group">{!! Form::email('email', Auth::user()->email, ['class' => 'form-control', 'placeholder' => 'email..']) !!}<p id="emailError" class="error hidden"></p></div></div><div class="col-md-12"><label>Change Password</label></div><div class="col-md-12"><div class="form-group">{!! Form::password('old_password', ['class' => 'form-control', 'placeholder' => 'old password..']) !!}<p id="old_passwordError" class="error hidden"></p></div></div><div class="col-md-6"><div class="form-group">{!! Form::password('new_password', ['class' => 'form-control', 'placeholder' => 'new password..']) !!}</div></div><div class="col-md-6"><div class="form-group">{!! Form::password('password_confirmation', ['class' => 'signin_input_password form-control', 'placeholder' => 'repeat password..']) !!}</div></div><div class="col-md-12 text-right"><div class="form-group">{!! Form::submit('Submit Changes',  ['class' => 'btn']) !!}</div></div>{!! Form::close() !!}</div></div><div class="col-md-3 col-sm-6"><div class="socialMediaWrapper"><div id="accordion" class="panel-group">     <div class="panel panel-default"><div class="panel-heading"><h4 class="panel-title"><a data-toggle="collapse" data-parent="#accordion" href="#googlePlus"> <i class="fa fa-google-plus"> </i> Google+</a></h4></div><div id="googlePlus" class="panel-collapse collapse in"><div class="panel-body"><?php if(false === Auth::user()->hasSocialAccount()) {  ?><a href="{{url('/createAuthUrl')}}" class="authenticateLink"> <i class="fa fa-google-plus"> </i>Authenticate with Google+</a><?php } if(Auth::user()->getGraphPath() !==null) {?>
<a target="_blank" href="<?php echo Auth::user()->getGraphPath() ?>">View XML Graph</a>
<?php } ?></div></div></div></div></div></div></div></div>{!! HTML::script('js/profileFormCheck.js') !!}<footer class="container-fluid footer-side"><div class="row"><div class="col-md-12"><p>This is the footer. Information soon to be added here</p></div></div></footer>{!! HTML::script('js/bootstrap.min.js')  !!}