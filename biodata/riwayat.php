<br/>
<table width="100%">
    <tr><td width="15%">Pilih Riwayat:</td><td>
    <select name="do" class="form-control-static" id="do" onchange="load_riwayat('<?= $_GET['nip'] ?>');">
        <option value="">Pilih ...</option>
        <option value="rpk" <?php if ($page=='rpk') echo "selected"?>>RIWAYAT PANGKAT</option>
        <option value="rjb"  <?php if ($page=='rjb') echo "selected"?>>RIWAYAT JABATAN</option>
        <option value="rtj"  <?php if ($page=='rtj') echo "selected"?>>RIWAYAT TANDA JASA</option>
        <option value="rtg"  <?php if ($page=='rtg') echo "selected"?>>RIWAYAT TUGAS KE LUAR NEGERI</option>
        <option value="bhs"  <?php if ($page=='bhs') echo "selected"?>>PENGUASAAN BAHASA</option>
        <option value="rdu"  <?php if ($page=='rdu') echo "selected"?>>RIWAYAT PENDIDIKAN UMUM</option>
        <option value="rst"  <?php if ($page=='rst') echo "selected"?>>RIWAYAT DIKLAT STRUKTURAL</option>
        <option value="rfu"  <?php if ($page=='rfu') echo "selected"?>>RIWAYAT DIKLAT FUNGSIONAL</option>
        <option value="rdt"  <?php if ($page=='rdt') echo "selected"?>>RIWAYAT DIKLAT TEKNIS</option>
        <option value="rpt"  <?php if ($page=='rpt') echo "selected"?>>RIWAYAT PENATARAN</option>
        <option value="rsm"  <?php if ($page=='rsm') echo "selected"?>>RIWAYAT SEMI/LOKA/SIMP</option>
        <option value="rku"  <?php if ($page=='rku') echo "selected"?>>RIWAYAT KURSUS DI DLM & LUAR NEGERI</option>
    </select>
    </td></tr>
</table>
<br/>
<div id="load-riwayat"></div>