<!DOCTYPE html><html lang="en"><head><meta charset="utf-8"><meta http-equiv="X-UA-Compatible" content="IE=edge"><meta name="viewport" content="width=device-width, initial-scale=1"><title>SoR</title>{!! HTML::style('css/bootstrap.min.css') !!}
{!! HTML::style('css/stylesheet.css') !!}
{!! HTML::style('https://fonts.googleapis.com/css?family=Raleway:400,300,500,700') !!}
{!! HTML::style('https://fonts.googleapis.com/css?family=Roboto') !!}  
{!! HTML::style('https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css') !!}
{!! HTML::style('css/jquery-ui.structure.min.css') !!}
{!! HTML::style('css/jquery-ui.theme.min.css') !!}
{!! HTML::script("https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js") !!}
{!! HTML::script('js/userHeaderAjax.js') !!}
{!! HTML::script('js/jquery-ui.min.js') !!}</head><body><div class="container-fluid top-side"><div class="row"><div class="col-md-8 col-sm-8 col-xs-6"><h1 class="logo"><a href="{{url('home')}}"><img src="images/logo.png" alt="sor"></a><span>Social Recommender</span></h1></div><div class="col-md-4 col-sm-4 col-xs-6"><div class="user-box"><img src="images/avatar.jpg" alt="avatar"><p class="name"> 
<?php echo Auth::user()->name ?></p><ul class="usermenu"><li><a href="{{url('profile')}}"> <span class="glyphicon glyphicon-user"> </span>Profile</a></li><li><a href="{{url('auth/logout')}}"> <span class="glyphicon glyphicon-log-out"> </span>Logout</a></li></ul></div></div></div></div></body></html><div class="container-fluid main"><div class="row row-eq-height"><div class="col-md-2 col-sm-12 sidebar"><ul><li><span class="glyphicon glyphicon-search"></span><a href="{{url('home')}}">Search</a></li><li><span class="glyphicon glyphicon-list-alt"></span><a href="javascript:void(0)">Search History</a></li><li><span class="glyphicon glyphicon-star"></span><a href="javascript:void(0)">Favorites</a></li><li><span class="glyphicon glyphicon-unchecked"></span><a href="graph.html">Graph</a></li><li><span class="glyphicon glyphicon-file"></span><a href="report.html">Report</a></li></ul></div><div class="col-md-10 col-sm-12 application"><div class="app-report"><div class="row"><div class="col-md-12"><h1>SOR report</h1><h2>Table of contents</h2><ul><li><a href="#chapter1">1. Start to know SOR</a></li><li><a href="#chapter2">2. Objectives and constraints</a></li><li><a href="#chapter3">3. Register</a></li><li><a href="#chapter4">4. Sign in</a></li><li><a href="#chapter5">5. Homepage</a></li><li><a href="#chapter6">6. Resources</a></li><li><a href="#chapter7">7. Social networks: Facebook</a></li><li><a href="#chapter8">8. FOAF graph</a></li><ul><li><a href="#chapter8p1">8.1 Creation of FOAF graph</a></li><li><a href="#chapter8p2">8.2 Storage of FOAF graph</a></li><li><a href="#chapter8p3">8.3 Usage of FOAF graph</a></li></ul><li><a href="#chapter9">9. API specifications</a></li><ul><li><a href="#chapter9p1">9.1 RAML file</a></li><li><a href="#chapter9p2">9.1 RAML file</a></li></ul><li><a href="#chapter10">10. Results - limited display of results</a></li><li><a href="#chapter11">11. Caching</a></li><li><a href="#chapter12">12. User preferences</a></li><li><a href="#chapter13">13. Conclusion</a></li><li><a href="#chapter14">14. Bibliography</a></li></ul><h2 id="chapter1">1. Start to know SOR.</h2><p>Social recommender is an application that is able to recommend certain people/events/things of interest according to a given FOAF graph build with information from a social network (for now Facebook, but later on it has the possibility to be extended with more information from other social networks such as LinkedIn, Twitter etc.) and external resources. The information from the social networks is about the client's features, interests, likes/dislikes, events/things, heard/liked music, artists, profession, knowledge, places he/she visited, played games, persons he/she knows and interacts with.</p><h2 id="chapter2">2. Objectives and constraints.</h2><p>Create an application that recommends (randomly or on request) to the user certain people/events/things of interesting according to social networks (Facebook).</p><p>Application constraints: </p><ul><li>The application should be a responsive application</li><li>Service oriented application</li><li>Restful API</li><li>An application built on the existing social and semantic Web technologies</li><li>The code-source and specific content must be available under the terms of the open source licenses</li><li>To be discussed</li></ul><h2 id="chapter3">3. Register</h2><p>First step to create an user account is to register. The registration requires filling in a form with personal information about the client so that when the user first checks the application, some preferences would already be displayed on the start page.</p><p>Note: The email and password are unique for every user.</p><h2 id="chapter4">4. Sign in</h2><p>Using the information from the registration step, like email and a password, the user can sign into a defined account already containing random recommendations based on details provided in the registration form.</p><h2 id="chapter5">5. Homepage</h2><p>Homepage is the staring page of the application and contains either results of random recommendations based on a social network (Facebook) and saved preferences – likes/dislikes (if any), or the results of a custom, user-defined query, also considering user’s feedback on previous results.</p><h2 id="chapter6">6. Resources:</h2><p>Resources are used to get accurate recommendations for the user. We use multiple open data sources in RDF format and their corresponding ontologies.</p><p>Here are some examples of resources that could be used for this application: </p><ul> <li> <a href="http://wiki.dbpedia.org/">Dbpedia </a>is a crowd-sourced community effort to extract structured information from Wikipedia and make this information available on the Web. </li><li> <a href="http://www.geonames.org/">Geonames.org </a>- the geographical database covers all countries and contains over eight million place names that are available for download free of charge.</li><li> <a href="http://linkeddata.org/">Linked Data </a>is about using the Web to connect related data that wasn't previously linked, or using the Web to lower the barriers to linking data currently linked using other methods. More specifically, Wikipedia defines Linked Data as "a term used to describe a recommended best practice for exposing, sharing, and connecting pieces of data, information, and knowledge on the Semantic Web using URIs and RDF.</li><li> <a href="http://schema.org/">Schema.org </a>is a collaborative, community activity with a mission to create, maintain, and promote schemas for structured data on the Internet, on web pages, in email messages, and beyond.</li><li> <a href="https://www.freebase.com/">Freebase </a>was a large collaborative knowledge base consisting of data composed mainly by its community members.</li><li> <a href="http://babelnet.org/">BabelNet </a>is a multilingual lexicalized semantic network and ontology.</li><li> <a href="https://www.wikidata.org/wiki/Wikidata:Main_Page Wikidata">Wikidata</a>is a collaboratively edited knowledge base.</li></ul><p class="strong">Note: This list of data sources is not final and the definitions of the resources are taken from the main sites.</p><h2 id="chapter7">7.  Social networks:  Facebook</h2><p>The FOAF graph will be constructed based on information from Facebook. The user must be connected to Facebook in order to create the graph and then be provided with the random or requested recommendations. </p><h2 id="chapter8">8.  FOAF graph</h2><p>FOAF graph (friend of a friend) is a RDF file that stores personal information taken from a social network (Facebook). </p><p>Personal information means information from Facebook profile, including client's friends,  likes, events, things, professions, music, artists, work places, educational institutes, domains of work and study, stores, electronics, clothes and so on.</p><h3 id="chapter8p1">8.1 Creation of FOAF graph</h3><p>A FOAF graph is created first when the client connects to a social network, in a RDF format (.xml/.ttl). The client has the possibility to update the content of the graph every time he/she requests so. 	 </p><p>Note:  Time limit of updating the graph can be changed if necessary.</p><h3 id="chapter8p2">8.2 Storage of FOAF graph</h3><p>FOAF graph will be loaded on the server side every time it is created/updated. There will be a RDF graph or more for each user that has an account for this application.</p><h3 id="chapter8p3">8.3 Usage of FOAF graph</h3><p> The graph is used for:</p><ul> <li>random generated recommendations  displayed on homepage</li><li>on user request generated recommendations.</li></ul><h2 id="chapter9">9. API specifications </h2><p>RAML file is used to describe API specifications</p><h3 id="chapter9p1">9.1 RAML file</h3><p> RAML file describes the API specifications of the application. The API is structured in four main modules:</p><ul> <li> <span class="strong">Randomly generated recommandations </span><br>Based on users’s FOAF graph, the app will first extract similarities – most common occurrences of things (places, movies), most popular events. It will also take into account user’s geographical location and current town as listed on Facebook. Considering this data, it will search for events nearby, similar movies, people who went to the same school and other things. Finally, the user will see query results filtered by type on his home page, or he can request the list by calling the following endpoints: <code>/recommendations?item_type=[TYPE_OF_ITEM]</code>, where TYPE_OF_ITEM is one of: person, event, movie, book, place, educational_institute. A drop-down with the five classes of recommendations will be available, serving as a filter where the client can chose the type of recommendations to see.</li><li> <span class="strong">Graph content</span><br>The user can see the content of his generated FOAF graph, sorted by relevance and filterd by item type, by calling the following uri: <code>/graph?item_type= [TYPE_OF_ITEM]</code>, where TYPE_OF_ITEM is one of: person, event, movie, book, place, educational_institute.</li><li> <span class="strong">Search module</span><br>The user will be able to look for stuff by defining his own criteria in five different forms for each type of resource.  Some examples – the client wants to get all books of Agatha Christie first published after 1940; the client wants to get all universities with over 5000 students and at least 2 Nobel Prize laureates.<br>All search features will be available by querying the following endpoint:<code>/search/[TYPE_OF_ITEM]</code>, with TYPE_OF_ITEM one of: person, event, movie, book, place, educational_institute.</li><li> <span class="strong">Saved items </span><br>The user will have the possibility to give positive/negative feedback for each query result, by clicking like/disliked. The item specified will be stored into database. Disliked items will not be taken into account on the next query (or, from the client point of view, on the next set of recommendations, either random or custom). Saved items can be filtered by type or grouped into user-defined lists with suggestive names. An items can be on many lists or on none. For reasons of time and space complexity, only at most three-months old saved items will be considered on queries<br>By calling the endpoint <code>/saved-items?item_type=[TYPE_OF_ITEM]</code>,  the user will get the list of all items. For lists, a call to /lists/[list_id] is required.</li></ul><h3 id="chapter9p3">9.2 Link to RAML file </h3><h2 id="chapter10">10. Results - limited display of results</h2><p>Results are displayed in Homepage, containing the name of the results and other information, according to the type of result.   </p><p>The constraints of the number of items displayed are:</p><ul> <li>minimum number of results:  5</li><li>maximum number of results:  50</li><li>default: 10 </li></ul><h2 id="chapter11">11. Caching </h2><p> Queries send by the user are saved on server side, in our database. This way, they will be available to the client from any computer, anytime.</p><h2 id="chapter12">12. User preferences</h2><p>A list of preferences will be saved for the user profile when he/she indicates the results liked by the user.		</p><p>Beside this list, SOR also creates a blacklist of results that should not be included in the displayed results. In this way SOR becomes more accurate each time it is used.</p><p>Two checks will be available for each result one with ‘+’ meaning to include this result in the user profile, and one with ’–‘, meaning to exclude this result when receiving a recommendation.		</p><p>Preferences are by default kept from the first time the user signed in his account, but there is a checklist available where the user can select the period of time the preferences were added.</p><h2 id="chapter13">13. Conclusion</h2><p>Social Recommender is a web application that user social networks (Facebook) and other external resources to recommend the user certain people, events, things, movies, books and so on.	</p><h2 id="chapter14">14. Bibliography</h2><p>DBpedia: <a href="http://wiki.dbpedia.org/ http://wiki.dbpedia.org/">http://wiki.dbpedia.org/ http://wiki.dbpedia.org/	</a></p><p>FOAF: <a href="http://www.foaf-project.org/">http://www.foaf-project.org/</a></p><p>RAML: <a href="http://raml.org/">http://raml.org/</a></p><p>Facebook:<a href="https://www.facebook.com/">https://www.facebook.com/</a></p><p> Security schemas: <a href="https://api.yaas.io/patterns/v1/security-schema-basic.yaml">https://api.yaas.io/patterns/v1/security-schema-basic.yaml</a></p><p>Schema.org: <a href="https://schema.org/">https://schema.org/</a></p><p>Wikipedia: <a href="https://wikipedia.com/">https://wikipedia.com/</a></p><p>Blog:  <a href="https://socialrecommender.wordpress.com/about/">https://socialrecommender.wordpress.com/about/</a></p><p>Web project page:<a href="http://profs.info.uaic.ro/~busaco/teach/courses/wade/web-projects.html">http://profs.info.uaic.ro/~busaco/teach/courses/wade/web-projects.html </a></p></div></div></div></div></div></div><footer class="container-fluid footer-side"><div class="row"><div class="col-md-12"><p>This is the footer. Information soon to be added here</p></div></div></footer>{!! HTML::script('js/bootstrap.min.js')  !!}