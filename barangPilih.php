<!DOCTYPE html>
<html>
<head>
<style>
table {
    width: 100%;
    border-collapse: collapse;
}

table, td, th {
    border: 1px solid black;
    padding: 5px;
}

th {text-align: left;}
</style>
</head>
<body>

<?php

	include "koneksi.php";
	echo $q;
	 $q = strval($_GET['q']);
	 $tampilkan="Select * from stock a join barang b on a.kode_barang= b.kode_barang where b.jenis_barang ='".$q."';";
	 $query_tampilkan=mysql_query($tampilkan);
	 
	 echo "<option selected=".selected.">Pilih Stock</option>";
	 while ($data = mysql_fetch_array($query_tampilkan))
	 {
	  echo "<option>".$data['id_stock']."</option>";
	 }
	

?>
</body>
</html>