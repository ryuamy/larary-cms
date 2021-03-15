$(document).ready(function () {
    if ($('#OSec').length > 0) {
        setInterval(function () {
            var seconds = new Date().getSeconds();
            $('#OSec').html((seconds < 10 ? '0' : '') + seconds);
        }, 1000);
    }

    if ($('#OMin').length > 0) {
        setInterval(function () {
            var minutes = new Date().getMinutes();
            $('#OMin').html((minutes < 10 ? '0' : '') + minutes);
        }, 1000);
    }

    if ($('#OHours').length > 0) {
        setInterval(function () {
            var hours = new Date().getHours();
            $('#OHours').html((hours < 10 ? '0' : '') + hours);
        }, 1000);
    }

    if ($('#OHours2').length > 0) {
        setInterval(function () {
            var hours2 = new Date().getHours();
            hours2 = hours2 > 12 ? hours2 - 12 : '';
            $('#OHours2').html('0' + hours2);
        }, 1000);
    }

    if ($('#OAMPM').length > 0) {
        setInterval(function () {
            var hours = new Date().getHours();
            var ampm = hours >= 12 ? 'PM' : 'AM';
            $('#OAMPM').html(ampm);
        }, 1000);
    }

    if ($('#OGreeting').length > 0) {
        setInterval(function () {
            var hours = new Date().getHours();
            // hours = hours + hours;
            var greeting = 'pagi';
            if (hours >= 19) {
                greeting = 'malam';
            } else if (hours >= 12 && hours <= 15) {
                greeting = 'siang';
            } else if (hours >= 15 && hours <= 19) {
                greeting = 'sore';
            };
            $('#OGreeting').html(greeting);
        }, 1000);
    }
});