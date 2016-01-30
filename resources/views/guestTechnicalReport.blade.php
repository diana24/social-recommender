<!DOCTYPE html><html lang="en"><head><meta charset="utf-8"><meta http-equiv="X-UA-Compatible" content="IE=edge"><meta name="viewport" content="width=device-width, initial-scale=1"><title>SoR</title>{!! HTML::style('css/bootstrap.min.css') !!}
{!! HTML::style('css/stylesheet.css') !!}
{!! HTML::style('https://fonts.googleapis.com/css?family=Raleway:400,300,500,700') !!}
{!! HTML::style('https://fonts.googleapis.com/css?family=Roboto') !!}  
{!! HTML::script("https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js") !!}</head><body></body></html><div class="container-fluid top-side"><div class="row"><div class="col-md-12"><h1 class="logo">{!! HTML::image('images/logo.png', 'Social Recommender') !!}<span>Social Recommender</span></h1></div><div class="col-md-12"><ul class="menu"><li><a href="{{url('auth/register')}}">Register </a></li><li><a href="{{url('auth/login')}}">Login </a></li><li><a href="{{url('report')}}">Report </a></li></ul></div></div></div><div style="background:white" class="container-fluid"><div class="app-report"><div class="row"><div class="col-md-12"><h1>SOR Technical Report</h1><a href="{{url('report')}}"> <span class="glyphicon glyphicon-file"></span>Switch to User Guide Report</a><h2>Table of contents</h2><ul><li><a href="#chapter1">1. Start to know SOR</a></li><li><a href="#chapter2">2. Objectives and constraints</a></li><li><a href="#chapter3">3. Register</a></li><li><a href="#chapter4">4. Sign in</a></li><li><a href="#chapter5">5. Homepage and Profile</a></li><li><a href="#chapter6">6. Resources</a></li><li><a href="#chapter7">7. Social network: Google+</a></li><li><a href="#chapter8">8. FOAF Graph</a></li><ul><li><a href="#chapter8p1">8.1 Creation of FOAF graph</a></li><li><a href="#chapter8p2">8.2 Storage of FOAF graph</a></li><li><a href="#chapter8p3">8.3 Usage of FOAF graph</a></li></ul><li><a href="#chapter9">9. API specifications</a></li><li><a href="#chapter10">10. Results - limited display of results</a></li><li><a href="#chapter11">11. Caching</a></li><li><a href="#chapter12">12. Favorites</a></li><li><a href="#chapter13">13. Tehnical description of SOR-main points</a></li><li><a href="#chapter14">14. Used resources (frameworks, scription languages)</a></li><li><a href="#chapter15">15. Conclusion</a></li><li><a href="#chapter16">16. Bibliography</a></li></ul><h2 id="chapter1">1. Start to know SOR.</h2><p>Social recommender is an application that is able to recommend certain people/events/places/books/films/educational institutes of interest according to a given FOAF graph build with information from a social network (for now Google+, but later on it has the possibility to be extended with more information from other social networks such as LinkedIn, Twitter etc.) and external resources. The information from the social networks will help provide more particular results based on what the user account contain.</p><h2 id="chapter2">2. Objectives and constraints.</h2><p>Create an application that recommends (randomly or on request) to the user certain people/events/places/books/films/educational institutes of interesting according to social networks (Google+).</p><p>Application constraints: </p><ul><li>The application should be a responsive application</li><li>Service oriented application</li><li>Restful API</li><li>An application built on the existing social and semantic Web technologies</li><li>The code-source and specific content must be available under the terms of the open source licenses( Git hub)</li></ul><h2 id="chapter3">3. Register</h2><p>First step to create an user account is to register. The registration requires filling in a form with personal information about the client such as email and password.</p><p>Note: The email and password are unique for every user.</p><h2 id="chapter4">4. Sign in</h2><p>Using the information from the registration step, like email and a password, the user can sign into a defined account directly to homepage.  </p><h2 id="chapter5">5. Homepage and Profile</h2><p>Homepage is the staring page of the application and may contain results of searches for persons, places, events, books, films, educational institutes. On the right of the screen, a list of forms is available. There, the user can fill in all necessary information to perform a search. Results will be displayed in the center of the screen and are based on a social network (Google) and external resources. </p><p>Profile is related to the user information.  A form is available in profile page that allows the user to change profile user settings.</p><h2 id="chapter6">6. Resources</h2><p>Resources are used to get accurate recommendations for the user. We use multiple open data sources in RDF format and their corresponding ontologies.</p><p>Here are some examples of resources that could be used for this application:<li> <a href="http://wiki.dbpedia.org/">Dbpedia </a>is a crowd-sourced community effort to extract structured information from Wikipedia and make this information available on the Web. </li><li> <a href="http://www.geonames.org/">Geonames.org </a>- the geographical database covers all countries and contains over eight million place names that are available for download free of charge.</li><li> <a href="http://schema.org/">Schema.org </a>is a collaborative, community activity with a mission to create, maintain, and promote schemas for structured data on the Internet, on web pages, in email messages, and beyond.</li></p><h2 id="chapter7">7.  Social networks: Google+</h2><p>The FOAF graph will be constructed based on information from Google and external resources. The user must be connected to a Google account in order to create the graph and then be provided with the random or requested recommendations.</p><h2 id="chapter8">8.  FOAF graph</h2><p>FOAF graph (friend of a friend) is a RDF file that stores personal information taken from a social network (Google). </p><p>Personal information means information from Google profile, including user's friends, events educational institutes, domains of work and study, stores, electronics, clothes and so on, books, films, and so on.</p><h3 id="chapter8p1">8.1 Creation of FOAF graph</h3><p>A FOAF graph is created first when the client connects to a social network, in a RDF format (.xml). The client has the possibility to update the content of the graph every time he/she requests so with: Rebuild XML Graph. The graph contains: people associated with the user account, schools, events, books, other People and organizations.</p><p>Example of FOAF graph content: </p><p> <img src="images/foaf.png" alt="sor"></p><h3 id="chapter8p2">8.2 Storage of FOAF graph</h3><p>FOAF graph will be loaded on the server side (on the cloud application platform Heroku) every time it is created/updated. There will be a RDF graph or more for each user that has an account for this application.</p><h3 id="chapter8p3">8.3 Usage of FOAF graph</h3><p> The graph is used for:</p><ul> <li>random generated recommendations  displayed on homepage</li><li>user request generated recommendations.</li></ul><h2 id="chapter9">9. API specifications</h2><p> RAML file describes the API specifications of the application. The API specifications of the application are structured in four main modules:</p><ul> <li> <span class="strong">Randomly generated recommandations </span><br>Based on users’s FOAF graph, the app will first extract similarities – most common occurrences of things (films, books), most popular events. It will also take into account user’s geographical location and current town as listed on Google. Considering this data, it will search for educational institutes nearby, similar books, films, people who went to the same school and other things. Finally, the user will see query results filtered by type on his home page, or he can request the list by calling the following endpoints:  <code>/recommendations?item_type=[TYPE_OF_ITEM]</code>, where TYPE_OF_ITEM is one of: book, film, educational institute. Forms of the 3 classes are available on the right of the Homepage, serving as a filter where the client can chose the type of recommendations to see.</li><li> <span class="strong">Graph content</span><br>The user can see the content of his generated FOAF graph, sorted by relevance and filterd by item type, by calling the following uri:   <code>/graph?item_type= [TYPE_OF_ITEM]</code>, is one of: the user account, schools, events, books, other people and organizations.</li><li> <span class="strong">Search module</span><br>The user will be able to look for stuff by defining his own criteria in five different forms for each type of resource. Some examples – the client wants to get all books of Agatha Christie first published after 1940; the client wants to get all universities with over 5000 students and at least 2 Nobel Prize laureates.<br>All search features will be available by querying the following endpoint: <code>/search/[TYPE_OF_ITEM]</code>, with TYPE_OF_ITEM one of: person, event, film, book, place, institution of education.</li><li> <span class="strong">Saved items </span><br>User will have the possibility to save some of the results in Favorites. The item specified will be stored into database.<br>By calling the endpoint <code>/saved-items?item_type=[TYPE_OF_ITEM]</code>,  the user will get the list of all items. For lists, a call to /lists/[list_id] is required.</li></ul><h2 id="chapter10">10. Results - limited display of results</h2><p>Results are displayed in Homepage, containing the name of the results and other information, according to the type of result.   </p><p>The constraints of the number of items displayed are:</p><ul> <li>minimum number of results:  5</li><li>maximum number of results:  50</li><li>default: 10 </li></ul><h2 id="chapter11">11. Caching </h2><p> Queries send by the user are saved on server side, in our database. This way, they will be available to the client from any computer, anytime.</p><h2 id="chapter12">12. User favorites</h2><p>A list of favorites will be saved for the user when he/she indicates the results preferred by the user, meaning the results are included in favorites when a search is performed.</p><h2 id="chapter13">13. Technical description of SOR</h2><p>Our application is developed using Laravel 5.1 framework, Grunt, Bootstrap and Jade technologies. For social network connection, we used the Google php api client. All SPARQL queries are run with EasyRdf library. We included Geocoder library (a(href="https://github.com/geocoder-php/Geocoder") https://github.com/geocoder-php/Geocoder) for place name to coordinate conversion and a JsonLD implementation ( a(href="https://github.com/lanthaler/JsonLD") https://github.com/lanthaler/JsonLD) for query results serialization.</p><p>The application uses Google+ connection, also taking data from Google Books and requiring data from Google Maps and Google Coordinates for geolocation. Google+ does not currently offer support for knowledge graphs, but we built a linked data graph using non-semantic data from user’s profile. Every person in user’s circles is mapped as a foaf:knows property of the graph owner and as a resource of type foaf:Person.</p><p> </p><span class="strong">People Data</span><p>For every person in the graph, including the owner, we mapped the following properties (from their corresponding ontologies):</p><ul><li> foaf:name</li><li>  foaf:givenname</li><li> foaf:family_name</li><li>  foaf:depiction(profile picture)</li><li>    foaf:homepage (link to Google+ profile)</li><li>  foaf:page (one or more pages on other social sites)</li><li>     dbp:website(one or more websites)</li><li>       foaf:gender</li><li>  dbo:occupation</li><li>  dbo:school</li><li>  foaf:based_near with code geo:lat and geo:long attributes</li><li>    dbo:country</li><li>  sch:description “about me” section</li></ul></div><p>Data sources: <ul><li><a href="https://plus.google.com/">https://plus.google.com/</a></li><li><a href="https://books.google.com/">https://books.google.com/</a></li><li><a href="https://www.google.com/calendar/">https://www.google.com/calendar/</a></li><li><a https://dbpedia.org/>http://dbpedia.org/</a></li><li><a href="https://schema.org/">http://schema.org/</a></li><li><a href="http://www.w3.org/2003/01/geo/wgs84_pos/">http://www.w3.org/2003/01/geo/wgs84_pos/</a></li></ul><p>For every person who provides a location in his/her profile, we use Geocoder to convert the textual information into semantic data. All people are identified by their own Google+ ids.  <p> <span class="strong">Book Data</span></p><p>Next, a list of books will be retrieved from user’s Google Books account. For books we can only have basic descriptive data (like name, author name, publisher, number of pages, rating details, genre, ISBN (with both 10 and 13 digits) and a Google Books id. Publishers and authors are mapped as organizations and people, respectively, with generated ids in the same RDF graph.<p>We are not provided any URIs/links, so our semantic searches based on this data can fail.</p><p>Example:  The 5th book of J. K. Rowling’s Harry Potter series has its name stated as:</p><p>Harry Potter And The Order Of The Phoenix Book.</p><p> <img src="images/potter.png" alt="sor"></p></p></p><p>In this case, queries that search a partial name matching will either fail or be timed out. A solution is to search by a combination of features – name, author, genre, publisher – using partial matchings and the SPARQL’s optional/union clauses.<p>span.strong Event data</p><p>Events from Google+ profile along with other events are retrieved from Google Calendars. We picked only those calendars whose owner is the user himself, to exclude generic events like Christmas, New Year, legal holidays.</p><p>We get the same basic data – title, description, date, website link and location (if specified), and also a Google+ id.</p><p>span.strong Recommendations</p><p>Once the graph is created, automatic recommendations can be generated. We implemented three types of recommendations:</p><ul> <li>for books</li><li>for films </li><li> for educational institutions, such as schools, colleges, libraries.</li></ul></p><p> <span class="strong">Book Recommendations</span></p><p>The app randomly retrieves a list of at most 5 books from the graph. Next, it attempts to match them to the corresponding entities from DBpedia, as described above. For each entity, a list of at most 10 books is retrieved. The books must have either the same author, publisher or literary genre. The diversity of recommendations is assured when the user has lots of books in his Google library, because they start from randomly chosen books. Partial results will be send in case the query fails for a book or is timed out (see example above). <p>span.strong Film Recommendations</p><p>Because Google+ does not provide any information about user’s favorite movies (everything is a “page”), we thought that it would be interesting to give movie recommendations starting from favorite books. The process is quite similar: 5 books randomly picked from graph. They are mapped to entities and an URI is returned. Next, we query DBpedia for objects of type dbo:Film which match at least one of the following criteria:<ul><li> it is disambiguated by the same resource as the book:</li></ul></p><p> <img src="images/dbo1.png" alt="sor"></p><ul> <li> it is based on the book</li></ul><p> <img src="images/dbo2.png" alt="sor"></p><p>Now we get a list of movies inspired by the books we read, if any. The next step is to search even more films the user might like. Given the list, we look for movies that have either the same director, same genre or one mutual actor.</p><p>All recommendations, as well as searches, return a lot of information, including external references for each object.</p><p> <span class="strong">Searches</span></p><p>We implemented searches for 6 types of objects:<ul><li>People</li><li> Places (gardens, historical monuments etc)</li><li> Educational Institutions</li><li>  Books</li><li> films</li><li> Events</li></ul></p></p><p>This module can be used without social profile connection. All searches are strictly semantic, which means that for almost every criteria we use URIs. A list of resources is initially retrieved using ajax requests.<p>Example – gardens of United States. We both map the type of place – garden – and the country – United States – to the corresponding resources. The user selects a name, but searches by an URI.</p><p> <img src="images/gardens_united_states.png" alt="sor"></p><p>Here is the list of criteria it checks for each type of entity (at least one selected for a valid query)</p><p> <span class="strong">People</span><ul> <li>name</li><li>profession(URI)</li><li>country (URI)    </li></ul></p><p> <span class="strong">Places<ul> <li>name</li><li>type(URI)</li><li>country(URI)   </li></ul></span></p><p>    <span class="strong">Event<ul> <li> name</li><li>type(URI)</li><li> location(URI)<li>start date(mim/max values, date)</li><li>end_date(mim/max values, date)</li></li></ul></span></p><p> <span class="strong">Books<ul> <li> title</li><li> author(URI)</li><li> litracy genre(URI)</li><li> number of pages(min/max values, numeric)</li><li>number of volumes(numeric)</li></ul></span></p><p> <span class="strong">Films<ul> <li> title</li><li> director(URI)</li><li> actor(URI)</li><li> musical artist (URI)</li><li>original language(URI)</li><li> country(URI)</li><li>  movie genre(URI)</li></ul></span></p><p> <span class="strong">Educational Institutes<ul> <li> name</li><li> type(URI)</li><li> location(URI)</li><li>country(URI)</li><li> principal(URI)</li><li>rector(URI)</li><li> number of academic staff(min/max values, numeric)</li><li>number of students ( min/max values, numeric)</li></ul></span></p><p>e.g. case study: results for films name France</p><p> <img src="images/film_france.png" alt="sor"></p><h2 id="chapter14">14. Resources (tools, frameworks, scripting languages) used for on creation of SOR</h2><ul><li> Laravel framework – PHP web application framework that follows model-view –controller application pattern.</li><li>PHP (Hypertext preprocessor) – a server scripting language </li><li>HTML (Hypertext markup language) - is a language set for markup tags.</li><li>CSS (Cascade Style Sheets) – styling added to HTML elements</li><li>Jade – is a language for writing HTML</li><li>Grunt – tool that runs jade files and creates HTML files. </li><li>Ajax (Asynchronous JavaScript and XML)- helps create asynchronous web application( the content is changed dynamically, without the need to change the entire page).</li><li>JsonLD implementation – helps JSON to interrogate data at web-scale (LD- linked data)</li><li> Bootstrap – a front end framework used in creating HTML and CSS.</li><li> Sparql- is used as a systematic query language for RDF file.</li><li> Heroku cloud application platform “based on managed container system”.</li></ul></p><h2 id="chapter15">15. Conclusion</h2><p>Social Recommender is a web application that user social networks (Google) and other external resources to recommend the user certain people, events, places, books and films.<h2 id="chapter16">16. Bibliography</h2><p>SOR:<a href="http://social-recommender.herokuapp.com/">http://social-recommender.herokuapp.com/</a></p><p>DBpedia: <a href="http://wiki.dbpedia.org/ http://wiki.dbpedia.org/">http://wiki.dbpedia.org/ http://wiki.dbpedia.org/    </a></p><p>FOAF: <a href="http://www.foaf-project.org/">http://www.foaf-project.org/</a></p><p>RAML: <a href="http://raml.org/">http://raml.org/</a></p><p> Security schemas: <a href="https://api.yaas.io/patterns/v1/security-schema-basic.yaml">https://api.yaas.io/patterns/v1/security-schema-basic.yaml</a></p><p>Schema.org: <a href="https://schema.org/">https://schema.org/</a></p><p>Wikipedia: <a href="https://wikipedia.com/">https://wikipedia.com/</a></p><p>Blog:  <a href="https://socialrecommender.wordpress.com/about/">https://socialrecommender.wordpress.com/about/</a></p><p>Web project page:</p><a href="http://profs.info.uaic.ro/~busaco/teach/courses/wade/web-projects.html">http://profs.info.uaic.ro/~busaco/teach/courses/wade/web-projects.html </a></p></p></div></div></div><footer class="container-fluid footer-side"><div class="row"><div class="col-md-12"><p>Web Application Development Project</p><a href="http://profs.info.uaic.ro/~busaco/teach/courses/wade/" target="_blank">Course Page</a></div></div></footer>{!! HTML::script('js/bootstrap.min.js')  !!}