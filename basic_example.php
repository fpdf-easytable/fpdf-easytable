<?php
 include 'fpdf.php';
 include 'exfpdf.php';
 include 'easyTable.php';

 $pdf=new exFPDF();
 $pdf->AddPage(); 
 $pdf->SetFont('helvetica','',10);

 $pdf->AddFont('lato','','Lato-Regular.php');

 $pdf->Write(6, 'Some writing...');

 $pdf->Ln(5);

 $pdf->Write(6, 'Integer eget risus non dui scelerisque consectetur. Integer eleifend in nibh in mattis. Aenean eu justo quis mauris tempus eleifend. Praesent malesuada turpis ut justo semper tempor. Integer varius, nisi non elementum molestie, leo arcu euismod velit, eu tempor ligula diam convallis sem. Sed ultrices hendrerit suscipit. Pellentesque volutpat a urna nec placerat. Etiam auctor dapibus leo nec ullamcorper. Nullam id placerat elit. Vivamus ut quam a metus tincidunt laoreet sit amet a ligula. Sed rutrum felis ipsum, sit amet finibus magna tincidunt id. Suspendisse vel urna interdum lacus luctus ornare. Curabitur ultricies nunc est, eget rhoncus orci vestibulum eleifend. In in consequat mi. Curabitur sodales magna at consequat molestie. Aliquam vulputate, neque varius maximus imperdiet, nisi orci accumsan risus, sit amet placerat augue ipsum eget elit. Quisque sodales orci non est tincidunt tincidunt. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. In ut diam in dolor ultricies accumsan sit amet eu ex. Pellentesque aliquet scelerisque ullamcorper. Aenean porta enim eget nisl viverra euismod sed non eros. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Quisque at imperdiet sem, non volutpat metus. Phasellus sed velit sed orci iaculis venenatis ac id risus.');
 
 $pdf->Ln(10);

 $pdf->AddFont('FontUTF8','','Arimo-Regular.php'); 
 $pdf->AddFont('FontUTF8','B','Arimo-Bold.php'); 
 $pdf->AddFont('FontUTF8','BI','Arimo-BoldItalic.php'); 
 $pdf->AddFont('FontUTF8','I','Arimo-Italic.php'); 
 
 $table=new easyTable($pdf, 3, 'border:1;font-size:12;');
 
    $table->easyCell('<b>This text is in bold</b> and <i>this is in italic</i> and this is normal', 'valign:T; bgcolor:#eee6ff;'); 
    $table->easyCell("T<s 'font-color:#3399ff; font-style:B; font-size:19'>h</s><s 'font-color:#00cc00; font-style:I; font-size:21'>i</s>s <s 'font-color:#ff0000; font-style:BI; font-size:8'>is</s> a <s 'font-color:#0099ff; font-size:25'><b>c</b><i>r</i><bi>a</bi><b>z</b><i>y</i></s> text");
    $table->easyCell("<s 'font-color:#4da6ff; font-style:B; font-size:18'><i>And can do it with Russian, just because <s 'font-size:25; font-color:#66ff99'>we can!</s></i></s>", 'font-style:I;');
    $table->printRow();

    $table->rowStyle('min-height:60; align:{C};font-size:18;');   // let's adjust the height of this row
    $table->easyCell(iconv("UTF-8", 'KOI8-R', '<b>Вери</b> порро <i>номинати</i> вел ех, <b><i>еум</i></b> те лаореет импедит, <s "font-style:B;font-size:18; font-color:#3399ff">ест но ферри ириуре.</s> Ет вис реяуе хомеро. Перфецто сцрипсерит вис еу, нам ин ассум пробатус. Фиерент импердиет аппеллантур меи но, граеце яуодси пертинациа вел ад, не при лудус оратио тациматес. Хис дебет дефинитионес цу.
    
    <s "font-family:times;font-size:20;">Set different font-families <s "font-family:lato;font-size:25;">in the same cell</s></s>  
    
    <s "font-family:times;font-size:18;">This is a link <s "font-family:lato;font-size:20;font-color:#0099ff; href:http://www.fpdf.org/">FPDF</s></s>  
    
    '), 'colspan:4; font-family:FontUTF8; font-size:12;');

    $table->printRow();

 $table->endTable(4);
 
//-----------------------------------------

 $pdf->Output(); 

?>