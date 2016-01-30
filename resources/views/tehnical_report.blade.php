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
<?php echo Auth::user()->name ?></p><ul class="usermenu"><li><a href="{{url('profile')}}"> <span class="glyphicon glyphicon-user"> </span>Profile</a></li><li><a href="{{url('auth/logout')}}"> <span class="glyphicon glyphicon-log-out"> </span>Logout</a></li></ul></div></div></div></div></body></html><div class="container-fluid main"><div class="row row-eq-height"><div class="col-md-2 col-sm-12 sidebar"><ul><li><span class="glyphicon glyphicon-flag"></span><a href="{{url('home')}}">Recommendations</a></li><li><span class="glyphicon glyphicon-search"></span><a href="{{url('search')}}">Search</a></li><li><span class="glyphicon glyphicon-star"></span><a href="javascript:void(0)">Favorites</a></li><li><span class="glyphicon glyphicon-file"></span><a href="{{url('report')}}">Report</a></li><li><?php if(Auth::user()->getGraphPath() !==null) {?>
<a target="_blank" href="<?php echo Auth::user()->getGraphPath() ?>"><span class="glyphicon glyphicon-unchecked"></span>Graph</a> 
<?php } ?></li></ul></div><div class="col-md-10 col-sm-12 application"><div class="app-report"><div class="row"><div class="col-md-12"><h1>SOR report</h1><h2>Table of contents</h2><ul><li><a href="#chapter1">1. Start to know SOR</a></li><li><a href="#chapter2">2. Register</a></li><li><a href="#chapter3">3. Sign in</a></li><li><a href="#chapter4">4. Homepage</a></li><li><a href="#chapter5">5. Profile and Connection to Google account</a></li><li><a href="#chapter6">6. Search forms</a></li><li><a href="#chapter7">7. Recommendations</a></li><li><a href="#chapter8">8. Favorites and Report</a></li><li><a href="#chapter9">9. Signout</a></li><li><a href="#chapter10">10. Conclusion</a></li><li><a href="#chapter11">11. Bibliography</a></li><li><span class="glyphicon glyphicon-file"></span><a href="{{url('tehnical_report')}}">12. Link to Technical report</a></li></ul><h2 id="chapter1">1. Start to know SOR.</h2><p>Social recommender is an application that is able to recommend certain people/events/places/books/films/educational institutes of interest according to a given FOAF graph build with information from a social network (for now Google+, but later on it has the possibility to be extended with more information from other social networks such as LinkedIn, Twitter etc.) and external resources. The information from the social networks will help provide more particular results based on what the user account contain.</p><h2 id="chapter2">2. Register</h2><p>First step to create an user account is to register. The registration requires filling in a form with personal information about the client such as email and password. Note that email should contain @ and be unique for every user.  Some indications are displayed in case of nonconformities regarding the email and the password. E.g. Email and Password must contain at least 8 letters.</p><p>img(src="images/register.png" alt="sor")</p><p>After registering with valid information, it will redirect to Homepage.</p><p>As a remark, using the information from the registration step, like email and a password, the user can sign into a defined account directly to homepage.  </p><h2 id="chapter3">3. Homepage</h2><p>Homepage is the staring page of the application and may contain results of searches for persons, places, events, books, films, educational institutes. </p><p>On the right of the screen, a list of search forms is available. There, the user can fill in all necessary information to perform a search. Results will be displayed in the center of the screen and are based on a social network (Google) and external resources. </p><p>img(src="images/homepage.png" alt="sor")</p><h2 id="chapter4">4. Profile and Connection to Google account</h2><p>Before having actual results, the user must connect to Google account from Profile page. </p><p>As you can see, Profile page is related to the user information.  A form is available in profile page that allows the user to change profile user settings.</p><p>img(src="images/profile.png" alt="sor")</p><h2 id="chapter5">5. Search Forms</h2><p>After connecting to a Google account, Search forms can be used. To access search forms from Profile, use Search option from the left of the screen.</p><p>Notice that on Profile page an option of rebuilding the XML graph is available. This ensures that the user can receive updated information as needed.</p><p>The results are not based only on the graph, but also on external resources, extending the results considerably.</p><p>One of the most interesting search forms is Search Films. The search basically returns films based on books that have status read/reading in Google account.  Also check the rest of the forms: Search People, Search Events, Search Places, Search Books and Search Educational Institutes.</p><p>img(src="images/films_results.png" alt="sor")</p><p>Study cases: </p><ul><li><Example>case study: results for wine regions in France</Example></li></ul><p>img(src="images/study_wine_regions.png" alt="sor")</p><ul><li><Example>– gardens of United States. We both map the type of place – garden – and the country – United States – to the corresponding resources.</Example></li></ul><p>img(src="images/gardens_united_states.png" alt="sor")</p><h2 id="chapter6">6. Recommendations</h2><p>Another option of SOR from the left side of the screen is Recommendations. Practically this offers the opportunity to receive random recommendations of Books, Films, Events and Educational Institutes based on the user Google account.</p><p>img(src="images/recommendations.png" alt="sor")</p><h2 id="chapter7">7.  Favorites and Report</h2><p>The user can save to Favorites some liked results and also check the report of the presentation in Report option. </p><p>img(src="images/favorites.png" alt="sor")</p><h2 id="chapter8">8.  Logout</h2><p>Lastly, to leave the application, use the Log outoption from the top right side of the screen. This signs out from user’s account. </p><h2 id="chapter9">9. Conclusion</h2><p>As a conclusion, Social Recommender is a web application that user social networks (Google) and other external resources to recommend the user certain people, events, place, books and films.</p><p>Feel free to check out SOR!</p><h2 id="chapter10">10. Bibliography</h2><p>SOR:<a href="http://social-recommender.herokuapp.com/">http://social-recommender.herokuapp.com/</a></p><p>DBpedia: <a href="http://wiki.dbpedia.org/ http://wiki.dbpedia.org/">http://wiki.dbpedia.org/ http://wiki.dbpedia.org/    </a></p><p>FOAF: <a href="http://www.foaf-project.org/">http://www.foaf-project.org/</a></p><p>RAML: <a href="http://raml.org/">http://raml.org/</a></p><p> Security schemas: <a href="https://api.yaas.io/patterns/v1/security-schema-basic.yaml">https://api.yaas.io/patterns/v1/security-schema-basic.yaml</a></p><p>Schema.org: <a href="https://schema.org/">https://schema.org/</a></p><p>Wikipedia: <a href="https://wikipedia.com/">https://wikipedia.com/</a></p><p>Blog:  <a href="https://socialrecommender.wordpress.com/about/">https://socialrecommender.wordpress.com/about/</a></p><p>Web project page:<a href="http://profs.info.uaic.ro/~busaco/teach/courses/wade/web-projects.html">http://profs.info.uaic.ro/~busaco/teach/courses/wade/web-projects.html </a></p></div></div></div></div></div></div><footer class="container-fluid footer-side"><div class="row"><div class="col-md-12"><p>This is the footer. Information soon to be added here</p></div></div></footer>{!! HTML::script('js/bootstrap.min.js')  !!}