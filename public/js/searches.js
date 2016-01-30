$(document).on("ready",function(){var placeTypes={},countries={},locations={},eventTypes={},literaryGenres={},illustrators={},authors={},institutionTypes={},professions={},principals={},rectors={},readyCheck=0,readyCount=0,actors={},directors={},movieGenres={},languages={},musicalArtists={},addToRemoveFromList=function(){$(".addToList").click(function(){jQuery.ajax({method:"post",url:"result/favorite",dataType:"json",data:$(this).attr("data"),success:function(data){},error:function(data){console.log("error")}})}),$(".removeResult").click(function(){jQuery.ajax({method:"post",url:"result/remove",dataType:"json",data:$(this).attr("data"),success:function(data){},error:function(data){console.log("error")}})})},getData=function(url,containerObject,fields,description,data,hideWrapper,form){jQuery.ajax({method:"get",url:url,data:data?{name:""}:{},dataType:"json",success:function(data){var key,autocompleteValues=[];for(key in data)autocompleteValues.push(data[key].name),containerObject[data[key].name.split(" ").join("_")]=data[key].uri;$.each(fields,function(index,value){$("input[name='"+value+"']").autocomplete({source:autocompleteValues})}),readyCheck+=1,$(hideWrapper).append("<p class='log info'>Added autocomplete "+description+"</p>"),readyCheck===readyCount&&($(hideWrapper).remove(),$(form).removeClass("hidden"))},error:function(){readyCheck+=1,$(hideWrapper).append("<p class='log err'>Error: Autocomplete "+description+" failed.. disabling field..</p>"),$("input[name='"+field+"']").attr("disabled","disabled"),readyCheck===readyCount&&($(hideWrapper).remove(),$(form).removeClass("hidden"))}})};$(function(){$("#eventStartDateMin").datepicker({defaultDate:"+1w",changeMonth:!0,numberOfMonths:2,dateFormat:"yy-mm-dd",onClose:function(selectedDate){$("#eventStartDateMax").datepicker("option","minDate",selectedDate)}}),$("#eventStartDateMax").datepicker({defaultDate:"+1w",changeMonth:!0,numberOfMonths:2,dateFormat:"yy-mm-dd",onClose:function(selectedDate){$("#eventStartDateMin").datepicker("option","maxDate",selectedDate)}}),$("#eventEndDateMin").datepicker({defaultDate:"+1w",changeMonth:!0,numberOfMonths:2,dateFormat:"yy-mm-dd",onClose:function(selectedDate){$("#eventEndDateMax").datepicker("option","minDate",selectedDate)}}),$("#eventEndDateMax").datepicker({defaultDate:"+1w",changeMonth:!0,numberOfMonths:2,dateFormat:"yy-mm-dd",onClose:function(selectedDate){$("#eventEndDateMin").datepicker("option","maxDate",selectedDate)}})}),$("#personInitialize").click(function(){var stop=!1;$.each($(".initializeWrapper"),function(index,value){$(value).hasClass("hidden")||(stop=!0)}),stop||($("#personInitialize").unbind().remove(),$("#personPanel .initializeWrapper").removeClass("hidden"),readyCount+=2,getData("/getProfessions",professions,["personProfession"],"professions",!1,"#personPanel .initializeWrapper","#personSearchForm"),getData("/getCountries",countries,["personCountry"],"countries",!1,"#personPanel .initializeWrapper","#personSearchForm"))}),$("#eventInitialize").click(function(){var stop=!1;$.each($(".initializeWrapper"),function(index,value){$(value).hasClass("hidden")||(stop=!0)}),stop||($("#eventInitialize").unbind().remove(),$("#eventPanel .initializeWrapper").removeClass("hidden"),readyCount+=2,getData("/getPlaces",locations,["locationUri"],"locations",!0,"#eventPanel .initializeWrapper","#eventSearchForm"),getData("/getEventTypes",eventTypes,["eventTypeUri"],"event types",!0,"#eventPanel .initializeWrapper","#eventSearchForm"))}),$("#bookInitialize").click(function(){var stop=!1;$.each($(".initializeWrapper"),function(index,value){$(value).hasClass("hidden")||(stop=!0)}),stop||($("#bookInitialize").unbind().remove(),$("#bookPanel .initializeWrapper").removeClass("hidden"),readyCount+=3,getData("/getAuthors",authors,["authorUri"],"authors",!0,"#bookPanel .initializeWrapper","#bookSearchForm"),getData("/getIllustrators",illustrators,["illustratorUri"],"illustrators",!0,"#bookPanel .initializeWrapper","#bookSearchForm"),getData("/getLiteraryGenres",literaryGenres,["literaryGenreUri"],"literary genres",!1,"#bookPanel .initializeWrapper","#bookSearchForm"))}),$("#placeInitialize").click(function(){var stop=!1;$.each($(".initializeWrapper"),function(index,value){$(value).hasClass("hidden")||(stop=!0)}),stop||($("#placeInitialize").unbind().remove(),$("#placePanel .initializeWrapper").removeClass("hidden"),readyCount+=2,getData("/getPlaceTypes",placeTypes,["placeTypeUri"],"place types",!1,"#placePanel .initializeWrapper","#placeSearchForm"),getData("/getCountries",countries,["countryUri"],"countries",!1,"#placePanel .initializeWrapper","#placeSearchForm"))}),$("#instituteInitialize").click(function(){var stop=!1;$.each($(".initializeWrapper"),function(index,value){$(value).hasClass("hidden")||(stop=!0)}),stop||($("#instituteInitialize").unbind().remove(),$("#institutePanel .initializeWrapper").removeClass("hidden"),readyCount+=4,getData("/getEduInstitutionTypes",institutionTypes,["eduTypeUri"],"educational institution types",!1,"#institutePanel .initializeWrapper","#instituteSearchForm"),getData("/getCountries",countries,["countryUri"],"countries",!1,"#institutePanel .initializeWrapper","#instituteSearchForm"),getData("/getPrincipals",principals,["principalUri"],"principals",!0,"#institutePanel .initializeWrapper","#instituteSearchForm"),getData("/getRectors",rectors,["rectorUri"],"rectors",!0,"#institutePanel .initializeWrapper","#instituteSearchForm"))}),$("#filmInitialize").click(function(){var stop=!1;$.each($(".initializeWrapper"),function(index,value){$(value).hasClass("hidden")||(stop=!0)}),stop||($("#filmInitialize").unbind().remove(),$("#filmPanel .initializeWrapper").removeClass("hidden"),readyCount+=6,getData("/getDirectors",directors,["directorUri"],"directors",!0,"#filmPanel .initializeWrapper","#filmSearchForm"),getData("/getActors",actors,["actorUri"],"actors",!0,"#filmPanel .initializeWrapper","#filmSearchForm"),getData("/getCountries",countries,["countryUri"],"countries",!1,"#filmPanel .initializeWrapper","#filmSearchForm"),getData("/getMovieGenres",movieGenres,["movieGenreUri"],"movieGenres",!0,"#filmPanel .initializeWrapper","#filmSearchForm"),getData("/getLanguages",languages,["originalLanguageUri"],"languages",!0,"#filmPanel .initializeWrapper","#filmSearchForm"),getData("/getMusicalArtists",musicalArtists,["musicalArtistUri"],"musicalArtists",!0,"#filmPanel .initializeWrapper","#filmSearchForm"))}),$("#filmSearchForm .btn").click(function(e){e.preventDefault(),$("#filmSearchForm input").removeClass("invalid");var actorUri=actors[$("#filmSearchForm input[name='actorUri']").val().split(" ").join("_")],directorUri=directors[$("#filmSearchForm input[name='directorUri']").val().split(" ").join("_")],countryUri=countries[$("#filmSearchForm input[name='countryUri']").val().split(" ").join("_")],movieGenreUri=movieGenres[$("#filmSearchForm input[name='movieGenreUri']").val().split(" ").join("_")],originalLanguageUri=languages[$("#filmSearchForm input[name='originalLanguageUri']").val().split(" ").join("_")],musicalArtistUri=musicalArtists[$("#filmSearchForm input[name='musicalArtistUri']").val().split(" ").join("_")],name=$("#filmSearchForm input[name='name']").val(),sendingData={name:name,actorUri:actorUri,directorUri:directorUri,countryUri:countryUri,movieGenreUri:movieGenreUri,originalLanguageUri:originalLanguageUri,musicalArtistUri:musicalArtistUri};(void 0!==directorUri||void 0!==countryUri||void 0!==movieGenreUri||name.trim().length>0||void 0!==originalLanguageUri||void 0!==musicalArtistUri||void 0!==actorUri)&&(void 0===directorUri&&$("#filmSearchForm input[name='directorUri']").val().length>0&&$("#filmSearchForm input[name='directorUri']").addClass("invalid"),void 0===countryUri&&$("#filmSearchForm input[name='countryUri']").val().length>0&&$("#filmSearchForm input[name='countryUri']").addClass("invalid"),void 0===movieGenreUri&&$("#filmSearchForm input[name='movieGenreUri']").val().length>0&&$("#filmSearchForm input[name='movieGenreUri']").addClass("invalid"),void 0===originalLanguageUri&&$("#filmSearchForm input[name='originalLanguageUri']").val().length>0&&$("#filmSearchForm input[name='originalLanguageUri']").addClass("invalid"),void 0===musicalArtistUri&&$("#filmSearchForm input[name='musicalArtistUri']").val().length>0&&$("#filmSearchForm input[name='musicalArtistUri']").addClass("invalid"),void 0===actorUri&&$("#filmSearchForm input[name='actorUri']").val().length>0&&$("#filmSearchForm input[name='actorUri']").addClass("invalid"),$("p.resultHeader").html("Fetching data.. please wait"),$(".allResults").html(""),jQuery.ajax({method:"get",url:"search/films",dataType:"json",data:sendingData,success:function(data){var result,comaCheck,limitCheck,saveData,prop,count=0;for(prop in data)data.hasOwnProperty(prop)&&(count+=1);$("p.resultHeader").html("There are "+count+" results based on your latest query."),$.each(data,function(key,val){saveData={type:"Film"},saveData[key]=val,result='<div class="col-lg-6 col-md-6 col-sm-12"><div class="resultWrapper"><p>Type: <span class="type">Film</span></p><p>Name: <span class="name">'+val.title+"</span></p>",val.directors&&(result+="<p>Directors: <span>",$.each(val.directors,function(key2,val2){result+=val2}),result+="</span></p>"),val.composers&&(limitCheck=0,result+="<p>Composers: <span>",comaCheck=!1,$.each(val.composers,function(key3,val3){3>limitCheck&&(result+=(comaCheck?", ":" ")+val3,comaCheck=!0,limitCheck+=1)}),result+="</span></p>"),val.actors&&(limitCheck=0,result+="<p>Actors: <span>",comaCheck=!1,$.each(val.actors,function(key3,val3){3>limitCheck&&(result+=(comaCheck?", ":" ")+val3,comaCheck=!0,limitCheck+=1)}),result+="</span></p>"),result+='<a target="_blank" href="'+val.link+'"> Original Link</a><button type="button" class="addToList" data="'+JSON.stringify(saveData)+'"><span class="glyphicon glyphicon-plus"></span></button><button type="button" class="removeResult" data="'+JSON.stringify(saveData)+'"><span class="glyphicon glyphicon-minus"></span></button></div></div>',$(".allResults").append(result)}),addToRemoveFromList()},error:function(data){$("p.resultHeader").html("Something wrong happened. Please try again.")}}))}),$("#instituteSearchForm .btn").click(function(e){e.preventDefault(),$("#instituteSearchForm input").removeClass("invalid");var eduTypeUri=institutionTypes[$("#instituteSearchForm input[name='eduTypeUri']").val().split(" ").join("_")],countryUri=countries[$("#instituteSearchForm input[name='countryUri']").val().split(" ").join("_")],rectorUri=rectors[$("#instituteSearchForm input[name='rectorUri']").val().split(" ").join("_")],principalUri=principals[$("#instituteSearchForm input[name='principalUri']").val().split(" ").join("_")],name=$("#instituteSearchForm input[name='name']").val(),nrOfAcademicStaffMin=$("#instituteSearchForm input[name='nrOfAcademicStaffMin']").val(),nrOfAcademicStaffMax=$("#instituteSearchForm input[name='nrOfAcademicStaffMax']").val(),nrOfStudentsMin=$("#instituteSearchForm input[name='nrOfStudentsMin']").val(),nrOfStudentsMax=$("#instituteSearchForm input[name='nrOfStudentsMax']").val(),sendingData={name:name,eduTypeUri:eduTypeUri,countryUri:countryUri,rectorUri:rectorUri,principalUri:principalUri,nrOfAcademicStaffMin:nrOfAcademicStaffMin,nrOfAcademicStaffMax:nrOfAcademicStaffMax,nrOfStudentsMin:nrOfStudentsMin,nrOfStudentsMax:nrOfStudentsMax};(void 0!==rectorUri||void 0!==principalUri||void 0!==eduTypeUri||void 0!==countryUri||name.trim().length>0||nrOfAcademicStaffMin.trim().length>0||nrOfAcademicStaffMax.trim().length>0||nrOfStudentsMin.trim().length>0||nrOfStudentsMax.trim().length>0)&&(void 0===rectorUri&&$("#instituteSearchForm input[name='rectorUri']").val().length>0&&$("#instituteSearchForm input[name='rectorUri']").addClass("invalid"),void 0===countryUri&&$("#instituteSearchForm input[name='countryUri']").val().length>0&&$("#instituteSearchForm input[name='countryUri']").addClass("invalid"),void 0===principalUri&&$("#instituteSearchForm input[name='principalUri']").val().length>0&&$("#instituteSearchForm input[name='principalUri']").addClass("invalid"),void 0===eduTypeUri&&$("#instituteSearchForm input[name='eduTypeUri']").val().length>0&&$("#instituteSearchForm input[name='eduTypeUri']").addClass("invalid"),$("p.resultHeader").html("Fetching data.. please wait"),$(".allResults").html(""),jQuery.ajax({method:"get",url:"search/edu",dataType:"json",data:sendingData,success:function(data){var result,comaCheck,saveData,prop,count=0;for(prop in data)data.hasOwnProperty(prop)&&(count+=1);$("p.resultHeader").html("There are "+count+" results based on your latest query."),$.each(data,function(key,val){saveData={type:"Institution"},saveData[key]=val,result='<div class="col-lg-6 col-md-6 col-sm-12"><div class="resultWrapper"><p>Type: <span class="type">Institution</span></p><p>Name: <span class="name">'+val.title+"</span></p>",val.numberOfStudents&&(result+="<p>Students: <span>"+val.numberOfStudents+"</span></p>"),val.countries&&(result+="<p>Country: <span>",comaCheck=!1,$.each(val.countries,function(key2,val2){result+=(comaCheck?", ":" ")+val2,comaCheck=!0}),result+="</span></p>"),result+='<a target="_blank" href="'+val.link+'"> Original Link</a><button type="button" class="addToList" data="'+JSON.stringify(saveData)+'"><span class="glyphicon glyphicon-plus"></span></button><button type="button" class="removeResult" data="'+JSON.stringify(saveData)+'"><span class="glyphicon glyphicon-minus"></span></button></div></div>',$(".allResults").append(result)}),addToRemoveFromList()},error:function(data){$("p.resultHeader").html("Something wrong happened. Please try again.")}}))}),$("#eventSearchForm .btn").click(function(e){e.preventDefault(),$("#eventSearchForm input").removeClass("invalid");var comaCheck,eventTypeUri=eventTypes[$("#eventSearchForm input[name='eventTypeUri']").val().split(" ").join("_")],locationUri=locations[$("#eventSearchForm input[name='locationUri']").val().split(" ").join("_")],name=$("#eventSearchForm input[name='name']").val(),startDateMin=$("#eventSearchForm input[name='startDateMin']").val(),startDateMax=$("#eventSearchForm input[name='startDateMax']").val(),endDateMin=$("#eventSearchForm input[name='endDateMin']").val(),endDateMax=$("#eventSearchForm input[name='endDateMax']").val(),sendingData={eventTypeUri:eventTypeUri,name:name,locationUri:locationUri,startDateMin:startDateMin,endDateMin:endDateMin,startDateMax:startDateMax,endDateMax:endDateMax};(void 0!==eventTypeUri||name.trim().length>0||void 0!==locationUri||startDateMin.trim().length>0||startDateMax.trim().length>0||endDateMin.trim().length>0||endDateMax.trim().length>0)&&(void 0===eventTypeUri&&$("#eventSearchForm input[name='eventTypeUri']").val().length>0&&$("#eventSearchForm input[name='eventTypeUri']").addClass("invalid"),void 0===locationUri&&$("#eventSearchForm input[name='locationUri']").val().length>0&&$("#eventSearchForm input[name='locationUri']").addClass("invalid"),$("p.resultHeader").html("Fetching data.. please wait"),$(".allResults").html(""),jQuery.ajax({method:"get",url:"search/events",dataType:"json",data:sendingData,success:function(data){var result,saveData,prop,count=0;for(prop in data)data.hasOwnProperty(prop)&&(count+=1);$("p.resultHeader").html("There are "+count+" results based on your latest query."),$.each(data,function(key,val){saveData={type:"Event"},saveData[key]=val,result='<div class="col-lg-6 col-md-6 col-sm-12"><div class="resultWrapper"><p>Type: <span class="type">Event</span></p><p>Name: <span class="name">'+val.title+"</span></p>",val.locations&&(result+="<p>Locations: <span>",comaCheck=!1,$.each(val.locations,function(key2,val2){result+=(comaCheck?", ":" ")+val2,comaCheck=!0}),result+="</span></p>"),result+='<a target="_blank" href="'+val.link+'"> Original Link</a><button type="button" class="addToList" data="'+JSON.stringify(saveData)+'"><span class="glyphicon glyphicon-plus"></span></button><button type="button" class="removeResult" data="'+JSON.stringify(saveData)+'"><span class="glyphicon glyphicon-minus"></span></button></div></div>',$(".allResults").append(result)}),addToRemoveFromList()},error:function(data){$("p.resultHeader").html("Something wrong happened. Please try again.")}}))}),$("#personSearchForm .btn").click(function(e){e.preventDefault(),$("#personSearchForm input").removeClass("invalid");var personCountry=countries[$("#personSearchForm input[name='personCountry']").val().split(" ").join("_")],personProfession=professions[$("#personSearchForm input[name='personProfession']").val().split(" ").join("_")],personName=$("#personSearchForm input[name='personName']").val(),sendingData={personName:personName,personProfession:personProfession,personCountry:personCountry};(void 0!==personCountry||personName.trim().length>0||void 0!==personProfession)&&(void 0===personProfession&&$("#personSearchForm input[name='personProfession']").val().length>0&&$("#personSearchForm input[name='personProfession']").addClass("invalid"),void 0===personCountry&&$("#personSearchForm input[name='personCountry']").val().length>0&&$("#personSearchForm input[name='personCountry']").addClass("invalid"),$("p.resultHeader").html("Fetching data.. please wait"),$(".allResults").html(""),jQuery.ajax({method:"get",url:"search/people",dataType:"json",data:sendingData,success:function(data){var result,saveData,prop,count=0;for(prop in data)data.hasOwnProperty(prop)&&(count+=1);$("p.resultHeader").html("There are "+count+" results based on your latest query."),$.each(data,function(key,val){saveData={type:"Person"},saveData[key]=val,result="<div class='col-lg-6 col-md-6 col-sm-12'><div class='resultWrapper'><p>Type: <span class='type'>Person</span></p><p>Name: <span class='name'>"+val.name+"</span></p><p>Profession: <span class='profession'>"+val.profession.name+"</span></p><p>Country: <span class='profession'>"+val.country.name+"</span></p><a target='_blank' href='"+val.link+"'> Original Link</a><button type='button' class='addToList' data='"+JSON.stringify(saveData)+"'><span class='glyphicon glyphicon-plus'></span></button><button type='button' class='removeResult' data='"+JSON.stringify(saveData)+"'><span class='glyphicon glyphicon-minus'></span></button></div></div>",$(".allResults").append(result)}),addToRemoveFromList()},error:function(data){$("p.resultHeader").html("Something wrong happened. Please try again.")}}))}),$("#bookSearchForm .btn").click(function(e){e.preventDefault(),$("#bookSearchForm input").removeClass("invalid");var illustratorUri=illustrators[$("#bookSearchForm input[name='illustratorUri']").val().split(" ").join("_")],authorUri=authors[$("#bookSearchForm input[name='authorUri']").val().split(" ").join("_")],titleName=$("#bookSearchForm input[name='name']").val(),literaryGenreUri=literaryGenres[$("#bookSearchForm input[name='literaryGenreUri']").val().split(" ").join("_")],numberOfPagesMin=$("#bookSearchForm input[name='numberOfPagesMin']").val(),numberOfPagesMax=$("#bookSearchForm input[name='numberOfPagesMax']").val(),numberOfVolumes=$("#bookSearchForm input[name='numberOfVolumes']").val(),sendingData={name:titleName,illustratorUri:illustratorUri,authorUri:authorUri,literaryGenreUri:literaryGenreUri,numberOfPagesMin:numberOfPagesMin,numberOfPagesMax:numberOfPagesMax,numberOfVolumes:numberOfVolumes};(void 0!==authorUri||titleName.trim().length>0||void 0!==literaryGenreUri||void 0!==illustratorUri||numberOfPagesMin.trim().length>0||numberOfPagesMax.trim().length>0||numberOfVolumes.trim().length>0)&&(void 0===illustratorUri&&$("#bookSearchForm input[name='illustratorUri']").val().length>0&&$("#bookSearchForm input[name='illustratorUri']").addClass("invalid"),void 0===literaryGenreUri&&$("#bookSearchForm input[name='literaryGenreUri']").val().length>0&&$("#bookSearchForm input[name='literaryGenreUri']").addClass("invalid"),void 0===authorUri&&$("#bookSearchForm input[name='authorUri']").val().length>0&&$("#bookSearchForm input[name='authorUri']").addClass("invalid"),$("p.resultHeader").html("Fetching data.. please wait"),$(".allResults").html(""),jQuery.ajax({method:"get",url:"search/books",dataType:"json",data:sendingData,success:function(data){var result,saveData,prop,count=0;for(prop in data)data.hasOwnProperty(prop)&&(count+=1);$("p.resultHeader").html("There are "+count+" results based on your latest query."),$.each(data,function(key,val){saveData={type:"Book"},saveData[key]=val,result='<div class="col-lg-6 col-md-6 col-sm-12"><div class="resultWrapper"><p>Type: <span class="type">Book</span></p><p>Name: <span class="name">'+val.title+"</span></p>",val.authors&&$.each(val.authors,function(key2,val2){result+='<p>Author: <span class="releaseDate">'+val2+"</span></p>"}),val.releaseDate&&("object"==typeof val.releaseDate&&(result+='<p>Name: <span class="releaseDate">'+val.releaseDate.date.split(" ")[0]+"</span></p>"),"object"!=typeof val.releaseDate&&(result+='<p>Year: <span class="releaseDate">'+val.releaseDate+"</span></p>")),result+='<a target="_blank" href="'+val.link+'"> Original Link</a><button type="button" class="addToList" data="'+JSON.stringify(saveData)+'"><span class="glyphicon glyphicon-plus"></span></button><button type="button" class="removeResult" data="'+JSON.stringify(saveData)+'"><span class="glyphicon glyphicon-minus"></span></button></div></div>',$(".allResults").append(result)}),addToRemoveFromList()},error:function(data){$("p.resultHeader").html("Something wrong happened. Please try again.")}}))}),$("#placeSearchForm .btn").click(function(e){e.preventDefault(),$("#placeSearchForm input").removeClass("invalid");var countryURI=countries[$("#placeSearchForm input[name='countryUri']").val().split(" ").join("_")],placeTypeURI=placeTypes[$("#placeSearchForm input[name='placeTypeUri']").val().split(" ").join("_")],placeName=$("#placeSearchForm input[name='name']").val(),sendingData={name:placeName,placeTypeUri:placeTypeURI,countryUri:countryURI};(void 0!==placeTypeURI||void 0!==countryURI||placeName.trim().length>0)&&(void 0===placeTypeURI&&$("#placeSearchForm input[name='placeTypeUri']").val().length>0&&$("#placeSearchForm input[name='placeTypeUri']").addClass("invalid"),void 0===countryURI&&$("#placeSearchForm input[name='countryUri']").val().length>0&&$("#placeSearchForm input[name='countryUri']").addClass("invalid"),$("p.resultHeader").html("Fetching data.. please wait"),$(".allResults").html(""),jQuery.ajax({method:"get",url:"search/places",dataType:"json",data:sendingData,success:function(data){var result,saveData,prop,count=0;for(prop in data)data.hasOwnProperty(prop)&&(count+=1);$("p.resultHeader").html("There are "+count+" results based on your latest query."),$.each(data,function(key,val){saveData={type:"Place"},saveData[key]=val,result='<div class="col-lg-6 col-md-6 col-sm-12"><div class="resultWrapper"><p>Type: <span class="type">Place</span></p><p>Name: <span class="name">'+val.title+"</span></p>",val.countries&&$.each(val.countries,function(key2,val2){result+="<p>Country: "+val2+"</p>"}),result+='<a target="_blank" href="'+val.link+'"> Original Link</a><button type="button" class="addToList" data="'+JSON.stringify(saveData)+'"><span class="glyphicon glyphicon-plus"></span></button><button type="button" class="removeResult" data="'+JSON.stringify(saveData)+'"><span class="glyphicon glyphicon-minus"></span></button></div></div>',$(".allResults").append(result)})},error:function(data){$("p.resultHeader").html("Something wrong happened. Please try again.")}}))})});