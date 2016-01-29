$(document).on('ready', function() {
    var placeTypes = {},
        countries = {},
        readyCheck = 0;
    jQuery.ajax({
        method: 'get',
        url: "/getPlaceTypes",
        dataType: "json",
        success: function(data) {
            var autocompleteValues = [];
            for (var key in data) {
                autocompleteValues.push(data[key].name);
                placeTypes[data[key].name.split(" ").join("_")] = data[key].uri;
            }
            $("input[name='placeTypeUri']").autocomplete({
                source: autocompleteValues
            });
            readyCheck += 1;
            if(readyCheck == 2) {
                $(".loader").remove();
                $("#accordion").removeClass("hidden");
            }
        },
        error: function() {
            readyCheck += 1;
            if(readyCheck == 2) {
                $(".loader").remove();
                $("#accordion").removeClass("hidden");
            }
        }
    });
    jQuery.ajax({
        method: 'get',
        url: "/getCountries",
        dataType: "json",
        success: function(data) {
            var autocompleteValues = [];
            for (var key in data) {
                autocompleteValues.push(data[key].name);
                countries[data[key].name.split(" ").join("_")] = data[key].uri;
            }
            $("input[name='countryUri']").autocomplete({
                source: autocompleteValues
            });
            readyCheck += 1;
            if(readyCheck == 2) {
                $(".loader").remove();
                $("#accordion").removeClass("hidden");
            }
        },
        error: function() {
            readyCheck += 1;
            if(readyCheck == 2) {
                $(".loader").remove();
                $("#accordion").removeClass("hidden");
            }
        }
    });

    $("#placeSearchForm .btn").click(function(e) {
        e.preventDefault();
        $("#placeSearchForm input[name='countryUri']").removeClass("invalid");
        $("#placeSearchForm input[name='placeTypeUri']").removeClass("invalid");
        var countryURI = countries[$("#placeSearchForm input[name='countryUri']").val().split(" ").join("_")],
            placeTypeURI = placeTypes[$("#placeSearchForm input[name='placeTypeUri']").val().split(" ").join("_")],
            sendingData = {
                name: $("#placeSearchForm input[name='name']").val(),
                placeTypeUri:placeTypeURI,
                countryUri: countryURI
            };
        console.log(sendingData);
        if(countryURI === undefined) {
            $("#placeSearchForm input[name='countryUri']").addClass("invalid");
        }
        if(placeTypeURI === undefined) {
            $("#placeSearchForm input[name='placeTypeUri']").addClass("invalid");
        } 
        if(placeTypeURI !== undefined && countryURI !== undefined) {
            $("p.resultHeader").html("Fetching data.. please wait");
            $(".allResults").html("");
            jQuery.ajax({
                method: 'get',
                url: "search/places",
                dataType: "json",
                data: sendingData,
                success: function(data) {
                    var count = 0,
                        title,
                        result;
                    for(var prop in data) {
                        if(data.hasOwnProperty(prop)) {
                            ++count;
                        }
                    }
                    $("p.resultHeader").html("There are " + count + " results based on your latest query.");
                    console.log(data);
                    $(data).each(function(key, val) {
                        title = val.title;
                        console.log(title);
                        /*
                        result = '<div class="col-lg-6 col-md-6 col-sm-12">' +
                            '<div class="resultWrapper">' + '
                            '<p>Type: <span class="type">Place</span></p>' +
                            '<p>Name: <span class="name">' + title + '</span></p>' +
                            '<button type="button" class="addToList"><span class="glyphicon glyphicon-plus"></span></button>' +
                            '<button type="button" class="removeResult"><span class="glyphicon glyphicon-minus"></span></button></div></div>';
                        $(".allResults").append(result);*/
                    });
                },
                error: function(data) {
                    console.log("error");
                }
            }); 
        }
    });
    
});