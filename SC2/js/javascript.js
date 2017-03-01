/**
 * Created by vic on 2017-02-01.
 */
function completeTransaction(end) {

    $.post("api.php", {end: end, method: 'completeTransaction'}, function (data, status) {
        }
    );
}

function updateTransaction(end) {
    $.post("api.php", {end: end, method: 'updateTransaction'}, function (data, status) {
        }
    );
}

function createNewTransaction(type, callback) {
    var start = Date.now;
    $.post("api.php", {start: start, type: type, method: 'createNewTransaction'}, function (data, status) {
            if (callback != null) {
                callback();
            }
        }
    );
}

function addUserSubject(subjectId) {
    $.post("api.php", {subject_id: subjectId, method: 'addUserSubject'}, function (data, status) {
            createNewTransaction(subjectId, updateUnitButtonsDiv);

            // console.log(data);
        }
    );
}

function updateTable() {
    $.post("api.php", {method: 'updateTable'}, function (data, status) {
            newTable = data;
            $("#time-table").html(newTable);
        }
    );
}

function updateUnitButtonsDiv() {
    // console.log("updateUnitButtonsDiv");
    $.post("api.php", {method: 'updateUnitButtonsDiv'}, function (data, status) {
            newPanel = data;
            $("#unit-buttons-div").html(newPanel);
        }
    );
}

function updateMonthHeader() {
    $.post("api.php", {method: 'updateMonthHeader'}, function (data, status) {
            newHeader = data;
            $("#month-header").html(newHeader);
        }
    );
}

function updateViews(end) {
    updateTransaction(end);
    updateUnitButtonsDiv();
    updateTable();
    updateMonthHeader();
}

function displayDescription(timerButtonId) {
    var description = $("#hidden-description-" + timerButtonId).html();
    $("#stopwatch-description").html(description);
}


function progressBarColor(color) {
    $(".progress-bar").css({
        'background-image': 'none',
        'background-color': color,
    });
}

function setProgressBarWidth(width) {
    // console.log("current width is: " + $(".progress-bar").css('width'));
    if(width == 0) {
        $(".progress-bar").css('width', width);
    } else {
        $(".progress-bar").css('width', width + '%');
    }
}

function getProgressBarWidth() {
    var barWidth = $('.progress-bar').width();
    var containerWidth = $('.progress-bar').offsetParent().width();

    // console.log("barWidth: " + barWidth);
    // console.log("containerWidth: " + containerWidth);


    if (barWidth == 0) {
        return 0;
    }

    return barWidth / (containerWidth / 100);
}


$(document).ajaxComplete(function () {
    $('.timer-start').popover({trigger: "hover"});
});


$(document).ready(function () {

    $('.message a').click(function () {
        $('form').animate({height: "toggle", opacity: "toggle"}, "slow");
    });

    $('.timer-start').popover({trigger: "hover"});

    $(document).on("click", ".subject-li", function () {
        var subjectId = $(this).data('value');
        addUserSubject(subjectId, null);
        updateUnitButtonsDiv();
        $(this).css("display", "none");
    });

    $(document).on("click", ".display-month-footer", function () {
        var monthId = $(this).data('value');
        $(".month").css("display", "none");
        $("#" + monthId).css("display", "block");
    });

    $(".nav a").on("click", function () {
        $(".nav").find(".active").removeClass("active");
        $(this).parent().addClass("active");
    });


    $(document).on("click", ".timer-start", function () {


        // this should ensure no popovers stay after modal is called
        $("[data-toggle='popover']").popover('hide');



        progressBarColor($(this).data('color'));
        // setProgressBarWidth($(this).data('width'));


        var timerButtonId = this.id;

        displayDescription(timerButtonId);

        createNewTransaction(timerButtonId);
        var h1 = document.getElementsByTagName('h1')[0];
        var seconds = 0;
        var minutes = 0;
        var hours = 0;
        var t;

        $(document).on("click", ".timer-stop", function () {

            var end = Date.now();

            h1.textContent = "00:00:00";
            seconds = 0;
            minutes = 0;
            hours = 0;

            clearTimeout(t);

            completeTransaction(end);

            updateUnitButtonsDiv();
            updateTable();
            updateMonthHeader();

            setProgressBarWidth(0);

            // this should ensure no popovers stay after modal is called
            $("[data-toggle='popover']").popover('hide');
        });

        function add() {
            seconds++;

            if (seconds % 5 == 0) {
                var end = Date.now();
                updateViews(end);
            }

            if (seconds % 18 == 0) {
                setProgressBarWidth(getProgressBarWidth() + 1);
            }

            if (seconds >= 60) {
                seconds = 0;
                minutes++;
                if (minutes >= 60) {
                    minutes = 0;
                    hours++;
                }
            }

            h1.textContent = (hours ? (hours > 9 ? hours : "0" + hours) : "00") + ":" + (minutes ? (minutes > 9 ? minutes : "0" + minutes) : "00") + ":" + (seconds > 9 ? seconds : "0" + seconds);

            timer();
        }

        function timer() {
            t = setTimeout(add, 1000);
        }

        timer();
    });

});