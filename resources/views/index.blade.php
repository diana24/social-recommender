<!DOCTYPE html><html lang="en"><head><meta charset="utf-8"><meta http-equiv="X-UA-Compatible" content="IE=edge"><meta name="viewport" content="width=device-width, initial-scale=1"><title>SoR</title>{!! HTML::style('css/bootstrap.min.css') !!}
{!! HTML::style('css/stylesheet.css') !!}
{!! HTML::style('https://fonts.googleapis.com/css?family=Raleway:400,300,500,700') !!}
{!! HTML::style('https://fonts.googleapis.com/css?family=Roboto') !!}  
{!! HTML::style('https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css') !!}
{!! HTML::style('css/jquery-ui.structure.min.css') !!}
{!! HTML::style('css/jquery-ui.min.css') !!}
{!! HTML::style('css/jquery-ui.theme.min.css') !!}
{!! HTML::script("https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js") !!}
{!! HTML::script('js/userHeaderAjax.js') !!}
{!! HTML::script('js/jquery-ui.min.js') !!}</head><body><div class="container-fluid top-side"><div class="row"><div class="col-md-8 col-sm-8 col-xs-6"><h1 class="logo"><a href="{{url('home')}}"><img src="images/logo.png" alt="sor"></a><span>Social Recommender</span></h1></div><div class="col-md-4 col-sm-4 col-xs-6"><div class="user-box"><img src="images/avatar.jpg" alt="avatar"><p class="name"> 
<?php echo Auth::user()->name ?></p><ul class="usermenu"><li><a href="{{url('profile')}}"> <span class="glyphicon glyphicon-user"> </span>Profile</a></li><li><a href="{{url('auth/logout')}}"> <span class="glyphicon glyphicon-log-out"> </span>Logout</a></li></ul></div></div></div></div></body></html><div class="container-fluid main"><div class="row row-eq-height"><div class="col-md-2 col-sm-12 sidebar"><ul><li><span class="glyphicon glyphicon-flag"></span><a href="{{url('home')}}">Recommandations</a></li><li><span class="glyphicon glyphicon-search"></span><a href="{{url('search')}}">Search</a></li><li><span class="glyphicon glyphicon-list-alt"></span><a href="javascript:void(0)">Search History</a></li><li><span class="glyphicon glyphicon-star"></span><a href="javascript:void(0)">Favorites</a></li><li><span class="glyphicon glyphicon-file"></span><a href="{{url('report')}}">Report</a></li><li><?php if(Auth::user()->getGraphPath() !==null) {?>
<a target="_blank" href="<?php echo Auth::user()->getGraphPath() ?>"><span class="glyphicon glyphicon-unchecked"></span>Graph</a> 
<?php } ?></li></ul></div><div class="col-md-10 col-sm-12 application"><div class="results"><p class="resultHeader">Recommandations</p><div class="row"><div class="col-md-12"><div style="z-index: 1; margin-bottom: 10px" role="group" aria-label="..." class="btn-group"><a id="film" href="javascript:void(0)" class="btn btn-default">Recommend Films</a><a id="book" href="javascript:void(0)" class="btn btn-default">Recommend Books</a><a id="edu" href="javascript:void(0)" class="btn btn-default">Recommend Educational Institutes</a><a id="event" href="javascript:void(0)" class="btn btn-default">Recommend Events</a></div><img src="images/loading.gif" alt="loading.." class="recomloading hidden"></div></div><div class="row allResults"></div></div></div></div></div>{!! HTML::script('js/recommandations.js') !!}<footer class="container-fluid footer-side"><div class="row"><div class="col-md-12"><p>This is the footer. Information soon to be added here</p></div></div></footer>{!! HTML::script('js/bootstrap.min.js')  !!}