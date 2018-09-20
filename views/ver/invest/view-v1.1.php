<?php
	$page_type = "invest";
	include_once("/home/ebizdev/web-home/nurifunding.co.kr/www/web-home/common/top.php");

		$_POST["num"] = !empty($_GET["num"]) ? $_GET["num"] : $_POST["num"];

		if(empty($_POST["num"])) {
			echo "<script>
				alert('잘못된 접근입니다');
				location.href='/invest/';
			</script>";
		}
		$qry = "select * from goods where num = '".$_POST["num"]."'";
		$res = mysql_query($qry);
		$row = mysql_fetch_array($res);
		
		$pqry = "select count(num) as cnt from pay where goodsno = '".$row["num"]."'";
		$pres = mysql_query($pqry);
		$cnt = mysql_fetch_array($pres);

		## 2018.09.06 박근수 지겹네...소수점 -> 없애달라 -> 소수점 -> 없애달라
		$per = @round(($row["mprice"]/$row["price"])*100);
/*
		$per = @($row["mprice"]/$row["price"])*10000;
		$per = @floor($per);
		$per = $per / 100;
*/
		$per1 = ($per == 100) ? '&nbsp;' : $per.'%';


		$url = "javascript: alert('투자모집이 완료된 건입니다.')";
		switch($row["state2"]) {
			case "S":
				$type	= "투자모집완료";
				$button	= "투자모집완료";
			break;
			case "G":
				$type	= "상환중";
				$button	= "상환중";
			break;
			case "E":
				$type = $button = "상환완료";
			break;
			case "Y":
			default:
				$type = "진행중";
				$button = "투자하기";
				$url = "javascript:invest_submit();";
			break;
		}

		$_sdate		= strtotime($row['sdate']);		// 시작일 timestamp
		$_edate		= strtotime($row['edate']);		// 종료일 timestamp

		if($_sdate > time()) {
			$type	= "준비중";
			$button	= "투자하기";
			$url	= "javascript: alert('".date("Y년 m월 d일 H시 i분 s초", $_sdate)."부터 투자 가능합니다.');";
			//$url	= "javascript: alert('".date("Y년 m월 d일", $_sdate)."부터 투자 가능합니다.');";
		} else {
			if($_edate < time() && $row["state2"] == "Y") {
				$type = "펀딩 종료";
				$button = "펀딩 종료";
				$url = "javascript: alert('펀딩종료된 건입니다.')";
			}
		}

		$info_qry	= "select * from goods_info where goods_no = '".$_POST["num"]."'";
		$info_res	= mysql_query($info_qry);
		$info		= mysql_fetch_array($info_res);	
			
		$g_qry	= "select * from grade_total where mapx = '".$info["grade2"]."' and mapy = '".$info["grade1"]."'";
		$g_sql	= mysql_query($g_qry);
		$g_row	= mysql_fetch_array($g_sql);

		$repay = json_decode($row['repay'], true);

		$repay1 = $repay['repay1'];
		$repay2	= (!empty($repay['repay2'])) ? '(거치기간 '.$repay['repay2'].')' : '';
		
		// =============================================================================
		$sdate		= $row['sdate'];				// 시작일 string
		$_sdate		= strtotime($row['sdate']);		// 시작일 timestamp

		//$_edate		= strtotime("+".$row['end_turn']." month", $_sdate);	// 종료일 timestamp
		$_edate		= strtotime($row["edate"]);
		$edate		= date("Y-m-d H:i:s", $_edate);	// 종료일 string
		
		if($_sdate > time()) {
			$s_date = explode(" ", $row["sdate"]);
			$e_date = explode(" ", $row["edate"]);

			$dday	= $s_date[0]." ~ ".$e_date[0];
			$button	= "준비중";
		} else {
			if($_edate >= time()) {
				$last_time = $_edate - time();						// 종료일 - 오늘 timestamp
				$dday = "D-".ceil(($last_time) / 86400)."일";		// dday 구하기
			} else {
				$dday = "펀딩 종료";
			}
		}
		// =============================================================================

		
		//## =========================== 멤버 잔액조회 ===========================
		$_url			= "/v5/member/seyfert/inquiry/balance";

		$val			= "reqMemGuid=".$Guid;
		$val			.= "&_method=GET";
		$val			.= "&nonce=".$member_info["num"].time();
		$val			.= "&_lang=ko";
		$val			.= "&dstMemGuid=".$member_info["guid"];
		$val			.= "&crrncy=KRW";

		$result			= apiAct($_url, $val, "GET", $Guid, $KeyP);

		if($result["status"] == "SUCCESS") {
			$cash	= $result["data"]["moneyPair"]["amount"];
		} else {
			$cash	= 0;
		}

