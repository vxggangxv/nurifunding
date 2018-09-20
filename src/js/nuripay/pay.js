$(function() {
	
    //신청하기 버튼 누르면 폼섹션으로 이동
    $('.btn-move').on('click', function(){
        var secMove = $('#sec-move').offset().top;

        $('html, body').stop().animate({scrollTop : secMove}, 550);
    });

});