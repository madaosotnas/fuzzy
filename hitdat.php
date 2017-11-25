Sebelum melakukan perhitungan data pastikan rules Penalaran Fuzzy - Tsukamoto yang akan anda pakai sesuai dengan rules yang terdapat di menu Beranda didalam situs ini.<br /><br />
<?php
require "config/koneksi.php";
	mysql_connect("$hostnya", "$usernya", "$passnya");
    mysql_select_db("$basenya");
$pertanyaan = $_POST['pertanyaan'];
$pmtbsr = $_POST['pmtbsr'];
$pmtkcl = $_POST['pmtkcl'];
$psdgbk = $_POST['psdgbk'];
$psdgkc = $_POST['psdgkc'];
$psdbgmax = $_POST['psdbgmax'];
$psdbgmin = $_POST['psdbgmin'];
$jmlpmt = $_POST['jmlpmt'];
$psdgr = $_POST['psdgr'];
switch($_GET[action]){
	case "input-data":
	$ins = "INSERT INTO data VALUES('', '$pertanyaan','$pmtbsr','$pmtkcl','$psdgbk','$psdgkc','$psdbgmax','$psdbgmin','$jmlpmt','$psdgr')";
	$exe = mysql_query($ins);
	$query = "SELECT * FROM data ORDER BY id DESC LIMIT 0,1";
	$hasil = mysql_query($query);
	$data  = mysql_fetch_array($hasil);
	if($exe){
		echo '		<div class="box success-box">Berhasil memasukan data.&nbsp;&nbsp;<a href="index.php?p=hasil-hitung-data&id='.$data['id'].'" >Lihat Hasil</a></div>';
	}
	else{
		echo "<div class='box error-box'>Gagal memasukan data. Silahkan isi semua form yang ada.</div>";
	}
	break;
	}
	?>
<br />
<form action="index.php?p=hitung-data&action=input-data" method="post"><table width="100%" border="0">
  <tr>
    <td colspan="2">Judul Perhitungan</td>
  </tr>
  <tr>
    <td colspan="2"><input type="text" name="pertanyaan" style="width:90%;" /></td>
  </tr>
  <tr>
    <td width="50%">Permintaan Terbesar</td>
    <td width="50%">Permintaan Terkecil</td>
  </tr>
  <tr>
    <td><input type="text" name="pmtbsr" style="width:50%;" /></td>
    <td><input type="text" name="pmtkcl" style="width:50%;" /></td>
  </tr>
  <tr>
    <td>Persediaan Terbanyak</td>
    <td>Persediaan Sedikit</td>
  </tr>
  <tr>
    <td><input type="text" name="psdgbk" style="width:50%;" /></td>
    <td><input type="text" name="psdgkc" style="width:50%;" /></td>
  </tr>
  <tr>
    <td>Produksi Barang Max</td>
    <td>Produksi Barang Min</td>
  </tr>
  <tr>
    <td><input type="text" name="psdbgmax" style="width:50%;" /></td>
    <td><input type="text" name="psdbgmin" style="width:50%;" /></td>
  </tr>
  <tr>
    <td>Jumlah Permintaan Real</td>
    <td>Jumlah Persediaan Gudang Real</td>
  </tr>
  <tr>
    <td><input type="text" name="jmlpmt" style="width:50%;" /></td>
    <td><input type="text" name="psdgr" style="width:50%;" /></td>
  </tr>
  <tr>
    <td><input type="submit" name="submit" class="pencetan" value="Hitung" /></td>
    <td>&nbsp;</td>
  </tr>
</table></form>
<br /><br />