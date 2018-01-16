// This functionality allows us to clear the input of the search bar.

$(document).ready(function() {

  $('.clear_search').on('click', function() {
    $('.search_input').val('');
  });

});
