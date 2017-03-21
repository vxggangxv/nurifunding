$(function() {
  $("section[class*='faq'] .f-q").on("click", function() {
    $(this).next().toggleClass("on");
    //$(this).next().slideToggle("fast");
  });
});