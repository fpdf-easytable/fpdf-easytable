<?php
include 'fpdf.php';
include 'exfpdf.php';
include 'easyTable.php';

$pdf=new exFPDF('P', 'in');
$pdf->AddPage();
$pdf->SetFont('helvetica','',10);

$write=new easyTable($pdf, 1, 'width:10;  align:L; dfont-style:B; font-size:15;font-family:times;');
$write->easyCell('Using  inches  as  user  units');
$write->printRow();

$write->endTable(1);

$tableB=new easyTable($pdf, 5, 'width:5; line-height:1; align:R{LC}; border:1;border-color:#1a66ff;');

$tableB->easyCell("Cell 1A A\n B\n C\n D\n E\n F\n", 'rowspan:5;');
$tableB->easyCell("Cell 1BC BB", 'rowspan:2; colspan:2; valign:B');
$tableB->easyCell("Cell 1D 1");
$tableB->easyCell("Cell 1D 1", '');
$tableB->printRow();

$tableB->easyCell("Cell 2D 1\n 2\n 3\n");
$tableB->easyCell("Cell 2D 1\n 2\n 3\n", 'rowspan:3;');
$tableB->printRow();
    
$tableB->easyCell("Cell 10 ");
$tableB->easyCell("Cell 12 1\n 2\n 3\n 4\n 5\n", 'rowspan:3;');
$tableB->easyCell("Cell 12 1\n 2\n 3\n 4\n 5\n", 'rowspan:2;');
$tableB->printRow();
    
$tableB->easyCell("Cell 12 ", '');
$tableB->printRow();
   
$tableB->easyCell("Cell 10 A");
$tableB->easyCell("Cell 12 1");
$tableB->easyCell("Cell 12 1");
$tableB->printRow();

$tableB->endTable(0.5);

//===================================================================
//===================================================================

 $table=new easyTable($pdf, '%{40, 30, 30}', 'width:3; align:{RCC}; bgcolor:#fff; line-height:1.2; border-width:0.05; border:1; border-color:#fff;');
 $table->easyCell('Change Plan', 'colspan:3; font-color:#bfbfbf; font-size:25; font-style:B; align:L;');
 $table->printRow();

 $table->easyCell('123-123-1234: Plan name', 'colspan:3; font-color:#bfbfbf; font-size:16; align:L');
 $table->printRow();

 $table->easyCell('Use the table below to help you select a new plan. Additional plan features can also be configured.', 'line-height:1.5; colspan:3; font-size:10;align:L');
 $table->printRow();

 $table->rowStyle('bgcolor:#f39; font-style:B; font-color:#fff;');
 $table->easyCell('');
 $table->easyCell('Current');
 $table->easyCell('Plan1');
 $table->printRow(); 

 $table->rowStyle('bgcolor:#f2f2f2; paddingY:0.2;');
 $table->easyCell('Data');
 $table->easyCell('500MB');
 $table->easyCell('2.5GB');
 $table->printRow();  
 
 $table->rowStyle('paddingY:0.2;');
 $table->easyCell("Mobile Hotspot\n Capable - $10");
 $table->easyCell('');
 $table->easyCell('', 'img:Pics/tick.png, w0.2;');
 $table->printRow();
 
 $table->rowStyle('bgcolor:#f2f2f2; paddingY:0.2; font-style:B;');
 $table->easyCell('');
 $table->easyCell('$50');
 $table->easyCell('$60');
 $table->printRow(); 
 
 $table->rowStyle('paddingY:0.2;');
 $table->easyCell("International\nCalling\n$20");
 $table->easyCell('');
 $table->easyCell('', 'img:Pics/tick.png, w0.2;');
 $table->printRow();
 
 $table->endTable(5);


//===================================================================
//===================================================================


$pdf->Output(); 


?>