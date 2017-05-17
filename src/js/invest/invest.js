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
  
  //nivo라이트박스
  $('.reg-inner a').nivoLightbox();
  $('#est-slider a').nivoLightbox();
  
  //부동산이미지 bxslider
  $('#est-slider').bxSlider({
    mode: 'fade',
    auto: true,
    speed: 500,
    duration: 6000,
    prevText: '<img src="http://img.nurifunding.co.kr/invest/inv_btn_prev.png" alt="다음">',
    nextText: '<img src="http://img.nurifunding.co.kr/invest/inv_btn_next.png" alt="다음">'
  });
  
});