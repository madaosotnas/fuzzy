<?php
error_reporting(0);
include "config/koneksi.php";
	mysql_connect("$hostnya", "$usernya", "$passnya");
    mysql_select_db("$basenya");
$id = $_GET['id'];
$query = "SELECT * FROM data WHERE id = '$id'";
$hasil = mysql_query($query);
$data  = mysql_fetch_array($hasil);

$inpmt = $data['pmtbsr']-$data['pmtkcl'];
$inpsd = $data['psdgbk']-$data['psdgkc'];
$inpmt = $inpmt;
$inpsd = $inpsd;
$gppmtx = $data['jmlpmt']/20+30;
$gppmty = $data['jmlpmt']/20+40;

$gppsdx = $data['psdgr']/2-60;
$gppsdy = $data['psdgr']/2-55;


$hslpmtr=($data['pmtbsr']-$data['jmlpmt'])/$inpmt;
$hslpmtk=($data['jmlpmt']-$data['pmtkcl'])/$inpmt;
$hslpsdk=($data['psdgbk']-$data['psdgr'])/$inpsd;
$hslpsdb=($data['psdgr']-$data['psdgkc'])/$inpsd;

if($hslpmtr==0 AND $hslpmtk==0 AND $hslpsdk==0 AND $hslpsdb==0){

  echo '<div style="padding-right:2%;">Mohon maaf data yang anda masukan di form sebelumnya tidak dapat dilakukan perhitungan karena ada data yang bernilai 0 atau tak terhingga.<br /><br /><div class="box error-box">Maaf, ada data yang bernilai 0</div><input type="button" value="Hitung Data Baru" onclick="window.location.href=\'index.php?p=hitung-data\'" class="pencetan" /></div>';
}
else {

$hslpmtr = round($hslpmtr,2);
$hslpmtk = round($hslpmtk,2);
$hslpsdk = round($hslpsdk,2);
$hslpsdb = round($hslpsdb,2);

$alpred1=min($hslpmtr,$hslpsdb);
$z1=$data['psdbgmax']-$alpred1*($data['psdbgmax']-$data['psdbgmin']);
$alpred2=min($hslpmtr,$hslpsdk);
$z2=$data['psdbgmax']-$alpred2*($data['psdbgmax']-$data['psdbgmin']);
$alpred3=min($hslpmtk,$hslpsdb);
$z3=$alpred3*($data['psdbgmax']-$data['psdbgmin'])+$data['psdbgmin'];
$alpred4=min($hslpmtk,$hslpsdk);
$z4=$alpred4*($data['psdbgmax']-$data['psdbgmin'])+$data['psdbgmin'];
$zats=$alpred1*$z1+$alpred2*$z2+$alpred3*$z3+$alpred4*$z4;
$zbwh=$alpred1+$alpred2+$alpred3+$alpred4;
$z=$zats/$zbwh;
$z = round($z,0);

  echo '
Berikut ini hasil perhitungan data yang anda masukan dengan menggunakan Penalaran Fuzzy - Tsukamoto.<br />
<p class="bar"><text>Fuzzyfikasi</text></p>
<table width="80%">
  <tr>
    <td width="24%">Input</td>
    <td width="1%">:</td>
    <td width="75%">1. Permintaan [{Turun};{Naik}] = ['.$data['pmtkcl'].';'.$data['pmtbsr'].']</td>
  </tr>
  <tr>
    <td colspan="2"></td>
    <td>2. Persediaan [{Sedikit};{Banyak}] = ['.$data['psdgkc'].';'.$data['psdgbk'].']</td>
  </tr>
  <tr>
    <td>Output</td>
    <td>:</td>
    <td>Jumlah Produksi [{Minimum};{Maximum}] = ['.$data['psdbgmin'].';'.$data['psdbgmax'].']</td>
  </tr>
</table>

<p class="bar"><text>Representasi Fuzzy</text></p>
<p>Representasi Fuzzy Input Permintaan</p>
<table width="80%">
  <tr>
    <td width="24%">PmtTurun ('.$data['jmlpmt'].')</td>
    <td width="1%">:</td>
    <td width="75%">('.$data['pmtbsr'].'-'.$data['jmlpmt'].')/'.$inpmt.' = '.$hslpmtr.'</td>
  </tr>
  <tr>
    <td>PmtNaik ('.$data['jmlpmt'].')</td>
    <td>:</td>
    <td>('.$data['jmlpmt'].'-'.$data['pmtkcl'].')/'.$inpmt.' = '.$hslpmtk.'</td>
  </tr>
</table><br />
<table cellpadding="0" cellspacing="0">
<tr><td rowspan="3">
<canvas id="NilaiY1" width="20" height="150" style="border:1px solid #d3d3d3;"></canvas>
</td><td>
<canvas id="ket1" width="330" height="15" style="border:1px solid #d3d3d3;"></canvas>
</td></tr>
<tr><td>
<canvas id="grafik1" width="330" height="120" style="border:1px solid #d3d3d3;"></canvas>
</td></tr>
<tr><td>
<canvas id="NilaiX1" width="330" height="10" style="border:1px solid #d3d3d3;"></canvas>
</td></tr></table>
<p>Representasi Fuzzy Input Persediaan</p>
<table width="80%">
  <tr>
    <td width="24%">PsdSedikit ('.$data['psdgr'].')</td>
    <td width="1%">:</td>
    <td width="75%">('.$data['psdgbk'].'-'.$data['psdgr'].')/'.$inpsd.' = '.$hslpsdk.'</td>
  </tr>
  <tr>
    <td>PsdBanyak ('.$data['psdgr'].')</td>
    <td>:</td>
    <td>('.$data['psdgr'].'-'.$data['psdgkc'].')/'.$inpsd.' = '.$hslpsdb.'</td>
  </tr>
</table><br />
<table cellpadding="0" cellspacing="0">
<tr><td rowspan="3">
<canvas id="NilaiY2" width="20" height="150" style="border:1px solid #d3d3d3;"></canvas>
</td><td>
<canvas id="ket2" width="330" height="15" style="border:1px solid #d3d3d3;"></canvas>
</td></tr>
<tr><td>
<canvas id="grafik2" width="330" height="120" style="border:1px solid #d3d3d3;"></canvas>
</td></tr>
<tr><td>
<canvas id="NilaiX2" width="330" height="10" style="border:1px solid #d3d3d3;"></canvas>
</td></tr></table>
<p>Representasi Fuzzy Output Jumlah Produksi</p>
<table width="80%">
  <tr>
    <td width="24%">Produksi Max</td>
    <td width="1%">:</td>
    <td width="75%">'.$data['psdbgmax'].'</td>
  </tr>
  <tr>
    <td>Produksi Min</td>
    <td>:</td>
    <td>'.$data['psdbgmin'].'</td>
  </tr>
</table><br />
<table cellpadding="0" cellspacing="0">
<tr><td rowspan="3">
<canvas id="NilaiY3" width="20" height="150" style="border:1px solid #d3d3d3;"></canvas>
</td><td>
<canvas id="ket3" width="330" height="15" style="border:1px solid #d3d3d3;"></canvas>
</td></tr>
<tr><td>
<canvas id="grafik3" width="330" height="120" style="border:1px solid #d3d3d3;"></canvas>
</td></tr>
<tr><td>
<canvas id="NilaiX3" width="330" height="10" style="border:1px solid #d3d3d3;"></canvas>
</td></tr></table>
<p class="bar"><text>Proses Implikasi Rules</text></p>
<p>[R1] IF Permintaan TURUN And Persediaan BANYAK THEN Produksi Barang BERKURANG</p>
<table width="80%" border="0">
  <tr>
    <td width="20%">alpha_predikat<sub>1</sub></td>
    <td width="2%">=</td>
    <td width="78%">min(μ<sub>Turun</sub>['.$data['jmlpmt'].'];μ<sub>Banyak</sub>['.$data['psdgr'].'])</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>=</td>
    <td>min('.$hslpmtr.';'.$hslpsdb.')</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>=</td>
    <td>'.$alpred1.'</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>('.$data['psdbgmax'].'-z)/('.$data['psdbgmax'].'-'.$data['psdbgmin'].') = '.$alpred1.' &rarr; ('.$data['psdbgmax'].'-'.$z1.')/('.$data['psdbgmax'].'-'.$data['psdbgmin'].') = '.$alpred1.'</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>z1 = '.$z1.'</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>Pencarian nilai Z</td>
    <td>=</td>
    <td>Maximum - Nilai alpha_predikat<sub>1</sub> * ( Maximum - Minimum )</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>'.$data['psdbgmax'].' - '.$alpred1.' * ('.$data['psdbgmax'].'-'.$data['psdbgmin'].') = '.$z1.'</td>
  </tr>
</table><hr />
<p>[R2] IF Permintaan TURUN And Persediaan SEDIKIT THEN Produksi Barang BERKURANG</p>
<table width="80%" border="0">
  <tr>
    <td width="20%">alpha_predikat<sub>2</sub></td>
    <td width="2%">=</td>
    <td width="78%">min(μ<sub>Turun</sub>['.$data['jmlpmt'].'];μ<sub>Sedikit</sub>['.$data['psdgkc'].'])</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>=</td>
    <td>min('.$hslpmtr.';'.$hslpsdk.')</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>=</td>
    <td>'.$alpred2.'</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>('.$data['psdbgmax'].'-z)/('.$data['psdbgmax'].'-'.$data['psdbgmin'].') = '.$alpred2.' &rarr; ('.$data['psdbgmax'].'-'.$z1.')/('.$data['psdbgmax'].'-'.$data['psdbgmin'].') = '.$alpred2.'</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>z2 = '.$z2.'</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>Pencarian nilai Z</td>
    <td>=</td>
    <td>Maximum - Nilai alpha_predikat<sub>2</sub> * ( Maximum - Minimum )</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>'.$data['psdbgmax'].' - '.$alpred2.' * ('.$data['psdbgmax'].'-'.$data['psdbgmin'].') = '.$z2.'</td>
  </tr>
</table><hr />
<p>[R3] IF Permintaan NAIK And Persediaan BANYAK THEN Produksi Barang BERTAMBAH</p>
<table width="80%" border="0">
  <tr>
    <td width="20%">alpha_predikat<sub>3</sub></td>
    <td width="2%">=</td>
    <td width="78%">min(μ<sub>Naik</sub>['.$data['jmlpmt'].'];μ<sub>Banyak</sub>['.$data['psdgbk'].'])</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>=</td>
    <td>min('.$hslpmtk.';'.$hslpsdb.')</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>=</td>
    <td>'.$alpred3.'</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>(z-'.$data['psdbgmin'].')/('.$data['psdbgmax'].'-'.$data['psdbgmin'].') = '.$alpred3.' &rarr; ('.$z3.'-'.$data['psdbgmin'].')/('.$data['psdbgmax'].'-'.$data['psdbgmin'].') = '.$alpred3.'</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>z3 = '.$z3.'</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>Pencarian nilai Z</td>
    <td>=</td>
    <td>Nilai alpha_predikat<sub>3</sub> * ( Maximum - Minimum ) + Minimum</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>'.$alpred3.' * ('.$data['psdbgmax'].'-'.$data['psdbgmin'].') + '.$data['psdbgmin'].'   = '.$z3.'</td>
  </tr>
</table><hr />
<p>[R4] IF Permintaan NAIK And Persediaan SEDIKIT THEN Produksi Barang BERTAMBAH</p>
<table width="80%" border="0">
  <tr>
    <td width="20%">alpha_predikat<sub>4</sub></td>
    <td width="2%">=</td>
    <td width="78%">min(μ<sub>Naik</sub>['.$data['jmlpmt'].'];μ<sub>Sedikit</sub>['.$data['psdgkc'].'])</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>=</td>
    <td>min('.$hslpmtk.';'.$hslpsdk.')</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>=</td>
    <td>'.$alpred4.'</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>(z-'.$data['psdbgmin'].')/('.$data['psdbgmax'].'-'.$data['psdbgmin'].') = '.$alpred4.' &rarr; ('.$z4.'-'.$data['psdbgmin'].')/('.$data['psdbgmax'].'-'.$data['psdbgmin'].') = '.$alpred4.'</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>z4 = '.$z4.'</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>Pencarian nilai Z</td>
    <td>=</td>
    <td>Nilai alpha_predikat<sub>4</sub> * ( Maximum - Minimum ) + Minimum</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>'.$alpred4.' * ('.$data['psdbgmax'].'-'.$data['psdbgmin'].') + '.$data['psdbgmin'].'   = '.$z4.'</td>
  </tr>
</table>
<p class="bar"><text>Defuzyfikasi</text></p>
Menghitung nilai Z dengan menggunakan nilai rata-rata :<br /><br />
<table width="80%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td width="20%">&nbsp;</td>
    <td width="2%">&nbsp;</td>
    <td colspan="2" align="center">'.$alpred1.' * '.$z1.' + '.$alpred2.' * '.$z2.' + '.$alpred3.' * '.$z3.' + '.$alpred4.' * '.$z4.'</td>
  </tr>
  <tr>
    <td align="right">Z&nbsp;</td>
    <td>=</td>
    <td colspan="2"><hr /></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td colspan="2" align="center">'.$alpred1.' + '.$alpred2.' + '.$alpred3.' + '.$alpred4.'
    </td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td align="center">'.$zats.'</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td align="right">Z&nbsp;</td>
    <td>=</td>
    <td width="12%"><hr /></td>
    <td width="66%"></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td align="center">'.$zbwh.'</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td colspan="2">&nbsp;</td>
  </tr>
  <tr>
    <td align="right">Z&nbsp;</td>
    <td>=</td>
    <td colspan="2">'.$z.'</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td colspan="2">&nbsp;</td>
  </tr>
</table>
Dari hasil data di atas dapat diketahui bahwa barang yang harus di produksi sebanyak '.$z.'
<script>
var canvas = document.getElementById("grafik1");
var ctx = canvas.getContext("2d");
ctx.moveTo(20,00);
ctx.lineTo(310,120);
ctx.stroke();
ctx.moveTo(310,0);
ctx.lineTo(20,120);
ctx.stroke();
ctx.moveTo(0,0);
ctx.lineTo(20,0);
ctx.stroke();
ctx.moveTo(0,119);
ctx.lineTo(20,119);
ctx.stroke();
ctx.moveTo(330,0);
ctx.lineTo(310,0);
ctx.stroke();
ctx.moveTo(330,119);
ctx.lineTo(310,119);
ctx.stroke();
ctx.moveTo(00,90);
ctx.lineTo('.$gppmty.',90);
ctx.stroke();
ctx.moveTo(00,30);
ctx.lineTo('.$gppmty.',30);
ctx.stroke();
</script>
<script>
var canvas = document.getElementById("NilaiX1");
var ctx = canvas.getContext("2d");
ctx.font = "10px Arial";
ctx.fillText("'.$data['pmtkcl'].'",10,9);
ctx.fillText("'.$data['jmlpmt'].'",'.$gppmtx.',9);
ctx.fillText("'.$data['pmtbsr'].'",300,9);
</script>
<script>
var canvas = document.getElementById("NilaiY1");
var ctx = canvas.getContext("2d");
ctx.font = "14px Arial";
ctx.fillText("1",5,25); 
ctx.font = "10px Arial";
ctx.fillText("0.9",2,32);
ctx.fillText("0.8",2,44);
ctx.fillText("0.7",2,56);
ctx.fillText("0.6",2,68);
ctx.fillText("0.5",2,80);
ctx.fillText("0.4",2,92);
ctx.fillText("0.3",2,104);
ctx.fillText("0.2",2,116);
ctx.fillText("0.1",2,128);
ctx.font = "14px Arial";
ctx.fillText("0",5,140); 
</script>
<script>
var canvas = document.getElementById("ket1");
var ctx = canvas.getContext("2d");
ctx.font = "14px Arial";
ctx.fillText("Turun",0,12);
ctx.fillText("Naik",300,12); 
</script>

<script>
var canvas = document.getElementById("grafik2");
var ctx = canvas.getContext("2d");
ctx.moveTo(20,00);
ctx.lineTo(310,120);
ctx.stroke();
ctx.moveTo(310,0);
ctx.lineTo(20,120);
ctx.stroke();
ctx.moveTo(0,0);
ctx.lineTo(20,0);
ctx.stroke();
ctx.moveTo(0,119);
ctx.lineTo(20,119);
ctx.stroke();
ctx.moveTo(330,0);
ctx.lineTo(310,0);
ctx.stroke();
ctx.moveTo(330,119);
ctx.lineTo(310,119);
ctx.stroke();
ctx.moveTo(00,90);
ctx.lineTo('.$gppsdy.',90);
ctx.stroke();
ctx.moveTo(00,30);
ctx.lineTo('.$gppsdy.',30);
ctx.stroke();
</script>
<script>
var canvas = document.getElementById("NilaiX2");
var ctx = canvas.getContext("2d");
ctx.font = "10px Arial";
ctx.fillText("'.$data['psdgkc'].'",10,9);
ctx.fillText("'.$data['psdgr'].'",'.$gppsdx.',9);
ctx.fillText("'.$data['psdgbk'].'",300,9);
</script>
<script>
var canvas = document.getElementById("NilaiY2");
var ctx = canvas.getContext("2d");
ctx.font = "14px Arial";
ctx.fillText("1",5,25); 
ctx.font = "10px Arial";
ctx.fillText("0.9",2,32);
ctx.fillText("0.8",2,44);
ctx.fillText("0.7",2,56);
ctx.fillText("0.6",2,68);
ctx.fillText("0.5",2,80);
ctx.fillText("0.4",2,92);
ctx.fillText("0.3",2,104);
ctx.fillText("0.2",2,116);
ctx.fillText("0.1",2,128);
ctx.font = "14px Arial";
ctx.fillText("0",5,140); 
</script>
<script>
var canvas = document.getElementById("ket2");
var ctx = canvas.getContext("2d");
ctx.font = "14px Arial";
ctx.fillText("Sedikit",0,12);
ctx.fillText("Banyak",280,12); 
</script>

<script>
var canvas = document.getElementById("grafik3");
var ctx = canvas.getContext("2d");
ctx.moveTo(20,00);
ctx.lineTo(310,120);
ctx.stroke();
ctx.moveTo(310,0);
ctx.lineTo(20,120);
ctx.stroke();
ctx.moveTo(0,0);
ctx.lineTo(20,0);
ctx.stroke();
ctx.moveTo(0,119);
ctx.lineTo(20,119);
ctx.stroke();
ctx.moveTo(330,0);
ctx.lineTo(310,0);
ctx.stroke();
ctx.moveTo(330,119);
ctx.lineTo(310,119);
ctx.stroke();
ctx.setLineDash([2, 5]);
ctx.moveTo(20,00);
ctx.lineTo(20,119);
ctx.stroke();
ctx.setLineDash([2, 5]);
ctx.moveTo(310,00);
ctx.lineTo(310,119);
ctx.stroke();
ctx.setLineDash([2, 5]);
ctx.moveTo(20,00);
ctx.lineTo(310,00);
ctx.stroke();
ctx.setLineDash([2, 5]);
ctx.moveTo(20,119);
ctx.lineTo(310,119);
ctx.stroke();
</script>
<script>
var canvas = document.getElementById("NilaiX3");
var ctx = canvas.getContext("2d");
ctx.font = "10px Arial";
ctx.fillText("'.$data['psdbgmin'].'",10,9);
ctx.fillText("'.$data['psdbgmax'].'",300,9);
</script>
<script>
var canvas = document.getElementById("NilaiY3");
var ctx = canvas.getContext("2d");
ctx.font = "14px Arial";
ctx.fillText("1",5,25); 
ctx.fillText("0",5,140); 
</script>
<script>
var canvas = document.getElementById("ket3");
var ctx = canvas.getContext("2d");
ctx.font = "14px Arial";
ctx.fillText("Berkurang",0,12);
ctx.fillText("Bertambah",260,12); 
</script>
';
}
?>