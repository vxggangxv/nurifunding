$(function() {
  $("#tab li a").on("click", function() {
    var thIdx = $(this).closest("li").index();
    console.log(thIdx);
    $("#tab-cont-box").find("section").removeClass("on");
    $("#tab-cont-box").find("section").eq(thIdx).addClass("on");
    return false;
  });
});