//print_r($member_info);

	?>


	<script type="text/javascript" src="https://openapi.map.naver.com/openapi/v3/maps.js?clientId=B_2aLLE5fvrWaehhjkYt&submodules=geocoder"></script>
	<script type="text/javascript" src="https://www.nurifunding.co.kr/static/js/jquery.dotdotdot.js"></script>
	<script type="text/javascript">
		function invest_price(val) {
			var per = "<?=$row['profit']?>";
			var date = "<?=$row['end_turn']?>"
			var price = val * 10000;
			//var price = 900000;
			per = per/12;
			
			var value = per*price*date*0.01;
			value	= value * 0.725;
			$("#total_price").html(AddComma(Math.floor(value))+" 원");
		}
		function invest_submit() {
			$("#iform").submit();
		}
		function more_txt() {
			var tit	= $('#goods_title_real').html();
			var txt = $('#goods_txt_real').html();

			$('#goods_content #g_content_tt').html(tit);
			$('#goods_content #g_content_ct').html(txt);
			$('#goods_content').show();
		}

		function close_more_txt() {
			$('#goods_content #g_content_tt, #goods_content #g_content_ct').html('');
			$('#goods_content').hide();
		}

		function print_pop(gnum) {
			var url = "./print/view.php?num="+gnum;
			var ww = window.open(url, "print_view", "width=1065, height=750, scrollbars=yes")

			ww.focus();
		}

		function login_chk() {
			alert('로그인 후 확인하실 수 있습니다.');
			setCookie('docu_layout', 'on', '1');
			location.href = '/member/login.php?url=/invest/view.php?num=<?=$_GET["num"]?>';
		}

		function price_plus(price) {
			var prev_price = Number($('input[name="invest_price"]').val());
			$('input[name="invest_price"]').val(prev_price + Number(price));
		}

		function money_chk(start) {

			if(start == 'Y') {
				price = 100;
			} else {
				var price = $('input[name="money_chk"]').val();
				price = Number(price.replace(",", ""));
			}

			$.ajax({
				type	:	"POST",
				data	:	{"mode":"<?=XOREncode('money_chk')?>", "goodsno":"<?=$_GET['num']?>", "price":price},
				url		:	"/inc/state.php",
				success	:	function(data) {
					$('#money_chk_div').html(data);
				}
			});
		}
		
		function cmaComma(obj) {
			var firstNum = obj.value.substring(0, 1);
			var strNum = /^[/,/,0,1,2,3,4,5,6,7,8,9,/]/;
			var str = "" + obj.value.replace(/,/gi,'');
			var regx = new RegExp(/(-?\d+)(\d{3})/);  
			var bExists = str.indexOf(".",0);  
			var strArr = str.split('.');  
		 
			if (!strNum.test(obj.value)) {
				obj.value = "";
				return false;
			}
		 
			if ((firstNum < "0" || "9" < firstNum)){
				obj.value = "";
				return false;
			}
		 
			while(regx.test(strArr[0])){  
				strArr[0] = strArr[0].replace(regx,"$1,$2");  
			}  
			if (bExists > -1)  {
				obj.value = strArr[0] + "." + strArr[1];  
			} else  {
				obj.value = strArr[0]; 
			}
		}
	</script>

	<script>
		$(function() {
			var docu_val = getCookie('docu_layout');

			if(docu_val == "on") {
				setCookie('docu_layout', '', '-1');

				var offset = $("#docu_layout").offset();
				$(window).scrollTop(offset.top);
			}

			money_chk(100);
		});
	</script>

	<form action="/invest/application.php" id="iform" method="POST">
		<input type="hidden" name="num" value="<?=$row["num"]?>" />
	
	<!-- 02.부동산 -->
    <section class="estate">
      <div class="container">
        <div class="row com-box est-wrap">
          <p class="bond-num">
			채권번호 : <?=$row["num"]?>호
			<?php
				if($_SERVER["REMOTE_ADDR"] == "61.74.233.194" || $_SERVER["REMOTE_ADDR"] == "61.74.233.195") {
			?>
			<a href="javascript: void();" class="fc-white br4 hidden-xs hidden-sm a-print" onclick="javascript: print_pop('<?=$row["num"];?>');"> 
				<span class="s-img"><img src="https://nurifunding.co.kr/img/invest/icon_print_blue.png" alt="프린트하기"></span>&nbsp;프린트&nbsp;
			</a>
			<?php
				}
			?>
		  </p>
          <h2 class="est-h2" id="goods_title_real"><?=$row["name"]?></h2>
        </div>
        <!-- 180622 투자상품 상단 최상단 리뉴얼 -->
		<div class="row com-box est-wrap">
			<div class="row invest-detail-view-area">
			   <!-- 이미지 -->
				<div class="invest-img">
					<?php
						$img = explode("||", $row['img2']);
						
						if($img[0] != "") {
					?>
					<img src="<?=$img[0];?>" alt="<?=$row['name'];?>">
					<?php
						} else {
					?>
					<span><?=$row["name"];?></span>
					<?php
						}
					?>
					
				</div>
				
				<!-- 투자 -->
				<div class="invest-detail-box bor-ddd br4">
					<!-- 퍼센트바 -->
					<div class="est-box per-bar clearfix">
						<p class="inBar" style="width: <?=$per;?>%;"></p>
					</div>
					
					<!-- 모집기간 및 퍼센트 -->
					<div class="invest-per-box">
						<p class="per-txt fc-blue"><?=$per1?></p>
						<?php
							$goods_price	= number_change($row["price"]);
							$goods_mprice	= ($row["mprice"] > 0) ? number_change($row["mprice"]) : 0;
						?>
						<p class="per-money"><em class="f-bd"><?=$goods_mprice;?>원</em> / <?=$goods_price;?>원</p>
						<!--span class="per-people">160명 참여</span-->
						
						<p class="end-txt-box">
							<span class="fc-blue"><?=$type;?></span>
							<span><?=str_replace('-', '.', substr($row['sdate'], 2, 11))?>시 ~ <?=str_replace('-', '.', substr($row['edate'], 2, 11))?>시</span>
						</p>
					</div>
					
					<!-- 잔액 및 한도 -->

					<?php if($row['state2'] == 'G') { ?>

					<div class="iv-complete">
						<p class="iv-p1">
							본 투자건은 성공적으로 모집이 완료되어<br>
							<strong>현재 상환중입니다.</strong>
						</p>
						<a href="/invest" class="iv-a1">다른 투자상품 보기</a>
					</div>

					<?php } else { ?>

					<div class="invest-money-box">
						<?php
						switch($member_info['mtype']) {
							case 1:
							case 5:
								$Limit = number_format(5000000).'원';			break;
							case 3:
							case 6:
								$Limit = number_format(20000000).'원';			break;
								break;
							default:
								$Limit = '별도의 투자한도 없음';						break;
								break;
						}
						?>

						<div class="my-money-txt"><p class="money-txt">나의 가상계좌 잔액 : <?=@number_format($cash);?>원</p></div>
						<div class="row max-money-txt">
							<p class="money-txt">투자한도 : <?=$Limit?></p>
							
							<div class="tooltip-box">
								<span class="tooltip-txt">투자한도</span>
								<a href="javascript:;" class="btn-tooltip" title="투자한도 안내 상세보기"><span>?</span></a>
					
								<div class="tooltip-detail" style="display: none">
									<p class="f-bd money-txt">투자한도 안내</p>
									<p>
										전체 투자한도에서 상환중인 투자상품의 투자금액을 뺀 현재 투자가능금액입니다.
									</p>
								</div>
							</div>							
						</div>
					</div>



					
					<!-- 투자 인풋 박스 -->
					<div class="row invest-input-money-box">
						<div class="invest-input-money">
						   <p class="nr-box invest-input-box br4">
								<input type="number" value="" name="invest_price" class="nr-text invest-input" placeholder="0"/>
								<span>만원</span>
						   </p>
						   <a style="cursor:pointer;" onclick="javascript: price_plus(10);" class="bg-skyblue fc-white br4 btn-add fir"><span>+10만</span></a>
						   <a style="cursor:pointer;" onclick="javascript: price_plus(100);" class="bg-skyblue fc-white br4 btn-add"><span>+100만</span></a>
						   <a style="cursor:pointer;" onclick="javascript: price_plus(500);" class="bg-skyblue fc-white br4 btn-add"><span>+500만</span></a>
						</div>
						
						<!--div class="est-box nth-3 col-xs-12 col-sm-7 btn-invest"><a class="bg-blue fc-white br4" href="javascript:invest_submit();"><?=$button?></a></div-->
						<div class="est-box nth-3 col-xs-12 col-sm-7 btn-invest"><a class="bg-blue fc-white br4" href="<?=$url?>"><?=$button?></a></div>
					</div>
					
					<?php } ?>


					
				</div>
				
			</div>
			
		</div>
		</form>

		<!-- 180622 멀티클래스 추가 및 내용 변경 -->
		<div class="row com-box est-wrap invest-list-area">
			<div class="invest-list-box">
				<ul class="est-b4-ul clearfix">
					<li class="est-b4-li1">
						<p class="est-b4-p1">등급</p>
						<p class="est-b4-p2"><i class="c-blue"><?=$info["grade1"];?></i></p>
					</li>
					<li class="est-b4-li2">
						<p class="est-b4-p1">예상 수익률</p>
						<p class="est-b4-p2"><?=$row["profit"]?>%</p>
					</li>
					<li class="est-b4-li3">
						<p class="est-b4-p1">기간</p>
						<p class="est-b4-p2"><?=$row["end_turn"]?>개월</p>
					</li>
					<li class="est-b4-li4">
						<p class="est-b4-p1">상환방식</p>
						<p class="est-b4-p2"><?=$repay1;?><?=$repay2;?></p>
					</li>
				</ul>
			</div>
		</div>
		
                
		<!-- 180718 투자예상정보 및 예상수익률 -->
		<?php
			if($row["state2"] == "Y") {
		?>
		<div class="row com-box est-wrap exp-calc-area" id="money_chk_div">
			<div class="est-box est-com br4 col-xs-12">
				<div class="exp-calc-box">
					<div class="calc-txt-box">
						<!-- 현재 기본값 100만원 -->
						<p>투자예정금 <input type="text" name="money_chk" onkeyup="cmaComma(this);" class="nr-text exp-input" placeholder="" value="100"> 만원 투자시 예상수익은 ?</p>
						<a style="cursor:pointer" onclick="javascript: money_chk(0);" class="bg-skyblue fc-white br4 btn-rvn">수익확인</a>
					</div>
					
					<!-- 수익확인 내용 -->
					<div class="calc-list-box">
						<ul class="calc-list clearfix">
							<li class="calc-li-1">
								<p class="calc-p1">대출실행일</p>
								<p class="calc-p2 fc-lightblue">기준 </p>
							</li>
							<li class="calc-li-2">
								<p class="calc-p1">만기상환일</p>
								<p class="calc-p2 fc-lightblue"></p>
							</li>
							<li class="calc-li-3">
								<p class="calc-p1">투자원금</p>
								<p class="calc-p2 fc-lightblue"></p>
							</li>
							<li class="calc-li-4">
								<p class="calc-p1">수익금(세전)</p>
								<p class="calc-p2 fc-lightblue"></p>
							</li>
							<li class="calc-li-5">
								<p class="calc-p1">세금(이자소득세+주민세)</p>
								<p class="calc-p2 fc-lightblue"></p>
							</li>
							<li class="calc-li-6">
								<p class="calc-p1">수익금(세후)</p>
								<p class="calc-p2 fc-lightblue"></p>
							</li>
						</ul>
					</div>
					
					<a href="javascript:;" class="bg-gray2 fc-white br4 btn-table">월별 수익금 지급 예정표 <span class="exp-txt">열기</span><span class="exp-deco"></span></a>
				</div>
				
				<!-- 월별 수익금 지급 예정표 -->
				<div class="exp-list-box" style="display:none">
					<p class="exp-list-tit">※ 금일 2018년 6월 28일 대출실행시 기준</p>
					
					<div class="exp-list">
						<div class="thead">
							<ul class="tr">
								<li class="th nth-1">회차</li>
								<li class="th nth-2">지급일</li>
								<li class="th nth-3">이용일수</li>
								<li class="th nth-4">수익금(세전)</li>
								<li class="th nth-5">이자소득세</li>
								<li class="th nth-6">주민세</li>
								<li class="th nth-7">수익금(세후)</li>
							</ul>
						</div>
						<div class="tbody">
							<ul class="tr">
								<li class="td nth-1">1회차</li>
								<li class="td nth-2">2018.07.01</li>
								<li class="td nth-3">4일</li>
								<li class="td nth-4">1,316원</li>
								<li class="td nth-5">320원</li>
								<li class="td nth-6">30원</li>
								<li class="td nth-7">966원</li>
							</ul>
							<ul class="tr">
								<li class="td nth-1">2회차</li>
								<li class="td nth-2">2018.08.01</li>
								<li class="td nth-3">31일</li>
								<li class="td nth-4">10,192원</li>
								<li class="td nth-5">2,540원</li>
								<li class="td nth-6">250원</li>
								<li class="td nth-7">7,402원</li>
							</ul>
							<ul class="tr">
								<li class="td nth-1">3회차</li>
								<li class="td nth-2">2018.09.01</li>
								<li class="td nth-3">31일</li>
								<li class="td nth-4">10,192원</li>
								<li class="td nth-5">2,540원</li>
								<li class="td nth-6">250원</li>
								<li class="td nth-7">7,402원</li>
							</ul>
							<ul class="tr">
								<li class="td nth-1">4회차</li>
								<li class="td nth-2">2018.10.01</li>
								<li class="td nth-3">30일</li>
								<li class="td nth-4">9,864원</li>
								<li class="td nth-5">2,460원</li>
								<li class="td nth-6">2400원</li>
								<li class="td nth-7">7,164원</li>
							</ul>
							<ul class="tr">
								<li class="td nth-1">5회차</li>
								<li class="td nth-2">2018.11.01</li>
								<li class="td nth-3">31일</li>
								<li class="td nth-4">10,192원</li>
								<li class="td nth-5">2,540원</li>
								<li class="td nth-6">250원</li>
								<li class="td nth-7">7,402원</li>
							</ul>
							<ul class="tr">
								<li class="td nth-1">11회차</li>
								<li class="td nth-2">2019.05.01</li>
								<li class="td nth-3">30일</li>
								<li class="td nth-4">9,864원</li>
								<li class="td nth-5">2,460원</li>
								<li class="td nth-6">2400원</li>
								<li class="td nth-7">7,164원</li>
							</ul>
						</div>
						<div class="tfoot">
							<ul class="tr">
								<li class="td nth-1">합계</li>
								<li class="td nth-4">9,591,583원</li>
								<li class="td nth-5">397,530원</li>
								<li class="td nth-6">399,690원</li>
								<li class="td nth-7">109,363원</li>
							</ul>
						</div>
					</div>
					
					<p class="exp-list-txt">※ 대출 실행일이 매월 1일 ~ 24일까지 - 첫번째 이자수익 지급일은 익월 첫영업일입니다.</p>
					<p class="exp-list-txt">※ 대출 실행일이 매월 25일 ~ 말일까지 - 첫번째 이자수익 지급일은 익익월 첫영업일입니다.</p>
				</div>
				
			</div>
		</div>
		<?php
			}
		?>

        <div class="row com-box est-wrap">
          <div class="est-box est-com nth-5 br4 col-xs-12">
            <h3 class="est-com-h3"><span class="fc-blue" id="invest_content">1.</span> 투자 개요</h3>


            <table id="guide_line" class="tbCms guideLine last-none">
			<colgroup>
				<col class="nth-1">
				<col class="nth-2">
			</colgroup>
			<thead>
				<tr>
					<th>구분</th>
					<th>내용</th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td>상품</td>
					<td><em class="fc-blue"><?=$info['product_type']?></em></td>
				</tr>
				<tr>
					<td>대출금</td>
					<td><em class="fc-blue"><?=number_change($row['price'])?>원</em></td>								
				</tr>
				<tr>
					<td><?=$info['txt2']?></td>
					<td><?=number_change($info['set_price'])?>원</td>								
				</tr>
				<tr>
					<td>상품종류</td>
					<td><?=$row['goods_type']?></td>
				</tr>
				<tr>
					<td>담보이용</td>
					<td><?=$info['collateral_use']?></td>
				</tr>
				<tr>
					<td><?=$info['txt1'];?></td>
					<td><?=number_change($info['collateral'])?>원</td>
				</tr>
				<tr>
					<td>자금용도</td>
					<td><em class="fc-blue"><?=$info['use']?></em></td>
				</tr>
				<tr>
					<td>안전장치</td>
					<td><?=nl2br($info["safety"]);?></td>
				</tr>
				<tr>
					<td>상품상세</td>
					<td><?=nl2br($row["goods_text"]);?></td>
				</tr>				
			</tbody>
			</table>

          </div>
        </div>
        <div class="row com-box est-wrap">
          <div class="est-box est-com nth-6 br4 col-xs-12">
            <h3 class="est-com-h3"><span class="fc-blue">2.</span> 투자 포인트</h3>
            <table class="tbCms">
			<colgroup>
				<col class="nth-1">
				<col class="nth-2">
			</colgroup>
			<thead>
				<tr>
					<th>구분</th>
					<th>내용</th>
				</tr>
			</thead>
			<tbody>
			<?php
				$title_arr		= json_decode($info["collateral_title"],true);
				$contents_arr	= json_decode($info["collateral_contents"],true);
				for($col_cnt=0; $col_cnt < 4; $col_cnt++) {
					$col_title = "";
					switch($col_cnt) {
						case "0":	$col_title	= "장점";	break;
						case "1":	$col_title	= "단점";	break;
						case "2":	$col_title	= "기회";	break;
						case "3":	$col_title	= "위협";	break;
					}
			?>
				<!--<h4><?=($col_cnt+1)?>. <?=$title_arr[$col_cnt]?></h4>-->
				<!--h4><?=($col_cnt+1)?>. <?=$col_title?></h4-->
				<tr><td><?=$col_title?></td><td><?=nl2br($contents_arr[$col_cnt])?></td></tr>
				<!--p class="left-b"><span class="b-icon">-</span><?=nl2br($contents_arr[$col_cnt])?></p-->
			<?php
				}
			?>
			</tbody>
			</table>


          </div>
        </div>
		 <?php
			$i_price2			= $info["price2"] / 10000;
			$i_price3			= $info["price3"] / 10000;

			$bank_price			= $info["bank_price"] / 10000;
			$life_price			= $info["life_price"] / 10000;
			$have_price			= $info["have_price"] / 10000;

			$dambo_total_price	= $info["price1"]+$i_price2+$i_price3;
			$dambo_all			= $row["dambo_loan"] + $row["dambo_deposit"] + $row["dambo_free"] + $row["dambo_tra"] + $row["dambo_trb"] + $row["dambo_trc"];

			if($dambo_total_price != $dambo_all) {
				$price_all		= $dambo_all / 10000;
				$price1			= $row["dambo_deposit"] / 10000;
				$price2			= ($dambo_all - $row["dambo_deposit"] - $row["dambo_free"]) / 10000;
				$price3			= $row["dambo_free"] / 10000;
			} else {
				$price_all		= $dambo_total_price;
				$price1			= $info["price1"];
				$price2			= $i_price2;
				$price3			= $i_price3;
			}

			
			$collateral	= $info["collateral"];
			$col_val	= $info["val"] / 100;									// 감정비율
			$chk_price	= ($collateral * $col_val);								// 감정가

			$ord_price	= ($info["first_ord"] + $info["second_ord"]);			// 선순위금
			$nuri_price	= $row["price"];										// 누리펀딩 대출금

			$free_price	= $chk_price - $ord_price - $nuri_price;				// 잔여 여유금
		  ?>
        <div class="row com-box est-wrap">
          <div class="est-box est-com nth-7 br4 col-xs-12">
            <h3 class="est-com-h3"><span class="fc-blue">3.</span> 누리펀딩에서 설정한 담보</h3>
            <ul class="est-b7-ul clearfix">
              <li class="est-b7-li1">
                <div id="canvas-holder-7"><span class="in-txt">담보가치 대비<br/>대출비율</span><canvas id="chart-area-7"></canvas></div>
                <script>
					var dataGroup7 = {"price1" : <?=@round($ord_price/$chk_price*100)?>, "price2" : <?=@round($nuri_price/$chk_price*100)?>, "price3" : <?=@round($free_price/$chk_price*100)?>};   

					var config7 = {
						type: 'doughnut',
						data: {
							datasets: [{
								data: [
									dataGroup7.price1,
									dataGroup7.price2,
									dataGroup7.price3,
								],
								backgroundColor: [
									"#dcdcdc",
									"#398FE2",
									"#121212",
								],
								borderWidth: [
									5
								]
							}],
							labels: [
								"선순위금",
								"누리펀딩 대출금",
								"잔여 여유금"
							]
						},
						options: {
							responsive: true,
							animation: {
								animateScale: false,
								animateRotate: true
							},
							legend: {
								display: false
							},
							tooltips : {
								callbacks : { 
									label : function(tooltipItem, data) {
										var indice = tooltipItem.index;
										var dataset = data.datasets[tooltipItem.datasetIndex];
										var currentLabel = data.labels[indice];
										var currentValue = dataset.data[tooltipItem.index];
										return " " + currentLabel + " : " + currentValue + " %";
									}
								}
							}
						}
					};    
                </script>
                
              </li>
              <li class="est-b7-li2 clearfix">
                <p class="est-b7-p1 clearfix"><span class="pull-left">담보 감정가</span><em class="pull-right"><?=number_change($chk_price)?><span>원</span></em></p>
                <p class="est-b7-p2 clearfix">
                  <span class="dot1 pull-left">&#9679;</span>
                  <span class="pull-left">선순위금</span>
                  <em class="pull-right"><?=number_change($ord_price)?>원 ( <?=@round($ord_price/$chk_price*100)?>% )</em>
                </p>
                <p class="est-b7-p2 clearfix">
                  <span class="dot2 pull-left">&#9679;</span>
                  <span class="pull-left">누리펀딩 대출금</span>
                  <em class="pull-right"><?=number_change($nuri_price)?>원 ( <?=@round($nuri_price/$chk_price*100)?>% )</em>
                </p>
                <p class="est-b7-p2 clearfix">
                  <span class="dot3 pull-left">&#9679;</span>
                  <span class="pull-left">잔여 여유금</span>
                  <em class="pull-right"><?=number_change($free_price)?>원 ( <?=@round($free_price/$chk_price*100)?>% )</em>
                </p>
                <!--p class="est-b7-p3 pull-right">(선순위금 채권최고액 : 19,680만원)</p-->
              </li>
            </ul>
            <h4>'선순위금'이란?</h4>
            <p class="left-b"><span class="b-icon">-</span>누리펀딩 대출금액보다 선순위의 권리로 타금융 기관대출금 또는 임대보증금 등 모든선순위 권리금액을 말합니다.</p>
            <h4>'담보여유'이란?</h4>
            <p class="left-b"><span class="b-icon">-</span>누리펀딩 대출 후에도 남아있는 담보의 잔존가치로 이 비율이 높을수록 채무불이행이 발생해도 원금 손실 가능성이 작아집니다.</p>
            <h4>'<?=$info["txt2"];?>'이란?</h4>
            <p class="left-b"><span class="b-icon">-</span>담보에 대한 채권자의 권리금액으로 채무불이행 시 연체이자, 채권회수 비용 등을 감안하여 대출금의 120% 이상 설정합니다.</p>
            <hr/>
            <h3 class="est-com-h3"><span class="fc-blue">4.</span> 투자자 보호</h3>
            <h4>1. 담보물 변동사항 모니터링 시스템</h4>
            <p class="left-b"><span class="b-icon">-</span>누리펀딩의 리스크관리 시스템에 의해 해당 담보물의 가치변동 및 권리침해 여부가 매일 모니터링 되고 있습니다.</p>
            <h4>2. 부실채권 사후처리 시스템</h4>
            <p class="left-b"><span class="b-icon">-</span>대출기간이 지나거나 이자를 2회 이상 지체 시 누리펀딩은 적절한 절차에 의하여 다음과 같은 자체 추심을 진행합니다.</p>
            <!-- <a class="fc0" href="/invest/realestate.php?num=<?=$_POST["num"]?>">자세히보기</a> -->
			
            <!-- 부동산 리스트 점검 -->
	        <section class="grade-sec rEstate-sec">
	            
		        <?php
					$num	= $_GET["num"];
					
					$qry = "select * from goods where num = '".$num."'";
					$res = mysql_query($qry);
					$row = mysql_fetch_array($res);

					$d_txt		= $row["gtype"] == "부동산" ? "부동산" : $row["txt"];

					$info_qry	= "select * from goods_info where goods_no = '".$num."'";
					$info_res	= mysql_query($info_qry);
					$info		= mysql_fetch_array($info_res);

					$per_arr	= array(0, 10, 15, 20, 25, 30, 35, 40);	// 부동산 시세 배열

					$market		= json_decode($info["market"], true);
				    $land       = json_decode($info["land"], true);
				?>

		        <h3 class="est-com-h3">
		        	<span class="fc-blue">4-1.</span> 
		        	<?=$d_txt?> 시세변동에 따른 리스크 점검
		        </h3>
                <!-- <h2 class="grd-h2"><?=$d_txt?> 시세변동에 따른 리스크 점검</h2> -->
                <!--180227 클래스 추가-->
                <div class="rEstate-per row com-box br4">
                    <h3 class="grd-com-h3"><?=$d_txt?> 가격 변동추이</h3>
                    <!--180227 차트 변경-->
                    <div class="canvas-wrap">
                        <div class="canvas-box">
                            <div id="canvas-holder-per">
                                <canvas id="chart-area-per"></canvas>
                            </div>
                        </div>
                        <span class="s-x">(%)</span>
                        <span class="s-y">(년도)</span>
                    </div>
                    <script>
                        var standard = ["100", "100", "100", "100"];
                        var dataPer = ["<?=$market['market1']?>", "<?=$market['market2']?>", "<?=$market['market3']?>", "<?=$market['market4']?>"];
                        var config = {
                            type: 'line',
                            data: {
                                labels: ["2014.12", "2015.12", "2016.12", "현재"],
                                datasets: [{
                                    label: "현재시세",
                                    backgroundColor: '#ff0404',
                                    borderColor: "#ff0404",
                                    data: [
                                        standard[0],
                                        standard[1],
                                        standard[2],
                                        standard[3]
                                    ],
                                    fill: false,
                                    lineTension: 0
                                },  {
                                    label: "변동추이",
                                    backgroundColor: '#398fe1',
                                    borderColor: "#398fe1",
                                    data: [
                                        dataPer[0],
                                        dataPer[1],
                                        dataPer[2],
                                        dataPer[3]
                                    ],
                                    fill: false,
                                    lineTension: 0
                                }]
                            },
                            options: {
                                responsive: true,
                                tooltips: {
                                    mode: 'index',
                                    intersect: false,
                                },
                                scales: {
                                    yAxes: [{
                                        ticks: {
                                            suggestedMin: 50,
                                            suggestedMax: 150,
                                        }
                                    }]
                                },
                            }
                        };
                    </script>
                </div>
                
                <div class="row com-box br4">
                    <h3 class="grd-com-h3"><?=$d_txt?> 가격 하락시 대출금 상환 가능성 점검</h3>
                    <p class="ps">(단위 : 백만원)</p>
                    <table class="repay-tb">
                        <tr>
                            <th class="nth-1"><div>구 분</div></th>
                            <th class="nth-2"><div>현재시세</div></th>
                            <th class="nth-3"><div><span class="xs-block320">감정</span>비율</div></th>
                            <th class="nth-4"><div>감정가</div></th>
                            <th class="nth-5"><div>우선순위</div></th>
                            <th class="nth-6"><div><span class="xs-block">본건</span>대출금</div></th>
                            <th class="nth-7"><div>남는담보</div></th>
                        </tr>

						<?php
							for($i=0; $i<count($per_arr); $i++) {
								$title		= $i == 0 ? "<span class=\"xs-block\">현재</span> 시세" : "<span class=\"xs-block\">".$per_arr[$i]."%</span> 하락";
								$minus		= ($info["collateral"] * $per_arr[$i]) / 100;	// 현재시세 계산용
								$collateral	= $info["collateral"] - $minus;					// 현재시세 ( 현재시세 - 부동산 하락가 )
								$col_val	= $info["val"];									// 감정비율

								$chk_price	= ($collateral * $col_val) / 100;				// 감정가
								
								$ord_price	= ($info["first_ord"] + $info["second_ord"]);			// 선순위금
								$nuri_price	= $row["price"];										// 누리펀딩 대출금

								$free_price	= $chk_price - $ord_price - $nuri_price;				// 잔여 여유금
                                $style      = ($free_price < 0) ? 'color: red;' : '';
						?>
							<tr>
								<td class="nth-1"><div><?=$title;?></div></td>
								<td><div style="text-align:right; padding-right:10px;"><?=number_format($collateral/1000000);?></div></td>
								<td><div style="text-align:right; padding-right:10px;"><?=$col_val;?>%</div></td>
								<td><div style="text-align:right; padding-right:10px;"><?=number_format($chk_price/1000000);?></div></td>
								<td><div style="text-align:right; padding-right:10px;"><?=number_format($ord_price/1000000);?></div></td>
								<td><div style="text-align:right; padding-right:10px;"><?=number_format($nuri_price/1000000);?></div></td>
								<td class="nth-7"><div style="text-align:right; padding-right:10px; <?=$style?>"><?=number_format($free_price/1000000);?></div></td>
							</tr>
						<?php
							}
						?>
                    </table>
                    
                </div>
                
				<?php if($row["gtype"] == "부동산") { ?>
                <div class="row com-box br4">
                    <h3 class="grd-com-h3">부동산 수익률 분석</h3>
                    <table class="yield-tb">
                        <tr>
                            <th><div>부동산 가격</div></th>
                            <th><div>대출금</div></th>
                            <th><div>전세보증금</div></th>
                            <th><div>자기자금</div></th>
                            <th><div>연간임대료</div></th>
                            <th><div>수익률</div></th>
                        </tr>
                        <tr>
                            <td><div><?=number_format($land['land1'])?>원</div></td>
                            <td><div><?=number_format($land['land2'])?>원</div></td>
                            <td><div><?=number_format($land['land3'])?>원</div></td>
                            <td><div><?=number_format($land['land4'])?>원</div></td>
                            <td><div><?=number_format($land['land5'])?>원</div></td>
                            <td><div><?=@($land['land5'] / $land['land4'] * 100)?>%</div></td>
                        </tr>
                    </table>
                </div>
				<?php }	?>
	        </section>
          </div>
        </div>


        <div class="row com-box est-wrap" id="docu_layout">
          <div class="est-box est-com nth-8 br4 col-xs-12">
            <h3 class="est-com-h3"><span class="fc-blue">5.</span> 증빙서류</h3>

			

            <ul class="reg-box clearfix">
			<?php
				$docu_arr = json_decode($info["docu"], true);
				for($docu_cnt=0; $docu_cnt<count($docu_arr); $docu_cnt++) {
					$docu_info = explode("||",$docu_arr[$docu_cnt]);
					if($docu_info[0] != "") {

						if(empty($member_info)) {
							$file_url	= "javascript: login_chk();";
							$box_class	= "";
						} else {
							if($docu_info[3] == "2") {
								$p_chk	= "select count(*) as cnt from pay where uid = '".$member_info["num"]."' and goodsno = '".$_GET["num"]."' and state = 'Y' and gubun = '-'";
								$p_res	= mysql_query($p_chk);
								$pay_chk	= mysql_fetch_array($p_res);

								if($pay_chk["cnt"] > 0) {
									$file_url	= "javascript: location.href='".$docu_info[2]."';";
									$box_class	= "lightBox";
								} else {
									$file_url	= "javascript: alert('투자 후 확인하실 수 있습니다.');";
									$box_class	= "";
								}
							} else {
								$file_url	= "javascript: location.href='".$docu_info[2]."';";
								$box_class	= "lightBox";
							}
						}
			?>
              <li class="reg-inner <?=$box_class;?>">
			    <a data-lightbox-gallery="reg" style="cursor:pointer" onclick="<?=$file_url?>" title="<?=$docu_info[0]?>" target="_blank" class="reg-link">
                  <img src="<?=$docu_info[1]?>" onerror="this.src='https://www.nurifunding.co.kr/img/docu.png'" alt="<?=$docu_info[0]?>">
                  <span class="reg-cap"><?=$docu_info[0]?></span>
                </a>
              </li>
		  <?php
					}
				}
			?>
              
            </ul>            
          </div>
        </div>
        <div class="row com-box est-wrap">
          <div class="est-box est-com nth-9 br4 col-xs-12">
            <h3 class="est-com-h3"><span class="fc-blue">6.</span> 위치 및 건축물 정보</h3>
			<?php
				$map_info = explode("||",$info["map_info"]);
			?>

			<div id="map" style="width:100%;height:400px;margin-top:10px;"></div>

			<script>
			  var map = new naver.maps.Map('map');
			  var myaddress = '<?=$map_info[1]?>';// 도로명 주소나 지번 주소만 가능 (건물명 불가!!!!)
			  naver.maps.Service.geocode({address: myaddress}, function(status, response) {
				  if (status !== naver.maps.Service.Status.OK) {
					  //return alert(myaddress + '의 검색 결과가 없거나 기타 네트워크 에러');
				  }

				  var result = response.result;
				  // 검색 결과 갯수: result.total
				  // 첫번째 결과 결과 주소: result.items[0].address
				  // 첫번째 검색 결과 좌표: result.items[0].point.y, result.items[0].point.x
				  var myaddr = new naver.maps.Point(result.items[0].point.x, result.items[0].point.y);
				  map.setCenter(myaddr); // 검색된 좌표로 지도 이동
				  // 마커 표시
				  var marker = new naver.maps.Marker({
					position: myaddr,
					map: map
				  });
				  // 마커 클릭 이벤트 처리
				  naver.maps.Event.addListener(marker, "click", function(e) {
					if (infowindow.getMap()) {
						infowindow.close();
					} else {
						infowindow.open(map, marker);
					}
				  });
				  // 마크 클릭시 인포윈도우 오픈
				  var infowindow = new naver.maps.InfoWindow({
					  content: '<h4 style="padding:5px;">[<?=$row["name"]?>]</h4>'
				  });
				  map.setOptions({ //지도 인터랙션 끄기
					draggable: false,
					pinchZoom: false,
					scrollWheel: false,
					keyboardShortcuts: false,
					disableDoubleTapZoom: true,
					disableDoubleClickZoom: true,
					disableTwoFingerTapZoom: true
				});
			  });
			  </script>

			<div style="float:right;display: block;text-align: center;padding: 6px;font-size: 15px;letter-spacing: 0;border-radius: 4px;background-color: #398fe1;color: #fff;cursor:pointer;margin-top:5px;" onclick="javascript:window.open('http://map.naver.com?query=<?=$map_info["1"]?>')">
				크게보기
			</div>

            <p class="left-b mt" style="clear:both;"><span class="b-icon">-</span>구분 : <?=$row["goods_type"]?></p>
            <p class="left-b"><span class="b-icon">-</span>면적 : <?=$map_info[0]?>㎡ </p>
            <p class="left-b"><span class="b-icon">-</span>주소 : <?=$map_info[1]?></p>
          </div>
        </div>
        
        <div class="row com-box est-wrap">
          <div class="est-box est-com nth-16 br4 col-xs-12">
            <h3 class="est-com-h3"><span class="fc-blue" id="return">7.</span> 대출자 정보</h3>
			
			<div class="est-box est-com nth-12 br4 col-xs-12 com-type2">
				<h4 class="est-com-h3"><?=($row["mtype"] == 2) ? '법인' : '개인'?>정보</h4>
				<p class="est-b7-p2 mt clearfix">
					<span class="dot1 pull-left">&#9679;</span>
					<span class="pull-left"><?=($row["mtype"] == 2) ? '매출액' : '총 소득'?></span>
					<em class="pull-right"><?=number_change($info["bank_price"])?>원</em>
				</p>
				<p class="est-b7-p2 clearfix">
					<span class="dot2 pull-left">&#9679;</span>
					<span class="pull-left"><?=($row["mtype"] == 2) ? '영업이익' : '금융비용'?></span>
					<em class="pull-right"><?=number_change($info["life_price"])?>원</em>
				</p>
				<p class="est-b7-p2 clearfix">
					<span class="dot3 pull-left">&#9679;</span>
					<span class="pull-left"><?=($row["mtype"] == 2) ? '당기순이익' : '여유자금'?></span>
					<em class="pull-right"><?=number_change($info["have_price"])?>원</em>
				</p>
			</div>

			<div class="est-box est-com nth-11 br4 col-xs-12 com-type3">
				<h4 class="est-com-h3">여신평가등급</h4>
				<p class="ebt-b11-p mt clearfix">기업(개인)의 신용등급과 담보가치를 결합한 여신평가 등급 입니다</p>
				<div class="grade">
					<h5 class="g-th c-blue f-bd align-center"><?=$info["grade1"]?></h5>
					<div class="g-chart">
						<?php
							//<!--등급에 따른 클래스추가로 따른 위치 이동-->
							switch($g_row["total"]) {
								case "C":
									echo "<span id=\"g-chart-dot\" class=\"n4\"></span>";
								break;
								case "B":
									echo "<span id=\"g-chart-dot\" class=\"n3\"></span>";
								break;
								case "A":
									echo "<span id=\"g-chart-dot\" class=\"n2\"></span>";
								break;
								case "S":
									echo "<span id=\"g-chart-dot\" class=\"n1\"></span>";
								default:
								break;
							}
						?>
					</div>
					<div class="g-label">
						<span class="nth-1">SAFTY ZONE<br>안전존</span>
						<span class="nth-2">THINK ZONE<br>고려존</span>
						<span class="nth-3">AGREE ZONE<br>고려존</span>
						<span class="nth-4">REJECT ZONE<br>거절존</span>
					</div>
					<!-- <div class="btn-area"><a class="br4 bor-ddd" href="/invest/grade.php?val=<?=XOREncode($row["num"])?>">등급 자세히보기</a></div> -->
				</div>
			</div>

			<?php
				$num	= XORDecode($_GET["val"]);
				$qry	= "select * from goods where num = '".$num."'";
				$sql	= mysql_query($qry);
				$row	= mysql_fetch_array($sql);

				$info_qry	= "select * from goods_info where goods_no = '".$num."'";
				$info_res	= mysql_query($info_qry);
				$info		= mysql_fetch_array($info_res);
				
				$dambo_all	= $row["dambo_loan"] + $row["dambo_deposit"] + $row["dambo_free"] + $row["dambo_tra"] + $row["dambo_trb"] + $row["dambo_trc"];
				$chart_all	= substr($dambo_all, 0, -4);

				$loan_per		= @number_format($row["dambo_loan"] / $dambo_all * 100, 1);
				$deposit_per	= @number_format($row["dambo_deposit"] / $dambo_all * 100, 1);
				$free_per		= @number_format($row["dambo_free"] / $dambo_all * 100, 1);
				$tra_per		= @number_format($row["dambo_tra"] / $dambo_all * 100, 1);
				$trb_per		= @number_format($row["dambo_trb"] / $dambo_all * 100, 1);
				$trc_per		= @number_format($row["dambo_trc"] / $dambo_all * 100, 1);

				
				$chk_price	= ($info["collateral"] * $info["val"]) / 100;			// 감정가
				$first_ord	= $info["first_ord"];									// 우선순위금
				$second_ord	= $info["second_ord"];									// 기존 대출금
				$nuri_price	= $row["price"];										// 누리펀딩 대출금

				$free_price	= $chk_price - $first_ord - $second_ord - $nuri_price;	// 잔여 여유금

				if($row["mtype"] == "2") {
					$mtype_gubun	= "법인";
					$mtype_class	= "alp";
				} else {
					$mtype_gubun	= "개인";
					$mtype_class	= "num";
				}


				$first_per	= @number_format($first_ord / $chk_price * 100, 1);
				$second_per	= @number_format($second_ord / $chk_price * 100, 1);
				$nuri_per	= @number_format($nuri_price / $chk_price * 100, 1);
				$free_per	= @number_format($free_price / $chk_price * 100, 1);
			?>

			<!-- 평가등급 -->
			<div class="clr"></div>
	        <section class="grade-sec">
                <h2 class="grd-h2">누리펀딩 여신평가 등급</h2>
                
                <div class="row com-box br4">
                    <h3 class="grd-com-h3"><?=$mtype_gubun;?>의 신용등급과 담보가치를 결합한 여신평가 등급</h3>
					<?php
						$g1_q = "select * from grade where type = 'y' and grade = '".$info["grade1"]."' and state = 'Y'";
						$g1_s = mysql_query($g1_q);
						$g1 = mysql_fetch_array($g1_s);
						$type_y = !empty($g1) && $g1["map"] != "" ? $g1["map"] : "10";

						$g2_q = "select * from grade where type = 'x' and grade = '".$info["grade2"]."' and state = 'Y'";
						$g2_s = mysql_query($g2_q);
						$g2 = mysql_fetch_array($g2_s);
						$type_x = !empty($g2) && $g2["map"] != "" ? $g2["map"] : "10";
					?>
					<!--div class="grd-rate-img"><img src="<?=base_img2?>/invest/i_grdCheck.png" alt="자신의등급표시" class="x-<?=$type_x?> y-<?=$type_y?>"></div-->
					<div class="grd-rate-img <?=$mtype_class;?>"><img src="<?=base_img2?>/invest/i_grdCheck.png" alt="자신의등급표시" class="x-<?=$type_x?> y-<?=$type_y?>"></div>
                    <ul class="grd-label">
                        <li class="l1">누리 STAR ZONE</li>
                        <li class="l2">SAFTY ZONE 안전존</li>
                        <li class="l3">THINK ZONE 고려존</li>
                        <li class="l4">AGREE ZONE 합의존</li>
                        <li class="l5">REJECT ZONE 거절존</li>
                    </ul>
                </div>
                
                <div class="row com-box br4">
                    <h3 class="grd-com-h3"><i>담보 가치 분석</i></h3>

					<div class="left-chart">
						<div id="canvas-holder-value">
							<span class="in-txt align-center">감정금액<br><?=@number_format($chk_price/1000000, 1);?> 백만원</span>
							<canvas id="chart-area-value" />
						</div>

						<script>
							var dataGroupGrade = [<?=$second_per;?>, <?=$first_per;?>, <?=$nuri_per;?>, <?=$free_per;?>];

							var configGrade = {
								type: 'doughnut',
								data: {
									datasets: [{
										data: [
											dataGroupGrade[0],
											dataGroupGrade[1],
											dataGroupGrade[2],
											dataGroupGrade[3],
											dataGroupGrade[4],
										],
										backgroundColor: [
											"#3AC1E3",
											"#34BA89",
											"#BED13F",
											"#DFAF2D",
											"#EA791D"
										],
										borderWidth: 2,
									}],
									labels: [
										"기존대출금",
										"우선순위금",
										"본건 대출금",
										"담보여유"
									],
									tooltips: [

									]
								},
								options: {
									responsive: true,
									animation: {
										animateScale: false,
										animateRotate: true
									},
									tooltips : { 
										callbacks : {  
											label : function(tooltipItem, data) { 
												var indice = tooltipItem.index; 
												var dataset = data.datasets[tooltipItem.datasetIndex]; 
												var currentLabel = data.labels[indice]; 
												var currentValue = dataset.data[tooltipItem.index]; 
												return " " + currentLabel + " : " + currentValue + " %"; 
											} 
										} 
									}, 
									legend: {
										display:false
									}
								}
							};
						</script>
						<div class="chart-per">
							<ul class="per-table clearfix">
								<li class="nth-2 clearfix">
									<div class="cell-1"><span class="circle"></span> 기존대출금 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:</div>
									<div class="cell-2"><?=$second_per;?>%</div>
								</li>
								<li class="nth-3 clearfix">
									<div class="cell-1"><span class="circle"></span> 우선순위금 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:</div>
									<div class="cell-2"><?=$first_per;?>%</div>
								</li>
								<li class="nth-4 clearfix">
									<div class="cell-1"><span class="circle"></span> 본건 대출금 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:</div>
									<div class="cell-2"><?=$nuri_per;?>%</div>
								</li>
								<li class="nth-5 clearfix">
									<div class="cell-1"><span class="circle"></span> 담보여유 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:</div>
									<div class="cell-2"><?=$free_per;?>%</div>
								</li>
							</ul>
						</div>
					</div>
                    

                    <div class="chart-label">
						<h4>항목별 비율 금액 (백만원)</h4>
                    	<ul class="lbl-table">
                    		<li class="nth-1">
                    			<div class="cell-1">담보감정가</div>
                    			<div class="cell-2" style="text-align:right; padding-right:10px;"><?=@number_format($chk_price / 1000000, 1);?></div>
                    		</li>
                    		<li class="nth-2">
                    			<div class="cell-1">기존대출금</div>
                    			<div class="cell-2" style="text-align:right; padding-right:10px;"><?=@number_format($second_ord / 1000000, 1);?></div>
                    		</li>
                    		<li class="nth-3">
                    			<div class="cell-1">우선순위금</div>
                    			<div class="cell-2" style="text-align:right; padding-right:10px;"><?=@number_format($first_ord / 1000000, 1);?></div>
                    		</li>
                    		<li class="nth-4">
                    			<div class="cell-1">본건 대출금</div>
                    			<div class="cell-2" style="text-align:right; padding-right:10px;"><?=@number_format($nuri_price / 1000000, 1);?></div>
                    		</li>
                    		<li class="nth-5">
                    			<div class="cell-1">담보여유</div>
                    			<div class="cell-2" style="text-align:right; padding-right:10px;"><?=@number_format($free_price / 1000000, 1);?></div>
                    		</li>
                    	</ul>
                    </div>

                    <div class="clearfix"></div>

                    <div class="grd-txt-box">
                        <p class="grd-p mt">감정금액이란? </p>
                        <p class="grd-p">현재 담보 가격에서 70% ~ 80% 수준으로 대출을 위한 적정 금액 산출한 가격</p>
                        <p class="grd-p mt">담보여유란?</p>
                        <p class="grd-p">현재 담보 가격에서 기존 대출금(기대출)과 본건 대출금으로 부동산 가격 하락시에도 대출금 회수를
                            위한 안전성을 확보할 수 있는 여유 부분</p>
                        <p class="grd-p mt">선순위란?</p>
                        <p class="grd-p">법에서 보장하는 임대 보증금, 우선 임금채권 등</p>
                        <p class="grd-p mt"><span class="xs-block">담보여유 </span>= 감정금액 - 기존대출금 - 우선순위금 - 본건 대출금</p>
                    </div>
                </div>
	                
	        </section>
          </div>
        </div>
        
        <div class="row com-box est-wrap">
          <div class="est-box est-com nth-16 br4 col-xs-12">
            <h3 class="est-com-h3"><span class="fc-blue" id="return">8.</span> 투자시 유의사항</h3>
            <p>
              온라인을 통한 금융투자상품의 투자는 회사의 권유 없이 고객님의 판단에 의해 이루어지며,<br/>
			  대출의 특성상 상환예정일 이전에 중도 상환될 수 있습니다.<br/>
			  투자이용약관 제11조와 12조 내용에 따라 상환지연 등에 해당되는 경우 채권추심과 환가절차 과정에서 원금의<br/>
			  일부 손실이 발생할 수 있으며 채권추심 등을 통해 투자금 회수에 상당기간 소요될 수 있습니다.<br/>
			  당사는 원금 및 수익률을 보장하지 않으므로 투자 시 신중한 결정 바랍니다.
            </p>
          </div>
        </div>

      </div>

	  <script>
	  
		$(function() {
			//nivo라이트박스
			$('.reg-inner.lightBox a').nivoLightbox();
			$('#est-slider a').nivoLightbox();

			//부동산이미지 bxslider
			$('#est-slider').bxSlider({
				mode: 'fade',
				auto: true,
				speed: 500,
				adaptiveHeight: true,
				duration: 6000,
				prevText: '<img src="https://nurifunding.co.kr/img/invest/inv_btn_prev.png" alt="다음">',
				nextText: '<img src="https://nurifunding.co.kr/img/invest/inv_btn_next.png" alt="다음">'
			});
		});
	  </script>
      
    </section>

	<!--180329 투자상품페이지 내 투자하기 배너-->
	<div class="rBn-box hidden-xs" id="rBn-box">
		<a href="#" onclick="<?=$url;?>"><img src="https://nurifunding.co.kr/img/banner/bt_pundding.png" alt="투자하기"><br></a>
	</div>

	<div class="rBn-box-m" id="rBn-box-m">
		<a href="#" onclick="<?=$url;?>" class="a-invest">
			<img src="https://nurifunding.co.kr/img/banner/pic_coin.jpg" alt="투자하기"><br>
			펀딩상품<br>투자하기
		</a>
	</div>
	<!--End-->



    <script>
      window.onload = function() {
        var ctx7 = document.getElementById("chart-area-7").getContext("2d");
        window.myDoughnut = new Chart(ctx7, config7);

        /*var ctx11 = document.getElementById("chart-area-11").getContext("2d");
        window.myLine = new Chart(ctx11, config11);*/
        
        /*var ctx12 = document.getElementById("chart-area-12").getContext("2d");
        window.myDoughnut = new Chart(ctx12, config12);*/
        var ctx = document.getElementById("chart-area-per").getContext("2d");
        window.myLine = new Chart(ctx, config);

        var ctxGrade = document.getElementById("chart-area-value").getContext("2d");
		window.myDoughnut = new Chart(ctxGrade, configGrade);
      };
	
	$(function() {
		$('#goods_txt').dotdotdot({
			keep: '.read-more'
		});
	});
    </script>
<?php
	include_once("/home/ebizdev/web-home/nurifunding.co.kr/www/web-home/common/bottom.php");
?>