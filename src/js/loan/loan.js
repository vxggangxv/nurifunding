$(function() {
  //통화가능시간
  $("#lon-call .dropdown-menu li a").on("click", function() {
    var thTxt = $(this).text();
    //console.log(thTxt);
    var thHtml = thTxt + "<span class='pull-right'>▼</span>";
    $("#lon-call").find(".btn").html(thHtml);
    //console.log(thHtml);
    $("#lon-call").find("ul").slideToggle("fast");
    $("#lon-call .btn").addClass("on");
    return false;
  });
  //대출기간
  $("#lon-term .dropdown-menu li a").on("click", function() {
    var thTxt = $(this).text();
    var thHtml = thTxt + "<span class='pull-right'>▼</span>";
    $("#lon-term").find(".btn").html(thHtml);
    $("#lon-term").find("ul").slideToggle("fast");
    $("#lon-term .btn").addClass("on");
    return false;
  });
  
  
});