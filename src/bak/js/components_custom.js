$(function() {
  /* 드롭다운 */
  $(".dropdown .btn").on("click", function() {
    $(this).next().slideToggle("fast");
  });
  /*텝박스 기능*/
  $(".tab-box li").on("click", function() {
    var thIdx = $(this).index();
    $(this).closest("ul").find("li").removeClass("on");
    $(this).closest("ul").find("li").eq(thIdx).addClass("on");
    $(this).closest("ul").next().find("li").removeClass("on");
    $(this).closest("ul").next().find("li").eq(thIdx).addClass("on");
  });
  
});