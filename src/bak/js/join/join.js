$(function() {
  /*체크박스 전체동의*/
  $(".nr-check.all").on("click", function() {
    var isChecked = $(this).prop("checked");
    //console.log(isChecked);
    $(this).closest(".main-box").find(".nr-check").prop("checked", isChecked);
  })
  
});