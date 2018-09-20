<?php
	$page_type = "grade";
	include_once("/home/ebizdev/web-home/nurifunding.co.kr/www/web-home/common/top.php");

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
        <section class="grade-sec">
            <div class="container">
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
                
            </div>
        </section>

		<script>
			window.onload = function () {
				var ctxGrade = document.getElementById("chart-area-value").getContext("2d");
				window.myDoughnut = new Chart(ctxGrade, configGrade);

			};
		</script>

<?php
	include_once("/home/ebizdev/web-home/nurifunding.co.kr/www/web-home/common/bottom.php");
?>