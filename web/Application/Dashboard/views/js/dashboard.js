$(document).ready(function () {
    $('.events-widget li').on('click', function () {
        window.location = $(this).data('href');
    });
    $('.dashboard-stat').on('click', function () {
        window.location = $(this).data('href');
    });
});