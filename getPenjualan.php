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

$q = strval($_GET['q']);


$sql="SELECT id_stock,id, a.kode_barang, gramasi_barang, kuantiti_barang, harga_modal, nama_supplier,  alamat_supplier, tanggal_masuk, tanggal_exp, margin_keuntungan, b.jenis_barang, a.biaya_operasional,b.satuan, a.harga_satuan FROM stock a join barang b on a.kode_barang= b.kode_barang where b.jenis_barang = '".$q."';";
$result = mysql_query($sql);

echo "<table table table-hover>
		<tr >
			<th>No. Surat Jalan</th>
			<th>Barang</th>
            <th>Gramasi</th>
            <th>Stock</th>
            <th>Expired</th>
            <th>Harga Satuan</th>

        </tr>";
		echo $q;
while($row = mysql_fetch_array($result)) {
	$harga_total = $row['harga_modal'] + $row['margin_keuntungan'];
    echo "<tr>";
	echo "<td>" . $row['id_stock'] . "</td>";
    echo "<td>" . $row['jenis_barang'] . "</td>";
    echo "<td>" . $row['satuan'] . "</td>";
    echo "<td>" . $row['kuantiti_barang'] . "</td>";
    echo "<td>" . $row['tanggal_exp'] . "</td>";
    echo "<td>" . $harga_total . "</td>";
    echo "</tr>";
}
echo "</table>";
?>
</body>
</html>