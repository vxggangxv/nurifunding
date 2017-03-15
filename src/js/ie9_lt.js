$(function() {
  /*투자상품 간격*/
  $(".ip-outer").css("padding", "10px");
  
  /*인풋 placeholder기능*/
  $(".nr-ph").css("display", "inline");
  $(".nr-box").each(function() {
    $(this).on("click", function() {
      var $nr_text = $(this).find(".nr-text");
      $nr_text.focus();
      $nr_text.next().hide();
    });
  });
  
});