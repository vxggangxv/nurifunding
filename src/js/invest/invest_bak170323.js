$(function() {
  //상품구분
/*  $("#category .dropdown-menu li a").on("click", function() {
    var thTxt = $(this).text();
    //console.log(thTxt);
    var thHtml = thTxt + "<span class='pull-right'>▼</span>";
    $("#category").find(".btn").html(thHtml);
    //console.log(thHtml);
    $("#category").find("ul").slideToggle("fast");
    event.preventDefault();
  });

  //예상 이자
  $("#est-calc .dropdown-menu li a").on("click", function() {
    var thTxt = $(this).text();
    var thHtml = thTxt + "<span class='pull-right'>▼</span>";
    $("#est-calc").find(".btn").html(thHtml);
    $("#est-calc").find("ul").slideToggle("fast");
    event.preventDefault();
  });
  //투자신청서 금액 일괄 적용
  $("#com-prc .dropdown-menu li a").on("click", function() {
    var thTxt = $(this).text();
    var thHtml = thTxt + "<span class='pull-right'>▼</span>";
    $("#com-prc").find(".btn").html(thHtml);
    $("#com-prc").find("ul").slideToggle("fast");
    event.preventDefault();
  });*/
  //투자신청서 금액 적용
  /*$("#com-p-chd .dropdown-menu li a").on("click", function() {
    var thTxt = $(this).text();
    var thHtml = thTxt + "<span class='pull-right'>▼</span>";
    $("#com-p-chd").find(".btn").html(thHtml);
    $("#com-p-chd").find("ul").slideToggle("fast");
    event.preventDefault();
  });*/
  
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