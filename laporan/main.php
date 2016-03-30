<!--<table border="0" cellpadding="5" cellspacing="0" style="border-collapse: collapse" bordercolor="#111111" width="100%" id="AutoNumber1">
    <tr>
      <td width="89%">
      <ul>
        <li><font size="2" face="Verdana"><a target="_blank" href="laporan/golongan.php">REKAPITULASI PNS BERDASARKAN GOLONGAN</a></font></li>
        <li><font size="2" face="Verdana"><a target="_blank" href="laporan/rekapeselon.php">REKAPITULASI PNS BERDASARKAN ESELON</a></font></li>
        <li><font size="2" face="Verdana"><a target="_blank" href="laporan/rekappddk.php">REKAPITULASI PNS BERDASARKAN TINGKAT PENDIDIKAN</a></font></li>
        <li><font size="2" face="Verdana"><a target="_blank" href="laporan/rekapdidik.php">REKAPITULASI PNS BERDASARKAN JENIS KELAMIN DAN TINGKAT PENDIDIKAN</a></font></li>
        <li><font size="2" face="Verdana"><a target="_blank" href="laporan/rekapagama.php">REKAPITULASI PNS BERDASARKAN AGAMA</a></font></li>
        <li><font size="2" face="Verdana"><a target="_blank" href="laporan/rekapumur.php">REKAPITULASI PNS BERDASARKAN USIA</a></font></li>
	</ul>
      </td>
    </tr>
    </table>-->
<script type="text/javascript">
    function cetak_rekap(file) {
        var wWidth = $(window).width();
        var dWidth = wWidth * 1;
        var x = screen.width/2 - dWidth/2;
        window.open('laporan/'+file,'Cetak Golongan','width='+dWidth+', left='+x);
    }
</script>
<h4 class="title">REKAP PROFILE PNS</h4>
<div class="wrapp-icon" onclick="cetak_rekap('golongan.php');">
    <div class="wrapp-image">
        <img src="./images/cpanel/army-icon.png" />
    </div>
    <div class="wrapp-keterangan">
        <b>GOLONGAN</b><p>Rekapitulasi Berdasar Golongan PNS</p>
    </div>
</div>

<div class="wrapp-icon" onclick="cetak_rekap('rekapeselon.php');">
    <div class="wrapp-image">
        <img src="./images/cpanel/eselon.jpg" />
    </div>
    <div class="wrapp-keterangan">
        <b>ESELON</b><p>Rekapitulasi Berdasar Eselon</p>
    </div>
</div>

<div class="wrapp-icon" onclick="cetak_rekap('rekappddk.php');">
    <div class="wrapp-image">
        <img src="./images/cpanel/kexi.png" />
    </div>
    <div class="wrapp-keterangan">
        <b>TKT PENDIDIKAN</b><p>Rekapitulasi Berdasar Tingkat Pendidikan PNS</p>
    </div>
</div>

<div class="wrapp-icon" onclick="cetak_rekap('rekapdidik.php');">
    <div class="wrapp-image">
        <img src="./images/cpanel/kexi.png" />
    </div>
    <div class="wrapp-keterangan">
        <b>JEKEL & TKT PEND.</b><br/><p>Rekapitulasi Berdasar Jenis Kelamin & Tingkat Pendidikan</p>
    </div>
</div>

<div class="wrapp-icon" onclick="cetak_rekap('rekapagama.php');">
    <div class="wrapp-image">
        <img src="./images/cpanel/kcmdf.png" />
    </div>
    <div class="wrapp-keterangan">
        <b>AGAMA</b><p>Rekapitulasi Berdasar Agama</p>
    </div>
</div>

<div class="wrapp-icon" onclick="cetak_rekap('rekapumur.php');">
    <div class="wrapp-image">
        <img src="./images/cpanel/grafik.png" />
    </div>
    <div class="wrapp-keterangan">
        <b>USIA</b><p>Rekapitulasi Berdasar Usia</p>
    </div>
</div>
