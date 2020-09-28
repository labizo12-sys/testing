<?php
	include "koneksi.php";
	
	$username=$_POST["user"];
	$password=$_POST["pass"];
	$pass1=$password;
	$tampilkan="select * from users where username='$username'";
	$query_tampilkan=mysql_query($tampilkan);
	session_start();
	//echo $password;
	date_default_timezone_set('Asia/Jakarta');
	$waktu = date("Y-m-d H:i:s");
	if($hasil=mysql_fetch_array($query_tampilkan))
	{
			
			
			$passdb=$hasil['password'];
			//$token=$hasil['dropbox_token'];
			//echo $passdb;
		if($pass1==$passdb)
		{
		    $_SESSION['login']=$username;
		    $insert ="insert into audit_trial (user, waktu, activity) values('$username','$waktu','Login');";
	        $insert_query = mysql_query($insert);
			if($insert_query){
			    if($username=="manager"){
					Header("location:inputBarang.php?pesan=Tambah");
				}
				else{
					Header("location:inputPenjualan2.php");
				}
			}
			else{
				Header("location:inputBarang.php?pesan=Tambah Stock gagal $insert");
			}
		//	Header("location:inputStock.php?");
			
		}
		
			//$_SESSION['login']=$username;
		
		else{
			Header("location:index.html?pesan=salah '$password'asd");
		
		}	
	}
	else{
			Header("location:index.html?pesan=salah");
		
		}	
		
	
	
	
		
		
	
	
?>