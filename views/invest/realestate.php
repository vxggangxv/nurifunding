<?php
	$page_type = "realestate";
	include_once("/home/ebizdev/web-home/nurifunding.co.kr/www/web-home/common/top.php");

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

<!-- 부동산 리스트 점검 -->
        <section class="grade-sec rEstate-sec">
            <div class="container">
                <h2 class="grd-h2"><?=$d_txt?> 시세변동에 따른 리스크 점검</h2>
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
                
            </div>
        </section>

        <!--180227 차트 스크립트-->
        <script>
            window.onload = function () {
                var ctx = document.getElementById("chart-area-per").getContext("2d");
                window.myLine = new Chart(ctx, config);
            };
        </script>

<?php
	include_once("/home/ebizdev/web-home/nurifunding.co.kr/www/web-home/common/bottom.php");
?>