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
        readyCheck = 0,
        readyCount = 9;
    $("p.resultHeader").html("Fetching initial data..");
    $(".allResults").html("");
    jQuery.ajax({
        method: 'get',
        url: "/getEduInstitutionTypes",
        dataType: "json",
        success: function (data) {
            var autocompleteValues = [],
                key;
            for (key in data) {
                autocompleteValues.push(data[key].name);
                institutionTypes[data[key].name.split(" ").join("_")] = data[key].uri;
            }
            $("input[name='eduTypeUri']").autocomplete({
                source: autocompleteValues
            });
            readyCheck += 1;
            $(".allResults").append("<p class='log info'>Added autocomplete educational institution types</p>");
            if (readyCheck === readyCount) {
                $(".loader").remove();
                $("#accordion").removeClass("hidden");
                $("p.resultHeader").html("Initial fetch complete!");
                $(".allResults").append("You may now use the search bar!");
            }
        },
        error: function () {
            readyCheck += 1;
            $(".allResults").append("<p class='log error'>Error: Autocomplete educational institution types failed.. disabling field..</p>");
            $("input[name='eduTypeUri']").attr("disabled", "disabled");
            if (readyCheck === readyCount) {
                $(".loader").remove();
                $("#accordion").removeClass("hidden");
                $("p.resultHeader").html("Initial fetch complete!");
                $(".allResults").append("You may now use the search bar!");
            }
        }
    });
    jQuery.ajax({
        method: 'get',
        url: "/getPlaces",
        data: {
            name: ""
        },
        dataType: "json",
        success: function (data) {
            var autocompleteValues = [],
                key;
            for (key in data) {
                autocompleteValues.push(data[key].name);
                locations[data[key].name.split(" ").join("_")] = data[key].uri;
            }
            $("input[name='locationUri']").autocomplete({
                source: autocompleteValues
            });
            readyCheck += 1;
            $(".allResults").append("<p class='log info'>Added autocomplete locations</p>");
            if (readyCheck === readyCount) {
                $(".loader").remove();
                $("#accordion").removeClass("hidden");
                $("p.resultHeader").html("Initial fetch complete!");
                $(".allResults").append("You may now use the search bar!");
            }
        },
        error: function () {
            readyCheck += 1;
            $(".allResults").append("<p class='log error'>Error: Autocomplete locations failed.. disabling field..</p>");
            $("input[name='locationUri']").attr("disabled", "disabled");
            if (readyCheck === readyCount) {
                $(".loader").remove();
                $("#accordion").removeClass("hidden");
                $("p.resultHeader").html("Initial fetch complete!");
                $(".allResults").append("You may now use the search bar!");
            }
        }
    });
    jQuery.ajax({
        method: 'get',
        url: "/getEventTypes",
        dataType: "json",
        success: function (data) {
            var autocompleteValues = [],
                key;
            for (key in data) {
                autocompleteValues.push(data[key].name);
                eventTypes[data[key].name.split(" ").join("_")] = data[key].uri;
            }
            $("input[name='eventTypeUri']").autocomplete({
                source: autocompleteValues
            });
            readyCheck += 1;
            $(".allResults").append("<p class='log info'>Added autocomplete event types</p>");
            if (readyCheck === readyCount) {
                $(".loader").remove();
                $("#accordion").removeClass("hidden");
                $("p.resultHeader").html("Initial fetch complete!");
                $(".allResults").append("You may now use the search bar!");
            }
        },
        error: function () {
            readyCheck += 1;
            $(".allResults").append("<p class='log error'>Error: Autocomplete event types failed.. disabling field..</p>");
            $("input[name='eventTypeUri']").attr("disabled", "disabled");
            if (readyCheck === readyCount) {
                $(".loader").remove();
                $("#accordion").removeClass("hidden");
                $("p.resultHeader").html("Initial fetch complete!");
                $(".allResults").append("You may now use the search bar!");
            }
        }
    });
    jQuery.ajax({
        method: 'get',
        url: "/getLiteraryGenres",
        dataType: "json",
        success: function (data) {
            var autocompleteValues = [],
                key;
            for (key in data) {
                autocompleteValues.push(data[key].name);
                literaryGenres[data[key].name.split(" ").join("_")] = data[key].uri;
            }
            $("input[name='literaryGenreUri']").autocomplete({
                source: autocompleteValues
            });
            readyCheck += 1;
            $(".allResults").append("<p class='log info'>Added autocomplete literary genres</p>");
            if (readyCheck === readyCount) {
                $(".loader").remove();
                $("#accordion").removeClass("hidden");
                $("p.resultHeader").html("Initial fetch complete!");
                $(".allResults").append("You may now use the search bar!");
            }
        },
        error: function () {
            readyCheck += 1;
            $(".allResults").append("<p class='log error'>Error: Autocomplete literary genres failed.. disabling field..</p>");
            $("input[name='literaryGenreUri']").attr("disabled", "disabled");
            if (readyCheck === readyCount) {
                $(".loader").remove();
                $("#accordion").removeClass("hidden");
                $("p.resultHeader").html("Initial fetch complete!");
                $(".allResults").append("You may now use the search bar!");
            }
        }
    });
    jQuery.ajax({
        method: 'get',
        url: "/getIllustrators",
        dataType: "json",
        data: {
            name: ""
        },
        success: function (data) {
            var autocompleteValues = [],
                key;
            for (key in data) {
                autocompleteValues.push(data[key].name);
                illustrators[data[key].name.split(" ").join("_")] = data[key].uri;
            }
            $("input[name='illustratorUri']").autocomplete({
                source: autocompleteValues
            });
            readyCheck += 1;
            $(".allResults").append("<p class='log info'>Added autocomplete illustrators</p>");
            if (readyCheck === readyCount) {
                $(".loader").remove();
                $("#accordion").removeClass("hidden");
                $("p.resultHeader").html("Initial fetch complete!");
                $(".allResults").append("You may now use the search bar!");
            }
        },
        error: function () {
            readyCheck += 1;
            $(".allResults").append("<p class='log error'>Error: Autocomplete illustrators fetch failed.. disabling field..</p>");
            $("input[name='illustratorUri']").attr("disabled", "disabled");
            if (readyCheck === readyCount) {
                $(".loader").remove();
                $("#accordion").removeClass("hidden");
                $("p.resultHeader").html("Initial fetch complete!");
                $(".allResults").append("You may now use the search bar!");
            }
        }
    });
    jQuery.ajax({
        method: 'get',
        url: "/getAuthors",
        dataType: "json",
        data: {
            name: ""
        },
        success: function (data) {
            var autocompleteValues = [],
                key;
            for (key in data) {
                autocompleteValues.push(data[key].name);
                authors[data[key].name.split(" ").join("_")] = data[key].uri;
            }
            $("input[name='authorUri']").autocomplete({
                source: autocompleteValues
            });
            readyCheck += 1;
            $(".allResults").append("<p class='log info'>Added autocomplete authors</p>");
            if (readyCheck === readyCount) {
                $(".loader").remove();
                $("#accordion").removeClass("hidden");
                $("p.resultHeader").html("Initial fetch complete!");
                $(".allResults").append("You may now use the search bar!");
            }
        },
        error: function () {
            readyCheck += 1;
            $(".allResults").append("<p class='log error'>Error: Autocomplete authors fetch failed.. disabling field..</p>");
            $("input[name='authorUri']").attr("disabled", "disabled");
            if (readyCheck === readyCount) {
                $(".loader").remove();
                $("#accordion").removeClass("hidden");
                $("p.resultHeader").html("Initial fetch complete!");
                $(".allResults").append("You may now use the search bar!");
            }
        }
    });
    jQuery.ajax({
        method: 'get',
        url: "/getPlaceTypes",
        dataType: "json",
        success: function (data) {
            var autocompleteValues = [],
                key;
            for (key in data) {
                autocompleteValues.push(data[key].name);
                placeTypes[data[key].name.split(" ").join("_")] = data[key].uri;
            }
            $("input[name='placeTypeUri']").autocomplete({
                source: autocompleteValues
            });
            readyCheck += 1;
            $(".allResults").append("<p class='log info'>Added autocomplete place types</p>");
            if (readyCheck === readyCount) {
                $(".loader").remove();
                $("#accordion").removeClass("hidden");
                $("p.resultHeader").html("Initial fetch complete!");
                $(".allResults").append("You may now use the search bar!");
            }
        },
        error: function () {
            readyCheck += 1;
            $(".allResults").append("<p class='log error'>Error: Autocomplete place types fetch failed.. disabling field..</p>");
            $("input[name='placeTypeUri']").attr("disabled", "disabled");
            if (readyCheck === readyCount) {
                $(".loader").remove();
                $("#accordion").removeClass("hidden");
                $("p.resultHeader").html("Initial fetch complete!");
                $(".allResults").append("You may now use the search bar!");
            }
        }
    });
    jQuery.ajax({
        method: 'get',
        url: "/getCountries",
        dataType: "json",
        success: function (data) {
            var autocompleteValues = [],
                key;
            for (key in data) {
                autocompleteValues.push(data[key].name);
                countries[data[key].name.split(" ").join("_")] = data[key].uri;
            }
            $("input[name='countryUri']").autocomplete({
                source: autocompleteValues
            });
            $("input[name='personCountry']").autocomplete({
                source: autocompleteValues
            });
            readyCheck += 1;
            $(".allResults").append("<p class='log info'>Added autocomplete countries</p>");
            if (readyCheck === readyCount) {
                $(".loader").remove();
                $("#accordion").removeClass("hidden");
                $("p.resultHeader").html("Initial fetch complete!");
                $(".allResults").append("You may now use the search bar!");
            }
            
        },
        error: function () {
            readyCheck += 1;
            $(".allResults").append("<p class='log error'>Error: Autocomplete countries fetch failed.. disabling field..</p>");
            $("input[name='countryUri']").attr("disabled", "disabled");
            if (readyCheck === readyCount) {
                $(".loader").remove();
                $("#accordion").removeClass("hidden");
                $("p.resultHeader").html("Initial fetch complete!");
                $(".allResults").append("You may now use the search bar!");
            }
        }
    });
    jQuery.ajax({
        method: 'get',
        url: "/getProfessions",
        dataType: "json",
        success: function (data) {
            var autocompleteValues = [],
                key;
            for (key in data) {
                autocompleteValues.push(data[key].name);
                professions[data[key].name.split(" ").join("_")] = data[key].uri;
            }
            $("input[name='personProfession']").autocomplete({
                source: autocompleteValues
            });
            readyCheck += 1;
            $(".allResults").append("<p class='log info'>Added autocomplete professions</p>");
            if (readyCheck === readyCount) {
                $(".loader").remove();
                $("#accordion").removeClass("hidden");
                $("p.resultHeader").html("Initial fetch complete!");
                $(".allResults").append("You may now use the search bar!");
            }
            
        },
        error: function () {
            readyCheck += 1;
            $(".allResults").append("<p class='log error'>Error: Autocomplete professions fetch failed.. disabling field..</p>");
            $("input[name='countryUri']").attr("disabled", "disabled");
            if (readyCheck === readyCount) {
                $(".loader").remove();
                $("#accordion").removeClass("hidden");
                $("p.resultHeader").html("Initial fetch complete!");
                $(".allResults").append("You may now use the search bar!");
            }
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
                    console.log(data);
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
        if (authorUri === undefined || titleName.trim().length > 0 || literaryGenreUri === undefined || illustratorUri === undefined || numberOfPagesMin.trim().length > 0 || numberOfPagesMax.trim().length > 0 || numberOfVolumes.trim().length > 0) {
            
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
                    console.log(data);
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