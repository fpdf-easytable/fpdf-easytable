<?php
 include 'fpdf.php';
 include 'exfpdf.php';
 include 'easyTable.php';

 $pdf=new exFPDF();
 $pdf->AddPage(); 
 $pdf->SetFont('helvetica','',10);

 $write=new easyTable($pdf, 1, 'width:150; align:L; font-style:B; font-size:15;font-family:times;');
 $write->easyCell('Evolution of a table');
 $write->printRow();
 $write->endTable(5);

//########################################################

 $tableB=new easyTable($pdf, 5, 'width:100; align:L{LC}; font-color:#0066ff');

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

 $tableB->endTable(10);


//########################################################

 $tableB=new easyTable($pdf, 5, 'width:100; align:{LC}; l-margin:20; border:TB; font-color:#0066ff');

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

 $tableB->endTable(10);

//########################################################

 $tableB=new easyTable($pdf, 5, 'width:100; align:C{LC}; border:RL; border-color:#f3c; border-width:0.7');

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

 $tableB->endTable(10);

//########################################################

 $tableB=new easyTable($pdf, 5, 'width:100; align:R{LC}; border:1;border-color:#1a66ff;');

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

 $tableB->endTable(10);

//########################################################
 $pdf->AddPage();
 
 $tableB=new easyTable($pdf, 5, 'width:100; align:L{LC}; border-color:#1a66ff; border-width:0.6; ');

 $tableB->easyCell("Cell 1A A\n B\n C\n D\n E\n F\n", 'rowspan:5; border:1');
 $tableB->easyCell("Cell 1BC BB", 'rowspan:2; colspan:2; valign:B;border:T');
 $tableB->easyCell("Cell 1D 1", 'border:T');
 $tableB->easyCell("Cell 1D 1", 'border:TR');
 $tableB->printRow();
    
 $tableB->easyCell("Cell 2D 1\n 2\n 3\n", 'border:1; border-color:#ff4d4d;');
 $tableB->easyCell("Cell 2D 1\n 2\n 3\n", 'rowspan:3;border:R');
 $tableB->printRow();
    
 $tableB->easyCell("Cell 10 ");
 $tableB->easyCell("Cell 12 1\n 2\n 3\n 4\n 5\n", 'rowspan:3;; border:1');
 $tableB->easyCell("Cell 12 1\n 2\n 3\n 4\n 5\n", 'rowspan:2;');
 $tableB->printRow();
    
 $tableB->easyCell("Cell 12 ", '');
 $tableB->printRow();
   
 $tableB->easyCell("Cell 10 A", 'border:B');
 $tableB->easyCell("Cell 12 1", 'border:B');
 $tableB->easyCell("Cell 12 1", 'border:BR');
 $tableB->printRow();

 $tableB->endTable(10);

//########################################################


 
 $tableB=new easyTable($pdf, 5, 'width:100; align:L{LC}; border-color:#1a66ff; ');

 $tableB->rowStyle('bgcolor:#b3ffcc;');
 $tableB->easyCell("Cell 1A A\n B\n C\n D\n E\n F\n", 'rowspan:5; border:1');
 $tableB->easyCell("Cell 1BC BB", 'rowspan:2; colspan:2; valign:B;border:T');
 $tableB->easyCell("Cell 1D 1", 'border:T');
 $tableB->easyCell("Cell 1D 1", 'border:TR');
 $tableB->printRow();
    
 $tableB->easyCell("Cell 2D 1\n 2\n 3\n", 'border:1');
 $tableB->easyCell("Cell 2D 1\n 2\n 3\n", 'rowspan:3;border:R');
 $tableB->printRow();
    
 $tableB->easyCell("Cell 10 ");
 $tableB->easyCell("Cell 12 1\n 2\n 3\n 4\n 5\n", 'rowspan:3;; border:1');
 $tableB->easyCell("Cell 12 1\n 2\n 3\n 4\n 5\n", 'rowspan:2;');
 $tableB->printRow();
    
 $tableB->easyCell("Cell 12 ", '');
 $tableB->printRow();
   
 $tableB->easyCell("Cell 10 A", 'border:B');
 $tableB->easyCell("Cell 12 1", 'border:B');
 $tableB->easyCell("Cell 12 1", 'border:BR');
 $tableB->printRow();

 $tableB->endTable(10);

