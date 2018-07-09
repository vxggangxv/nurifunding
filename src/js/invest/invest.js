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

	// 동의하기 레이어팝업
	popCenter();		
});

function popCenter () {
	$(window).resize(function(){
		var invstPop = $('.invst-popup .popup-wrap');
		$.each(invstPop, function() {
			var invstPopW = $(this).find('.popup-container').outerWidth();
			var invstPopH = $(this).find('.popup-container').outerHeight();
			$(this).css({'margin-top' : '-'+(invstPopH/2)+'px', 'margin-left' : '-'+(invstPopW/2)+'px'});
		});
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