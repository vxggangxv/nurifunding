$(function() {
  /*모바일 바 클릭시 모바일 네비게이션 등장*/
  $(".header .nav-tab").on("click", function() {
    $("#mlnb-wrap").addClass("on");
  });
  /*모바일 네비게이션 닫기 버튼*/
  $("#mlnb-wrap .cls-btn").on("click", function() {
    $("#mlnb-wrap").removeClass("on");
  });
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