<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="icon" type="image/png" href="gambar/icon.png">
<link href="config/style.css" rel="stylesheet">
<title>Sistem Penalaran Fuzzy - Tsukamoto</title>
</head>
<body>
<div class="tengah input-list style-1 clearfix">
<img class="header" src="gambar/header.jpg" />
<nav class="clearfix">
	<a href="#" id="pull">Menu</a>
	<ul class="clearfix">
	<li><a href="index.php?p=beranda">Beranda</a></li>
	<li><a href="index.php?p=hitung-data">Hitung Data</a></li>
	<li><a href="index.php?p=data-perhitungan">Data Perhitungan</a></li>
	</ul>
</nav>
<div class="hidden-scrollbar"><div class="inner">
<?php
$p = (isset($_GET['p']))? $_GET['p'] : "beranda";
switch ($p) {
	case 'hitung-data'	: include "hitdat.php"; break;
	case 'hasil-hitung-data'	: include "hasil.php"; break;
	case 'lihat-hasil-data'	: include "hasil.php"; break;
	case 'data-perhitungan'	: include "dathit.php"; break;
	case 'beranda' :
	default : include 'beranda.php';	
}
?>
</div></div>
<div class="footer">Hak Cipta Sistem @ 2017 - Anggota Kelompok Kelas GH 2015 Semester 4</div>
</div>
</body>
</html>
