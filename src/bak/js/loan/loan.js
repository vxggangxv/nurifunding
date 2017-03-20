$(function() {
  
  
  //상품구분
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
  //상환기간
  $("#lon-term .dropdown-menu li a").on("click", function() {
    var thTxt = $(this).text();
    var thHtml = thTxt + "<span class='pull-right'>▼</span>";
    $("#lon-term").find(".btn").html(thHtml);
    $("#lon-term").find("ul").slideToggle("fast");
    $("#lon-term .btn").addClass("on");
    event.preventDefault();
  });
  //상환일
  $("#lon-day .dropdown-menu li a").on("click", function() {
    var thTxt = $(this).text();
    var thHtml = thTxt + "<span class='pull-right'>▼</span>";
    $("#lon-day").find(".btn").html(thHtml);
    $("#lon-day").find("ul").slideToggle("fast");
    $("#lon-day .btn").addClass("on");
    event.preventDefault();
  });
  //성별
  $("#lon-gender .dropdown-menu li a").on("click", function() {
    var thTxt = $(this).text();
    var thHtml = thTxt + "<span class='pull-right'>▼</span>";
    $("#lon-gender").find(".btn").html(thHtml);
    $("#lon-gender").find("ul").slideToggle("fast");
    $("#lon-gender .btn").addClass("on");
    event.preventDefault();
  });
  
  //직장규모
  $("#lon-company .dropdown-menu li a").on("click", function() {
    var thTxt = $(this).text();
    var thHtml = thTxt + "<span class='pull-right'>▼</span>";
    $("#lon-company").find(".btn").html(thHtml);
    $("#lon-company").find("ul").slideToggle("fast");
    $("#lon-company .btn").addClass("on");
    event.preventDefault();
  });
  //고용형태
  $("#lon-employ .dropdown-menu li a").on("click", function() {
    var thTxt = $(this).text();
    var thHtml = thTxt + "<span class='pull-right'>▼</span>";
    $("#lon-employ").find(".btn").html(thHtml);
    $("#lon-employ").find("ul").slideToggle("fast");
    $("#lon-employ .btn").addClass("on");
    event.preventDefault();
  });
  //직장입사일
  $("#lon-year .dropdown-menu li a").on("click", function() {
    var thTxt = $(this).text();
    var thHtml = thTxt + "<span class='pull-right'>▼</span>";
    $("#lon-year").find(".btn").html(thHtml);
    $("#lon-year").find("ul").slideToggle("fast");
    $("#lon-year .btn").addClass("on");
    event.preventDefault();
  });
  $("#lon-month .dropdown-menu li a").on("click", function() {
    var thTxt = $(this).text();
    var thHtml = thTxt + "<span class='pull-right'>▼</span>";
    $("#lon-month").find(".btn").html(thHtml);
    $("#lon-month").find("ul").slideToggle("fast");
    $("#lon-month .btn").addClass("on");
    event.preventDefault();
  });
  //4대보험가입
  $("#lon-major4 .dropdown-menu li a").on("click", function() {
    var thTxt = $(this).text();
    var thHtml = thTxt + "<span class='pull-right'>▼</span>";
    $("#lon-major4").find(".btn").html(thHtml);
    $("#lon-major4").find("ul").slideToggle("fast");
    $("#lon-major4 .btn").addClass("on");
    event.preventDefault();
  });
  /*var loanGroup = [];
  $(".loan.nth-1 .lon-d.dropdown").each(function(idx, item) {
    $(item).find(".dropdown-menu li a").on("click", function() {
      var thTxt = $(this).text();
      console.log(thTxt);
      var thHtml = thTxt + "<span class='pull-right'>▼</span>";
      $(this).closest("div").find(".btn").html(thHtml);
      $(this).closest("div").find(".btn").addClass("on");
      $(this).closest("ul").slideToggle("fast");
      event.preventDefault();
      console.log(idx + ":" + thTxt);
      loanGroup.push(thTxt);
      console.log(loanGroup);
    });
  });
  var loanGroup2 = [];
  $(".loan.nth-2 .lon-d.dropdown").each(function(idx, item) {
    $(item).find(".dropdown-menu li a").on("click", function() {
      var thTxt = $(this).text();
      console.log(thTxt);
      var thHtml = thTxt + "<span class='pull-right'>▼</span>";
      $(this).closest("div").find(".btn").html(thHtml);
      $(this).closest("div").find(".btn").addClass("on");
      $(this).closest("ul").slideToggle("fast");
      event.preventDefault();
      console.log(idx + ":" + thTxt);
      loanGroup2.push(thTxt);
      console.log(loanGroup2);
    });
  });*/
  /*전체 집합 확인*/
  $(".alow3").on('click', function() {
    console.log("loanGroup :" + loanGroup);
    console.log("loanGroup2 :" + loanGroup2);
    event.preventDefault();
  });
  
  
  
  /*체크박스 전체동의*/
  $(".nr-check.all").on("click", function() {
    var isChecked = $(this).prop("checked");
    //console.log(isChecked);
    $(this).closest(".nr-box").next().find(".nr-check").prop("checked", isChecked);
  });
  
});