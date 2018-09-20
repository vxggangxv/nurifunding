<?php
	@header("Content-Type: text/html; charset=UTF-8");
	include_once("/home/ebizdev/web-home/nurifunding.co.kr/config/config.php");
	include_once("/home/ebizdev/web-home/nurifunding.co.kr/www/web-home/common/log_query.php");
?>
<!DOCTYPE html>
<html lang="ko-KR">

<head>

  <meta name="title" content="<?=SNAME_K?>"/> 
<meta name="author" content="<?=SNAME_K?>"/>
<meta name="subject" content="<?=description?>"/> 
<meta name="description" content="<?=description?>"/>
<meta name="keywords" content="<?=description?>"/>
<meta name="classification" content="<?=SNAME_K?>"/>

<!-- 오픈그래프 -->
<meta property="og:type" content="website">
<meta property="og:title" content="<?=SNAME_K?>"/>
<meta property="og:description" content="<?=description?>"/>
<meta property="og:url" content="<?=base_w?>"/>
<meta property="og:site_name" content="<?=SNAME_K?>"/>
<!-- 오픈그래프 -->

<meta name="format-detection" content="telephone=no" />
<meta http-equiv="X-UA-Compatible" content="IE=Edge">
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0, user-scalable=0">
  <title>누리펀딩</title>

	<link rel="shortcut icon" href="<?=base_img2?>/32x32.ico" />
	<!-- Android icon -->
	<link rel='shortcut icon' href='<?=base_img2?>/128x128.png' />
	<!-- iPhone icon -->
	<link rel='apple-touch-icon' sizes='57x57' href='<?=base_img2?>/57x57.png' />
	<!-- iPad icon -->
	<link rel='apple-touch-icon' sizes='72x72' href='<?=base_img2?>/72x72.png' />
	<!-- iPhone icon(Retina) -->
	<link rel='apple-touch-icon' sizes='114x114' href='<?=base_img2?>/114x114.png' />
	<!-- iPad icon(Retina) -->
	<link rel='apple-touch-icon' sizes='144x144' href='<?=base_img2?>/144x144.png' />



  <link rel="stylesheet" href="<?=base_font2;?>/NanumBarunGothic/nanumbarungothic.css?ver=<?=time();?>">
  <link rel="stylesheet" href="https://fonts.googleapis.com/earlyaccess/notosanskr.css?ver=<?=time();?>"> 
  <link rel="stylesheet" href="https://fonts.googleapis.com/earlyaccess/nanumgothic.css?ver=<?=time();?>"> 
  <link rel="stylesheet" type="text/css" href="https://cdn.rawgit.com/moonspam/NanumSquare/master/nanumsquare.css?ver=<?=time();?>">
  <link rel="canonical" href="https://www.nurifunding.co.kr">
  <link href="https://opensource.keycdn.com/fontawesome/4.6.3/font-awesome.min.css?ver=<?=time();?>" rel="stylesheet">

  <link rel="stylesheet" href="<?=base_css2;?>/common.css?ver=<?=time();?>">
  <link rel="stylesheet" href="<?=base_css2;?>/animate.css?ver=<?=time();?>">
  <link rel="stylesheet" href="<?=base_css2;?>/nivo-lightbox-theme/default.css?ver=<?=time();?>">
  <link rel="stylesheet" href="<?=base_css2;?>/nivo-lightbox.css?ver=<?=time();?>">
  <link rel="stylesheet" href="<?=base_css2;?>/jquery.bxslider.css?ver=<?=time();?>">

  <script type="text/javascript" src="<?=base_js2?>/jquery-1.10.2.min.js?ver=<?=time();?>"></script>
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js?ver=<?=time();?>"></script>
  <script type="text/javascript" src="<?=base_js2?>/common.js?ver=<?=time();?>"></script>
  <script type="text/javascript" src="<?=base_js2?>/com.js?ver=<?=date("YmdHis")?>"></script>
  <script type="text/javascript" src="<?=base_js2;?>/Chart.bundle.min.js?ver=<?=time();?>"></script>
  
  <script type="text/javascript" src="<?=base_js2;?>/nivo-lightbox.min.js?ver=<?=time();?>"></script>
  <script type="text/javascript" src="<?=base_js2;?>/jquery.bxslider.min.js?ver=<?=time();?>"></script>
  <script type="text/javascript" src="<?=base_js2;?>/jquery.animateNumber.min.js?ver=<?=time();?>"></script>
  <script type="text/javascript" src="<?=base_js2;?>/waypoints.min.js?ver=<?=time();?>"></script>
  <script type="text/javascript" src="<?=base_js2;?>/jquery.easing.min.js?ver=<?=time();?>"></script>
   <?php
	switch($page_type) {
		case "member":
			echo "<link rel=\"stylesheet\" href=\"".base_css2."/join/join2.css?ver=".time()."\">";
			echo "<script type=\"text/javascript\" src=\"".base_js2."/mypage/mypage.js?ver=".time()."\"></script> ";
		break;
		case "loan":
			echo "<link rel=\"stylesheet\" href=\"".base_css2."/loan/loan2.css?ver=".time()."\">";
			echo "<script type=\"text/javascript\" src=\"".base_js2."/loan/loan.js?ver=".time()."\"></script>";
		break;
		case "join":
			echo "<script type=\"text/javascript\" src=\"".base_js2."/join/join.js?ver=".time()."\"></script> ";
			echo "<link rel=\"stylesheet\" href=\"".base_css2."/join/join.css?ver=".time()."\">";
		break;
		case "service":
			echo " <link rel=\"stylesheet\" href=\"".base_css2."/service/service2.css?ver=".time()."\">";
			echo "<link rel=\"stylesheet\" href=\"".base_css2."/nivo-lightbox-theme/default.css?ver=".time()."\">";
			echo "<link rel=\"stylesheet\" href=\"".base_css2."/nivo-lightbox.css?ver=".time()."\">";
			echo "<script type=\"text/javascript\" src=\"".base_js2."/nivo-lightbox.min.js?ver=".time()."\"></script>"; 
			echo "<script type=\"text/javascript\" src=\"".base_js2."/service/service.js?ver=".time()."\"></script>";
		break;
		case "faq":
			echo "<link rel=\"stylesheet\" href=\"".base_css2."/faq/faq.css?ver=".time()."\">";
			echo "<script type=\"text/javascript\" src=\"".base_js2."/faq/faq.js?ver=".time()."\"></script>";
		break;
		case "notice":
			echo "<link rel=\"stylesheet\" href=\"".base_css2."/notice/notice.css?ver=".time()."\">";
			echo "<script type=\"text/javascript\" src=\"".base_js2."/notice/notice.js?ver=".time()."\"></script>";
		break;
		case "mypage":
			echo "<link rel=\"stylesheet\" href=\"".base_css2."/mypage/mypage.css?ver=".time()."\">";
			echo "<script type=\"text/javascript\" src=\"".base_js2."/mypage/mypage.js?ver=".time()."\"></script> ";
		break;
		case "mydeposit":
			echo "<link rel=\"stylesheet\" href=\"".base_css2."/mydeposit/mydeposit.css?ver=".time()."\">";
			echo "<script type=\"text/javascript\" src=\"".base_js2."/mydeposit/mydeposit.js?ver=".time()."\"></script>";
			echo "<!--[if lt IE 9]><link rel=\"stylesheet\" href=\"".base_css2."/mydeposit/mydeposit_ie9lt.css?ver=".time()."\"><![endif]-->";
		break;
		case "invest":
			echo "<script type=\"text/javascript\" src=\"".base_js2."/invest/invest.js?ver=".time()."\"></script>";
			echo "<link rel=\"stylesheet\" href=\"".base_css2."/invest/invest2.css?ver=".time()."\">";
			echo "<link rel=\"stylesheet\" href=\"".base_css2."/invest/override.css?ver=".time()."\">";
		break;
		case "grade":
			echo "<script type=\"text/javascript\" src=\"".base_js2."/Chart.bundle.min.js?ver=".time()."\"></script>";
			echo "<script type=\"text/javascript\" src=\"".base_js2."/components_custom.js?ver=".time()."\"></script>";
			echo "<script type=\"text/javascript\" src=\"".base_js2."/invest/invest.js?ver=".time()."\"></script>";

			echo "<link rel=\"stylesheet\" href=\"".base_css2."/invest/invest2.css?ver=".time()."\">";
			echo "<link rel=\"stylesheet\" href=\"".base_css2."/invest/override.css?ver=".time()."\">";
			echo "<link rel=\"stylesheet\" href=\"".base_css2."/common.css?ver=".time()."\">";
		break;
		case "myinvest":
			echo "<script type=\"text/javascript\" src=\"".base_js2."/myinvest/myinvest.js?ver=".time()."\"></script>";
			echo "<link rel=\"stylesheet\" href=\"".base_css2."/myinvest/myinvest.css?ver=".time()."\">";
		break;
		case "myrepay":
			echo "<link rel=\"stylesheet\" href=\"".base_css2."/myrepay/myrepay.css?ver=".date("YmdHis")."\">";
			echo "<script type=\"text/javascript\" src=\"".base_js2."/myrepay/myrepay.js?ver=".date("YmdHis")."\"></script>";
		break;
		case "realestate":
			echo "<link rel=\"stylesheet\" href=\"".base_css2."/invest/override.css?ver=".time()."\">
				  <link rel=\"stylesheet\" href=\"".base_css2."/invest/invest2.css?ver=".time()."\">";
			echo "<script type=\"text/javascript\" src=\"".base_js2."/invest/invest.js?ver=".time()."\"></script>";
		break;
		case "dataroom":
			echo "<link rel=\"stylesheet\" href=\"".base_css2."/notice/notice.css?ver=".time()."\">";
			echo "<script type=\"text/javascript\" src=\"".base_js2."/notice/notice.js?ver=".time()."\"></script>";
		break;
		default:
			echo "<link rel=\"stylesheet\" href=\"".base_css2."/index2.css?ver=".date("YmdHis")."\">";
			echo "<link rel=\"stylesheet\" href=\"".base_css2."/override.css?ver=".date("YmdHis")."\">";
			echo "<script type=\"text/javascript\" src=\"".base_js2."/index.js?ver=".date("YmdHis")."\"></script>";
		break;
  }

  $join_php	= "join";
  $info_php	= "member_info";
  ?>

  <script type="text/javascript">
	document.domain = 'nurifunding.co.kr'; 
	
	/*
	var setCookie = function(name, value, exp) {
		var date = new Date();
		date.setTime(date.getTime() + exp*24*60*60*1000);
		document.cookie = name + '=' + value + ';expires=' + date.toUTCString() + ';path=/';
	};

	var deleteCookie = function(name) {
		document.cookie = name + '=; expires=Thu, 01 Jan 1970 00:00:01 GMT;';
	}

	var getCookie = function(name) {
		var value = document.cookie.match('(^|;) ?' + name + '=([^;]*)(;|$)');
		return value? value[2] : null;
	};
	*/

	function setCookie(name,value,d){
		document.cookie=name+'='+escape(value)+'; path=/'+(d?'; expires='+(function(t){t.setDate(t.getDate()+d);return t})(new Date).toGMTString():'');
	}

	function getCookie(name){
		name = new RegExp(name + '=([^;]*)');
		return name.test(document.cookie) ? unescape(RegExp.$1) : '';
	}
  </script>
  
  <!--[if lt IE 9]>
    <link rel="stylesheet" href="<?=base_css2;?>/grid_ie9lt.min.css?ver=<?=time();?>">
    <link rel="stylesheet" href="<?=base_css2;?>/common_ie9lt.css?ver=<?=time();?>">
	<?php
		switch($page_type) {
			case "invest":
				echo "<link rel=\"stylesheet\" href=\"".base_css2."/invest/invest2_ie9lt.css?ver=".time()."\">";
			break;
			case "faq":
				echo "<link rel=\"stylesheet\" href=\"".base_css2."/faq/faq_ie9lt.css?ver=".time()."\">";
			break;
			case "join":
			case "member":
				echo "<link rel=\"stylesheet\" href=\"".base_css2."/join/join_ie9lt.css?ver=".time()."\">";
			break;
			case "mydeposit":
				echo "<link rel=\"stylesheet\" href=\"".base_css2."/mydeposit/mydeposit_ie9lt.css?ver=".time()."\">";
			break;
			case "loan":
				echo "<link rel=\"stylesheet\" href=\"".base_css2."/loan/loan2_ie9lt.css?ver=".time()."\">";
			break;
			case "myinvest":
				echo "<link rel=\"stylesheet\" href=\"".base_css2."/myinvest/myinvest_ie9lt.css?ver=".time()."\">";
			break;
			case "service":
				echo "<link rel=\"stylesheet\" href=\"".base_css2."/service/service2_ie9lt.css?ver=".time()."\">";
			break;
			case "mypage":
				echo "<link rel=\"stylesheet\" href=\"".base_css2."/mypage/mypage_ie9lt.css?ver=".time()."\">";
			break;
			case "myrepay":
				echo "<link rel=\"stylesheet\" href=\"".base_css2."/myrepay/myrepay_ie9lt.css?ver=".time()."\">";
			break;
			case "notice":
				echo "<link rel=\"stylesheet\" href=\"".base_css2."/notice/notice_ie9lt.css?ver=".time()."\">";
			break;
			default:
				echo "<link rel=\"stylesheet\" href=\"".base_css2."/index2_ie9lt.css?ver=".time()."\">";
			break;
		}
	?>
   
    <script type="text/javascript" src="<?=base_js2;?>/ie9_lt.js?ver=<?=time()?>"></script>
    <script type="text/javascript" src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js?ver=<?=time()?>"></script>
  <![endif]-->
