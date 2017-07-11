<?php
include 'PDFMerger.php';

$pdf = new PDFMerger;

$pdf->addPDF('samplepdfs/report_1.pdf', 'all')
	->addPDF('samplepdfs/report_2.pdf', 'all')
	->merge('browser');
	
	//REPLACE 'file' WITH 'browser', 'download', 'string', or 'file' for output options
	//You do not need to give a file path for browser, string, or download - just the name.
