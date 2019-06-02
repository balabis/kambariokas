var $ = require('jquery');

$('#filter-toggle-button').click(function(){
    $('#match-filter').removeClass('d-none');
    $(this).addClass('d-none');
});

$('#close-filter-btn').click(function() {
    $('#match-filter').addClass('d-none');
    $('#filter-toggle-button').removeClass('d-none');
});