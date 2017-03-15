$(function() {
  /* 드롭다운 */
  $(".dropdown .btn").on("click", function() {
    $(this).next().slideToggle("fast");
  });
  /*체크박스 전체동의*/
  $(".nr-check.all").on("click", function() {
    var isChecked = $(this).prop("checked");
    //console.log(isChecked);
    $(this).closest(".main-box").find(".nr-check").prop("checked", isChecked);
  })
  /*텝박스 기능*/
  $(".tab-box li").on("click", function() {
    var thIdx = $(this).index();
    $(this).closest("ul").find("li").removeClass("on");
    $(this).closest("ul").find("li").eq(thIdx).addClass("on");
    $(this).closest("ul").next().find("li").removeClass("on");
    $(this).closest("ul").next().find("li").eq(thIdx).addClass("on");
  });
  
});