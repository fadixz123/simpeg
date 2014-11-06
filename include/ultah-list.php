<?php
include('config.inc');
include('fungsi.inc');
$link=mysql_connect($server,$user,$pass);
mysql_select_db($db);
?>
<table class="table table-bordered table-stripped table-hover" id="table_data_no">
    <thead>
<tr>
    <th width="4" >No</th>
    <th>NIP</th>
    <th>NAMA PNS</th>
    <th>JABATAN</th>
    <th>G/R</th>
    <th>TGL LAHIR</th>
</tr>
</thead>
    <tbody>
        <?
        if ($ultah=='bl') {
                $q="select * from MASTFIP08 where month(B_05)='".date("m")."' ";
        } else if ($ultah=='bld') {
                $q="select * from MASTFIP08 where month(date_sub(B_05,interval 1 month))='".date("m")."' ";
        } else {
                $q="select * from MASTFIP08 where substring(date_sub(B_05,interval ".$ultah." day),6,10)='".date("m-d")."' ";
        }
        if ($uk!='all') {
                if (strlen($uk)==2) $q.="and A_01='".$uk."' ";
                else $q.="and A_01='".substr($uk,0,2)."' and A_02='".substr($uk,2,2)."' and A_03='".substr($uk,4,2)."' ";
        }
        $r=mysql_query($q) or die(mysql_error());
        $no=0;
        while ($row=mysql_fetch_array($r))
        {
                        $no++;
                ?>
                <tr>
                <td width="4"><? echo $no; ?>&nbsp;</td>
                <td><a href="index.htm?sid=<?=$sid?>&do=cari&cari=1&nip=<?=$row['B_02']?>"><?=$row['B_02B']=='' ? $row[B_02] : format_nip_baru($row[B_02B])?></a>&nbsp;</td>
                <td><? echo namaPNS($row['B_03A'],$row['B_03'],$row['B_03B']); ?>&nbsp;</td>
                <td><? echo getNaJab($row[B_02]); ?>&nbsp;</td>
                <td><? echo pktH($row['F_03']); ?>&nbsp;</td>
                <td><? echo tanggalnya($row['B_05'],0); ?>&nbsp;</TD>
                </tr>
                <?
        }
        ?>
    </tbody>
</table>