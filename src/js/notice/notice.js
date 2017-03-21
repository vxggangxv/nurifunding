$(function() {
  //공지사항 리스트 페이지번호
  $("#pagenation li a").on("click", function() {
    var idx = $(this).closest("li").index();
    var lastIdx = $(this).closest("ul").find("li").length;
        lastIdx -- ;
    console.log(lastIdx);
    if( idx != 0 && idx != lastIdx ){
      $("#pagenation li").removeClass("on");
      $(this).closest("li").addClass("on");
    }
    event.preventDefault();
  });
  //글쓰기 분류 선택
  $("#fwi-category .dropdown-menu li a").on("click", function() {
    var thTxt = $(this).text();
    var thHtml = thTxt + "<span class='pull-right'>▼</span>";
    $("#fwi-category").find(".btn").html(thHtml);
    $("#fwi-category").find("ul").slideToggle("fast");
    $("#fwi-category .btn").addClass("on");
    event.preventDefault();
  });
  //파일박스 꾸미기
  var fileTarget = $('.filebox .upload-hidden'); 
  fileTarget.on('change', function(){ // 값이 변경되면 
    if(window.FileReader){ // modern browser 
      var filename = $(this)[0].files[0].name; 
    } else { // old IE 
      var filename = $(this).val().split('/').pop().split('\\').pop(); // 파일명만 추출 
    } 
    // 추출한 파일명 삽입 
    $(this).siblings('.upload-name').val(filename);
    $(this).siblings('.upload-name').css("color","#666");
  });
});