//########################################################

 $write=new easyTable($pdf, 1);
 $write->easyCell('What about drawing two tables side by side?', 'font-family:times; font-size:15; font-style:B;');
 $write->printRow();
 $write->endTable(5);

 $x=$pdf->GetX();
 $y=$pdf->GetY();

 $tableB=new easyTable($pdf, 5, 'width:100; align:L{LC}; bgcolor:#b3ffcc;border-color:#1a66ff; ');

 $tableB->easyCell("Cell 1A A\n B\n C\n D\n E\n F\n", 'rowspan:5; border:1');
 $tableB->easyCell("Cell 1BC BB", 'rowspan:2; colspan:2; valign:B;border:T');
 $tableB->easyCell("Cell 1D 1", 'border:T');
 $tableB->easyCell("Cell 1D 1", 'border:TR');
 $tableB->printRow();
    
 $tableB->easyCell("Cell 2D 1\n 2\n 3\n", 'border:1');
 $tableB->easyCell("Cell 2D 1\n 2\n 3\n", 'rowspan:3;border:R');
 $tableB->printRow();
    
 $tableB->easyCell("Cell 10 ");
 $tableB->easyCell("Cell 12 1\n 2\n 3\n 4\n 5\n", 'rowspan:3; border:1');
 $tableB->easyCell("Cell 12 1\n 2\n 3\n 4\n 5\n", 'rowspan:2;');
 $tableB->printRow();
    
 $tableB->easyCell("Cell 12 ", '');
 $tableB->printRow();
   
 $tableB->easyCell("Cell 10 A", 'border:B');
 $tableB->easyCell("Cell 12 1", 'border:B');
 $tableB->easyCell("Cell 12 1", 'border:BR');
 $tableB->printRow();

 $tableB->endTable(10);
//########################################################


 $pdf->SetY($y);
 
 $tableB=new easyTable($pdf, 3, 'width:60; l-margin:115; border1; border-color:#1a66ff;');
 
 for($i=0; $i<8; $i++)
 {
    $style='';
    if($i%2)
    {
       $style='bgcolor:#b3f0ff;';
    }
    $tableB->rowStyle($style);
    $tableB->easyCell("Cell ", 'font-style:i');
    $tableB->easyCell("Cell 1D 1");
    $tableB->easyCell("Cell 1D 1");
    $tableB->printRow(); 
 }
 $tableB->endTable(10);

//########################################################

 $write=new easyTable($pdf, 1);
 $write->easyCell('The following table split on two pages', 'font-family:times; font-size:15; font-style:B;');
 $write->printRow();
 $write->endTable(10);

 $tableB=new easyTable($pdf, 5, 'split-row:true; width:100; border:1; border-color:#ffff00; fbgcolor:#000000; font-color:#FFFFBB; paddingY:4;');

 $tableB->easyCell("Cell 1A A\n B\n C\n D\n E\n F\n", 'bgcolor:#29526D; rowspan:5; font-size:11; valign:B');
 $tableB->easyCell("Cell 1BC BB", 'img:Pics/fpdflogo.gif,w30;align:C; font-size:8; rowspan:2; colspan:2; bgcolor:#ff1a75; valign:B');
 $tableB->easyCell("Cell 1D 1", 'font-size:14; bgcolor:#99ff66 ');
 $tableB->easyCell("Cell 1D 1", 'font-size:14; bgcolor:#85adad; paddingY:6; font-color:0,120,0;');
 $tableB->printRow();
    
 $tableB->easyCell("Cell 2D 1\n 2\n 3\n", 'font-size:14; bgcolor:#005ce6');
 $tableB->easyCell("Cell 2D 1\n 2\n 3\n", 'font-size:14; rowspan:3; bgcolor:#b3d9ff');
 $tableB->printRow();
    
 $tableB->easyCell("Cell 10 ", 'align:J; font-size:8; bgcolor:#ff6666;');
 $tableB->easyCell("Cell 12 1\n 2\n 3\n 4\n 5\n", 'font-size:14; rowspan:3; bgcolor:#0077b3; ');
 $tableB->easyCell("Cell 12 1\n 2\n 3\n 4\n 5\n", 'font-color:0,0,0;font-size:10; rowspan:2;');
 $tableB->printRow();
    
 $tableB->easyCell("Cell 12 ", 'font-size:14; bgcolor:#33ccff ');
 $tableB->printRow();
   
 $tableB->easyCell("Cell 10 A", 'align:J; font-size:8; bgcolor:#1aff8c;');
 $tableB->easyCell("Cell 12 1", 'font-size:12; bgcolor:#ff884d ');
 $tableB->easyCell("Cell 12 1", 'font-size:12; bgcolor:#e62e00 ');
 $tableB->printRow();

 $tableB->endTable(10);

