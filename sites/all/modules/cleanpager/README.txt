
Clean Pagination module:
-------------------------
Author - Chris Shattuck (www.impliedbydesign.com)
License - GPL

Drupal 7 port - JC Tenney (sponsored by byronbay.com Pty Ltd.)


Overview:
-------------------------
The Clean Pagination is a really simple module that helps get around the way Drupal
structures paginated URLs, which is by adding a query string, such as 'my-view?page=2'.
Clean Pagination will let you set which pages you would like to have clean URL
pagination, which looks like 'my-view/2'.

There is also an option to use search-engine-friendly links, which will add the URL of the page
to the pagination links, and will remove the extra text after the page loads. That way,
users see the typical '1 2 3' pagination, but search engines see 'View my-view Page 1 
View my-view Page 2  View my-view Page 3'. If your URL is keyword-rich, having the 
keywords in the hyperlink can be beneficial.