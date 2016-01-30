$(document).ready(function() {
    var bookRecommandations,
        eventRecommandations,
        filmRecommandations,
        eduRecommandations;
    $("#book").click(function() {
        if($(".recomloading").hasClass("hidden")) {
            $(".recomloading").removeClass("hidden");
            if(bookRecommandations !== undefined) {
                $(".allResults").html(bookRecommandations);
            } else {
                jQuery.ajax({
                    method: 'get',
                    url: "recommendations/books",
                    dataType: "json",
                    success: function (data) {
                        $(".recomloading").addClass("hidden");
                        console.log(data);

                    },
                    error: function () {
                        $(".recomloading").addClass("hidden");
                        $(".allResults").html("<div class='col-md-12'><p class='red'>Fetching recommandations failed.. Try again.</p></div>");
                    }
                })
            }
        }
    });
    $("#event").click(function() {
        if($(".recomloading").hasClass("hidden")) {
            $(".recomloading").removeClass("hidden");
            if(eventRecommandations !== undefined) {
                $(".allResults").html(bookRecommandations);
            } else {
                jQuery.ajax({
                    method: 'get',
                    url: "recommendations/events",
                    dataType: "json",
                    success: function (data) {
                        $(".recomloading").addClass("hidden");
                        console.log(data);

                    },
                    error: function () {
                        $(".allResults").html("<div class='col-md-12'><p class='red'>Fetching recommandations failed.. Try again.</p></div>");
                    }
                })
            }
        }
    });
    $("#film").click(function() {
        if($(".recomloading").hasClass("hidden")) {
            $(".recomloading").removeClass("hidden");
            if(filmRecommandations !== undefined) {
                $(".allResults").html(bookRecommandations);
            } else {
                jQuery.ajax({
                    method: 'get',
                    url: "recommendations/films",
                    dataType: "json",
                    success: function (data) {
                        console.log(data);
                        $(".recomloading").addClass("hidden");
                    },
                    error: function () {
                        $(".recomloading").addClass("hidden");
                        $(".allResults").html("<div class='col-md-12'><p class='red'>Fetching recommandations failed.. Try again.</p></div>");
                    }
                })
            }
        }
    });
    $("#edu").click(function() {
        if($(".recomloading").hasClass("hidden")) {
            $(".recomloading").removeClass("hidden");
            if(eduRecommandations !== undefined) {
                $(".allResults").html(bookRecommandations);
            } else {
                jQuery.ajax({
                    method: 'get',
                    url: "recommendations/edu",
                    dataType: "json",
                    success: function (data) {
                        console.log(data);
                        $(".recomloading").addClass("hidden");
                    },
                    error: function () {
                        $(".recomloading").addClass("hidden");
                        $(".allResults").html("<div class='col-md-12'><p class='red'>Fetching recommandations failed.. Try again.</p></div>");
                    }
                })
            }
        });
    }
});