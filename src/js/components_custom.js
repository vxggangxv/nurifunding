$(function() {
  /* 드롭다운 */
  $(".dropdown .btn").on("click", function() {
    $(this).next().slideToggle("fast");
  });
    
});