<?php
include('../include/config.inc');
include('../include/fungsi.inc');
$link=mysql_connect($server,$user,$pass);
mysql_select_db($db);
if ($_GET['pilihjab'] === '3') { ?>
        <select name="I_05" onchange="get_ijb(this.value);" class="form-control-static" style="width: 300px;">
        <option value=""><?= ucwords(strtolower('PILIH KELOMPOK JAB FUNGSIONAL UMUM')) ?></option>
                                <?
                                $qjfu="select * from TABJFU order by NAJFU";
                                $rjfu=mysql_query($qjfu) or die(mysql_error());
                                while ($rojfu=mysql_fetch_array($rjfu)) {
                                ?>
        <option value="<?=$rojfu[KOJFU]?>" <? if ($I_05==$rojfu[KOJFU]) echo "selected";?>><?=ucwords(strtolower($rojfu['NAJFU']))?></option>
                                <? } ?>
                                </select>
                                <?
        $q="select KOJFU,NAJFU from TABJFU where KOJFU='$I_05'";
        
        $r=mysql_query($q) or die(mysql_error());
        $xo=mysql_fetch_array($r);
        $I_06='99';
        ?>-
        <input type="hidden" name="I_JB" id="I_JB" value="<?=$xo[NAJFU]?>">
        <input type="hidden" name="I_5A" value="0">
        <input type="hidden" name="pilihjab" value="0">
        <button type="button" class="btn btn-default btn-xs" onclick="refresh_submit();"><i class="fa fa-minus-circle"></i> Batal</button>
        <?
}
if ($_GET['pilihjab'] === '1') {
        $NIP = $_GET['nip'];
        $q="select * from MASTFIP08 where B_02='$NIP' LIMIT 1";
        $row=mysql_fetch_array(mysql_query($q));
        $uq="select A_01,KOLOK,NALOK,NAJAB,ESEL from TABLOKB08 where KOLOK='".$row[A_01].$row[A_02].$row[A_03].$row[A_04].$row[A_05]."'";
        
        $ro=mysql_query($uq) or die (mysql_error());
        $xo=mysql_fetch_array($ro);
                                $I_06=$xo[ESEL];
        echo "<b>".$xo[NAJAB]."</b>";
                                //echo "<b>".$xo[KOLOK]."</b>";
        ?>-
        <input type="hidden" name="I_JB" value="<?=$xo[NAJAB]?>">
        <input type="hidden" name="I_05" value="<?=$xo[KOLOK]?>">
        <input type="hidden" name="I_5A" value="1">
        <input type="hidden" name="pilihjab" value="0">
        <?
}
if ($_GET['pilihjab'] === '2') {
        ?>
        <select name="I_05" class="form-control-static" id="I_05" onchange="load_jab_fungsional_khusus();" style="width: 300px;">
            <option value=""><?= ucwords(strtolower('PILIH KELOMPOK JAB FUNGSIONAL KHUSUS')) ?></option>
        <?
        $ro=mysql_query("select * from TABFNG1 order by NFUNG") or die (mysql_error());
        while ($ox=mysql_fetch_array($ro))
        {
        ?>
        <option value="<?=$ox[KFUNG]?>" <? if ($I_05==$ox[KFUNG]) echo "selected";?>><?=ucwords(strtolower($ox['NFUNG']))?></option>
        <?
        }
        ?>
        </select>
        <input type="hidden" name="I_5A" value="2">
        <?
}
if ($_GET['khusus'] === 'detail') {
        $I_05 = $_GET['I_05'];
        if ($I_05!='00018') {
                $qjenjang="select * from TABJENJANG order by KJENJANG";
        } else {
                $qjenjang="select * from TABJENJANG_GURU order by KJENJANG";
        }
        $r1=mysql_query($qjenjang) or die (mysql_error());
        ?>
        <select name="I_07" class="form-control-static" onChange="validate_jenjang(this.value);" style="width: 150px;">
        <option value=""><?= ucwords(strtolower('PILIH JENJANG')) ?></option>
        <?
        while ($x1=mysql_fetch_array($r1))
        {
        ?>
        <option value="<?=$x1[KJENJANG]?>"><?=ucwords(strtolower($x1['JENJANG']))?></option>
        <?
        }
        ?>
        </select>
        <!--<a href="javascript:refresh_submit()">Batal</a>-->
        <?
        $I_06='99';
        if ($I_05!='00018') $tabeljenjang='TABJENJANG'; else $tabeljenjang='TABJENJANG_GURU';
        $oo=mysql_fetch_array(mysql_query("select * from TABFNG1 where KFUNG='$I_05' LIMIT 1"));
        $pp=mysql_fetch_array(mysql_query("select * from $tabeljenjang where KJENJANG='$I_07' LIMIT 1"));
        ?>
        <input type="hidden" name="I_JB" value="<?=$oo[NFUNG]." ".$pp[JENJANG]?>">
        <?
}

if ($_GET['extend'] === 'jurusan_pendidikan') {
    $H_1A = $_GET['H_IA'];
    $id_jurusan = $_GET['id_jurusan'];
    ?>
    <select name="H_1B" class="form-control-static" id="H_IB">
        <option value="">-</option>
        <?php
        if ($H_1A=='') { $H_1A='10'; }

        //if (substr($H_1A,0,1) !='4') $TKP='0'.substr($H_1A,0,1); else $TKP=$H_1A;
        $h1b="select * from TABDIK".$H_1A." where tkp ='".$H_1A."' order by ket";

        $rh1b=mysql_query($h1b) or die(mysql_error());
        while ($o1b=mysql_fetch_array($rh1b))
        {
                echo "<option value=\"".$o1b['kod']."\" ".(($id_jurusan === $o1b['kod'])?'selected':'')." ";
                if ($row[H_1B]==$o1b['kod']) echo "selected";
                echo ">".$o1b['ket']."</option>";
        }
        ?>
      </select>
        <?php
}

if ($_GET['geteselon'] === 'yes') {
    $NIP = $_GET['nip'];
    $q="select * from MASTFIP08 where B_02='$NIP' LIMIT 1";
    $row=mysql_fetch_array(mysql_query($q));
    die(json_encode($row));
}

if ($_GET['get_ijb'] === 'true') {
    $q="select KOJFU,NAJFU from TABJFU where KOJFU='".$_GET['id']."'";
        
    $r=mysql_query($q) or die(mysql_error());
    $xo=mysql_fetch_array($r);
    die(json_encode($xo));
}
?>