<?php
include 'fpdf.php';
include 'exfpdf.php';
include 'easyTable.php';

$cells=array('Lorem ipsum dolor', 
'Consectetur adipiscing elit. Nam quis tincidunt mi', 
'Vitae pulvinar tortor. Integer quis mattis lorem. Quisque maximus ut ipsum aliquet mattis.', 
'Sed in tristique enim. Vivamus malesuada, sapien non consequat tempus, risus mauris ornare risus, in varius urna est quis enim.', 
'Suspendisse nec fermentum orci, ut feugiat felis.', 
'Phasellus molestie urna nisi, nec
imperdiet orci pretium vel. Donec vehicula tellus nisl, nec commodo diam posuere eu.',
'Interdum et malesuada fames ac ante ipsum primis in faucibus. Nunc in libero non velit consectetur facilisis tincidunt non justo.',
'Pellentesque', 'Scelerisque nec nibh a sollicitudin.', 'Nullam porttitor nulla est, nec semper felis mattis sit amet.',
'Donec', 'fringilla congue felis, ornare', 'tempus velit congue at.', 
'Curabitur euismod, urna ut pretium sodales',
'felis ligula tincidunt tellus, a vestibulum urna velit ac odio.',
'In non est et arcu sollicitudin', 
'Faucibus et in metus. Proin consequat dictum aliquam. Fusce sodales, nisl sit amet ornare porta', 
'velit odio ultricies quam', 'ut accumsan massa enim a tortor', 
'Sed euismod est eu laoreet blandit.',
'Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas.',
'Donec eget enim egestas, pulvinar nulla non, mollis risus. In id ipsum ex. Morbi laoreet dui feugiat enim dapibus rhoncus. Curabitur mollis velit accumsan ex suscipit fringilla. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Curabitur quis fermentum nibh. Aenean eget tellus eu ligula hendrerit dapibus vitae at leo. Vivamus at ligula non purus iaculis eleifend. Integer eget risus non dui scelerisque consectetur. Quisque et leo ut ex lacinia malesuada dictum vitae diam. Integer eleifend in nibh in mattis. Aenean eu justo quis mauris tempus eleifend. Praesent malesuada turpis ut justo semper tempor. Integer varius, nisi non elementum molestie, leo arcu euismod velit, eu tempor ligula diam convallis sem. Sed ultrices hendrerit suscipit. Pellentesque volutpat a urna nec placerat. Etiam auctor dapibus leo nec ullamcorper. Nullam id placerat elit. Vivamus ut quam a metus tincidunt laoreet sit amet a ligula. Sed rutrum felis ipsum, sit amet finibus magna tincidunt id. Suspendisse vel urna interdum lacus luctus ornare. Curabitur ultricies nunc est, eget rhoncus orci vestibulum eleifend. In in consequat mi. Curabitur sodales magna at consequat molestie. Aliquam vulputate, neque varius maximus imperdiet, nisi orci accumsan risus, sit amet placerat augue ipsum eget elit. Quisque sodales orci non est tincidunt tincidunt. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. In ut diam in dolor ultricies accumsan sit amet eu ex. Pellentesque aliquet scelerisque ullamcorper. Aenean porta enim eget nisl viverra euismod sed non eros. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Quisque at imperdiet sem, non volutpat metus. Phasellus sed velit sed orci iaculis venenatis ac id risus.');


 $pdf=new exFPDF();
 $pdf->AddPage(); 
 $pdf->SetFont('helvetica','',10);
 $pdf->AddFont('FontUTF8','','Arimo-Regular.php'); 
 $pdf->AddFont('FontUTF8','B','Arimo-Bold.php');
 $pdf->AddFont('FontUTF8','I','Arimo-Italic.php');
 $pdf->AddFont('FontUTF8','BI','Arimo-BoldItalic.php');

 $table=new easyTable($pdf, '{20, 30, 45, 45, 30}', 'width:170; border-color:#ffff00; font-size:10; border:1; paddingY:2;');

 $table->rowStyle('align:{LRCC}; bgcolor:#00ace6;font-style:B');
 $table->easyCell("Header 1", 'rowspan:2');
 $table->easyCell("Header 2");
 $table->easyCell("Header 3", 'colspan:2');
 $table->easyCell("Header 4");
 $table->printRow();

 $table->rowStyle('align:{RCC}; bgcolor:#00ace6;font-style:B');
 $table->easyCell("Header 5");
 $table->easyCell("Header 6");
 $table->easyCell("Header 7");
 $table->easyCell("Header 8");
 $table->printRow(true);

 $table->rowStyle('align:C; valign:M');
 $table->easyCell('<s "font-style:U">'.$cells[0] .'</s>', 'font-size:8');
 $table->easyCell(iconv("UTF-8", 'KOI8-R', '<b>Вери</b> порро <i>номинати</i> вел ех, <b><i>еум</i></b> те лаореет импедит, <s "font-style:B;font-size:18; font-color:#3399ff">ест но ферри ириуре.</s> Ет вис реяуе хомеро. Перфецто сцрипсерит вис еу, нам ин ассум пробатус. Фиерент импердиет аппеллантур меи но, граеце яуодси пертинациа вел ад, не при лудус оратио тациматес. Хис дебет дефинитионес цу.'), 'colspan:4; font-family:FontUTF8; font-size:12;');

 $table->printRow();

 $table->easyCell($cells[0], 'font-size:6; valign:T');
 $table->easyCell($cells[0], 'font-size:6; align:C; valign:M');
 $table->easyCell($cells[0], 'font-size:6; align:R; valign:B');
 $table->easyCell($cells[5], 'font-size:6; align:J; valign:M');
 $table->easyCell($cells[6]);
 $table->printRow();
 
 $table->easyCell('', 'img:Pics/fpdflogo.png, w10, h40;');
 $table->easyCell('', 'img:Pics/fpdflogo.png');
 $table->easyCell('', 'img:Pics/fpdflogo.png, w40, h10;');
 $table->easyCell($cells[0], 'img:Pics/fpdflogo.png, w30; align:C; valign:B;font-size:6; font-style:I;');
 $table->easyCell($cells[1], 'img:Pics/fpdflogo.png, w30; align:C; valign:T;font-size:6; font-style:I;');
 $table->printRow();
 
 $table->easyCell('', 'img:Pics/fpdflogo.png, w10; align:L');
 $table->easyCell('', 'img:Pics/fpdflogo.png, w10;');
 $table->easyCell('', 'img:Pics/fpdflogo.png, h10; align:R;');
 $table->easyCell('', 'img:Pics/fpdflogo.png, h10; align:R; valign:T');
 $table->easyCell($cells[1], 'img:Pics/fpdflogo.png, w30; align:C; valign:T;font-size:6; font-style:I;');
 $table->printRow();
  
 $table->easyCell($cells[0], 'font-size:6; valign:T');
 $table->easyCell($cells[4] . ' ' . $cells[5] . ' ' . $cells[6], 'font-size:8; colspan:4; align:J; valign:M; bgcolor:#ff5050;');
 $table->printRow();
 
 $table->easyCell($cells[0], 'font-size:6; valign:T');
 $table->easyCell($cells[1] . ' ' . $cells[5], 'font-size:8; colspan:3; align:C; bgcolor:#ff5050;');
 $table->easyCell($cells[0], 'font-size:6; align:R; valign:B; bgcolor:#66b3ff;');
 $table->printRow();
 
 
 $table->easyCell($cells[7], 'rowspan:2;bgcolor:#00ffcc;');
 $table->easyCell($cells[7], 'rowspan:3; colspan:3');
 $table->easyCell($cells[0]);
 $table->printRow();
 
 $table->easyCell($cells[1]);
 $table->printRow();
 
 $table->easyCell($cells[1]);
 $table->easyCell($cells[1]);
 $table->printRow(); 
 
 $n=count($cells);
 for($i=0; $i<10; $i++)
 {
    $table->easyCell($cells[$i%$n]);
    $table->easyCell($cells[(1+$i)%$n]);
    $table->easyCell($cells[(2+$i)%$n]);
    $table->easyCell($cells[(3+$i)%$n]);
    $table->easyCell($cells[(4+$i)%$n]);
    $table->printRow();
 } 
 
 $table->endTable(10);
 
 $pdf->Output(); 


 

?>