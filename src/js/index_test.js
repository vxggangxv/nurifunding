$(function () {
	//애니메이션 함수 호출
	wayP("on", "#per-chart", "27");
	wayP("on", "#per-chart-m", "11.5");

	//이미지로드 지연 - 로딩속도 단축
	/*$("img.lazy").lazyload({
	  threshold : 300,        
	  effect : "fadeIn"       
	});*/

	//메인 bxslider
	$('.swiper-wrapper').bxSlider({
		auto: true,
		speed: 500,
		duration: 7500,
		slideMargin: 50,
		prevText: '<img src="https://www.nurifunding.co.kr/img/btn_prev.png" alt="다음">',
		nextText: '<img src="https://www.nurifunding.co.kr/img/btn_next.png" alt="다음">',
		onSliderLoad: function () {
			msAni("on");
		},
		onSlideBefore: function () {
			$(".swiper-slide").find(".s1-div-2 .d1, .s1-div-2 .d2, .s1-div-3").fadeOut(100);
		},
		onSlideAfter: function ($slideElement, oldIndex, newIndex) {
			msAni("on");
		}
	});

});
//메인슬라이드 애니메이션
function msAni(flag) {
	if (flag == "on") {
		var $_slide = $(".swiper-slide");
		$_slide.find(".s1-div-2 .d1, .s1-div-2 .d2, .s1-div-3").hide();
		setTimeout(function () {
			$_slide.find(".s1-div-2 .d1").fadeIn();
		}, 0);
		setTimeout(function () {
			$_slide.find(".s1-div-2 .d2").fadeIn();
		}, 500);
		setTimeout(function () {
			$_slide.find(".s1-div-3").fadeIn();
		}, 1000);
	} else if (flag == "off") {
		var $_slide = $(".swiper-slide");
		$_slide.find(".s1-div-2 .d1, .s1-div-2 .d2, .s1-div-3").show();

	}
}

//interactive 효과
function wayP(on, itm, ht) {
	//차트
	$(itm).children('div').each(function (idx, item) {
		var $this = $(this)
			, $pChart = $this.find('.p-chart')
			, perData = $this.find(".p-per > span").text()
			, perHeight = perData * ht ;
		
		$(item).waypoint(function () {
			$this.children(".p-chart").height(perHeight);
		}, {
			offset: '95%'
		});
	});
	
	$(itm).children('div').each(function (idx, item) {
		var $this = $(this)
			, $pPer = $this.find(".p-per");
		$pPer.addClass("blind");
		
		$pPer.waypoint(function () {
			$pPer.addClass('fadeIn');
			$("#p-per1").animateNumber({
				number: 156,
				numberStep: $.animateNumber.numberStepFactories.separator('.', 2)
			}, 1000);
			$("#p-per2").animateNumber({
				number: 189,
				numberStep: $.animateNumber.numberStepFactories.separator('.', 2)
			}, 1000);
			$("#p-per3").animateNumber({
				number: 561,
				numberStep: $.animateNumber.numberStepFactories.separator('.', 2)
			}, 1000);
			$("#p-per4").animateNumber({
				number: 1296,
				numberStep: $.animateNumber.numberStepFactories.separator('.', 2)
			}, 1000);
			$("#p-per5").animateNumber({
				number: $('#per5_val').val(),
				numberStep: $.animateNumber.numberStepFactories.separator('.', 2)
			}, 1000);
			
		}, {
			offset: '89%'
		});
	});
	
	//쉬운 대출
	$("#easy > div img, #easy > div h3, #easy > div p, #easy > div.ip-more-outer").each(function (idx, item) {
		$(item).addClass("blind");
		$(item).waypoint(function () {
			$(item).addClass('animated fadeIn');
		}, {
			offset: '75%'
		});
	});

}