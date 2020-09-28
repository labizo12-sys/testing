<?php 

	/*
	* Created by Belal Khan
	* website: www.simplifiedcoding.net 
	* Retrieve Data From MySQL Database in Android
	*/
	
	//database constants
	define('DB_HOST', 'localhost');
	define('DB_USER', 'root');
	define('DB_PASS', '');
	define('DB_NAME', 'sps');
	
	//connecting to database and getting the connection object
	$conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
	//$orderBy = $_POST["orderBy"];
	//Checking if any error occured while connecting
	if (mysqli_connect_errno()) {
		echo "Failed to connect to MySQL: " . mysqli_connect_error();
		die();
	}
	$q = strval($_GET['q']);
	
	//creating a query
	$stmt = $conn->prepare("SELECT id, a.kode_barang, b.satuan, kuantiti_barang, harga_modal, nama_supplier,  alamat_supplier, tanggal_masuk, tanggal_exp, margin_keuntungan, b.jenis_barang, harga_satuan FROM stock a join barang b on a.kode_barang= b.kode_barang where a.id_stock = '".$q."';");
	
	//executing the query 
	$stmt->execute();
	
	//binding results to the query 
	$stmt->bind_result($id, $kode_barang, $gramasi_barang, $kuantiti_barang, $harga_modal, $nama_supplier, $alamat_supplier, $tanggal_masuk, $tanggal_exp, $margin_keuntungan, $jenis_barang, $harga_satuan);
	
	$products = array(); 
	
	//traversing through all the result 
	while($stmt->fetch()){
		$temp = array();
		$temp["id"] = $id; 
		$temp["kode_barang"] = $kode_barang;  
		$temp["gramasi_barang"] = $gramasi_barang;
		$temp["kuantiti_barang"] = $kuantiti_barang; 
		$temp["harga_modal"] = $harga_modal; 
		$temp["nama_supplier"] = $nama_supplier; 
		$temp["alamat_supplier"] = $alamat_supplier; 
		$temp["tanggal_masuk"] = $tanggal_masuk; 
		$temp["tanggal_exp"] = $tanggal_exp; 
		$temp["margin_keuntungan"] = $margin_keuntungan; 
		$temp["jenis_barang"] = $jenis_barang;
		$temp["harga_satuan"] = $harga_satuan;

		
		array_push($products, $temp);
		//echo $temp['detail'] = $detail;
	}
	
	//var_dump($products);
	//return json_encode($temp);
	
	//displaying the result in json format 
	echo json_encode($products);
	
	mysqli_close($conn);
?>