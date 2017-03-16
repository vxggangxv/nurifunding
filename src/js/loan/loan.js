$(function() {
  /*상품구분*/
  $("#lon-pdt .dropdown-menu li a").on("click", function() {
    var thTxt = $(this).text();
    //console.log(thTxt);
    var thHtml = thTxt + "<span class='pull-right'>▼</span>";
    $("#lon-pdt").find(".btn").html(thHtml);
    //console.log(thHtml);
    $("#lon-pdt").find("ul").slideToggle("fast");
    $("#lon-pdt .btn").addClass("on");
    event.preventDefault();
  });
  /*상환기간*/
  $("#lon-term .dropdown-menu li a").on("click", function() {
    var thTxt = $(this).text();
    var thHtml = thTxt + "<span class='pull-right'>▼</span>";
    $("#lon-term").find(".btn").html(thHtml);
    $("#lon-term").find("ul").slideToggle("fast");
    $("#lon-term .btn").addClass("on");
    event.preventDefault();
  });
  /*상환일*/
  $("#lon-day .dropdown-menu li a").on("click", function() {
    var thTxt = $(this).text();
    var thHtml = thTxt + "<span class='pull-right'>▼</span>";
    $("#lon-day").find(".btn").html(thHtml);
    $("#lon-day").find("ul").slideToggle("fast");
    $("#lon-day .btn").addClass("on");
    event.preventDefault();
  });
  /*성별*/
  $("#lon-gender .dropdown-menu li a").on("click", function() {
    var thTxt = $(this).text();
    var thHtml = thTxt + "<span class='pull-right'>▼</span>";
    $("#lon-gender").find(".btn").html(thHtml);
    $("#lon-gender").find("ul").slideToggle("fast");
    $("#lon-gender .btn").addClass("on");
    event.preventDefault();
  });
  
  /*체크박스 전체동의*/
  $(".nr-check.all").on("click", function() {
    var isChecked = $(this).prop("checked");
    //console.log(isChecked);
    $(this).closest(".nr-box").next().find(".nr-check").prop("checked", isChecked);
  })
});