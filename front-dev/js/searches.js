$(document).on('ready', function () {
    var placeTypes = {},
        countries = {},
        locations = {},
        eventTypes = {},
        literaryGenres = {},
        illustrators = {},
        authors = {},
        institutionTypes = {},
        professions = {},
        principals = {},
        rectors = {},
        readyCheck = 0,
        readyCount = 1,
        getData= function(url, containerObject, fields, description, data, hideWrapper, form) {
            jQuery.ajax({
                method: 'get',
                url: url,
                data: (data ? {name:""} :{}),
                dataType: "json",
                success: function (data) {
                    var autocompleteValues = [],
                        key;
                    for (key in data) {
                        autocompleteValues.push(data[key].name);
                        containerObject[data[key].name.split(" ").join("_")] = data[key].uri;
                    }
                    $.each(fields, function(index,value) {
                        $("input[name='" + value + "']").autocomplete({
                            source: autocompleteValues
                        });
                    });
                    readyCheck += 1;
                    $(hideWrapper).append("<p class='log info'>Added autocomplete " + description + "</p>");
                    if (readyCheck === readyCount) {
                        $(hideWrapper).remove();
                        $(form).removeClass("hidden");
                        
                    }
                    return "<p class='log info'>Added autocomplete " + description + "</p>";
                },
                error: function () {
                    readyCheck += 1;
                    $(hideWrapper).append("<p class='log err'>Error: Autocomplete " + description + " failed.. disabling field..</p>");
                    $("input[name='" + field + "']").attr("disabled", "disabled");
                    if (readyCheck === readyCount) {
                        $(hideWrapper).remove();
                        $(form).removeClass("hidden");
                    }
                }
            })
        };
    $("p.resultHeader").html("Fetching initial data..");
    $(".allResults").html("");

    $(function() {
        $( "#eventStartDateMin" ).datepicker({
            defaultDate: "+1w",
            changeMonth: true,
            numberOfMonths: 2,
            dateFormat: "dd/mm/yy",
            onClose: function( selectedDate ) {
            $( "#eventStartDateMax" ).datepicker( "option", "minDate", selectedDate );
            }
        });
        $( "#eventStartDateMax" ).datepicker({
            defaultDate: "+1w",
            changeMonth: true,
            numberOfMonths: 2,
            dateFormat: "dd/mm/yy",
            onClose: function( selectedDate ) {
            $( "#eventStartDateMin" ).datepicker( "option", "maxDate", selectedDate );
            }
        });
        $( "#eventEndDateMin" ).datepicker({
            defaultDate: "+1w",
            changeMonth: true,
            numberOfMonths: 3,
            dateFormat: "dd/mm/yy",
            onClose: function( selectedDate ) {
            $( "#eventEndDateMax" ).datepicker( "option", "minDate", selectedDate );
            }
        });
        $( "#eventEndDateMax" ).datepicker({
            defaultDate: "+1w",
            changeMonth: true,
            numberOfMonths: 3,
            dateFormat: "dd/mm/yy",
            onClose: function( selectedDate ) {
            $( "#eventEndDateMin" ).datepicker( "option", "maxDate", selectedDate );
            }
        });
        readyCheck += 1;
        $(".allResults").append("<p class='log info'>Added event datepickers..</p>");
        if (readyCheck === readyCount) {
            //$(".loader").remove();
            $("#accordion").removeClass("hidden");
            $("p.resultHeader").html("Initial fetch complete!");
            $(".allResults").append("You may now use the search bar!");
        }
    });
    $("#personInitialize").click(function() {
        $("#personInitialize").unbind().remove();
        $("#personPanel .initializeWrapper").removeClass("hidden");
        readyCount += 2;
        getData("/getProfessions", professions, ["personProfession"], "professions", false, "#personPanel .initializeWrapper", "#personSearchForm"); 
        getData("/getCountries", countries, ["placeTypeUri","countryUri"], "countries", false, "#personPanel .initializeWrapper", "#personSearchForm");
    });
    /*
    $("a[href='#searchPerson'][init='false']").click(function() {
        var check = 0;
        $("a[href='#searchPerson'][init='false']").attr("init", "true");
        check += getData("/getProfessions", professions, ["personProfession"], "professions", false); 
        check += getData("/getCountries", countries, ["placeTypeUri","countryUri"], "countries", false);
        do {
            if(check ===2) {
                $("#personPanel .initializeWrapper").slideUp("fast");
                $("#personSearchForm").removeClass("hidden");
            }
        } while(check!==2);
    });
    */
    /*
    getData("/getRectors", rectors, ["rectorUri"], "rectors", true);
    getData("/getPrincipals", principals, ["principalUri"], "principals", true);
    getData("/getEduInstitutionTypes", institutionTypes, ["eduTypeUri"], "educational institution types", false);
    getData("/getPlaces", locations, ["locationUri"], "locations", true);
    getData("/getEventTypes", eventTypes, ["eventTypeUri"], "event types", true);
    getData("/getLiteraryGenres", literaryGenres, ["literaryGenreUri"], "literary genres", false);
    getData("/getIllustrators", illustrators, ["illustratorUri"], "illustrators", true);
    getData("/getAuthors", authors, ["authorUri"], "authors", true);
    getData("/getPlaceTypes", placeTypes, ["placeTypeUri"], "place types", false);
    */
    
    $("#instituteSearchForm .btn").click(function (e) {
        e.preventDefault();
        $("#instituteSearchForm input").removeClass("invalid");
        var eduTypeUri = institutionTypes[$("#instituteSearchForm input[name='eduTypeUri']").val().split(" ").join("_")],
            locationUri = locations[$("#instituteSearchForm input[name='locationUri']").val().split(" ").join("_")],
            rectorUri = locations[$("#instituteSearchForm input[name='rectorUri']").val().split(" ").join("_")],
            principalUri = locations[$("#instituteSearchForm input[name='principalUri']").val().split(" ").join("_")],
            name = $("#instituteSearchForm input[name='name']").val(),
            nrOfAcademicStaffMin = $("#instituteSearchForm input[name='nrOfAcademicStaffMin']").val(),
            nrOfAcademicStaffMax = $("#instituteSearchForm input[name='nrOfAcademicStaffMax']").val(),
            nrOfStudentsMin = $("#instituteSearchForm input[name='nrOfStudentsMin']").val(),
            nrOfStudentsMax = $("#instituteSearchForm input[name='nrOfStudentsMax']").val(),
            sendingData = {
                name: name,
                eduTypeUri: eduTypeUri,
                locationUri: locationUri,
                rectorUri: rectorUri,
                principalUri: principalUri,
                nrOfAcademicStaffMin: nrOfAcademicStaffMin,
                nrOfAcademicStaffMax: nrOfAcademicStaffMax,
                nrOfStudentsMin: nrOfStudentsMin,
                nrOfStudentsMax: nrOfStudentsMax
            },
            comaCheck,
            result;
        if (rectorUri !== undefined || principalUri !== undefined || eduTypeUri !== undefined || name.trim().length > 0 || locationUri !== undefined || nrOfAcademicStaffMin.trim().length > 0 || nrOfAcademicStaffMax.trim().length > 0 || nrOfStudentsMin.trim().length > 0 || nrOfStudentsMax.trim().length > 0) {
            
            if (rectorUri === undefined && $("#instituteSearchForm input[name='rectorUri']").val().length > 0) {
                $("#instituteSearchForm input[name='rectorUri']").addClass("invalid");
            }
            if (locationUri === undefined && $("#instituteSearchForm input[name='locationUri']").val().length > 0) {
                $("#instituteSearchForm input[name='locationUri']").addClass("invalid");
            }
            if (principalUri === undefined && $("#instituteSearchForm input[name='principalUri']").val().length > 0) {
                $("#instituteSearchForm input[name='principalUri']").addClass("invalid");
            }
            if (eduTypeUri === undefined && $("#instituteSearchForm input[name='eduTypeUri']").val().length > 0) {
                $("#instituteSearchForm input[name='eduTypeUri']").addClass("invalid");
            }
            $("p.resultHeader").html("Fetching data.. please wait");
            $(".allResults").html("");
            jQuery.ajax({
                method: 'get',
                url: "search/edu",
                dataType: "json",
                data: sendingData,
                success: function (data) {
                    console.log(data);
                    var count = 0,
                        title,
                        result,
                        comaCheck,
                        prop;
                    for (prop in data) {
                        if (data.hasOwnProperty(prop)) {
                            count += 1;
                        }
                    }
                    $("p.resultHeader").html("There are " + count + " results based on your latest query.");
                    $.each(data, function (key, val) {
                        result = '<div class="col-lg-6 col-md-6 col-sm-12">' +
                            '<div class="resultWrapper">' +
                            '<p>Type: <span class="type">Institution</span></p>' +
                            '<p>Name: <span class="name">' + val.title + '</span></p>';
                        if(val.numberOfStudents) {
                            result += '<p>Students: <span>' + val.numberOfStudents + '</span></p>';
                        }
                        if(val.countries) {
                            result += '<p>Country: <span>';
                            $.each(val.countries, function (key2, val2) {
                                result += val2;
                            });
                            result += '</span></p>';
                        }
                        result += '<a target="_blank" href="' + val.link + '"> Original Link</a>' +
                            '<button type="button" class="addToList"><span class="glyphicon glyphicon-plus"></span></button>' +
                            '<button type="button" class="removeResult"><span class="glyphicon glyphicon-minus"></span></button></div></div>';
                        $(".allResults").append(result);
                    });
                },
                error: function (data) {
                    $("p.resultHeader").html("Something wrong happened. Please try again.");
                }
            });
        }
    });
    $("#eventSearchForm .btn").click(function (e) {
        e.preventDefault();
        $("#eventSearchForm input").removeClass("invalid");
        var eventTypeUri = eventTypes[$("#eventSearchForm input[name='eventTypeUri']").val().split(" ").join("_")],
            locationUri = locations[$("#eventSearchForm input[name='locationUri']").val().split(" ").join("_")],
            name = $("#eventSearchForm input[name='name']").val(),
            startDateMin = $("#eventSearchForm input[name='startDateMin']").val(),
            startDateMax = $("#eventSearchForm input[name='startDateMax']").val(),
            endDateMin = $("#eventSearchForm input[name='endDateMin']").val(),
            endDateMax = $("#eventSearchForm input[name='endDateMax']").val(),
            sendingData = {
                name: name,
                eventTypeUri: eventTypeUri,
                locationUri: locationUri,
                startDateMin: startDateMin,
                endDateMin: endDateMin,
                startDateMax: startDateMax,
                endDateMax: endDateMax
            },
            comaCheck,
            result;
        if (eventTypeUri !== undefined || name.trim().length > 0 || locationUri !== undefined || startDateMin.trim().length > 0 || startDateMax.trim().length > 0 || endDateMin.trim().length > 0 || endDateMax.trim().length > 0) {
            
            if (eventTypeUri === undefined && $("#eventSearchForm input[name='eventTypeUri']").val().length > 0) {
                $("#eventSearchForm input[name='eventTypeUri']").addClass("invalid");
            }
            
            if (locationUri === undefined && $("#eventSearchForm input[name='locationUri']").val().length > 0) {
                $("#eventSearchForm input[name='locationUri']").addClass("invalid");
            }
            
            $("p.resultHeader").html("Fetching data.. please wait");
            $(".allResults").html("");
            jQuery.ajax({
                method: 'get',
                url: "search/events",
                dataType: "json",
                data: sendingData,
                success: function (data) {
                    var count = 0,
                        title,
                        result,
                        prop;
                    for (prop in data) {
                        if (data.hasOwnProperty(prop)) {
                            count += 1;
                        }
                    }
                    $("p.resultHeader").html("There are " + count + " results based on your latest query.");
                    $.each(data, function (key, val) {
                        result = '<div class="col-lg-6 col-md-6 col-sm-12">' +
                            '<div class="resultWrapper">' +
                            '<p>Type: <span class="type">Event</span></p>' +
                            '<p>Name: <span class="name">' + val.title + '</span></p>';
                        if(val.locations) {
                            result += '<p>Locations: <span>';
                            comaCheck = false;
                            $.each(val.locations, function (key2, val2) {
                                result += (comaCheck ? ', ' : ' ') + val2;
                                comaCheck = true;
                            });
                            result += '</span></p>';
                        }
                        result += '<a target="_blank" href="' + val.link + '"> Original Link</a>' +
                            '<button type="button" class="addToList"><span class="glyphicon glyphicon-plus"></span></button>' +
                            '<button type="button" class="removeResult"><span class="glyphicon glyphicon-minus"></span></button></div></div>';
                        $(".allResults").append(result);
                    });
                },
                error: function (data) {
                    $("p.resultHeader").html("Something wrong happened. Please try again.");
                }
            });
        }
    });
    $("#personSearchForm .btn").click(function (e) {
        e.preventDefault();
        $("#personSearchForm input").removeClass("invalid");
        var personCountry = countries[$("#personSearchForm input[name='personCountry']").val().split(" ").join("_")],
            personProfession = professions[$("#personSearchForm input[name='personProfession']").val().split(" ").join("_")],
            personName = $("#personSearchForm input[name='personName']").val(),
            sendingData = {
                personName: personName,
                personProfession: personProfession,
                personCountry: personCountry,
            },
            result;
        if (personCountry !== undefined || personName.trim().length > 0 || personProfession !== undefined) {
            
            if (personProfession === undefined && $("#personSearchForm input[name='personProfession']").val().length > 0) {
                $("#personSearchForm input[name='personProfession']").addClass("invalid");
            }
            
            if (personCountry === undefined && $("#personSearchForm input[name='personCountry']").val().length > 0) {
                $("#personSearchForm input[name='personCountry']").addClass("invalid");
            }
            
            $("p.resultHeader").html("Fetching data.. please wait");
            $(".allResults").html("");
            jQuery.ajax({
                method: 'get',
                url: "search/people",
                dataType: "json",
                data: sendingData,
                success: function (data) {
                    var count = 0,
                        title,
                        result,
                        prop;
                    for (prop in data) {
                        if (data.hasOwnProperty(prop)) {
                            count += 1;
                        }
                    }
                    $("p.resultHeader").html("There are " + count + " results based on your latest query.");
                    $.each(data, function (key, val) {
                        result = '<div class="col-lg-6 col-md-6 col-sm-12">' +
                            '<div class="resultWrapper">' +
                            '<p>Type: <span class="type">Person</span></p>' +
                            '<p>Name: <span class="name">' + val.name + '</span></p>' +
                            '<p>Profession: <span class="profession">' + val.profession.name + '</span></p>' +
                            '<p>Country: <span class="profession">' + val.country.name + '</span></p>' +
                            '<a target="_blank" href="' + val.link + '"> Original Link</a>' +
                            '<button type="button" class="addToList"><span class="glyphicon glyphicon-plus"></span></button>' +
                            '<button type="button" class="removeResult"><span class="glyphicon glyphicon-minus"></span></button></div></div>';
                        $(".allResults").append(result);
                    });
                },
                error: function (data) {
                    $("p.resultHeader").html("Something wrong happened. Please try again.");
                }
            });
        }
    });
    $("#bookSearchForm .btn").click(function (e) {
        e.preventDefault();
        $("#bookSearchForm input").removeClass("invalid");
        var illustratorUri = illustrators[$("#bookSearchForm input[name='illustratorUri']").val().split(" ").join("_")],
            authorUri = authors[$("#bookSearchForm input[name='authorUri']").val().split(" ").join("_")],
            titleName = $("#bookSearchForm input[name='name']").val(),
            literaryGenreUri = literaryGenres[$("#bookSearchForm input[name='literaryGenreUri']").val().split(" ").join("_")],
            numberOfPagesMin = $("#bookSearchForm input[name='numberOfPagesMin']").val(),
            numberOfPagesMax = $("#bookSearchForm input[name='numberOfPagesMax']").val(),
            numberOfVolumes = $("#bookSearchForm input[name='numberOfVolumes']").val(),
            sendingData = {
                name: titleName,
                illustratorUri: illustratorUri,
                authorUri: authorUri,
                literaryGenreUri: literaryGenreUri,
                numberOfPagesMin: numberOfPagesMin,
                numberOfPagesMax: numberOfPagesMax,
                numberOfVolumes: numberOfVolumes
            },
            result;
        if (authorUri !== undefined || titleName.trim().length > 0 || literaryGenreUri !== undefined || illustratorUri !== undefined || numberOfPagesMin.trim().length > 0 || numberOfPagesMax.trim().length > 0 || numberOfVolumes.trim().length > 0) {
            
            if (illustratorUri === undefined && $("#bookSearchForm input[name='illustratorUri']").val().length > 0) {
                $("#bookSearchForm input[name='illustratorUri']").addClass("invalid");
            }
            
            if (literaryGenreUri === undefined && $("#bookSearchForm input[name='literaryGenreUri']").val().length > 0) {
                $("#bookSearchForm input[name='literaryGenreUri']").addClass("invalid");
            }
            
            if (authorUri === undefined && $("#bookSearchForm input[name='authorUri']").val().length > 0) {
                $("#bookSearchForm input[name='authorUri']").addClass("invalid");
            }
            
            $("p.resultHeader").html("Fetching data.. please wait");
            $(".allResults").html("");
            jQuery.ajax({
                method: 'get',
                url: "search/books",
                dataType: "json",
                data: sendingData,
                success: function (data) {
                    var count = 0,
                        title,
                        result,
                        prop;
                    for (prop in data) {
                        if (data.hasOwnProperty(prop)) {
                            count += 1;
                        }
                    }
                    $("p.resultHeader").html("There are " + count + " results based on your latest query.");
                    $.each(data, function (key, val) {
                        result = '<div class="col-lg-6 col-md-6 col-sm-12">' +
                            '<div class="resultWrapper">' +
                            '<p>Type: <span class="type">Book</span></p>' +
                            '<p>Name: <span class="name">' + val.title + '</span></p>';
                        
                        if(val.authors) {
                            $.each(val.authors, function (key2, val2) {
                                result += '<p>Author: <span class="releaseDate">' + val2 + '</span></p>';
                            });
                        }
                        if(val.releaseDate) {
                            if(typeof val.releaseDate === 'object') {
                                result += '<p>Name: <span class="releaseDate">' + val.releaseDate.date.split(" ")[0] + '</span></p>';
                            }
                            if(typeof val.releaseDate !== 'object') {
                                result += '<p>Year: <span class="releaseDate">' + val.releaseDate + '</span></p>';
                            }
                        }
                        result += '<a target="_blank" href="' + val.link + '"> Original Link</a>' +
                            '<button type="button" class="addToList"><span class="glyphicon glyphicon-plus"></span></button>' +
                            '<button type="button" class="removeResult"><span class="glyphicon glyphicon-minus"></span></button></div></div>';
                        $(".allResults").append(result);
                    });
                },
                error: function (data) {
                    $("p.resultHeader").html("Something wrong happened. Please try again.");
                }
            });
        }
    });
    $("#placeSearchForm .btn").click(function (e) {
        e.preventDefault();
        $("#placeSearchForm input").removeClass("invalid");
        var countryURI = countries[$("#placeSearchForm input[name='countryUri']").val().split(" ").join("_")],
            placeTypeURI = placeTypes[$("#placeSearchForm input[name='placeTypeUri']").val().split(" ").join("_")],
            placeName = $("#placeSearchForm input[name='name']").val(),
            sendingData = {
                name: placeName,
                placeTypeUri: placeTypeURI,
                countryUri: countryURI
            },
            result;
        if ((placeTypeURI !== undefined || countryURI !== undefined) || placeName.trim().length > 0) {
            if (placeTypeURI === undefined && $("#placeSearchForm input[name='placeTypeUri']").val().length > 0) {
                $("#placeSearchForm input[name='placeTypeUri']").addClass("invalid");
            }
            if (countryURI === undefined && $("#placeSearchForm input[name='countryUri']").val().length > 0) {
                $("#placeSearchForm input[name='countryUri']").addClass("invalid");
            }
            $("p.resultHeader").html("Fetching data.. please wait");
            $(".allResults").html("");
            jQuery.ajax({
                method: 'get',
                url: "search/places",
                dataType: "json",
                data: sendingData,
                success: function (data) {
                    var count = 0,
                        title,
                        result,
                        prop;
                    for (prop in data) {
                        if (data.hasOwnProperty(prop)) {
                            count += 1;
                        }
                    }
                    $("p.resultHeader").html("There are " + count + " results based on your latest query.");
                    $.each(data, function (key, val) {
                        result = '<div class="col-lg-6 col-md-6 col-sm-12">' +
                            '<div class="resultWrapper">' +
                            '<p>Type: <span class="type">Place</span></p>' +
                            '<p>Name: <span class="name">' + val.title + '</span></p>';
                        if (val.countries) {
                            $.each(val.countries, function (key2, val2) {
                                result += '<p>Country: ' + val2 + '</p>';
                            });
                        }
                        result += '<a target="_blank" href="' + val.link + '"> Original Link</a>' +
                            '<button type="button" class="addToList"><span class="glyphicon glyphicon-plus"></span></button>' +
                            '<button type="button" class="removeResult"><span class="glyphicon glyphicon-minus"></span></button></div></div>';
                        $(".allResults").append(result);
                    });
                },
                error: function (data) {
                    $("p.resultHeader").html("Something wrong happened. Please try again.");
                }
            });
        }
    });
    
});