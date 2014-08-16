<?php
include("charts/charts.php");

	$qj="select count(*) as jml from MASTFIP08 where ";
	if ($uk!='all') $qj.="A_01='$uk' and ";
	else $qj.="A_01<>'99' and ";
	$qj.="(B_05<>'' and B_05<>'0' and B_05 is not null)";
	$rj=mysql_query($qj);
	$roj=mysql_fetch_row($rj);
	
	$aUmur=array(16,21,26,31,36,41,46,51,56,60);
	$jml=count($aUmur);
	for ($i=0;$i<$jml;$i++) {
		$thskr=date("Y");
		$blskr=date("m");
		$tgskr=date("d");
		$r=$i+1;
		
		$u1=intval($thskr)-$aUmur[$r];
		$u2=intval($thskr)-$aUmur[$i];
		$tu1=$u1."-".$blskr."-".$tgskr;
		$tu2=$u2."-".$blskr."-".$tgskr;
	   	$q="select count(*) from MASTFIP08 where ";
	   	if ($uk!='all') $q.="A_01='$uk' and ";
	   	$q.="B_05>='$tu1' and B_05<'$tu2'";
   		$r=mysql_query($q);
		$ro[$i]=mysql_fetch_row($r);
	}
	
	$chart[ 'chart_data' ] = array (  array ( "", "" ), array ( "16-20", $ro[0][0]), array ( "21-25", $ro[1][0]) , array ( "26-30", $ro[2][0] ) , array ( "31-35", $ro[3][0] ) , array ( "36-40", $ro[4][0] ), array ( "41-45", $ro[5][0]), array ( "46-50", $ro[6][0]) , array ( "51-55", $ro[7][0] ) , array ( "56-60", $ro[8][0] ));
	$chart[ 'canvas_bg' ]['width' ] =600;
	$chart[ 'canvas_bg' ]['height' ] =400;
	$chart[ 'canvas_bg' ]['color' ] ="ffffff";
$chart[ 'chart_rect' ] = array ( 'x'=>1, 'y'=>-60, 'width'=>560, 'height'=> 460 );
$chart[ 'chart_type' ] = "3d column" ;
$chart[ 'chart_value' ] = array ( 'hide_zero'=>true, 'color'=>"ffffff", 'alpha'=>90, 'font'=>"arial", 'bold'=>true, 'size'=>10, 'position'=>"over", 'prefix'=>"", 'suffix'=>"", 'decimals'=>0, 'separator'=>"", 'as_percentage'=>true );

$chart[ 'legend_bg' ] = array ( 'bg_color'=>"000066", 'bg_alpha'=>0, 'border_color'=>"000000", 'border_alpha'=>0, 'border_thickness'=>0 ); 
$chart[ 'legend_label' ] = array ( 'layout'=>"vertical", 'font'=>"arial", 'bold'=>true, 'size'=>12, 'color'=>"000000", 'alpha'=>50 ); 
$chart[ 'legend_rect' ] = array ( 'x'=>450, 'y'=>25, 'width'=>100, 'height'=>45, 'margin'=>5 ); 

$chart[ 'series_color' ] = array ("666699","660066","666666","993300","006600","33cc33","99ccff","003399","cc0000"); 
$chart[ 'series_gap' ] = array ( 'bar_gap'=>10, 'set_gap'=>20) ; 

$chart[ 'draw_text' ] = array (	array ( 'color'=>"666666", 'alpha'=>100, 'font'=>"arial", 'rotation'=>0, 'bold'=>true, 'size'=>20, 'x'=>-30, 'y'=>340, 'width'=>300, 'height'=>50, 'text'=>"* Total PNS = $roj[0]", 'h_align'=>"center", 'v_align'=>"middle" )) ;
DrawChart($chart);
?>