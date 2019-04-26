<?php 
	include 'mpdf60/mpdf.php';
	$mpdf = new mPDF();
	$mpdf->Bookmark('Start of the document');
	$data = include "index.php";
	$mpdf->WriteHTML(''.$data);
	$mpdf->Output('test.pdf','I');
?>