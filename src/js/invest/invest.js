$(function() {
  //상품구분
  $("#category .dropdown-menu li a").on("click", function() {
    var thTxt = $(this).text();
    //console.log(thTxt);
    var thHtml = thTxt + "<span class='pull-right'>▼</span>";
    $("#category").find(".btn").html(thHtml);
    //console.log(thHtml);
    $("#category").find("ul").slideToggle("fast");
    event.preventDefault();
  });

  
});