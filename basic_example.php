<?php
 include 'fpdf.php';
 include 'exfpdf.php';
 include 'easyTable.php';

 $pdf=new exFPDF();
 $pdf->AddPage(); 
 $pdf->SetFont('helvetica','',10);
 
 $pdf->Write(6, 'Some writing...');

 $pdf->Ln(5);

 $pdf->Write(6, 'Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Curabitur quis fermentum nibh. Aenean eget tellus eu ligula hendrerit dapibus vitae at leo. Vivamus at ligula non purus iaculis eleifend. Integer eget risus non dui scelerisque consectetur. Quisque et leo ut ex lacinia malesuada dictum vitae diam. Integer eleifend in nibh in mattis. Aenean eu justo quis mauris tempus eleifend. Praesent malesuada turpis ut justo semper tempor. Integer varius, nisi non elementum molestie, leo arcu euismod velit, eu tempor ligula diam convallis sem. Sed ultrices hendrerit suscipit. Pellentesque volutpat a urna nec placerat. Etiam auctor dapibus leo nec ullamcorper. Nullam id placerat elit. Vivamus ut quam a metus tincidunt laoreet sit amet a ligula. Sed rutrum felis ipsum, sit amet finibus magna tincidunt id. Suspendisse vel urna interdum lacus luctus ornare. Curabitur ultricies nunc est, eget rhoncus orci vestibulum eleifend. In in consequat mi. Curabitur sodales magna at consequat molestie. Aliquam vulputate, neque varius maximus imperdiet, nisi orci accumsan risus, sit amet placerat augue ipsum eget elit. Quisque sodales orci non est tincidunt tincidunt. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. In ut diam in dolor ultricies accumsan sit amet eu ex. Pellentesque aliquet scelerisque ullamcorper. Aenean porta enim eget nisl viverra euismod sed non eros. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Quisque at imperdiet sem, non volutpat metus. Phasellus sed velit sed orci iaculis venenatis ac id risus.');
 
 $pdf->Ln(10);

 $pdf->AddFont('FontUTF8','','Arimo-Regular.php'); 
 
 $table=new easyTable($pdf, 3, 'border:1;');
 
    $table->easyCell('Text 1', 'valign:T'); 
    $table->easyCell('Text 2', 'bgcolor:#b3ccff;');
    $table->easyCell('Text 3');
    $table->printRow();

    $table->rowStyle('min-height:60; align:{C};');   // let's adjust the height of this row
    $table->easyCell(iconv("UTF-8", 'KOI8-R', 'What about Russian? Вери порро номинати вел ех, еум те лаореет импедит, ест но ферри ириуре. Ет вис реяуе хомеро. Перфецто сцрипсерит вис еу, нам ин ассум пробатус. Фиерент импердиет аппеллантур меи но, граеце яуодси пертинациа вел ад, не при лудус оратио тациматес. Хис дебет дефинитионес цу.'), 'colspan:3; font-family:FontUTF8;');

    $table->printRow();

 $table->endTable(4);
 
//-----------------------------------------



 $pdf->Output(); 
?>