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
	$files = glob('uploads/*'); // get all file names
	foreach($files as $filess){ // iterate files
	if(is_file($filess))
    unlink($filess); // delete file
	}
	$files = glob('downloads/*'); // get all file names
	foreach($files as $filess){ // iterate files
	if(is_file($filess))
    unlink($filess); // delete file
	}
	?>
<nav class="navbar navbar-default" id="navbar">
  <div class="container-fluid">
    <div class="navbar-header">
      <a class="navbar-brand" href="#">CompressEncrypt</a>
    </div>
    <ul class="nav navbar-nav">
      <li class="active"><a href="Home.php">Home</a></li>
      
      <li ><a href="menuupload.php">Upload</a></li>
	  <li ><a href="activity.php">Activity Log</a></li>
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
				require_once 'AESCryptFileLib.php';
				require_once 'aes256/MCryptAES256Implementation.php';
				//href="style.css"  <td><a href="'.$data['file'].'">'.$data['nama_file'].'</a></td>
				//include('koneksi.php');
				require_once 'vendor/autoload.php';
				use Kunnu\Dropbox\Dropbox;
				use Kunnu\Dropbox\DropboxApp;
				use Kunnu\Dropbox\DropboxFile;
				use Kunnu\Dropbox\Exceptions\DropboxClientException;
				use Hashids\Hashids;
				//Configure Dropbox Application
				$dropboxKey='ndedmidiudkw4yb';
				$dropboxSecret='47df691sa59oeyx';
				$dropboxtoken=$_SESSION['dropbox_token'];
				$app = new DropboxApp($dropboxKey, $dropboxSecret, $dropboxtoken);

				//Configure Dropbox service
				$dropbox = new Dropbox($app);
				$listFolderContents = $dropbox->listFolder("/");

				//Fetch Items
				$items = $listFolderContents->getItems();
				//$item2=$items->last();
				//Fetch Cusrsor for listFolderContinue()
				$cursor = $listFolderContents->getCursor();

				//If more items are available
				$hasMoreItems = $listFolderContents->hasMoreItems();
				$no=1;
				//$nama_file=$value->name; <td> <a href= menudekrip.php?id=',$id ,'>Download','</a>
				foreach ($items as $value) {
					$nama_file=$value->name;
					$id_file=$value->id;
					$tampilkan="select * from download where dropbox_file_id='$id_file' AND dropbox_token='$dropboxtoken' ORDER BY id DESC;";
						$query_tampilkan=mysql_query($tampilkan);
						
						
						
						if($hasil=mysql_fetch_array($query_tampilkan))
							{
								$id=$hasil['id'];
								$hashids=new Hashids('ydazzaql12ZxEt', 10);
								$encodeID=$hashids->encode($id);
								$tgl=$hasil['tanggal_upload'];
								
								echo '
						<tr >
						<td align="center">'.$no.'</td>
						<td >'.$tgl.'</td>
						<td >'.$value->name.'</td>
						
						<td align="center">'.formatBytes($value->size).'</td>
						<td style="width:15%"><a href=menudekrip.php?params=',$encodeID ,'><span class="glyphicon glyphicon-download"></span> Download</a></td>
						
						
					</tr>';
					$no++;
							}
				
				}
				
				
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
  <div class="footer"><p>2018 CompressEncrypt by Hervindo Chandra</p></div>


</body>
</html>
