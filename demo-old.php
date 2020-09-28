<?php 
require "fpdf.php";
include "koneksi.php";
$id2=$_GET['id'];

class myPDF extends FPDF{
    function header(){
        $this->image('logo.png',10,6);
        $this->SetFont('Arial','B',14);
        $this->Cell(276,5,'PT SINERGI PRIMA SENTOSA',0,0,'C');
        $this->Ln();
        $this->SetFont('Times','',12);
        $this->Cell(276,10,'Jl. K.H. Hasyim Ashari No. 3c RT 10 RW 08 Kec. Gambir Kel. Petojo Utara Jakarta Pusat',0,0,'C');
        $this->Ln(20);
    }
	function header2($id2){
        $this->SetFont('Arial','B',14);
        $this->Cell(65,10,'SURAT JALAN',0,0,'C');
        $this->Ln();
		$tampilkan="select * from penjualan a join barang b on a.kode_barang = b.kode_barang join stock c on a.id_stock = c.id where a.id_penjualan = '$id2';";
		$query_tampilkan=mysql_query($tampilkan);
        if($hasil=mysql_fetch_array($query_tampilkan)){
			$this->Cell(40,0,'No:'.$id2,0,0,'C');

            $this->Ln();
        }
        $this->Ln(20);
    }
    function footer(){
        $this->SetY(-15);
        $this->SetFont('Arial','',8);
        $this->Cell(0,10,'Page '.$this->PageNo().'/{nb}',0,0,'C');
    }
    function headerTable(){
		
        $this->SetFont('Times','B',12);
		$this->Cell(63,10,'',0,0,'C');
        $this->Cell(50,10,'Nama Barang',1,0,'C');
        $this->Cell(30,10,'Jumlah',1,0,'C');
        $this->Cell(70,10,'Keterangan',1,0,'C');
        $this->Ln();
    }
    function viewTable($id2){
        $this->SetFont('Times','',12);
		$tampilkan="select * from penjualan a join barang b on a.kode_barang = b.kode_barang join stock c on a.id_stock = c.id where a.id_penjualan = '$id2';";
		$query_tampilkan=mysql_query($tampilkan);
        while($hasil=mysql_fetch_array($query_tampilkan)){
			$this->Cell(63,10,'',0,0,'C');
            $this->Cell(50,10,$hasil['jenis_barang'],1,0,'C');
            $this->Cell(30,10,$hasil['kuantiti_barang'],1,0,'L');
            $this->Cell(70,10,"",1,0,'L');

            $this->Ln();
        }
    }
}

$pdf = new myPDF();
$pdf->AliasNbPages();
$pdf->AddPage('L','A4',0);
$pdf->header2($id2);

$pdf->headerTable();
$pdf->viewTable($id2);
$pdf->Output();