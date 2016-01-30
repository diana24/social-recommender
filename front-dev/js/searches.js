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
        readyCount = 0,
        actors = {},
        directors = {},
        movieGenres = {},
        languages = {},
        musicalArtists = {},
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

    
    $("#bookInitialize").click(function() {
        var stop = false;
        $.each($(".initializeWrapper"), function(index,value) { 
            if (!$(value).hasClass("hidden")) {
                stop = true;
            }
        });
        if(!stop) {
            $("#bookInitialize").unbind().remove();
            $("#bookPanel .initializeWrapper").removeClass("hidden");
            readyCount += 3;
            getData("/getAuthors", authors, ["authorUri"], "authors", true, "#bookPanel .initializeWrapper", "#bookSearchForm");
            getData("/getIllustrators", illustrators, ["illustratorUri"], "illustrators", true, "#bookPanel .initializeWrapper", "#bookSearchForm");
            getData("/getLiteraryGenres", literaryGenres, ["literaryGenreUri"], "literary genres", false, "#bookPanel .initializeWrapper", "#bookSearchForm");
        }
    });
    $("#placeInitialize").click(function() {
        var stop = false;
        $.each($(".initializeWrapper"), function(index,value) { 
            if (!$(value).hasClass("hidden")) {
                stop = true;
            }
        });
        if(!stop) {
            $("#placeInitialize").unbind().remove();
            $("#placePanel .initializeWrapper").removeClass("hidden");
            readyCount += 2;
            getData("/getPlaceTypes", placeTypes, ["placeTypeUri"], "place types", false, "#placePanel .initializeWrapper", "#placeSearchForm");
            getData("/getCountries", countries, ["countryUri"], "countries", false, "#placePanel .initializeWrapper", "#placeSearchForm");
        }
    });
    $("#instituteInitialize").click(function() {
        var stop = false;
        $.each($(".initializeWrapper"), function(index,value) { 
            if (!$(value).hasClass("hidden")) {
                stop = true;
            }
        });
        if(!stop) {
            $("#instituteInitialize").unbind().remove();
            $("#institutePanel .initializeWrapper").removeClass("hidden");
            readyCount += 4;
            getData("/getEduInstitutionTypes", institutionTypes, ["eduTypeUri"], "educational institution types", false, "#institutePanel .initializeWrapper", "#instituteSearchForm");
            getData("/getCountries", countries, ["countryUri"], "countries", false, "#institutePanel .initializeWrapper", "#instituteSearchForm");
            getData("/getPrincipals", principals, ["principalUri"], "principals", true, "#institutePanel .initializeWrapper", "#instituteSearchForm");
            getData("/getRectors", rectors, ["rectorUri"], "rectors", true, "#institutePanel .initializeWrapper", "#instituteSearchForm");
        }
    });
    $("#filmInitialize").click(function() {
        var stop = false;
        $.each($(".initializeWrapper"), function(index,value) { 
            if (!$(value).hasClass("hidden")) {
                stop = true;
            }
        });
        if(!stop) {
            $("#filmInitialize").unbind().remove();
            $("#filmPanel .initializeWrapper").removeClass("hidden");
            readyCount += 6;
            getData("/getDirectors",directors, ["directorUri"], "directors", true, "#filmPanel .initializeWrapper", "#filmSearchForm");
            getData("/getActors",actors, ["actorUri"], "actors", true, "#filmPanel .initializeWrapper", "#filmSearchForm");
            getData("/getCountries", countries, ["countryUri"], "countries", false, "#filmPanel .initializeWrapper", "#filmSearchForm");
            getData("/getMovieGenres", movieGenres, ["movieGenreUri"], "movieGenres", true, "#filmPanel .initializeWrapper", "#filmSearchForm");
            getData("/getLanguages", languages, ["originalLanguageUri"], "languages", true, "#filmPanel .initializeWrapper", "#filmSearchForm");
            getData("/getMusicalArtists", musicalArtists, ["musicalArtistUri"], "musicalArtists", true, "#filmPanel .initializeWrapper", "#filmSearchForm");
        }
    });   
    
    $("#filmSearchForm .btn").click(function (e) {
        e.preventDefault();
        $("#filmSearchForm input").removeClass("invalid");
        var actorUri = actors[$("#filmSearchForm input[name='actorUri']").val().split(" ").join("_")],
            directorUri = directors[$("#filmSearchForm input[name='directorUri']").val().split(" ").join("_")],
            countryUri = countries[$("#filmSearchForm input[name='countryUri']").val().split(" ").join("_")],
            movieGenreUri = movieGenres[$("#filmSearchForm input[name='movieGenreUri']").val().split(" ").join("_")],
            originalLanguageUri = languages[$("#filmSearchForm input[name='originalLanguageUri']").val().split(" ").join("_")],
            musicalArtistUri = musicalArtists[$("#filmSearchForm input[name='musicalArtistUri']").val().split(" ").join("_")],
            name = $("#filmSearchForm input[name='name']").val(),
            sendingData = {
                name: name,
                actorUri: actorUri,
                directorUri: directorUri,
                countryUri: countryUri,
                movieGenreUri: movieGenreUri,
                originalLanguageUri: originalLanguageUri,
                musicalArtistUri: musicalArtistUri
            },
            comaCheck,
            result;
        if (directorUri !== undefined || countryUri !== undefined || movieGenreUri !== undefined || name.trim().length > 0 || originalLanguageUri !== undefined || musicalArtistUri !== undefined || actorUri !== undefined) {
            
            if (directorUri === undefined && $("#filmSearchForm input[name='directorUri']").val().length > 0) {
                $("#filmSearchForm input[name='directorUri']").addClass("invalid");
            }
            if (countryUri === undefined && $("#filmSearchForm input[name='countryUri']").val().length > 0) {
                $("#filmSearchForm input[name='countryUri']").addClass("invalid");
            }
            if (movieGenreUri === undefined && $("#filmSearchForm input[name='movieGenreUri']").val().length > 0) {
                $("#filmSearchForm input[name='movieGenreUri']").addClass("invalid");
            }
            if (originalLanguageUri === undefined && $("#filmSearchForm input[name='originalLanguageUri']").val().length > 0) {
                $("#filmSearchForm input[name='originalLanguageUri']").addClass("invalid");
            }
            if (musicalArtistUri === undefined && $("#filmSearchForm input[name='musicalArtistUri']").val().length > 0) {
                $("#filmSearchForm input[name='musicalArtistUri']").addClass("invalid");
            }
            if (actorUri === undefined && $("#filmSearchForm input[name='actorUri']").val().length > 0) {
                $("#filmSearchForm input[name='actorUri']").addClass("invalid");
            }
            $("p.resultHeader").html("Fetching data.. please wait");
            $(".allResults").html("");
            jQuery.ajax({
                method: 'get',
                url: "search/films",
                dataType: "json",
                data: sendingData,
                success: function (data) {
                    var count = 0,
                        title,
                        result,
                        comaCheck,
                        limitCheck,
                        saveData,
                        prop;
                    for (prop in data) {
                        if (data.hasOwnProperty(prop)) {
                            count += 1;
                        }
                    }
                    $("p.resultHeader").html("There are " + count + " results based on your latest query.");
                    $.each(data, function (key, val) {
                        saveData = {
                            type: 'Film',
                        };
                        saveData[key] = val;
                        result = '<div class="col-lg-6 col-md-6 col-sm-12">' +
                            '<div class="resultWrapper">' +
                            '<p>Type: <span class="type">Film</span></p>' +
                            '<p>Name: <span class="name">' + val.title + '</span></p>';
                        if(val.directors) {
                            result += '<p>Directors: <span>';
                            $.each(val.directors, function (key2, val2) {
                                result += val2;
                            });
                            result += '</span></p>';
                        }
                        if(val.composers) {
                            limitCheck = 0;
                            result += '<p>Composers: <span>';
                            comaCheck = false;
                            $.each(val.composers, function (key3, val3) {
                                if(limitCheck < 3) {
                                    result += (comaCheck ? ', ' : ' ') + val3;
                                    comaCheck = true;
                                    limitCheck += 1;
                                }
                            });
                            result += '</span></p>';
                        }
                        if(val.actors) {
                            limitCheck = 0;
                            result += '<p>Actors: <span>';
                            comaCheck = false;
                            $.each(val.actors, function (key3, val3) {
                                if(limitCheck < 3) {
                                    result += (comaCheck ? ', ' : ' ') + val3;
                                    comaCheck = true;
                                    limitCheck += 1;
                                }
                            });
                            result += '</span></p>';
                        }
                        result += '<a target="_blank" href="' + val.link + '"> Original Link</a></div></div>';
                        $(".allResults").append(result);
                    });
                    addToRemoveFromList();
                },
                error: function (data) {
                    $("p.resultHeader").html("Something wrong happened. Please try again.");
                }
            });
        }
    });    
    $("#instituteSearchForm .btn").click(function (e) {
        e.preventDefault();
        $("#instituteSearchForm input").removeClass("invalid");
        var eduTypeUri = institutionTypes[$("#instituteSearchForm input[name='eduTypeUri']").val().split(" ").join("_")],
            countryUri = countries[$("#instituteSearchForm input[name='countryUri']").val().split(" ").join("_")],
            rectorUri = rectors[$("#instituteSearchForm input[name='rectorUri']").val().split(" ").join("_")],
            principalUri = principals[$("#instituteSearchForm input[name='principalUri']").val().split(" ").join("_")],
            name = $("#instituteSearchForm input[name='name']").val(),
            nrOfAcademicStaffMin = $("#instituteSearchForm input[name='nrOfAcademicStaffMin']").val(),
            nrOfAcademicStaffMax = $("#instituteSearchForm input[name='nrOfAcademicStaffMax']").val(),
            nrOfStudentsMin = $("#instituteSearchForm input[name='nrOfStudentsMin']").val(),
            nrOfStudentsMax = $("#instituteSearchForm input[name='nrOfStudentsMax']").val(),
            sendingData = {
                name: name,
                eduTypeUri: eduTypeUri,
                countryUri: countryUri,
                rectorUri: rectorUri,
                principalUri: principalUri,
                nrOfAcademicStaffMin: nrOfAcademicStaffMin,
                nrOfAcademicStaffMax: nrOfAcademicStaffMax,
                nrOfStudentsMin: nrOfStudentsMin,
                nrOfStudentsMax: nrOfStudentsMax
            },
            comaCheck,
            result;
        if (rectorUri !== undefined || principalUri !== undefined || eduTypeUri !== undefined || countryUri !== undefined || name.trim().length > 0 || nrOfAcademicStaffMin.trim().length > 0 || nrOfAcademicStaffMax.trim().length > 0 || nrOfStudentsMin.trim().length > 0 || nrOfStudentsMax.trim().length > 0) {
            
            if (rectorUri === undefined && $("#instituteSearchForm input[name='rectorUri']").val().length > 0) {
                $("#instituteSearchForm input[name='rectorUri']").addClass("invalid");
            }
            if (countryUri === undefined && $("#instituteSearchForm input[name='countryUri']").val().length > 0) {
                $("#instituteSearchForm input[name='countryUri']").addClass("invalid");
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
                            comaCheck = false;
                            $.each(val.countries, function (key2, val2) {
                                result += (comaCheck ? ', ' : ' ') + val2;
                                comaCheck = true;
                            });
                            result += '</span></p>';
                        }
                        result += '<a target="_blank" href="' + val.link + '"> Original Link</a></div></div>';
                        $(".allResults").append(result);
                    });
                    addToRemoveFromList();
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
                        result += '<a target="_blank" href="' + val.link + '"> Original Link</a></div></div>';
                        $(".allResults").append(result);
                    });
                    addToRemoveFromList();
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
                        result += '<a target="_blank" href="' + val.link + '"> Original Link</a></div></div>';
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