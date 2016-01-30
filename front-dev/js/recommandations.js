$(document).ready(function() {
    var bookRecommandations="",
        eventRecommandations="",
        filmRecommandations="",
        eduRecommandations="";
    $("#book").click(function() {
        if($(".recomloading").hasClass("hidden")) {
            $(".recomloading").removeClass("hidden");
            if(bookRecommandations !== "") {
                $(".recomloading").addClass("hidden");
                $(".allResults").html(bookRecommandations);
            } else {
                jQuery.ajax({
                    method: 'get',
                    url: "recommendations/books",
                    dataType: "json",
                    success: function (data) {
                        $(".recomloading").addClass("hidden");
                        $.each(data, function (key, val) {
                            bookRecommandations += '<div class="col-lg-4 col-md-6 col-sm-12">' +
                                '<div class="resultWrapper">' +
                                '<p>Type: <span class="type">Book</span></p>' +
                                '<p>Name: <span class="name">' + val.title + '</span></p>';

                            if(val.authors) {
                                $.each(val.authors, function (key2, val2) {
                                    bookRecommandations += '<p>Author: <span class="releaseDate">' + val2 + '</span></p>';
                                });
                            }
                            if(val.releaseDate) {
                                if(typeof val.releaseDate === 'object') {
                                    bookRecommandations += '<p>Name: <span class="releaseDate">' + val.releaseDate.date.split(" ")[0] + '</span></p>';
                                }
                                if(typeof val.releaseDate !== 'object') {
                                    bookRecommandations += '<p>Year: <span class="releaseDate">' + val.releaseDate + '</span></p>';
                                }
                            }
                            bookRecommandations += '<a target="_blank" href="' + val.link + '"> Original Link</a>' +
                                '<button type="button" class="addToList"><span class="glyphicon glyphicon-plus"></span></button>' +
                                '<button type="button" class="removeResult"><span class="glyphicon glyphicon-minus"></span></button></div></div>';
                        });
                        $(".allResults").html(bookRecommandations);
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
            if(eventRecommandations !== "") {
                $(".recomloading").addClass("hidden");
                $(".allResults").html(eventRecommandations);
            } else {
                jQuery.ajax({
                    method: 'get',
                    url: "recommendations/events",
                    dataType: "json",
                    success: function (data) {
                        $(".recomloading").addClass("hidden");
                        $.each(data, function (key, val) {
                            eventRecommandations += '<div class="col-lg-4 col-md-6 col-sm-12">' +
                                '<div class="resultWrapper">' +
                                '<p>Type: <span class="type">Event</span></p>' +
                                '<p>Name: <span class="name">' + val.title + '</span></p>';
                            if(val.locations) {
                                eventRecommandations += '<p>Locations: <span>';
                                comaCheck = false;
                                $.each(val.locations, function (key2, val2) {
                                    eventRecommandations += (comaCheck ? ', ' : ' ') + val2;
                                    comaCheck = true;
                                });
                                eventRecommandations += '</span></p>';
                            }
                            eventRecommandations += '<a target="_blank" href="' + val.link + '"> Original Link</a>' +
                                '<button type="button" class="addToList"><span class="glyphicon glyphicon-plus"></span></button>' +
                                '<button type="button" class="removeResult"><span class="glyphicon glyphicon-minus"></span></button></div></div>';
                        });
                        $(".allResults").html(eventRecommandations);
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
            if(filmRecommandations !== "") {
                $(".recomloading").addClass("hidden");
                $(".allResults").html(filmRecommandations);
            } else {
                jQuery.ajax({
                    method: 'get',
                    url: "recommendations/films",
                    dataType: "json",
                    success: function (data) {
                        $(".recomloading").addClass("hidden");
                        $.each(data, function (key, val) {
                            filmRecommandations += '<div class="col-lg-4 col-md-6 col-sm-12">' +
                                '<div class="resultWrapper">' +
                                '<p>Type: <span class="type">Film</span></p>' +
                                '<p>Name: <span class="name">' + val.title + '</span></p>';
                            if(val.directors) {
                                filmRecommandations += '<p>Directors: <span>';
                                $.each(val.directors, function (key2, val2) {
                                    filmRecommandations += val2;
                                });
                                filmRecommandations += '</span></p>';
                            }
                            if(val.composers) {
                                limitCheck = 0;
                                filmRecommandations += '<p>Composers: <span>';
                                comaCheck = false;
                                $.each(val.composers, function (key3, val3) {
                                    if(limitCheck < 3) {
                                        filmRecommandations += (comaCheck ? ', ' : ' ') + val3;
                                        comaCheck = true;
                                    }
                                });
                                filmRecommandations += '</span></p>';
                            }
                            if(val.actors) {
                                limitCheck = 0;
                                filmRecommandations += '<p>Actors: <span>';
                                comaCheck = false;
                                $.each(val.actors, function (key3, val3) {
                                    if(limitCheck < 3) {
                                        filmRecommandations += (comaCheck ? ', ' : ' ') + val3;
                                        comaCheck = true;
                                    }
                                });
                                filmRecommandations += '</span></p>';
                            }
                            filmRecommandations += '<a target="_blank" href="' + val.link + '"> Original Link</a>' +
                                '<button type="button" class="addToList"><span class="glyphicon glyphicon-plus"></span></button>' +
                                '<button type="button" class="removeResult"><span class="glyphicon glyphicon-minus"></span></button></div></div>';    
                        });
                        $(".allResults").html(filmRecommandations);
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
            if(eduRecommandations !== "") {
                $(".recomloading").addClass("hidden");
                $(".allResults").html(eduRecommandations);
            } else {
                jQuery.ajax({
                    method: 'get',
                    url: "recommendations/edu",
                    dataType: "json",
                    success: function (data) {
                        $.each(data, function (key, val) {
                            eduRecommandations = '<div class="col-lg-6 col-md-6 col-sm-12">' +
                                '<div class="resultWrapper">' +
                                '<p>Type: <span class="type">Institution</span></p>' +
                                '<p>Name: <span class="name">' + val.title + '</span></p>';
                            if(val.numberOfStudents) {
                                eduRecommandations += '<p>Students: <span>' + val.numberOfStudents + '</span></p>';
                            }
                            if(val.countries) {
                                eduRecommandations += '<p>Country: <span>';
                                $.each(val.countries, function (key2, val2) {
                                    result += val2;
                                });
                                eduRecommandations += '</span></p>';
                            }
                            eduRecommandations += '<a target="_blank" href="' + val.link + '"> Original Link</a>' +
                                '<button type="button" class="addToList"><span class="glyphicon glyphicon-plus"></span></button>' +
                                '<button type="button" class="removeResult"><span class="glyphicon glyphicon-minus"></span></button></div></div>';
                        });
                        $(".allResults").append(eduRecommandations);
                        $(".recomloading").addClass("hidden");
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