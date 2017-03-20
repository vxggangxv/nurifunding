$(function() {
  var loanGroup = {"pdt": "", "term": "", "day": "", "gender": ""};
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
    loanGroup.pdt = thTxt;
  });
  //상환기간
  $("#lon-term .dropdown-menu li a").on("click", function() {
    var thTxt = $(this).text();
    var thHtml = thTxt + "<span class='pull-right'>▼</span>";
    $("#lon-term").find(".btn").html(thHtml);
    $("#lon-term").find("ul").slideToggle("fast");
    $("#lon-term .btn").addClass("on");
    event.preventDefault();
    loanGroup.term = thTxt;
  });
  //상환일
  $("#lon-day .dropdown-menu li a").on("click", function() {
    var thTxt = $(this).text();
    var thHtml = thTxt + "<span class='pull-right'>▼</span>";
    $("#lon-day").find(".btn").html(thHtml);
    $("#lon-day").find("ul").slideToggle("fast");
    $("#lon-day .btn").addClass("on");
    event.preventDefault();
    loanGroup.day = thTxt;
  });
  //성별
  $("#lon-gender .dropdown-menu li a").on("click", function() {
    var thTxt = $(this).text();
    var thHtml = thTxt + "<span class='pull-right'>▼</span>";
    $("#lon-gender").find(".btn").html(thHtml);
    $("#lon-gender").find("ul").slideToggle("fast");
    $("#lon-gender .btn").addClass("on");
    event.preventDefault();
    loanGroup.gender = thTxt;
  });
  //key, val 확인
  $(".loan.nth-1 .alow3").on('click', function() {
    $.each(loanGroup, function(key, val){
      console.log(key + ":" + val);
    });
    event.preventDefault();
  });
  
  var loanGroup2 = {"company": "", "employ": "", "year": "", "month": "", "major4": ""};
  //직장규모
  $("#lon-company .dropdown-menu li a").on("click", function() {
    var thTxt = $(this).text();
    var thHtml = thTxt + "<span class='pull-right'>▼</span>";
    $("#lon-company").find(".btn").html(thHtml);
    $("#lon-company").find("ul").slideToggle("fast");
    $("#lon-company .btn").addClass("on");
    event.preventDefault();
    loanGroup2.company = thTxt;
  });
  //고용형태
  $("#lon-employ .dropdown-menu li a").on("click", function() {
    var thTxt = $(this).text();
    var thHtml = thTxt + "<span class='pull-right'>▼</span>";
    $("#lon-employ").find(".btn").html(thHtml);
    $("#lon-employ").find("ul").slideToggle("fast");
    $("#lon-employ .btn").addClass("on");
    event.preventDefault();
    loanGroup2.employ = thTxt;
  });
  //직장입사일
  $("#lon-year .dropdown-menu li a").on("click", function() {
    var thTxt = $(this).text();
    var thHtml = thTxt + "<span class='pull-right'>▼</span>";
    $("#lon-year").find(".btn").html(thHtml);
    $("#lon-year").find("ul").slideToggle("fast");
    $("#lon-year .btn").addClass("on");
    event.preventDefault();
    loanGroup2.year = thTxt;
  });
  $("#lon-month .dropdown-menu li a").on("click", function() {
    var thTxt = $(this).text();
    var thHtml = thTxt + "<span class='pull-right'>▼</span>";
    $("#lon-month").find(".btn").html(thHtml);
    $("#lon-month").find("ul").slideToggle("fast");
    $("#lon-month .btn").addClass("on");
    event.preventDefault();
    loanGroup2.month = thTxt;
  });
  //4대보험가입
  $("#lon-major4 .dropdown-menu li a").on("click", function() {
    var thTxt = $(this).text();
    var thHtml = thTxt + "<span class='pull-right'>▼</span>";
    $("#lon-major4").find(".btn").html(thHtml);
    $("#lon-major4").find("ul").slideToggle("fast");
    $("#lon-major4 .btn").addClass("on");
    event.preventDefault();
    loanGroup2.major4 = thTxt;
  });
  //key, val 확인
  $(".loan.nth-2 .alow3").on('click', function() {
    $.each(loanGroup2, function(key, val){
      console.log(key + ":" + val);
    });
    event.preventDefault();
  });
  
  
  
  //체크박스 전체동의
  $(".nr-check.all").on("click", function() {
    var isChecked = $(this).prop("checked");
    //console.log(isChecked);
    $(this).closest(".nr-box").next().find(".nr-check").prop("checked", isChecked);
  });
  
});