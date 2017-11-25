Berikut ini merupakan riwayat data yang pernah dihitung memakai sistem didalam situs ini.<br /><br />
<?php
require "config/koneksi.php";
$db = new mysqli("$hostnya","$usernya","$passnya","$basenya");
echo $db->connect_errno?'Koneksi gagal :'.$db->connect_error:'';
$sql = "SELECT * FROM data ORDER BY id ASC";
$result = $db->query($sql);
while($row = $result->fetch_object()){
?>
<table width="80%" border="0">
  <tr>
    <td colspan="3"><h3><?php echo $row->pertanyaan; ?></h3></td>
  </tr>
  <tr>
    <td width="32%">Jumlah Permintaan</td>
    <td width="33%">:&nbsp;<?php echo $row->jmlpmt; ?></td>
    <td width="35%" rowspan="2"><a href="index.php?p=lihat-hasil-data&id=<?php echo $row->id; ?>">Lihat Perhitungan</a></td>
  </tr>
  <tr>
    <td>Persediaan di Gudang</td>
    <td>:&nbsp;<?php echo $row->psdgr; ?></td>
  </tr>
</table>
<?php }?>