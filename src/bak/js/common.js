$(function() {
  /*모바일 바 클릭시 모바일 네비게이션 등장*/
  $(".header .nav-tab").on("click", function() {
    $("#mlnb-wrap").addClass("on");
  });
  /*모바일 네비게이션 닫기 버튼*/
  $("#mlnb-wrap .cls-btn").on("click", function() {
    $("#mlnb-wrap").removeClass("on");
  });

});