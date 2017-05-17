$(function() {
  //애니메이션 함수 호출
  wayP("on");
  
  //이미지로드 지연 - 로딩속도 단축
  /*$("img.lazy").lazyload({
    threshold : 300,        
    effect : "fadeIn"       
  });*/
  
  //메인 bxslider
  $('.swiper-wrapper').bxSlider({
    auto: true,
    speed: 500,
    duration: 6000,
    slideMargin: 50,
    prevText: '<img src="http://img.nurifunding.co.kr/btn_prev.png" alt="다음">',
    nextText: '<img src="http://img.nurifunding.co.kr/btn_next.png" alt="다음">',
    onSliderLoad: function(){
      msAni("on");
    },
    onSlideBefore: function(){
      $(".swiper-slide").find(".s1-div-2 .d1, .s1-div-2 .d2, .s1-div-3").fadeOut(100);
    },
    onSlideAfter: function($slideElement, oldIndex, newIndex){
      msAni("on");
    }
  });
  
});
//메인슬라이드 애니메이션
function msAni(flag){
  if (flag == "on") {
    var $_slide = $(".swiper-slide");
    $_slide.find(".s1-div-2 .d1, .s1-div-2 .d2, .s1-div-3").hide();
    setTimeout(function() {
      $_slide.find(".s1-div-2 .d1").fadeIn();
    }, 0);
    setTimeout(function() {
      $_slide.find(".s1-div-2 .d2").fadeIn();
    }, 500);
    setTimeout(function() {
      $_slide.find(".s1-div-3").fadeIn();
    }, 1000);
  } else if (flag == "off") { 
    var $_slide = $(".swiper-slide");
    $_slide.find(".s1-div-2 .d1, .s1-div-2 .d2, .s1-div-3").show(); 
    
  }
}

//interactive 효과
function wayP(flag) {
  if (flag == "on") {
    //차트
    $('#per-chart > div .p-chart').each(function(idx, item){
      $(item).addClass("blind");
      $(item).waypoint(function () {
        $(item).addClass('animated fadeIn chart0'+(idx+1));
      }, {
        offset: '95%'
      });
    });
    $('#per-chart > div .p-per').each(function(idx, item){
      $(item).addClass("blind");
      $(item).waypoint(function () {
        $(item).addClass('animated fadeIn');
        $("#p-per1").animateNumber({
          number: 152,
          numberStep: $.animateNumber.numberStepFactories.separator('.', 2)
        }, 1000);
        $("#p-per2").animateNumber({
          number: 215,
          numberStep: $.animateNumber.numberStepFactories.separator('.', 2)
        }, 1000);
        $("#p-per3").animateNumber({
          number: 685,
          numberStep: $.animateNumber.numberStepFactories.separator('.', 2)
        }, 1000);
        $("#p-per4").animateNumber({
          number: 1286,
          numberStep: $.animateNumber.numberStepFactories.separator('.', 2)
        }, 1000);
        $("#p-per5").animateNumber({
          number: 1640,
          numberStep: $.animateNumber.numberStepFactories.separator('.', 2)
        }, 1000);
      }, {
        offset: '89%'
      });
    });
    //쉬운 대출
    $("#easy > div img, #easy > div h3, #easy > div p").each(function(idx, item){
      $(item).addClass("blind");
      $(item).waypoint(function () {
        $(item).addClass('animated fadeIn');
      }, {
        offset: '75%'
      });
    });
    
  } else if (flag == "off") {
    $('#per-chart > div .p-chart').each(function(idx, item){
      $(item).removeClass("blind");
    });
  }

}