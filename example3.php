<?php
 include 'fpdf.php';
 include 'exfpdf.php';
 include 'easyTable.php';

 $pdf=new exFPDF();
 $pdf->AddPage(); 
 $pdf->SetFont('helvetica','',10);

 $table1=new easyTable($pdf, 2);
 $table1->easyCell('Sales Invoice', 'font-size:30; font-style:B; font-color:#00bfff;');
 $table1->easyCell('', 'img:Pics/fpdf.png, w80; align:R;');
 $table1->printRow();

 $table1->rowStyle('font-size:15; font-style:B;');
 $table1->easyCell('Customer details');
 $table1->easyCell('FPDF Generator Ltd', 'align:R;');
 $table1->printRow();
 
 $table1->rowStyle('font-size:12;');
 $table1->easyCell("<b>Name:</b> Mr. Rasmus Lerdorf\n<b>Address:</b> 123 Some Street\n<b>City:</b> Some City\n<b>Post Code:</b> ABC 123\n<b>Country:</b> Some Country");
 $table1->easyCell("Mr. Olivier PLATHEY\n123 Some other Street\nSome other City\nABC 123\nSome other Country", 'align:R;');
 $table1->printRow(); 
 $table1->endTable(5);

//====================================================================

$products=array(
'Consectetur adipiscing elit. Nam quis tincidunt mi', 
'Vitae pulvinar tortor. Integer quis mattis lorem. Quisque maximus ut ipsum aliquet mattis.', 
'Sed in tristique enim. Vivamus malesuada, sapien non consequat tempus, 
risus mauris ornare risus, in varius urna est quis enim.', 
'Suspendisse nec fermentum orci, ut feugiat felis.', 
'Phasellus molestie urna nisi, nec
imperdiet orci pretium vel. Donec vehicula tellus nisl, nec commodo diam posuere eu.',
'Interdum et malesuada fames ac ante ipsum primis in faucibus. Nunc in libero non',
'velit consectetur facilisis tincidunt non justo.',
'Pellentesque', 
'Scelerisque nec nibh a sollicitudin.', 
'Nullam porttitor nulla est, nec semper felis mattis sit amet.',
'Donec', 'fringilla congue felis, ornare', 'tempus velit congue at.', 
);

 $table=new easyTable($pdf, '{130, 20, 20, 20}','align:C{LCRR};border:1; border-color:#a1a1a1; ');

 $table->rowStyle('align:{CCCR};valign:M;bgcolor:#000000; font-color:#ffffff; font-family:times; font-style:B;');
 $table->easyCell('Description');
 $table->easyCell('Quantity');
 $table->easyCell('Price Per Unit');
 $table->easyCell('Amount');
 $table->printRow();
 
 for($i=0; $i<12; $i++)
 {
    $bgcolor='';
    if($i%2)
    {
       $bgcolor='bgcolor:#ccf2ff;';
    }
    $table->rowStyle('valign:M;border:LR;paddingY:2;' . $bgcolor);
    $table->easyCell($products[$i]);
    $table->easyCell(2+$i);
    $table->easyCell('$ 123.45');
    $table->easyCell('$ 123.45');
    $table->printRow();
 }
 
 $table->rowStyle('align:{RRRR};');
 $table->easyCell(' ', 'border:T;colspan:2');
 $table->easyCell('Subtotal', 'font-style:B;');
 $table->easyCell('$ 123.45');
 $table->printRow();

 $table->easyCell(' ', 'border:0;colspan:2');
 $table->easyCell('Tax', 'font-style:B; align:R');
 $table->easyCell('$ 123.45', 'align:R;');
 $table->printRow();

 $table->rowStyle('bgcolor:153,255,153;');
 $table->easyCell(' ', 'border:0;colspan:2; bgcolor:255,255,255;');
 $table->easyCell('Total', 'font-style:IB; align:R');
 $table->easyCell('$ ' . 123.45, 'align:R;');
 $table->printRow();

 $table->endTable();


 $pdf->Output(); 


 

?>