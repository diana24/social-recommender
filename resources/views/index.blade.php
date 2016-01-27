<!DOCTYPE html><html lang="en"><head><meta charset="utf-8"><meta http-equiv="X-UA-Compatible" content="IE=edge"><meta name="viewport" content="width=device-width, initial-scale=1"><title>SoR</title><link href="css/bootstrap.min.css" rel="stylesheet"><link href="css/stylesheet.css" rel="stylesheet"><link href="https://fonts.googleapis.com/css?family=Raleway:400,300,500,700" rel="stylesheet"><link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet"></head><body><div class="container-fluid top-side"><div class="row"><div class="col-md-8"><h1 class="logo"><a href="index.html"><img src="images/logo.png" alt="sor"></a><span>Social Recommender</span></h1></div><div class="col-md-4"><div class="user-box"><img src="images/avatar.jpg" alt="avatar"><p class="name">Fermuș V. Vasile-Octavian</p><ul class="usermenu"><li><a href="profile.html"><span class="glyphicon glyphicon-user">&thinsp;</span>Profile </a></li><li><a href="connect.html"><span class="glyphicon glyphicon-eye-open">&thinsp;</span>Connect </a></li><li><a href="register.html"><span class="glyphicon glyphicon-log-out">&thinsp;</span>Log out</a></li></ul></div></div></div></div></body></html><div class="container-fluid main"><div class="row row-eq-height"><div class="col-md-2 col-sm-12 sidebar"><ul><li><span class="glyphicon glyphicon-search"></span><a href="index.html">Search</a></li><li><span class="glyphicon glyphicon-floppy-disk"></span><a href="javascript:void(0)">Saved Lists</a></li><li><span class="glyphicon glyphicon-list-alt"></span><a href="javascript:void(0)">Search History</a></li><li><span class="glyphicon glyphicon-star"></span><a href="javascript:void(0)">Favorites</a></li><li><span class="glyphicon glyphicon-unchecked"></span><a href="graph.html">Graph</a></li><li><span class="glyphicon glyphicon-file"></span><a href="report.html">Report</a></li></ul></div><div class="col-md-7 col-sm-6 application"><div class="results"><p class="resultHeader">There are <span class="resultNo">3 </span>results based on your query.</p><div class="row"><div class="col-lg-6 col-md-6 col-sm-12"><div class="resultWrapper"><img src="images/diana.jpg" alt="avatar" class="resultImg"><p>Type: <span class="type">Person</span></p><p>Name: <span class="name">Mînzat Diana</span></p><p>Common friends:<span class="commonFriends green">22</span></p><p><a href="javascript:void(0)">Original link (Facebook)</a></p><button type="button" class="addToList"><span class="glyphicon glyphicon-plus"></span></button><button type="button" class="removeResult"><span class="glyphicon glyphicon-minus"></span></button></div></div><div class="col-lg-6 col-md-6 col-sm-12"><div class="resultWrapper"><img src="images/ionela.jpg" alt="avatar" class="resultImg"><p>Type: <span class="type">Person</span></p><p>Name: <span class="name">Ababi Ionela</span></p><p>Common friends:<span class="commonFriends green">15</span></p><p><a href="javascript:void(0)">Original link (Facebook)</a></p><button type="button" class="addToList"><span class="glyphicon glyphicon-plus"></span></button><button type="button" class="removeResult"><span class="glyphicon glyphicon-minus"></span></button></div></div><div class="col-lg-6 col-md-6 col-sm-12"><div class="resultWrapper"><img src="images/event.jpg" alt="avatar" class="resultImg"><p>Type: <span class="type">Event</span></p><p>Name: <span class="name">Ziua Izabelei</span></p><p>Friends going:<span class="commonFriends green">66</span></p><p><a href="javascript:void(0)">Original link (Facebook)</a></p><button type="button" class="addToList"><span class="glyphicon glyphicon-plus"></span></button><button type="button" class="removeResult"><span class="glyphicon glyphicon-minus"></span></button></div></div></div></div></div><div class="col-md-3 col-sm-6 searchBar"><div id="accordion" class="panel-group"><div class="panel panel-default"><div class="panel-heading"><h4 class="panel-title"><a data-toggle="collapse" data-parent="#accordion" href="#searchPerson">Search Persons</a></h4></div><div id="searchPerson" class="panel-collapse collapse"><div class="panel-body">{!! Form::open(array('url' => 'person', 'class' => 'form', 'role' => 'form')) !!}
                            {!! Form::text('personFirstName', null, ['class' => 'input  form-control', 'placeholder' => 'First Name...']) !!}
                            {!! Form::text('personLastName', null, ['class' => 'input  form-control', 'placeholder' => 'Last Name...']) !!}
                            {!! Form::text('personBirthPlace', null, ['class' => 'input  form-control', 'placeholder' => 'Birth Place...']) !!}
                            {!! Form::text('personProfession', null, ['class' => 'input  form-control', 'placeholder' => 'Profession...']) !!}
                            {!! Form::text('personCountry', null, ['class' => 'input  form-control', 'placeholder' => 'Country...']) !!}
                            {{ Form::Label('ranking_id','Ranking:') }}
                            {{ Form::select('ranking_id', array(
                             '',
                            '2'=>'1',
                            '3'=>'2'
                            '4'=>'3'
                            '5'=>'4'
                            '6'=>'5'
                            ),'5') }}
                            {!! Form::submit('Search',  ['class' => 'Search']) !!}
                        {!! Form::close() !!}</div></div></div><div class="panel panel-default"><div class="panel-heading"><h4 class="panel-title"><a data-toggle="collapse" data-parent="#accordion" href="#searchEvent">Search Events</a></h4></div><div id="searchEvent" class="panel-collapse collapse"><div class="panel-body"><form role="form" class="search-form"><div class="row"><div class="col-md-12"><label>Event Name</label><div class="form-group"><input id="eventName" type="text" name="eventName" class="form-control"></div></div><div class="col-md-12"><label>Event Type</label><div class="form-group"><input id="eventType" type="text" name="eventType" class="form-control"><label>Ranking</label></div></div><div class="col-md-6 col-sm-6 col-xs-6"><div class="form-group"><select class="form-control"><option value="">from..</option><option>1</option><option>2</option><option>3</option><option>4</option><option>5</option></select></div></div><div class="col-md-6 col-sm-6 col-xs-6"><div class="form-group"><select class="form-control"><option value="">to..</option><option>1</option><option>2</option><option>3</option><option>4</option><option>5</option></select></div></div><div class="col-md-12 col-sm-12 col-xs-12 text-right"><button type="submit" name="Search" value="Search" class="btn">Search</button></div></div></form></div></div></div><div class="panel panel-default"><div class="panel-heading"><h4 class="panel-title"><a data-toggle="collapse" data-parent="#accordion" href="#searchBook">Search Books</a></h4></div><div id="searchBook" class="panel-collapse collapse"><div class="panel-body"><form role="form" class="search-form"><div class="row"><div class="col-md-12"><label>Book Title</label><div class="form-group"><input id="BookName" type="text" name="BookName" class="form-control"></div></div><div class="col-md-12"><label>Author Name</label><div class="form-group"><input id="author" type="text" name="author" class="form-control"></div></div><div class="col-md-12"><label>Release Date</label><div class="form-group"><input id="releaseDate" type="text" name="releaseDate" class="form-control"></div></div><div class="col-md-12"><label>Literary Genre</label><div class="form-group"><select class="form-control"><option value="">Comedy</option><option>Drama</option><option>Non-fiction</option><option>Realistic fiction</option><option>Romance Novel</option><option>Satire</option><option>Tragedy</option><option>Tragicomedy</option></select></div></div><div class="col-md-12"><label>Number of pages</label></div><div class="col-md-6 col-sm-6 col-xs-6"><div class="form-group"><input id="numberOfPagesMin" type="text" placeholder="from.." name="numberOfPagesMin" class="form-control"></div></div><div class="col-md-6 col-sm-6 col-xs-6"><div class="form-group"><input id="numberOfPagesMax" type="text" placeholder="to.." name="numberOfPagesMax" class="form-control"></div></div><div class="col-md-12"><label>Number of Volumes</label><div class="form-group"><input id="numberOfVolumes" type="text" name="numberOfVolumes" class="form-control"></div><label>Ranking</label></div><div class="col-md-6 col-sm-6 col-xs-6"><div class="form-group"><select class="form-control"><option value="">from..</option><option>1</option><option>2</option><option>3</option><option>4</option><option>5</option></select></div></div><div class="col-md-6 col-sm-6 col-xs-6"><div class="form-group"><select class="form-control"><option value="">to..</option><option>1</option><option>2</option><option>3</option><option>4</option><option>5</option></select></div></div><div class="col-md-12 col-sm-12 col-xs-12 text-right"><button type="submit" name="Search" value="Search" class="btn">Search</button></div></div></form></div></div></div><div class="panel panel-default"><div class="panel-heading"><h4 class="panel-title"><a data-toggle="collapse" data-parent="#accordion" href="#searchPlace">Search Places</a></h4></div><div id="searchPlace" class="panel-collapse collapse"><div class="panel-body"><form role="form" class="search-form"><div class="row"><div class="col-md-12"><label>Place Name</label><div class="form-group"><input id="givenPlaceName" type="text" name="givenPlaceName" class="form-control"></div></div><div class="col-md-12"><label>Country</label><div class="form-group"><input id="country" type="text" name="country" class="form-control"></div><label>Ranking</label></div><div class="col-md-6 col-sm-6 col-xs-6"><div class="form-group"><select class="form-control"><option value="">from..</option><option>1</option><option>2</option><option>3</option><option>4</option><option>5</option></select></div></div><div class="col-md-6 col-sm-6 col-xs-6"><div class="form-group"><select class="form-control"><option value="">to..</option><option>1</option><option>2</option><option>3</option><option>4</option><option>5</option></select></div></div><div class="col-md-12 col-sm-12 col-xs-12 text-right"><button type="submit" name="Search" value="Search" class="btn">Search</button></div></div></form></div></div></div><div class="panel panel-default"><div class="panel-heading"><h4 class="panel-title"><a data-toggle="collapse" data-parent="#accordion" href="#searchInstitute">Search Institutes</a></h4></div><div id="searchInstitute" class="panel-collapse collapse in"><div class="panel-body"><form role="form" class="search-form"><div class="row"><div class="col-md-12"><label>Institute Name</label><div class="form-group"><input id="givenInstituteName" type="text" name="givenInstituteName" class="form-control"></div></div><div class="col-md-12"><label>Number of Classes</label></div><div class="col-md-6 col-sm-6 col-xs-6"><div class="form-group"><input id="minimumInstituteClasses" type="text" placeholder="from.." name="minimumInstituteClasses" class="form-control"></div></div><div class="col-md-6 col-sm-6 col-xs-6"><div class="form-group"><input id="maximumInstituteClasses" type="text" placeholder="to.." name="maximumInstituteClasses" class="form-control"></div></div><div class="col-md-12"><label>Campus Size</label></div><div class="col-md-6 col-sm-6 col-xs-6"><div class="form-group"><input id="minimumCampusSize" type="text" placeholder="from.." name="minimumCampusSize" class="form-control"></div></div><div class="col-md-6 col-sm-6 col-xs-6"><div class="form-group"><input id="maximumCampusSize" type="text" placeholder="to.." name="maximumCampusSize" class="form-control"></div></div><div class="col-md-12"><label>Nobel Laureates</label></div><div class="col-md-6 col-sm-6 col-xs-6"><div class="form-group"><input id="minimumCampusLaureates" type="text" placeholder="from.." name="minimumCampusLaureates" class="form-control"></div></div><div class="col-md-6 col-sm-6 col-xs-6"><div class="form-group"><input id="maximumCampusLaureates" type="text" placeholder="to.." name="maximumCampusLaureates" class="form-control"></div></div><div class="col-md-12"><label>Academic Staff</label></div><div class="col-md-6 col-sm-6 col-xs-6"><div class="form-group"><input id="minimumAcademicStaff" type="text" placeholder="from.." name="minimumAcademicStaff" class="form-control"></div></div><div class="col-md-6 col-sm-6 col-xs-6"><div class="form-group"><input id="maximumAcademicStaff" type="text" placeholder="to.." name="maximumAcademicStaff" class="form-control"></div></div><div class="col-md-12"><label>Locations</label></div><div class="col-md-6 col-sm-6 col-xs-6"><div class="form-group"><input id="minimumLocations" type="text" placeholder="from.." name="minimumLocations" class="form-control"></div></div><div class="col-md-6 col-sm-6 col-xs-6"><div class="form-group"><input id="maximumLocations" type="text" placeholder="to.." name="maximumLocations" class="form-control"></div></div><div class="col-md-12"><label>Students</label></div><div class="col-md-6 col-sm-6 col-xs-6"><div class="form-group"><input id="minimumStudents" type="text" placeholder="from.." name="minimumStudents" class="form-control"></div></div><div class="col-md-6 col-sm-6 col-xs-6"><div class="form-group"><input id="maximumStudents" type="text" placeholder="to.." name="maximumStudents" class="form-control"></div></div><div class="col-md-12"><label>Offered Classes</label></div><div class="col-md-12 col-sm-12 col-xs-12"><div class="form-group"><input id="offeredClasses" type="text" placeholder="separate by coma.." name="offeredClasses" class="form-control"></div></div><div class="col-md-12"><label>Ranking</label></div><div class="col-md-6 col-sm-6 col-xs-6"><div class="form-group"><select class="form-control"><option value="">from..</option><option>1</option><option>2</option><option>3</option><option>4</option><option>5</option></select></div></div><div class="col-md-6 col-sm-6 col-xs-6"><div class="form-group"><select class="form-control"><option value="">to..</option><option>1</option><option>2</option><option>3</option><option>4</option><option>5</option></select></div></div><div class="col-md-12 col-sm-12 col-xs-12 text-right"><button type="submit" name="Search" value="Search" class="btn">Search</button></div></div></form></div></div></div></div></div></div></div><footer class="container-fluid footer-side"><div class="row"><div class="col-md-12"><p>This is the footer. Information soon to be added here</p></div></div></footer>{!! HTML::script('js/bootstrap.min.js')  !!}