</head>

<body>
<?php
	if($_SERVER["REMOTE_ADDR"] == "61.74.233.194") {
?>
<div id="uppri_pop" style="position:relative; top:0px; left:50%; width:50%; z-index:10000; display:block; background:red;">
	<div style="position:absolute; right:200px; top:25px">
		<iframe id="ebiz_counter" src="https://www.nurifunding.co.kr/common/counter.php" width="300" height="350" frameborder="0" marginheight="0" marginwidth="0" scrolling="0" style="width:200px; position:absolute; top:22px;"></iframe>
	</div>
</div>
<?php
	}
?>

  <h1 class="skip">누리펀딩</h1>
  <div class="wrap">
    <!-- 일반 해더 -->
    <header class="header" id="header">
      <div class="container header-box">
        <div class="navbar-header">
          <button type="button" class="nav-tab show-xs">
            <span class="icon-bar b1"></span>
            <span class="icon-bar b2"></span>
            <span class="icon-bar b3"></span>
          </button>
          <h2><a href="/" class="navbar-brand"><img src="<?=base_img2;?>/logo.png" alt="누리펀딩로고"></a></h2>
          <a href="/member/member_info.php" class="my-tab show-xs"><img src="<?=base_img2;?>/myp_icon.png" alt="마이페이지2"></a>
        </div>
        <div class="navbar-collapse pull-right hidden-xs">
          <ul class="main-nav clearfix">
            <li><a href="/loan/">대출신청</a></li>
            <li class="hidden-xs hidden-sm hidden-margin"></li>
            <li><a href="/invest/">투자하기</a></li>
            <li class="hidden-xs hidden-sm hidden-margin"></li>
            <li><a href="/service/">회사소개</a>
              <nav class="sub-nav">
                <ul>
                  <li><a href="/service/">회사소개</a></li>
				  <li><a href="/service/ceo.php">대표이사소개</a></li>
                </ul>
              </nav>
            </li>
            <li class="hidden-xs hidden-sm hidden-margin"></li>
            <li><a>이용안내</a>
              <nav class="sub-nav">
                <ul>
				<li><a href="/faq/">FAQ</a></li> 
                  <li><a href="/notice/">공지사항</a></li>
				  <li><a href="/dataroom/">자료실</a></li>
                </ul>
              </nav>
			</li>
			<!--<li class="hidden-xs hidden-sm hidden-margin"></li>
            <li><a href="/notice/">공지시항(임시)</a></li>-->
			<?php
				if($login_mode == false) {
			?>
            <li class="hidden-xs hidden-sm hidden-margin"></li>
            <li><a class="c-blue" href="/member/<?=$join_php;?>.php">회원가입</a></li>
            <li class="hidden-xs hidden-sm hidden-margin"></li>
            <li><a class="c-blue" href="/member/login.php">로그인</a></li>
			<?php
				} else {
			?>
			<li class="hidden-xs hidden-sm hidden-margin"></li>
            <li><a class="c-blue" href="/member/myinvest.php">내정보</a>
				<nav class="sub-nav">
                <ul>
                  <li><a href="/member/myinvest.php">나의투자정보</a></li>
                  <li><a href="/member/<?=$info_php;?>.php">회원정보</a></li>
				  <li><a href="/member/account.php">계좌정보</a></li>
				  <li><a href="/member/logout.php">로그아웃</a></li>
                </ul>
              </nav>
			</li>
            <li class="hidden-xs hidden-sm hidden-margin"></li>
			<?php
			}
			?>
          </ul>
        </div>
      </div>
    </header>
    <!-- 모바일 네비게이션 -->
    <section class="mlnb-wrap show-xs" id="mlnb-wrap">
      <div class="mlnb-container">
        <header class="mlnb-header">
          <p>
            <a href="" class="mh-logo"><img src="<?=base_img2;?>/lnb_logo.png" alt="누리펀딩"></a><a href="#" class="cls-btn"><img src="<?=base_img2;?>/cls_icon.png" alt="닫기"></a>
          </p>
		  <?php
			if($login_mode != true) {
		  ?>
          <div class="t-box">
            <p>지금 바로 로그인하고</p>
            <p>누리펀딩의 투자서비스를 이용하세요!</p>
            <p class="nth-3"><a href="/member/login.php" >로그인</a><a href="/member/<?=$join_php;?>.php" class="nth-2">회원가입</a></p>
          </div>
		  <?php
			} else {
		  ?>
		  <div class="t-box">
            <p>누리펀딩의 투자서비스를 이용하세요!</p>
			<p class="nth-3">
				<a href="/member/<?=$info_php;?>.php">회원정보</a>
				<a href="/member/account.php">계좌정보</a>
				<a href="/member/myinvest.php" class="nth-2">나의투자</a>
				<a href="/member/logout.php" class="nth-2">로그아웃</a>
			</p>
          </div>
		  <?php
		  }
		  ?>
        </header>
        <ul class="mlnb">
          <li><a href="/loan/">대출신청<img src="<?=base_img2;?>/arrow_r_icon.png" alt="바로가기"></a></li>
          <li><a href="/invest/">투자하기<img src="<?=base_img2;?>/arrow_r_icon.png" alt="바로가기"></a></li>
          <li>
			<a href="javascript:void(0)">회사소개<img src="<?=base_img2;?>/arrow_r_icon.png" alt="바로가기"></a> 
			<nav class="m-sub-nav"> 
				<ul> 
					<li><a href="/service/">회사소개</a></li> 
					<li><a href="/service/ceo.php">대표소개</a></li> 
				</ul> 
			</nav> 
	      </li>
          <li>
			<a>이용안내<img src="<?=base_img2;?>/arrow_r_icon.png" alt="바로가기"></a>
			<nav class="m-sub-nav"> 
				<ul> 
					<li><a href="/faq/">FAQ</a></li> 
					<li><a href="/notice/">공지사항</a></li> 
					<li><a href="/dataroom/">자료실</a></li> 
				</ul> 
			</nav> 
			</li>
        </ul>
      </div>
    </section>