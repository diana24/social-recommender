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
<<<<<<< HEAD
<?php } ?></li></ul></div><div class="col-md-10 col-sm-12 application"><div class="app-report"><div class="row"><div class="col-md-12"><h1>SOR report</h1><h2>Table of contents</h2><ul><li><a href="#chapter1">1. Start to know SOR</a></li><li><a href="#chapter2">2. Objectives and constraints</a></li><li><a href="#chapter3">3. Register</a></li><li><a href="#chapter4">4. Sign in</a></li><li><a href="#chapter5">5. Homepage and Profile</a></li><li><a href="#chapter6">6. Resources</a></li><li><a href="#chapter7">7. Social network: Google+</a></li><li><a href="#chapter8">8. FOAF Graph</a></li><ul><li><a href="#chapter8p1">8.1 Creation of FOAF graph</a></li><li><a href="#chapter8p2">8.2 Storage of FOAF graph</a></li><li><a href="#chapter8p3">8.3 Usage of FOAF graph</a></li></ul><li><a href="#chapter9">9. API specifications</a></li><li><a href="#chapter10">10. Results - limited display of results</a></li><li><a href="#chapter11">11. Caching</a></li><li><a href="#chapter12">12. Favorites</a></li><li><a href="#chapter13">13. Tehnical description of SOR-main points</a></li><li><a href="#chapter14">14. Used resources (frameworks, scription languages)</a></li><li><a href="#chapter15">15. Conclusion</a></li><li><a href="#chapter16">16. Bibliography</a></li><li><span class="glyphicon glyphicon-file"></span><a href="{{url('report')}}">12. Link to User guide report</a></li></ul><h2 id="chapter1">1. Start to know SOR.</h2><p>Social recommender is an application that is able to recommend certain people/events/places/books/films/educational institutes of interest according to a given FOAF graph build with information from a social network (for now Google+, but later on it has the possibility to be extended with more information from other social networks such as LinkedIn, Twitter etc.) and external resources. The information from the social networks will help provide more particular results based on what the user account contain.</p><h2 id="chapter2">2. Objectives and constraints.</h2><p>Create an application that recommends (randomly or on request) to the user certain people/events/places/books/films/educational institutes of interesting according to social networks (Google+).</p><p>Application constraints: </p><ul><li>The application should be a responsive application</li><li>Service oriented application</li><li>Restful API</li><li>An application built on the existing social and semantic Web technologies</li><li>The code-source and specific content must be available under the terms of the open source licenses( Git hub)</li></ul><h2 id="chapter3">3. Register</h2><p>First step to create an user account is to register. The registration requires filling in a form with personal information about the client such as email and password.</p><p>Note: The email and password are unique for every user.</p><h2 id="chapter4">4. Sign in</h2><p>Using the information from the registration step, like email and a password, the user can sign into a defined account directly to homepage.  </p><h2 id="chapter5">5. Homepage and Profile</h2><p>Homepage is the staring page of the application and may contain results of searches for persons, places, events, books, films, educational institutes. On the right of the screen, a list of forms is available. There, the user can fill in all necessary information to perform a search. Results will be displayed in the center of the screen and are based on a social network (Google) and external resources. </p><p>Profile is related to the user information.  A form is available in profile page that allows the user to change profile user settings.</p><h2 id="chapter6">6. Resources</h2><p>Resources are used to get accurate recommendations for the user. We use multiple open data sources in RDF format and their corresponding ontologies.</p><p>Here are some examples of resources that could be used for this application:<li> <a href="http://wiki.dbpedia.org/">Dbpedia </a>is a crowd-sourced community effort to extract structured information from Wikipedia and make this information available on the Web. </li><li> <a href="http://www.geonames.org/">Geonames.org </a>- the geographical database covers all countries and contains over eight million place names that are available for download free of charge.</li><li> <a href="http://schema.org/">Schema.org </a>is a collaborative, community activity with a mission to create, maintain, and promote schemas for structured data on the Internet, on web pages, in email messages, and beyond.</li></p><h2 id="chapter7">7.  Social networks: Google+</h2><p>The FOAF graph will be constructed based on information from Google and external resources. The user must be connected to a Google account in order to create the graph and then be provided with the random or requested recommendations.</p><h2 id="chapter8">8.  FOAF graph</h2><p>FOAF graph (friend of a friend) is a RDF file that stores personal information taken from a social network (Google). </p><p>Personal information means information from Google profile, including user's friends, events educational institutes, domains of work and study, stores, electronics, clothes and so on, books, films, and so on.</p><h3 id="chapter8p1">8.1 Creation of FOAF graph</h3><p>A FOAF graph is created first when the client connects to a social network, in a RDF format (.xml). The client has the possibility to update the content of the graph every time he/she requests so with: Rebuild XML Graph. The graph contains: people associated with the user account, schools, events, books, other People and organizations.</p><p>Example of FOAF graph content: </p><p> <img src="images/foaf.png" alt="sor"></p><h3 id="chapter8p2">8.2 Storage of FOAF graph</h3><p>FOAF graph will be loaded on the server side (on the cloud application platform Heroku) every time it is created/updated. There will be a RDF graph or more for each user that has an account for this application.</p><h3 id="chapter8p3">8.3 Usage of FOAF graph</h3><p> The graph is used for:</p><ul> <li>random generated recommendations  displayed on homepage</li><li>user request generated recommendations.</li></ul><h2 id="chapter9">9. API specifications</h2><p> RAML file describes the API specifications of the application. The API specifications of the application are structured in four main modules:</p><ul> <li> <span class="strong">Randomly generated recommandations </span><br>Based on users’s FOAF graph, the app will first extract similarities – most common occurrences of things (films, books), most popular events. It will also take into account user’s geographical location and current town as listed on Google. Considering this data, it will search for educational institutes nearby, similar books, films, people who went to the same school and other things. Finally, the user will see query results filtered by type on his home page, or he can request the list by calling the following endpoints:  <code>/recommendations?item_type=[TYPE_OF_ITEM]</code>, where TYPE_OF_ITEM is one of: book, film, educational institute. Forms of the 3 classes are available on the right of the Homepage, serving as a filter where the client can chose the type of recommendations to see.</li><li> <span class="strong">Graph content</span><br>The user can see the content of his generated FOAF graph, sorted by relevance and filterd by item type, by calling the following uri:   <code>/graph?item_type= [TYPE_OF_ITEM]</code>, is one of: the user account, schools, events, books, other people and organizations.</li><li> <span class="strong">Search module</span><br>The user will be able to look for stuff by defining his own criteria in five different forms for each type of resource. Some examples – the client wants to get all books of Agatha Christie first published after 1940; the client wants to get all universities with over 5000 students and at least 2 Nobel Prize laureates.<br>All search features will be available by querying the following endpoint: <code>/search/[TYPE_OF_ITEM]</code>, with TYPE_OF_ITEM one of: person, event, film, book, place, institution of education.</li><li> <span class="strong">Saved items </span><br>User will have the possibility to save some of the results in Favorites. The item specified will be stored into database.<br>By calling the endpoint <code>/saved-items?item_type=[TYPE_OF_ITEM]</code>,  the user will get the list of all items. For lists, a call to /lists/[list_id] is required.</li></ul></div><h2 id="chapter10">10. Results - limited display of results<p>Results are displayed in Homepage, containing the name of the results and other information, according to the type of result.   </p><p>The constraints of the number of items displayed are:</p><ul> <li>minimum number of results:  5</li><li>maximum number of results:  50</li><li>default: 10 </li></ul><h2 id="chapter11">11. Caching </h2><p> Queries send by the user are saved on server side, in our database. This way, they will be available to the client from any computer, anytime.</p><h2 id="chapter12">12. User favorites</h2><p>A list of favorites will be saved for the user when he/she indicates the results preferred by the user, meaning the results are included in favorites when a search is performed.</p><h2 id="chapter13">13. Technical description of SOR</h2><p>Our application is developed using Laravel 5.1 framework, Grunt, Bootstrap and Jade technologies. For social network connection, we used the Google php api client. All SPARQL queries are run with EasyRdf library. We included Geocoder library (a(href="https://github.com/geocoder-php/Geocoder") https://github.com/geocoder-php/Geocoder) for place name to coordinate conversion and a JsonLD implementation ( a(href="https://github.com/lanthaler/JsonLD") https://github.com/lanthaler/JsonLD) for query results serialization.</p><p>The application uses Google+ connection, also taking data from Google Books and requiring data from Google Maps and Google Coordinates for geolocation. Google+ does not currently offer support for knowledge graphs, but we built a linked data graph using non-semantic data from user’s profile. Every person in user’s circles is mapped as a foaf:knows property of the graph owner and as a resource of type foaf:Person.</p><span class="strong">People Data</span><p>Two checks will be available for each result one with ‘+’ meaning to include this result in the user profile, and one with ’–‘, meaning to exclude this result when receiving a recommendation.		</p><p>Preferences are by default kept from the first time the user signed in his account, but there is a checklist available where the user can select the period of time the preferences were added.</p></h2><p>As a conclusion, Social Recommender is a web application that user social networks (Google) and other external resources to recommend the user certain people, events, place, books and films.<p>Feel free to check out SOR!</p><h2 id="chapter10">10. Bibliography</h2><p>SOR:<a href="http://social-recommender.herokuapp.com/">http://social-recommender.herokuapp.com/</a></p><p>DBpedia: <a href="http://wiki.dbpedia.org/ http://wiki.dbpedia.org/">http://wiki.dbpedia.org/ http://wiki.dbpedia.org/    </a></p><p>FOAF: <a href="http://www.foaf-project.org/">http://www.foaf-project.org/</a></p><p>RAML: <a href="http://raml.org/">http://raml.org/</a></p><p> Security schemas: <a href="https://api.yaas.io/patterns/v1/security-schema-basic.yaml">https://api.yaas.io/patterns/v1/security-schema-basic.yaml</a></p><p>Schema.org: <a href="https://schema.org/">https://schema.org/</a></p><p>Wikipedia: <a href="https://wikipedia.com/">https://wikipedia.com/</a></p><p>Blog:  <a href="https://socialrecommender.wordpress.com/about/">https://socialrecommender.wordpress.com/about/</a></p><p>Web project page:<a href="http://profs.info.uaic.ro/~busaco/teach/courses/wade/web-projects.html">http://profs.info.uaic.ro/~busaco/teach/courses/wade/web-projects.html </a></p></p></div></div></div></div></div><footer class="container-fluid footer-side"><div class="row"><div class="col-md-12"><p>This is the footer. Information soon to be added here</p></div></div></footer>{!! HTML::script('js/bootstrap.min.js')  !!}
=======
<?php } ?></li></ul></div><div class="col-md-10 col-sm-12 application"><div class="app-report"><div class="row"><div class="col-md-12"><h1>SOR report</h1><h2>Table of contents</h2><ul><li><a href="#chapter1">1. Start to know SOR</a></li><li><a href="#chapter2">2. Register</a></li><li><a href="#chapter3">3. Sign in</a></li><li><a href="#chapter4">4. Homepage</a></li><li><a href="#chapter5">5. Profile and Connection to Google account</a></li><li><a href="#chapter6">6. Search forms</a></li><li><a href="#chapter7">7. Recommendations</a></li><li><a href="#chapter8">8. Favorites and Report</a></li><li><a href="#chapter9">9. Signout</a></li><li><a href="#chapter10">10. Conclusion</a></li><li><a href="#chapter11">11. Bibliography</a></li><li><span class="glyphicon glyphicon-file"></span><a href="{{url('tehnical_report')}}">12. Link to Technical report</a></li></ul><h2 id="chapter1">1. Start to know SOR.</h2><p>Social recommender is an application that is able to recommend certain people/events/places/books/films/educational institutes of interest according to a given FOAF graph build with information from a social network (for now Google+, but later on it has the possibility to be extended with more information from other social networks such as LinkedIn, Twitter etc.) and external resources. The information from the social networks will help provide more particular results based on what the user account contain.</p><h2 id="chapter2">2. Register</h2><p>First step to create an user account is to register. The registration requires filling in a form with personal information about the client such as email and password. Note that email should contain @ and be unique for every user.  Some indications are displayed in case of nonconformities regarding the email and the password. E.g. Email and Password must contain at least 8 letters.</p><p>img(src="images/register.png" alt="sor")</p><p>After registering with valid information, it will redirect to Homepage.</p><p>As a remark, using the information from the registration step, like email and a password, the user can sign into a defined account directly to homepage.  </p><h2 id="chapter3">3. Homepage</h2><p>Homepage is the staring page of the application and may contain results of searches for persons, places, events, books, films, educational institutes. </p><p>On the right of the screen, a list of search forms is available. There, the user can fill in all necessary information to perform a search. Results will be displayed in the center of the screen and are based on a social network (Google) and external resources. </p><p>img(src="images/homepage.png" alt="sor")</p><h2 id="chapter4">4. Profile and Connection to Google account</h2><p>Before having actual results, the user must connect to Google account from Profile page. </p><p>As you can see, Profile page is related to the user information.  A form is available in profile page that allows the user to change profile user settings.</p><p>img(src="images/profile.png" alt="sor")</p><h2 id="chapter5">5. Search Forms</h2><p>After connecting to a Google account, Search forms can be used. To access search forms from Profile, use Search option from the left of the screen.</p><p>Notice that on Profile page an option of rebuilding the XML graph is available. This ensures that the user can receive updated information as needed.</p><p>The results are not based only on the graph, but also on external resources, extending the results considerably.</p><p>One of the most interesting search forms is Search Films. The search basically returns films based on books that have status read/reading in Google account.  Also check the rest of the forms: Search People, Search Events, Search Places, Search Books and Search Educational Institutes.</p><p>img(src="images/films_results.png" alt="sor")</p><p>Study cases: </p><ul><li><Example>case study: results for wine regions in France</Example></li></ul><p>img(src="images/study_wine_regions.png" alt="sor")</p><ul><li><Example>– gardens of United States. We both map the type of place – garden – and the country – United States – to the corresponding resources.</Example></li></ul><p>img(src="images/gardens_united_states.png" alt="sor")</p><h2 id="chapter6">6. Recommendations</h2><p>Another option of SOR from the left side of the screen is Recommendations. Practically this offers the opportunity to receive random recommendations of Books, Films, Events and Educational Institutes based on the user Google account.</p><p>img(src="images/recommendations.png" alt="sor")</p><h2 id="chapter7">7.  Favorites and Report</h2><p>The user can save to Favorites some liked results and also check the report of the presentation in Report option. </p><p>img(src="images/favorites.png" alt="sor")</p><h2 id="chapter8">8.  Logout</h2><p>Lastly, to leave the application, use the Log outoption from the top right side of the screen. This signs out from user’s account. </p><h2 id="chapter9">9. Conclusion</h2><p>As a conclusion, Social Recommender is a web application that user social networks (Google) and other external resources to recommend the user certain people, events, place, books and films.</p><p>Feel free to check out SOR!</p><h2 id="chapter10">10. Bibliography</h2><p>SOR:<a href="http://social-recommender.herokuapp.com/">http://social-recommender.herokuapp.com/</a></p><p>DBpedia: <a href="http://wiki.dbpedia.org/ http://wiki.dbpedia.org/">http://wiki.dbpedia.org/ http://wiki.dbpedia.org/    </a></p><p>FOAF: <a href="http://www.foaf-project.org/">http://www.foaf-project.org/</a></p><p>RAML: <a href="http://raml.org/">http://raml.org/</a></p><p> Security schemas: <a href="https://api.yaas.io/patterns/v1/security-schema-basic.yaml">https://api.yaas.io/patterns/v1/security-schema-basic.yaml</a></p><p>Schema.org: <a href="https://schema.org/">https://schema.org/</a></p><p>Wikipedia: <a href="https://wikipedia.com/">https://wikipedia.com/</a></p><p>Blog:  <a href="https://socialrecommender.wordpress.com/about/">https://socialrecommender.wordpress.com/about/</a></p><p>Web project page:<a href="http://profs.info.uaic.ro/~busaco/teach/courses/wade/web-projects.html">http://profs.info.uaic.ro/~busaco/teach/courses/wade/web-projects.html </a></p></div></div></div></div></div></div><footer class="container-fluid footer-side"><div class="row"><div class="col-md-12"><p>Web Application Development Project</p><a href="http://profs.info.uaic.ro/~busaco/teach/courses/wade/">Course Page</a></div></div></footer>{!! HTML::script('js/bootstrap.min.js')  !!}
>>>>>>> 56a77a4f16a1bd7983ce9ed541558b1414261768
