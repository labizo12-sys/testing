<!DOCTYPE html>
<html>
<body>

<?php
include "koneksi.php";
$q = strval($_GET['q']);


$sql="SELECT * FROM barang WHERE jenis_barang = '".$q."'";
$result = mysql_query($sql);
while($row = mysql_fetch_array($result)) {
	echo "".$row['kode_barang'];
}
?>
</body>
</html>