//############################################

 $write=new easyTable($pdf, 1, 'font-family:times;');
 $write->easyCell('Demonstration of the attribute min-height for rows', 'font-style:B; font-size:15;');
 $write->printRow();
 $write->easyCell("The following two tables have the same cell configuration, however in the first case, the middle row collapse. In the second table, we fix this using of the row attribute min-height.
 This is not a bug but an expected behaviour (compare with HTML tables). This happens because, the second row does not contain a cell that span to just one row. Despite the cell has a height given by its content, the second row has height zero", 'font-size:12;');
 $write->printRow();
 $write->endTable(5);
 
 $write=new easyTable($pdf, 1, 'font-family:times;');
 $write->easyCell('Without the min-height attribute', 'font-style:B;');
 $write->printRow();
 $write->endTable();

 $cells=array('Lorem Ipsum dolor sit amet', 
'Consectetur adipiscing elit. Nam quis tincidunt mi', 
'Vitae pulvinar tortor. Integer quis mattis lorem. Quisque maximus ut ipsum aliquet mattis.', 
'Sed in tristique enim. Vivamus malesuada, sapien non consequat tempus, risus 
mauris ornare risus, in varius urna est quis enim.', 
'Suspendisse nec fermentum orci, ut feugiat felis.', 
'Phasellus molestie urna nisi, nec
imperdiet orci pretium vel. Donec vehicula tellus nisl, nec commodo diam posuere eu.'
);

 $table4=new easyTable($pdf, 3, 'width:100; align:C{LCR}; bgcolor:#66ffcc; paddingY:5;');

 $table4->easyCell('Cell 1 ' . $cells[0], 'bgcolor:#b3ccff; rowspan:2');
 $table4->easyCell('Cell 2 ' . $cells[1], 'valign:M; bgcolor:#ffffff;');
 $table4->easyCell('Cell 1 ' . $cells[0], 'rowspan:2'); 
 $table4->printRow();
 
 $table4->easyCell('Cell 1 ' . $cells[0], 'bgcolor:#3377ff; rowspan:2');
 $table4->printRow();

 $table4->easyCell('Cell 2 ' . $cells[1], 'valign:M');
 $table4->easyCell('Cell 1 ' . $cells[0], 'bgcolor:#99bbff;');
 $table4->printRow();
 $table4->endTable(5);
 
 
 $write=new easyTable($pdf, 1, 'font-family:times;');
 $write->easyCell('With the min-height attribute', 'font-style:B;');
 $write->printRow();
 $write->endTable(5);
 
 
 $table4=new easyTable($pdf, 3, 'width:100; align:C{LCR}; bgcolor:#66ffcc; paddingY:5;');

 $table4->easyCell('Cell 1 ' . $cells[0], 'bgcolor:#b3ccff; rowspan:2');
 $table4->easyCell('Cell 2 ' . $cells[1], 'valign:M; bgcolor:#ffffff;');
 $table4->easyCell('Cell 1 ' . $cells[0], 'rowspan:2'); 
 $table4->printRow();
 
 $table4->rowStyle('min-height:20');
 $table4->easyCell('Cell 1 ' . $cells[0], 'bgcolor:#3377ff;rowspan:2');
 $table4->printRow();

 $table4->easyCell('Cell 2 ' . $cells[1], 'valign:M');
 $table4->easyCell('Cell 1 ' . $cells[0], 'bgcolor:#99bbff;');
 $table4->printRow();

 $table4->endTable();
 
//#################################################

 $pdf->AddPage(); 
  
 $write=new easyTable($pdf, 1, 'font-family:times;');
 $write->easyCell('What about to leave a gap between to rows?', 'font-style:B; font-size:15;');
 $write->printRow();
 $write->endTable(5);
 

 $table=new easyTable($pdf, 2, 'width:100; align:Ld; border:1; fbgcolor:#ffffff; font-color:#f3a2a3; paddingY:4;');

 $table->easyCell("Cell 0 A\n", 'bgcolor:#29526D; font-size:8');
 $table->easyCell("Cell 1 A\n B\n C\n", 'bgcolor:#ff1a75; font-size:12');
 $table->printRow();
 
 $pdf->Ln(2);

 $table->easyCell("Cell 2 A\n B\n C\n", 'font-size:14; bgcolor:#99ff66 ');
 $table->easyCell("Cell 3 A\n B\n", 'font-size:10; bgcolor:#85adad ');
 $table->printRow();

 $table->endTable(10);



//###############################################

 $write=new easyTable($pdf, 1, 'font-family:times;');
 $write->easyCell('Two ways to do the same layout', 'font-style:B; font-size:15;');
 $write->printRow();
 $write->easyCell('In this case using two tables side by side (not recommended)', 'font-style:B; font-size:10;');
 $write->printRow();
 $write->endTable(5);

 $text='Sed euismod est eu laoreet blandit. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Donec eget enim egestas, pulvinar nulla non, mollis risus. In id ipsum ex. Morbi laoreet dui feugiat enim dapibus rhoncus. Curabitur mollis velit accumsan ex suscipit fringilla. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Curabitur quis fermentum nibh. Aenean eget tellus eu ligula hendrerit dapibus vitae at leo. Vivamus at ligula non purus iaculis eleifend. Integer eget risus non dui scelerisque consectetur. Quisque et leo ut ex lacinia malesuada dictum vitae diam. Integer eleifend in nibh in mattis. Aenean eu justo quis mauris tempus eleifend. Praesent malesuada turpis ut justo semper tempor. Integer varius, nisi non elementum molestie, leo arcu euismod velit, eu tempor ligula diam convallis sem. Sed ultrices hendrerit suscipit. Pellentesque volutpat a urna nec placerat. Etiam auctor dapibus leo nec ullamcorper. Nullam id placerat elit. Vivamus ut quam a metus tincidunt laoreet sit amet a ligula. Sed rutrum felis ipsum, sit amet finibus magna tincidunt id. Suspendisse vel urna interdum lacus luctus ornare. Curabitur ultricies nunc est, eget rhoncus orci vestibulum eleifend. In in consequat mi. Curabitur sodales magna at consequat molestie. Aliquam vulputate, neque varius maximus imperdiet, nisi orci accumsan risus, sit amet placerat augue ipsum eget elit. Quisque sodales orci non est tincidunt tincidunt. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. In ut diam in dolor ultricies accumsan sit amet eu ex. Pellentesque aliquet scelerisque ullamcorper. Aenean porta enim eget nisl viverra euismod sed non eros. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Quisque at imperdiet sem, non volutpat metus. Phasellus sed velit sed orci iaculis venenatis ac id risus.';

 $y=$pdf->GetY(); 
 $table=new easyTable($pdf, 1, 'width:100; align:L');
 $table->easyCell($text);
 $table->printRow();
 $table->endTable(2);
 $final_vposition=$pdf->GetY(); 

 $pdf->SetY($y); 
 $table=new easyTable($pdf, 3, 'width:90; align:R; border:1;');
 for($i=0; $i<20; $i++)
 { 
    $table->easyCell('text 1');
    $table->easyCell('text 2');
    $table->easyCell('text 3');
    $table->printRow();
 }
 $table->endTable(10);
 $pdf->SetY(max($final_vposition, $pdf->GetY())); 

 //----------------------------------------------

 $write=new easyTable($pdf, 1, 'font-family:times;');
 $write->easyCell('The right way', 'font-style:B; font-size:10;');
 $write->printRow();
 $write->endTable(5);
 
 $rows=20;  
 $table=new easyTable($pdf, '{100, 30,30,30}', 'split-row:true; align:L; border:1');
 $table->easyCell($text, "rowspan:$rows; border:0;");
 $table->easyCell('text 1', 'bgcolor:#000; font-color:#fff');
 $table->easyCell('text 2', 'bgcolor:#000; font-color:#fff');
 $table->easyCell('text 3', 'bgcolor:#000; font-color:#fff');
 $table->printRow();
 for($i=0; $i<$rows-1; $i++)
 { 
    
    $table->easyCell('text 1 ' . $i);
    $table->easyCell('text 2 ' . $i);
    $table->easyCell('text 3 ' . $i);
    $table->printRow();
 }
 $table->endTable(10);
 
 

//###############################################


 $pdf->Output(); 


 

?>