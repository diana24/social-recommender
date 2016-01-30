$(document).ready(function() {
    var bookRecommendations="",
        eventRecommendations="",
        filmRecommendations="",
        eduRecommendations="",
        addToRemoveFromList = function() {
            $(".addToList").click(function() {
                jQuery.ajax({
                    method: 'post',
                    url: "result/favorite",
                    dataType: "json",
                    data: $(this).attr("data"),
                    success: function (data) {
                    },
                    error: function(data) {
                        console.log("error");
                    }
                });
            });
            $(".removeResult").click(function() {
                jQuery.ajax({
                    method: 'post',
                    url: "result/remove",
                    dataType: "json",
                    data: $(this).attr("data"),
                    success: function (data) {
                    },
                    error: function(data) {
                        console.log("error");
                    }
                });
            });
        },;
    $("#book").click(function() {
        if($(".recomloading").hasClass("hidden")) {
            $(".recomloading").removeClass("hidden");
            if(bookRecommendations !== "") {
                $(".recomloading").addClass("hidden");
                $(".allResults").html(bookRecommendations);
                addToRemoveFromList();
            } else {
                jQuery.ajax({
                    method: 'get',
                    url: "recommendations/books",
                    dataType: "json",
                    success: function (data) {
                        $(".recomloading").addClass("hidden");
                        $.each(data, function (key, val) {
                            bookRecommendations += '<div class="col-lg-4 col-md-6 col-sm-12">' +
                                '<div class="resultWrapper">' +
                                '<p>Type: <span class="type">Book</span></p>' +
                                '<p>Name: <span class="name">' + val.title + '</span></p>';

                            if(val.authors) {
                                $.each(val.authors, function (key2, val2) {
                                    bookRecommendations += '<p>Author: <span class="releaseDate">' + val2 + '</span></p>';
                                });
                            }
                            if(val.releaseDate) {
                                if(typeof val.releaseDate === 'object') {
                                    bookRecommendations += '<p>Name: <span class="releaseDate">' + val.releaseDate.date.split(" ")[0] + '</span></p>';
                                }
                                if(typeof val.releaseDate !== 'object') {
                                    bookRecommendations += '<p>Year: <span class="releaseDate">' + val.releaseDate + '</span></p>';
                                }
                            }
                            bookRecommendations += '<a target="_blank" href="' + val.link + '"> Original Link</a>' +
                                '<button type="button" class="addToList" data="' + JSON.stringify(saveData) + '"><span class="glyphicon glyphicon-plus"></span></button>' +
                            '<button type="button" class="removeResult" data="' + JSON.stringify(saveData) + '"><span class="glyphicon glyphicon-minus"></span></button></div></div>';
                        });
                        $(".allResults").html(bookRecommendations);
                        addToRemoveFromList();
                    },
                    error: function () {
                        $(".recomloading").addClass("hidden");
                        $(".allResults").html("<div class='col-md-12'><p>Fetching recommandations failed.. Try again.</p></div>");
                        
                    }
                })
            }
        }
    });
    $("#event").click(function() {
        if($(".recomloading").hasClass("hidden")) {
            $(".recomloading").removeClass("hidden");
            if(eventRecommendations !== "") {
                $(".recomloading").addClass("hidden");
                $(".allResults").html(eventRecommendations);
            } else {
                jQuery.ajax({
                    method: 'get',
                    url: "recommendations/events",
                    dataType: "json",
                    success: function (data) {
                        $(".recomloading").addClass("hidden");
                        $.each(data, function (key, val) {
                            eventRecommendations += '<div class="col-lg-4 col-md-6 col-sm-12">' +
                                '<div class="resultWrapper">' +
                                '<p>Type: <span class="type">Event</span></p>' +
                                '<p>Name: <span class="name">' + val.title + '</span></p>';
                            if(val.locations) {
                                eventRecommendations += '<p>Locations: <span>';
                                comaCheck = false;
                                $.each(val.locations, function (key2, val2) {
                                    eventRecommendations += (comaCheck ? ', ' : ' ') + val2;
                                    comaCheck = true;
                                });
                                eventRecommendations += '</span></p>';
                            }
                            eventRecommendations += '<a target="_blank" href="' + val.link + '"> Original Link</a>' +
                                '<button type="button" class="addToList" data="' + JSON.stringify(saveData) + '"><span class="glyphicon glyphicon-plus"></span></button>' +
                            '<button type="button" class="removeResult" data="' + JSON.stringify(saveData) + '"><span class="glyphicon glyphicon-minus"></span></button></div></div>';
                        });
                        $(".allResults").html(eventRecommendations);
                        addToRemoveFromList();
                    },
                    error: function () {
                        $(".recomloading").addClass("hidden");
                        $(".allResults").html("<div class='col-md-12'><p>Fetching recommandations failed.. Try again.</p></div>");
                    }
                })
            }
        }
    });
    $("#film").click(function() {
        if($(".recomloading").hasClass("hidden")) {
            $(".recomloading").removeClass("hidden");
            if(filmRecommendations !== "") {
                $(".recomloading").addClass("hidden");
                $(".allResults").html(filmRecommendations);
            } else {
                jQuery.ajax({
                    method: 'get',
                    url: "recommendations/films",
                    dataType: "json",
                    success: function (data) {
                        $(".recomloading").addClass("hidden");
                        $.each(data, function (key, val) {
                            filmRecommendations += '<div class="col-lg-4 col-md-6 col-sm-12">' +
                                '<div class="resultWrapper">' +
                                '<p>Type: <span class="type">Film</span></p>' +
                                '<p>Name: <span class="name">' + val.title + '</span></p>';
                            if(val.directors) {
                                filmRecommendations += '<p>Directors: <span>';
                                $.each(val.directors, function (key2, val2) {
                                    filmRecommendations += val2;
                                });
                                filmRecommendations += '</span></p>';
                            }
                            if(val.composers) {
                                limitCheck = 0;
                                filmRecommendations += '<p>Composers: <span>';
                                comaCheck = false;
                                $.each(val.composers, function (key3, val3) {
                                    if(limitCheck < 3) {
                                        filmRecommendations += (comaCheck ? ', ' : ' ') + val3;
                                        comaCheck = true;
                                    }
                                });
                                filmRecommendations += '</span></p>';
                            }
                            if(val.actors) {
                                limitCheck = 0;
                                filmRecommendations += '<p>Actors: <span>';
                                comaCheck = false;
                                $.each(val.actors, function (key3, val3) {
                                    if(limitCheck < 3) {
                                        filmRecommendations += (comaCheck ? ', ' : ' ') + val3;
                                        comaCheck = true;
                                    }
                                });
                                filmRecommendations += '</span></p>';
                            }
                            filmRecommendations += '<a target="_blank" href="' + val.link + '"> Original Link</a>' +
                                '<button type="button" class="addToList" data="' + JSON.stringify(saveData) + '"><span class="glyphicon glyphicon-plus"></span></button>' +
                            '<button type="button" class="removeResult" data="' + JSON.stringify(saveData) + '"><span class="glyphicon glyphicon-minus"></span></button></div></div>';
                        });
                        $(".allResults").html(filmRecommendations);
                        addToRemoveFromList();
                    },
                    error: function () {
                        $(".recomloading").addClass("hidden");
                        $(".allResults").html("<div class='col-md-12'><p>Fetching recommandations failed.. Try again.</p></div>");
                    }
                })
            }
        }
    });
    $("#edu").click(function() {
        if($(".recomloading").hasClass("hidden")) {
            $(".recomloading").removeClass("hidden");
            if(eduRecommendations !== "") {
                $(".recomloading").addClass("hidden");
                $(".allResults").html(eduRecommendations);
            } else {
                jQuery.ajax({
                    method: 'get',
                    url: "recommendations/edu",
                    dataType: "json",
                    success: function (data) {
                        $(".recomloading").addClass("hidden");
                        $.each(data, function (key, val) {
                            eduRecommendations += '<div class="col-lg-4 col-md-6 col-sm-12">' +
                                '<div class="resultWrapper">' +
                                '<p>Type: <span class="type">Institution</span></p>' +
                                '<p>Name: <span class="name">' + val.name + '</span></p>';
                            if(val.numberOfStudents) {
                                eduRecommendations += '<p>Students: <span>' + val.numberOfStudents + '</span></p>';
                            }
                            if(val.countries) {
                                eduRecommendations += '<p>Country: <span>';
                                $.each(val.countries, function (key2, val2) {
                                    result += val2;
                                });
                                eduRecommendations += '</span></p>';
                            }
                            eduRecommendations += '<a target="_blank" href="' + val.link + '"> Original Link</a>' +
                                '<button type="button" class="addToList" data="' + JSON.stringify(saveData) + '"><span class="glyphicon glyphicon-plus"></span></button>' +
                            '<button type="button" class="removeResult" data="' + JSON.stringify(saveData) + '"><span class="glyphicon glyphicon-minus"></span></button></div></div>';
                        });
                        $(".allResults").html(eduRecommendations);
                        addToRemoveFromList();
                    },
                    error: function () {
                        $(".recomloading").addClass("hidden");
                        $(".allResults").html("<div class='col-md-12'><p>Fetching recommandations failed.. Try again.</p></div>");
                    }
                })
            }
        }
    })
});