$(function() {
  $("#pagenation li a").on("click", function() {
    var idx = $(this).closest("li").index();
    if( idx != 0 && idx !=6 ){
      $("#pagenation li").removeClass("on");
      $(this).closest("li").addClass("on");
    }
    event.preventDefault();
  });
});