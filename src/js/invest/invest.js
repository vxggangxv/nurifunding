$(function() {
  //상품구분
  //예상 이자
  //투자신청서 금액 일괄 적용
  //투자신청서 금액 적용
  
  $(".dropdown").each(function(idx, item) {
    $(item).find(".dropdown-menu li a").on("click", function() {
      var thTxt = $(this).text();
      var thHtml = thTxt + "<span class='pull-right'>▼</span>";
      $(this).closest(".dropdown").find(".btn").html(thHtml);
      $(this).closest(".dropdown").find(".dropdown-menu").slideToggle("fast");
      event.preventDefault();
    });
});
  
});