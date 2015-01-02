<?php
include("charts/charts.php");

	$query="select count(*) as jml from MASTFIP08 where ";
	if ($uk!='all') $query.="A_01='$uk' and ";
	$query.="F_03<>'' and F_03 is not null and A_01<>'99'";
	$rj=mysql_query($query);
	$roj=mysql_fetch_row($rj);
	
	$query="select F_03,count(*) as jml from MASTFIP08 where ";
	if ($uk!='all') $query.="A_01='$uk' and ";
	$query.="F_03<>'' and F_03 is not null and A_01<>'99'";
	$query.=" group by F_03 order by F_03 ";
        echo $query;
   	$r=mysql_query($query);
   	while($row=mysql_fetch_array($r)) {
   		switch($row[0]) {
   			case "11": $g11=$row[1];break;
   			case "12": $g12=$row[1];break;
   			case "13": $g13=$row[1];break;
   			case "14": $g14=$row[1];break;
   			case "21": $g21=$row[1];break;
   			case "22": $g22=$row[1];break;
   			case "23": $g23=$row[1];break;
   			case "24": $g24=$row[1];break;
   			case "31": $g31=$row[1];break;
   			case "32": $g32=$row[1];break;
   			case "33": $g33=$row[1];break;
   			case "34": $g34=$row[1];break;
   			case "41": $g41=$row[1];break;
   			case "42": $g42=$row[1];break;
   			case "43": $g43=$row[1];break;
   			case "44": $g44=$row[1];break;
   			case "45": $g45=$row[1];break;
   		}
   	}
	$chart[ 'chart_data' ] = array (  
					array ( "", "" ), 
					array ( "IV/e", $g45), 
					array ( "IV/d", $g44) , 
					array ( "IV/c", $g43 ) , 
					array ( "IV/b", $g42 ) , 
					array ( "IV/a", $g41 ) , 
					array ( "III/d", $g34 ) , 
					array ( "III/c", $g33 ) , 
					array ( "III/b", $g32 ) , 
					array ( "III/a", $g31 ) , 
					array ( "II/d", $g24 ) , 
					array ( "II/c", $g23 ) , 
					array ( "II/b", $g22 ) , 
					array ( "II/a", $g21 ) , 
					array ( "I/d", $g14 ) , 
					array ( "I/c", $g13 ) , 
					array ( "I/b", $g12 ) , 
					array ( "I/a", $g11 ));
	$chart[ 'canvas_bg' ]['width' ] =600;
	$chart[ 'canvas_bg' ]['height' ] =400;
	$chart[ 'canvas_bg' ]['color' ] ="ffffff";
	$chart[ 'axis_category' ] = array ( 'size'=>12, 'color'=>"000000", 'alpha'=>75, 'font'=>"arial", 'bold'=>true, 'skip'=>0 ,'orientation'=>"vertical_down" ); 
	$chart[ 'chart_rect' ] = array ( 'x'=>-25, 'y'=>-49, 'width'=>560, 'height'=> 460 );
	$chart[ 'chart_type' ] = "3d column" ;
	$chart[ 'chart_value' ] = array ( 'hide_zero'=>true, 'color'=>"ffffff", 'alpha'=>90, 'font'=>"arial", 'bold'=>true, 'size'=>10, 'position'=>"over", 'prefix'=>"", 'suffix'=>"", 'decimals'=>0, 'separator'=>"", 'as_percentage'=>true );
	$chart[ 'legend_bg' ] = array ( 'bg_color'=>"000066", 'bg_alpha'=>0, 'border_color'=>"000000", 'border_alpha'=>0, 'border_thickness'=>0 ); 
	$chart[ 'legend_label' ] = array ( 'layout'=>"vertical", 'font'=>"arial", 'bold'=>true, 'size'=>12, 'color'=>"000000", 'alpha'=>50 ); 
	$chart[ 'legend_rect' ] = array ( 'x'=>480, 'y'=>0, 'width'=>100, 'height'=>45, 'margin'=>5 ); 
	$chart[ 'series_color' ] = array ("220000", "aa0066","000066","ff0066","0066ff","9909cc","666699","660066","666666","800000","006600","33cc33","99ccff","4ccccc","cccc00","003399","cc0000"); 
	$chart[ 'series_gap' ] = array ( 'bar_gap'=>10, 'set_gap'=>20) ; 
	$chart[ 'draw_text' ] = array (	array ( 'color'=>"666666", 'alpha'=>100, 'font'=>"arial", 'rotation'=>0, 'bold'=>true, 'size'=>20, 'x'=>-30, 'y'=>340, 'width'=>300, 'height'=>50, 'text'=>"* Total PNS = $roj[0]", 'h_align'=>"center", 'v_align'=>"middle" )) ;
	DrawChart($chart);
?>
