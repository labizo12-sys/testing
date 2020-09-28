<?php
//koneksi ke database
	$host = "localhost";
	$username= "root";
	$password="";
	$database="sps";
	@mysql_connect($host,$username,$password) or die ("Koneksi gagal");
	mysql_select_db($database) or die ("Database tidak ditemukabn");
 //$insert="INSERT INTO download VALUES(NULL,'2018-06-16', '45534_LABEL CD glosy.docx','45534_LABEL CD glosy.docx.md.aes','docx', '1556424','uploads/45534_LABEL CD glosy.docx')";
//fungsi untuk mengkonversi size file
	//mysql_query($insert);

?>