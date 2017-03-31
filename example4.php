<?php
 include 'exfpdf.php';
 include 'easyTable.php';

 $pdf=new exFPDF();
 $pdf->AddPage(); 
 $pdf->SetFont('helvetica','',10);

 $table=new easyTable($pdf, '%{30,30, 20, 20}', 'width:70; border:0; font-size:8; line-height:1.2; paddingX:0');
 $table->easyCell('Nutrition Facts', 'colspan:4;font-style:B; font-size:20;line-height:0.6;');
 $table->printRow();

 $table->easyCell('Serving size 1/2 cup (about 82g)
                   Serving Per Container 8', 'colspan:4');
 $table->printRow();
 
 $table->rowStyle('min-height:1.8;paddingY:0.02;');
 $table->easyCell('', 'colspan:4; bgcolor:#000;');
 $table->printRow();
 
 $table->easyCell('Amount Per Serving', 'colspan:4; border:B; border-color:#a1a1a1;');
 $table->printRow(); 
 
 $table->easyCell('Calories 200','colspan:1; font-style:B;');
 $table->easyCell('Calories from Fat 130','colspan:3; align:R');
 $table->printRow();
 
 $table->rowStyle('min-height:1;paddingY:0.02;');
 $table->easyCell('', 'colspan:4; bgcolor:#000;');
 $table->printRow();
 
 $table->easyCell('% Daily Value*','colspan:4; align:R; font-style:B; border:B;border-color:#a1a1a1;');
 $table->printRow();

 $table->rowStyle('font-style:B; border:B;border-color:#a1a1a1;');
 $table->easyCell('Total Fat 14g','colspan:2;');
 $table->easyCell('22%','colspan:2; align:R; ');
 $table->printRow();

 $table->rowStyle('border:B;border-color:#a1a1a1;');
 $table->easyCell('Saturated Fat 9g','colspan:2; paddingX:5;');
 $table->easyCell('22%','colspan:2; align:R;font-style:B;');
 $table->printRow();

 $table->easyCell('Trans Fat 0g','colspan:4; paddingX:5; border:B; border-color:#a1a1a1;');
 $table->printRow();


 $table->rowStyle('font-style:B;border:B;border-color:#a1a1a1;');
 $table->easyCell('Cholesterol 55mg','colspan:2; ');
 $table->easyCell('18%','colspan:2; align:R;');
 $table->printRow();
 
 $table->rowStyle('font-style:B;border:B;border-color:#a1a1a1;');
 $table->easyCell('Sodium 40mg','colspan:2;');
 $table->easyCell('2%','colspan:2; align:R;');
 $table->printRow();

 $table->rowStyle('font-style:B;border:B;border-color:#a1a1a1;');
 $table->easyCell('Total Carbohydrate 17g','colspan:2;');
 $table->easyCell('6%','colspan:2; align:R;');
 $table->printRow();

 $table->rowStyle('border:B;border-color:#a1a1a1;');
 $table->easyCell('Dietary Fiber 1g','colspan:2; paddingX:5;');
 $table->easyCell('4%','colspan:2; align:R;font-style:B;');
 $table->printRow();

 $table->easyCell('Sugars 14g','colspan:4; paddingX:5; border:B;border-color:#a1a1a1;');
 $table->printRow();
 
 $table->easyCell('Protein 3g','colspan:4; font-style:B;border:B');
 $table->printRow();

 $table->rowStyle('min-height:1.8;paddingY:0.02;');
 $table->easyCell('', 'colspan:4; bgcolor:#000;');
 $table->printRow(); 
 
 $table->rowStyle('border:B;border-color:#a1a1a1;');
 $table->easyCell('Vitamin A 10%','colspan:2;');
 $table->easyCell(iconv("UTF-8", "CP1252", '•') . ' Vitamin C 0%','colspan:2;');
 $table->printRow();
 
 $table->rowStyle('border:B;border-color:#a1a1a1;'); 
 $table->easyCell('Calcium 10%','colspan:2;');
 $table->easyCell(iconv("UTF-8", "CP1252", '•') . ' Iron 6%','colspan:2;');
 $table->printRow();
 
 $table->easyCell('* Percent Daily Values are based on a 2,000 calorie 
 diet. Your daily values  may be higher or lower 
 depending on your calorie needs:','colspan:4;'); 
 $table->printRow();
 
 $table->rowStyle('border:B;border-color:#a1a1a1');
 $table->easyCell('Calories:','align:R;colspan:2; paddingX:5;'); 
 $table->easyCell('2,000',''); 
 $table->easyCell('2,500',''); 
 $table->printRow();
 
 $table->rowStyle('line-height:0.8;paddingY:0.5;');
 $table->easyCell('Total Fat'); 
 $table->easyCell('Less than'); 
 $table->easyCell('65g'); 
 $table->easyCell('80g'); 
 $table->printRow();
 
 $table->rowStyle('line-height:0.8;paddingY:0.5;');
 $table->easyCell('Saturated Fat'); 
 $table->easyCell('Less than'); 
 $table->easyCell('20g'); 
 $table->easyCell('25g'); 
 $table->printRow();

 $table->rowStyle('line-height:0.8;paddingY:0.5;');
 $table->easyCell('Cholesterol'); 
 $table->easyCell('Less than'); 
 $table->easyCell('300mg'); 
 $table->easyCell('300mg'); 
 $table->printRow();
 
 $table->rowStyle('line-height:0.8;paddingY:0.5;');
 $table->easyCell('Sodium'); 
 $table->easyCell('Less than'); 
 $table->easyCell('2,400mg'); 
 $table->easyCell('2,400mg'); 
 $table->printRow(); 
 
 $table->rowStyle('line-height:0.8;paddingY:0.5;');
 $table->easyCell('Total Carbohydrates', 'colspan:2;'); 
 $table->easyCell('300g'); 
 $table->easyCell('375g'); 
 $table->printRow(); 
 
 $table->rowStyle('line-height:0.8;paddingY:0.5;border:B; border-color:#a1a1a1;');
 $table->easyCell('Dietary Fiber', 'colspan:2; paddingX:5'); 
 $table->easyCell('25g'); 
 $table->easyCell('30g'); 
 $table->printRow(); 
 
 $table->easyCell('Calories per gram:', 'colspan:4; line-height:0.8;paddingY:0.5;'); 
 $table->printRow();

 $table->easyCell('Fat 9  ' . iconv("UTF-8", "CP1252", '•') . '  Carbohydrate 4  ' . iconv("UTF-8", "CP1252", '•') . '  Protein 4', 'colspan:4; line-height:0.8;paddingY:0.5;align:C'); 
 $table->printRow(); 

 $table->endTable(12);

//##############################################################  

 $y=$pdf->GetY();
 $pdf->Rect(65,$y-5, 80,110,'F');
 
 $table=new easyTable($pdf, '%{40, 30,30}', 'width:70; align:{RCC};bgcolor:#fff; line-height:1.2;border-width:0.001; border:1; border-color:#fff;');
 $table->easyCell('Change Plan', 'colspan:3; font-color:#bfbfbf; font-size:25; font-style:B;align:L; ');
 $table->printRow();

 $table->easyCell('123-123-1234: Plan name', 'colspan:3; font-color:#bfbfbf; font-size:16;align:L');
 $table->printRow();

 $table->easyCell('Use the table below to help you select a new plan. Additional plan features can also be configured.', 'line-height:1.5; colspan:3; font-size:10;align:L');
 $table->printRow();

 $table->rowStyle('bgcolor:#f39; font-style:B; dfont-size:11;font-color:#fff;');
 $table->easyCell('');
 $table->easyCell('Current');
 $table->easyCell('Plan1');
 $table->printRow(); 

 $table->rowStyle('bgcolor:#f2f2f2; paddingY:2;');
 $table->easyCell('Data');
 $table->easyCell('500MB');
 $table->easyCell('2.5GB');
 $table->printRow();  
 
 $table->rowStyle('paddingY:2;');
 $table->easyCell("Mobile Hotspot\n Capable - $10");
 $table->easyCell('');
 $table->easyCell('', 'img:tick.png, w3;');
 $table->printRow();
 
 $table->rowStyle('bgcolor:#f2f2f2; paddingY:2;font-style:B;');
 $table->easyCell('');
 $table->easyCell('$50');
 $table->easyCell('$60');
 $table->printRow(); 
 
 $table->rowStyle('paddingY:2;');
 $table->easyCell("International\nCalling\n$20");
 $table->easyCell('');
 $table->easyCell('', 'img:tick.png, w3;');
 $table->printRow();
 
 $table->endTable(1);


//##############################################################  
  
  
 $pdf->Output();  

?>