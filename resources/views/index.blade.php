<!DOCTYPE html><html lang="en"><head><meta charset="utf-8"><meta http-equiv="X-UA-Compatible" content="IE=edge"><meta name="viewport" content="width=device-width, initial-scale=1"><title>SoR</title>{!! HTML::style('css/bootstrap.min.css') !!}
{!! HTML::style('css/stylesheet.css') !!}
{!! HTML::style('https://fonts.googleapis.com/css?family=Raleway:400,300,500,700') !!}
{!! HTML::style('https://fonts.googleapis.com/css?family=Roboto') !!}  
{!! HTML::style('https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css') !!}
{!! HTML::style('css/jquery-ui.structure.min.css') !!}
{!! HTML::style('css/jquery-ui.theme.min.css') !!}
{!! HTML::script("https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js") !!}
{!! HTML::script('js/userHeaderAjax.js') !!}
{!! HTML::script('js/jquery-ui.min.js') !!}</head><body><div class="container-fluid top-side"><div class="row"><div class="col-md-8"><h1 class="logo"><a href="{{url('home')}}"><img src="images/logo.png" alt="sor"></a><span>Social Recommender</span></h1></div><div class="col-md-4"><div class="user-box"><img src="images/avatar.jpg" alt="avatar"><p class="name"> 
<?php echo Auth::user()->name ?></p><ul class="usermenu"><li><a href="{{url('profile')}}"> <span class="glyphicon glyphicon-user"> </span>Profile</a></li><li><a href="{{url('auth/logout')}}"> <span class="glyphicon glyphicon-log-out"> </span>Logout</a></li></ul></div></div></div></div></body></html><div class="container-fluid main"><div class="row row-eq-height"><div class="col-md-2 col-sm-12 sidebar"><ul><li><span class="glyphicon glyphicon-search"></span><a href="{{url('home')}}">Search</a></li><li><span class="glyphicon glyphicon-list-alt"></span><a href="javascript:void(0)">Search History</a></li><li><span class="glyphicon glyphicon-star"></span><a href="javascript:void(0)">Favorites</a></li><li><span class="glyphicon glyphicon-unchecked"></span><a href="graph.html">Graph</a></li><li><span class="glyphicon glyphicon-file"></span><a href="report.html">Report</a></li></ul></div><div class="col-md-7 col-sm-6 application"><div class="results"><p class="resultHeader">There are <span class="resultNo">3 </span>results based on your query.</p><div class="row allResults"> <div class="col-lg-6 col-md-6 col-sm-12"><div class="resultWrapper"><img src="images/diana.jpg" alt="avatar" class="resultImg"><p>Type: <span class="type">Person</span></p><p>Name: <span class="name">Mînzat Diana</span></p><p>Common friends:<span class="commonFriends green">22</span></p><p><a href="javascript:void(0)">Original link (Facebook)</a></p><button type="button" class="addToList"><span class="glyphicon glyphicon-plus"></span></button><button type="button" class="removeResult"><span class="glyphicon glyphicon-minus"></span></button></div></div><div class="col-lg-6 col-md-6 col-sm-12"><div class="resultWrapper"><img src="images/ionela.jpg" alt="avatar" class="resultImg"><p>Type: <span class="type">Person</span></p><p>Name: <span class="name">Ababi Ionela</span></p><p>Common friends:<span class="commonFriends green">15</span></p><p><a href="javascript:void(0)">Original link (Facebook)</a></p><button type="button" class="addToList"><span class="glyphicon glyphicon-plus"></span></button><button type="button" class="removeResult"><span class="glyphicon glyphicon-minus"></span></button></div></div><div class="col-lg-6 col-md-6 col-sm-12"><div class="resultWrapper"><img src="images/event.jpg" alt="avatar" class="resultImg"><p>Type: <span class="type">Event</span></p><p>Name: <span class="name">Ziua Izabelei</span></p><p>Friends going:<span class="commonFriends green">66</span></p><p><a href="javascript:void(0)">Original link (Facebook)</a></p><button type="button" class="addToList"><span class="glyphicon glyphicon-plus"></span></button><button type="button" class="removeResult"><span class="glyphicon glyphicon-minus"></span></button></div></div></div></div></div><div class="col-md-3 col-sm-6 searchBar"><img src="images/hex-loader2.gif" alt="loading.." class="loader"><div id="accordion" class="panel-group hidden"><div class="panel panel-default"><div class="panel-heading"><h4 class="panel-title"><a data-toggle="collapse" data-parent="#accordion" href="#searchPerson">Search Persons</a></h4></div><div id="searchPerson" class="panel-collapse collapse"><div class="panel-body">{!! Form::open(array('url' => 'person', 'class' => 'search-form', 'role' => 'form')) !!}<div class="row"><div class="col-md-12">{!! Form::Label('Name','Name') !!}</div><div class="col-md-6 col-sm-6 col-xs-6"><div class="form-group">{!! Form::text('personFirstName', null, ['class' => 'input  form-control', 'placeholder' => 'first name..']) !!}</div></div><div class="col-md-6 col-sm-6 col-xs-6"><div class="form-group">{!! Form::text('personLastName', null, ['class' => 'input  form-control', 'placeholder' => 'last name..']) !!}</div></div><div class="col-md-12">{!! Form::Label('birthplace','Birthplace') !!}</div><div class="col-md-12"><div class="form-group">{!! Form::text('personBirthPlace', null, ['class' => 'input  form-control', 'placeholder' => 'date..']) !!}</div></div><div class="col-md-12">{!! Form::Label('profession','Profession') !!}</div><div class="col-md-12"><div class="form-group">{!! Form::text('personProfession', null, ['class' => 'input  form-control', 'placeholder' => 'profession..']) !!}</div></div><div class="col-md-12">{!! Form::Label('nationality','Nationality') !!}</div><div class="col-md-12"><div class="form-group">{!! Form::text('personCountry', null, ['class' => 'input  form-control', 'placeholder' => 'country..']) !!}</div></div><div class="col-md-12">{!! Form::Label('ranking_id','Ranking:') !!}</div><div class="col-md-12">   <div class="form-group">{!! Form::select('ranking_id', array('','2'=>'1','3'=>'2','4'=>'3','5'=>'4','6'=>'5'),'5', ['class' => 'form-control']) !!}</div></div><div class="col-md-12 text-right">{!! Form::submit('Search',  ['class' => 'btn']) !!}</div></div>{!! Form::close() !!}</div></div></div><div class="panel panel-default"><div class="panel-heading"><h4 class="panel-title"><a data-toggle="collapse" data-parent="#accordion" href="#searchEvent">Search Events</a></h4></div><div id="searchEvent" class="panel-collapse collapse"><div class="panel-body">{!! Form::open(array('url' => 'event', 'class' => 'search-form', 'role' => 'form')) !!}<div class="row"><div class="col-md-12">{!! Form::Label('eventName','Event name') !!}<div class="form-group"> 
{!! Form::text('name', null, ['class' => 'input form-control', 'placeholder' => ' Event name..']) !!}                    </div></div><div class="col-md-12">{!! Form::Label('eventType','Event Type') !!}<div class="form-group"> 
{!! Form::text('eventTypeUri', null, ['class' => 'input form-control', 'placeholder' => ' Event types..']) !!}</div></div><div class="col-md-12">{!! Form::Label('locationUri','Event Location') !!}<div class="form-group"> 
{!! Form::text('locationUri', null, ['class' => 'input form-control', 'placeholder' => ' Event location..']) !!}</div></div><div class="col-md-12">                    
{!! Form::Label('startDate','Start date') !!}                 </div><div class="col-md-6 col-sm-6 col-xs-6"><div class="form-group">{!! Form::text('startDateMin', null, ['class' => 'input form-control', 'placeholder' => 'Min start date...']) !!}          </div></div><div class="col-md-6 col-sm-6 col-xs-6">            <div class="form-group">{!! Form::text('startDateMax', null, ['class' => 'input form-control', 'placeholder' => 'Max start date...']) !!}</div></div><div class="col-md-12">{!! Form::Label('endDate','End date') !!}                            </div><div class="col-md-6 col-sm-6 col-xs-6">                        <div class="form-group">{!! Form::text('endDateMin', null, ['class' => 'input form-control', 'placeholder' => 'Min end date...']) !!}</div></div><div class="col-md-6 col-sm-6 col-xs-6"> <div class="form-group"> 
{!! Form::text('endDateMax', null, ['class' => 'input form-control', 'placeholder' => 'Max end date...']) !!}</div></div><div class="col-md-12">{!! Form::Label('ranking_id','Ranking:') !!}</div><div class="col-md-12">   <div class="form-group">{!! Form::select('ranking_id', array('','2'=>'1','3'=>'2','4'=>'3','5'=>'4','6'=>'5'),'5', ['class' => 'form-control']) !!}</div></div><div class="col-md-12 text-right">{!! Form::submit('Search',  ['class' => 'btn']) !!}</div></div>{!! Form::close() !!}</div></div></div><div class="panel panel-default"><div class="panel-heading"><h4 class="panel-title"><a data-toggle="collapse" data-parent="#accordion" href="#searchBook">Search Books</a></h4></div><div id="searchBook" class="panel-collapse collapse"><div class="panel-body">{!! Form::open(array('url' => 'book', 'class' => 'search-form', 'role' => 'form')) !!}<div class="row"><div class="col-md-12">{!! Form::Label('bookTitle','Book title') !!}<div class="form-group">{!! Form::text('name', null, ['class' => 'input form-control', 'placeholder' => ' Book name..']) !!}</div></div><div class="col-md-12">{!! Form::Label('author','Author') !!}<div class="form-group">{!! Form::text('authorUri', null, ['class' => 'input form-control', 'placeholder' => ' Author name..']) !!}</div></div><div class="col-md-12">{!! Form::Label('illustrator','Illustrator') !!}<div class="form-group"> 
{!! Form::text('illustratorUri', null, ['class' => 'input form-control', 'placeholder' => ' Illustrator name..']) !!}</div></div><div class="col-md-12"> 
{!! Form::Label('literaryGenres','Literary Genres') !!}<div class="form-group"> 
{!! Form::select('literaryGenreUri', array(
'2'=>'Comedy',
'3'=>'Drama',
'4'=>'Non-fiction',
'5'=>'Realistic fiction',
'6'=>'Romance Novel',
'7'=>'Satire',
'8'=>'Tragedy',
'9'=>'Tragicomedy'
),'8', ['class'=>'form-control']) !!}</div></div><div class="col-md-12">{!! Form::Label('Number of Pages') !!}</div><div class="col-md-6 col-sm-6 col-xs-6"><div class="form-group">{!! Form::text('numberOfPagesMin', null, ['class' => 'input form-control', 'placeholder' => 'Number of minimum pages...']) !!}</div></div><div class="col-md-6 col-sm-6 col-xs-6"><div class="form-group">{!! Form::text('numberOfPagesMax', null, ['class' => 'input form-control', 'placeholder' => 'Number of maximum pages...']) !!}</div></div><div class="col-md-12">{!! Form::label('numberOfVolumes','Number of Volumes') !!}<div class="form-group">{!! Form::text('numberOfVolums', null, ['class' => 'input form-control', 'placeholder' => 'Number of Volumes...']) !!}	</div></div><div class="col-md-12">{!! Form::Label('ranking_id','Ranking:') !!}</div><div class="col-md-12">   <div class="form-group">{!! Form::select('ranking_id', array('','2'=>'1','3'=>'2','4'=>'3','5'=>'4','6'=>'5'),'5', ['class' => 'form-control']) !!}</div></div><div class="col-md-12 text-right">{!! Form::submit('Search',  ['class' => 'btn']) !!}</div></div>{!! Form::close() !!}</div></div></div><div class="panel panel-default"><div class="panel-heading"><h4 class="panel-title"><a data-toggle="collapse" data-parent="#accordion" href="#searchPlace">Search Places</a></h4></div><div id="searchPlace" class="panel-collapse collapse"><div class="panel-body">{!! Form::open(array('url' => 'place', 'id'=>'placeSearchForm', 'class' => 'search-form', 'role' => 'form')) !!}<div class="row"><div class="col-md-12">{!! Form::Label('placeName','Place name') !!}<div class="form-group">{!! Form::text('name', null, ['class' => 'input form-control', 'placeholder' => ' Place name..']) !!}</div></div><div class="col-md-12"> 
{!! Form::Label('placeType','Place Type') !!}<div class="form-group"> 
{!! Form::text('placeTypeUri', null, ['class' => 'input form-control', 'placeholder' => ' Place type..']) !!}</div></div><div class="col-md-12">{!! Form::Label('country','Country') !!}<div class="form-group">{!! Form::text('countryUri', null, ['class' => 'input form-control', 'placeholder' => ' Country..']) !!}</div></div><div class="col-md-12 text-right">{!! Form::submit('Search',  ['class' => 'btn']) !!}</div></div>{!! Form::close() !!}</div></div></div><div class="panel panel-default"><div class="panel-heading"><h4 class="panel-title"><a data-toggle="collapse" data-parent="#accordion" href="#searchInstitute">Search Institutes</a></h4></div><div id="searchInstitute" class="panel-collapse collapse"><div class="panel-body">{!! Form::open(array('url' => 'institute', 'class' => 'search-form', 'role' => 'form')) !!}<div class="row"><div class="col-md-12">{!! Form::Label('instituteName','Institute name') !!}<div class="form-group"> 
{!! Form::text('name', null, ['class' => 'input form-control', 'placeholder' => ' Institute name..']) !!}</div></div><div class="col-md-12">{!! Form::Label('educationalInstituteType','Educational Institute Type') !!}<div class="form-group">{!! Form::text('eduTypeUri', null, ['class' => 'input form-control', 'placeholder' => ' Educational Institute type..']) !!}</div></div><div class="col-md-12">{!! Form::Label('location','Location') !!}<div class="form-group">{!! Form::text('locationUri', null, ['class' => 'input form-control', 'placeholder' => ' Location..']) !!}</div></div><div class="col-md-12">{!! Form::Label('country','Country') !!}<div class="form-group">{!! Form::text('countryUri', null, ['class' => 'input form-control', 'placeholder' => ' Country..']) !!}</div></div><div class="col-md-12">{!! Form::Label('principal','Principal') !!}<div class="form-group">{!! Form::text('principalUri', null, ['class' => 'input form-control', 'placeholder' => ' Principal name..']) !!}</div></div><div class="col-md-12">{!! Form::Label('rector','Rector') !!}<div class="form-group">{!! Form::text('rectorUri', null, ['class' => 'input form-control', 'placeholder' => ' Rector..']) !!}</div></div><div class="col-md-12">                
{!! Form::Label('numberOFAcademicStaff','Number of Academic staff:') !!}</div><div class="col-md-6 col-sm-6 col-xs-6"><div class="form-group">{!! Form::text('nrOfAcademicStaffMin', null, ['class' => 'input form-control', 'placeholder' => ' Min number of academic staff..']) !!}</div></div><div class="col-md-6 col-sm-6 col-xs-6"><div class="form-group">{!! Form::text('nrOfAcademicStaffMax', null, ['class' => 'input form-control', 'placeholder' => ' Max number of academic staff..']) !!}</div></div><div class="col-md-12">            
{!! Form::label('numberOFStudents','Number of Students:') !!}</div><div class="col-md-6 col-sm-6 col-xs-6"><div class="form-group"> 
{!! Form::text('nrOfStudentsMin', null, ['class' => 'input form-control', 'placeholder' => ' Min number of students..']) !!}</div></div><div class="col-md-6 col-sm-6 col-xs-6"><div class="form-group">{!! Form::text('nrOfStudentsMax', null, ['class' => 'input form-control', 'placeholder' => ' Max number of students..']) !!}</div></div><div class="col-md-12">   <div class="form-group">{!! Form::select('ranking_id', array('','2'=>'1','3'=>'2','4'=>'3','5'=>'4','6'=>'5'),'5', ['class' => 'form-control']) !!}    </div></div><div class="col-md-12 text-right">{!! Form::submit('Search',  ['class' => 'btn']) !!}</div></div>{!! Form::close() !!}</div></div></div></div></div></div></div>{!! HTML::script('js/searches.js') !!}<footer class="container-fluid footer-side"><div class="row"><div class="col-md-12"><p>This is the footer. Information soon to be added here</p></div></div></footer>{!! HTML::script('js/bootstrap.min.js')  !!}