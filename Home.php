<!DOCTYPE html>
<html lang="en">
<head>
  <title>CompressEncrypt</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  <link href="css/style.css" rel="stylesheet" type="text/css" />
</head>
<body style="background-color:MintCream;">
<?php session_start();
	include "koneksi.php";
	$username=$_SESSION['login'];
	$tampilkan="select * from Users where username='$username';";
	$query_tampilkan=mysql_query($tampilkan);
	if($hasil=mysql_fetch_array($query_tampilkan)){
		$fullname=$hasil['username'];
	}
	else{
		Header("location:index.php?pesan=login");
	}
	?>
<nav class="navbar navbar-default" id="navbar">
  <div class="container-fluid">
    <div class="navbar-header">
      <a class="navbar-brand" href="#">SPS Food</a>
    </div>
    <ul class="nav navbar-nav">
      <li class="active"><a href="Home.php">Home</a></li>
      
      <li ><a href="inputStock.php">Input Stock</a></li>
	  <li ><a href="listPenjualan.php">List Penjualan</a></li>
	  <li ><a href="inputPenjualan.php">Input Penjualan</a></li>	  
    </ul>
    <ul class="nav navbar-nav navbar-right">
      <li class="dropdown">
        <a class="dropdown-toggle" data-toggle="dropdown" href="#"><span class="glyphicon glyphicon-user"></span><?php echo ' '.$fullname;?>
        <span class="caret"></span></a>
        <ul class="dropdown-menu">
          <li><a href="editprofil.php" <span class="glyphicon glyphicon-edit"></span> ManageAccount</a></li>
          <li><a href="logout.php"><span class="glyphicon glyphicon-log-out"></span> &nbsp&nbsp&nbspSign Out</a></li>
          
        </ul>
      </li>
	  
    </ul>
  </div>
</nav>
<div id="content">
        	<h2>Home</h2>
            <!-- <li><a href="logout.php"><span class="glyphicon glyphicon-log-out"></span> Logout</a></li>     <p>Silahkan download file yang sudah di Upload di website ini. Untuk men-Download Anda bisa mengklik Judul file yang di inginkan.</p>
			-->
			<?php 
			if(isset($_GET["pesan"])){
			$pesan= $_GET["pesan"];
			//echo $pesan;
				if($pesan=="berhasil"){
					//echo "Upload Success";
					echo '
								<div class="alert alert-success">
								<strong>Success!</strong>';
						echo " Upload Success";
						echo '</div>'	;
				}
				else if($pesan=="gagal"){
					//echo "Upload Failed";
					echo '
					<div class="alert alert-danger">
					<strong>Failed!</strong>';
							echo " Upload Failed";
							echo '</div>'	;
				}
				else if($pesan=="berhasil2"){
					//echo "Upload Success";
					echo '
								<div class="alert alert-success">
								<strong>Success!</strong>';
						echo " Download Success";
						echo '</div>'	;
				}	
				
				
			}
			
		
			?>
			
			
            <p>
			
            <table  class="table table-hover">
			
            	<tr bgcolor="#ccffff">
                	<th width="30">No.</th>
                    <th width="110">Date Uploaded</th>
                    <th>Filename</th>
                    <th width="70">Size</th>
                    <th width="70"></th>
                </tr>
                <?php
				
				?>
				<script>
				window.onscroll = function() {myFunction()};

				var navbar = document.getElementById("navbar");
				var sticky = navbar.offsetTop;

				function myFunction() {
				  if (window.pageYOffset >= sticky) {
					navbar.classList.add("sticky")
				  } else {
					navbar.classList.remove("sticky");
				  }
				}
				</script>
            </table>
		
            </p>
        </div>
  <div class="footer"><p>2019 SPS FOOD</p></div>


</body>
</html>
