<!DOCTYPE html><html lang="en"><head><meta charset="utf-8"><meta http-equiv="X-UA-Compatible" content="IE=edge"><meta name="viewport" content="width=device-width, initial-scale=1"><title>SoR</title>{!! HTML::style('css/bootstrap.min.css') !!}
{!! HTML::style('css/stylesheet.css') !!}
{!! HTML::style('https://fonts.googleapis.com/css?family=Raleway:400,300,500,700') !!}
{!! HTML::style('https://fonts.googleapis.com/css?family=Roboto') !!}  
{!! HTML::script("https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js") !!}</head><body><div class="container-fluid top-side"><div class="row"><div class="col-md-8"><h1 class="logo"><a href="index.html"><img src="images/logo.png" alt="sor"></a><span>Social Recommender</span></h1></div><div class="col-md-4"><div class="user-box"><img src="images/avatar.jpg" alt="avatar"><p class="name">Fermuș V. Vasile-Octavian</p><ul class="usermenu"><li><a href=<?php echo url('profile') ?>> <span class="glyphicon glyphicon-user"></span> Profile</a></li><li><a href=<?php echo url('auth/logout') ?>> <span class="glyphicon glyphicon-log-out"></span> Logout</a></li></ul></div></div></div></div></body></html><div class="container-fluid main"><div class="row row-eq-height"><div class="col-md-2 col-sm-12 sidebar"><ul><li><span class="glyphicon glyphicon-search"></span><a href="index.html">Search</a></li><li><span class="glyphicon glyphicon-floppy-disk"></span><a href="javascript:void(0)">Saved Lists</a></li><li><span class="glyphicon glyphicon-list-alt"></span><a href="javascript:void(0)">Search History</a></li><li><span class="glyphicon glyphicon-star"></span><a href="javascript:void(0)">Favorites</a></li><li><span class="glyphicon glyphicon-unchecked"></span><a href="graph.html">Graph</a></li><li><span class="glyphicon glyphicon-file"></span><a href="report.html">Report</a></li></ul></div><div class="col-md-10 col-sm-12 application">{!! Form::open(array('url' => 'update', 'class' => 'profile-form', 'role' => 'form', 'method'=>'put')) !!}<h2>Profile Settings</h2><div class="row"><div class="col-md-12"><div class="form-group">{!! Form::text('name', Auth::user()->name, ['class' => 'form-control', 'placeholder' => 'username..']) !!}</div></div><div class="col-md-12"><div class="form-group">{!! Form::email('email', Auth::user()->email, ['class' => 'form-control', 'placeholder' => 'email..']) !!}</div></div><div class="col-md-12"><label>Change Password</label></div><div class="col-md-6"><div class="form-group">{!! Form::password('password', ['class' => 'form-control', 'placeholder' => 'new password..']) !!}</div></div><div class="col-md-6"><div class="form-group">{!! Form::password('password_confirmation', ['class' => 'signin_input_password form-control', 'placeholder' => 'repeat password..']) !!}</div></div><div class="col-md-12 text-right"><div class="form-group">{!! Form::submit('Submit Changes',  ['class' => 'btn']) !!}</div></div></div>{!! Form::close() !!}</div></div></div>