(function ($) {
  $(document).ready(function() {
      $('.pager a').each( function() { 
        $(this).text($(this).text().replace(/Visit(.*)Page /,''));
      });
  });
})(jQuery);