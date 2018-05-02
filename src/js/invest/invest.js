$(function() {
	// 투자하기 버튼
	fixedInvest("#rBn-box-m");
	
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
	adaptiveHeight: true,
	duration: 6000,
	prevText: '<img src="https://nurifunding.co.kr/img/invest/inv_btn_prev.png" alt="다음">',
	nextText: '<img src="https://nurifunding.co.kr/img/invest/inv_btn_next.png" alt="다음">'
	});

	// 동의하기 레이어팝업
	popCenter ();
		
});

function popCenter () {
	$(window).resize(function(){
			var invstPop = $('.invst-popup .popup-wrap');
			var invstPopW = invstPop.find('.popup-container').outerWidth();
			var invstPopH = invstPop.find('.popup-container').outerHeight();
			invstPop.css({'margin-top' : '-'+(invstPopH/2)+'px', 'margin-left' : '-'+(invstPopW/2)+'px'})
	}).resize();
}

function popupOpen(itm) {
	$(itm).show(); 
	var itm; 
	popCenter();
	$(itm).on('scroll touchmove mousewheel', function(event){
		event.preventDefault();
		event.stopPropagation();
		return false;
	});
}

function popupClose(itm) {
	$(itm).hide().off('scroll touchmove mousewheel');
	//console.log('닫기');
}

function fixedInvest(itm) {
	$(itm).on("click", function() {
		$("html, body").animate({ scrollTop: 0 }, 500);
		return false;
	});
	$(window).on('scroll', function() {
		var scr = $(window).scrollTop(),
			winHt = $(window).height();
		//var setTop = $("#setTop").offset().top;
		
		if (scr < winHt) {
			$(itm).removeClass('on');
		}
		if (scr >= winHt) {
			$(itm).addClass('on');
		}
	});
}