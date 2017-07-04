<?php
 include 'fpdf.php';
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
 $table->easyCell('', 'img:Pics/tick.png, w3;');
 $table->printRow();
 
 $table->rowStyle('bgcolor:#f2f2f2; paddingY:2;font-style:B;');
 $table->easyCell('');
 $table->easyCell('$50');
 $table->easyCell('$60');
 $table->printRow(); 
 
 $table->rowStyle('paddingY:2;');
 $table->easyCell("International\nCalling\n$20");
 $table->easyCell('');
 $table->easyCell('', 'img:Pics/tick.png, w3;');
 $table->printRow();
 
 $table->endTable(5);


//##############################################################  
//##############################################################  

 $table=new easyTable($pdf, '%{15, 35, 15, 35}', 'width:150; paddingX:3;border:1; border-color:#000; font-color:#fff; bgcolor:#000;');

 $table->rowStyle('dfont-style:B; font-size:13; paddingY:3;');
 $table->easyCell('Shared Cluster', 'colspan:2;');
 $table->easyCell('Dedicated', 'colspan:2;');
 $table->printRow();
 
 $table->rowStyle('font-size:9; line-height:1.3;');
 $table->easyCell('Light to medium data need? Our shared
 cluster is simple and cost-effective.', 'colspan:2;');
 $table->easyCell('Powerful, high-end servers 
 for your mission critical projects.', 'colspan:2;');
 $table->printRow();

 $table->rowStyle('min-height:4;');
 $table->easyCell('', 'colspan:4');
 $table->printRow();

 $table->easyCell('', 'img:Pics/a.png; rowspan:2;');
 $table->easyCell('Tau FREE', 'font-style:B; font-size:15; align:J; font-color:#1a53ff;');
 $table->easyCell('', 'img:Pics/b.png; rowspan:2;');
 $table->easyCell('Capri $15.00', 'font-style:B; font-size:15; align:J');
 $table->printRow();

 $table->rowStyle('font-size:8;line-height:1.3');
 $table->easyCell('500MB storage
 Fits a blog, personal site or
 small project wiki');
 $table->easyCell('1GB storage
 Great for a small company
 intranet or staging server');
 $table->printRow();

 $table->rowStyle('min-height:4;');
 $table->easyCell('', 'colspan:4');
 $table->printRow();
 
 $table->easyCell('', 'img:Pics/c.png; rowspan:2;');
 $table->easyCell('Scorp $30.00', 'font-style:B; font-size:15; align:J');
 $table->easyCell('', 'img:Pics/d.png; rowspan:2;');
 $table->easyCell('Leo $50.00', 'font-style:B; font-size:15; align:J');
 $table->printRow();

 $table->rowStyle('font-size:8;line-height:1.3');
 $table->easyCell('1.5GB storage
 Perfect for small biz app.
 e-commerce site or CMS.');
 $table->easyCell("10GB storage
 Superior performance when it's most critical for your super scale, high traffic apps.");
 $table->printRow();

 $table->endTable(30);


//##############################################################  
//##############################################################  

 $header=array('Employee', 'Salary', 'Bonus', 'Supervisor');
 $query=array(
              array('Employee'=>'Michael J. Fox', 'Salary'=>300.50, 'Bonus'=>50, 'Supervisor'=>'Bob'),
              array('Employee'=>'Robert Smit', 'Salary'=>240, 'Bonus'=>20, 'Supervisor'=>'Michel'),
              array('Employee'=>'Jessie Roberts', 'Salary'=>205, 'Bonus'=>15, 'Supervisor'=>'Bob'),
              array('Employee'=>'Roger Brown', 'Salary'=>350, 'Bonus'=>30, 'Supervisor'=>'Antony'),
              array('Employee'=>'Rosie Taylor', 'Salary'=>270.50, 'Bonus'=>70, 'Supervisor'=>'Mark'),
              );

 $table=new easyTable($pdf, '%{30, 20, 20, 30}', 'width:120; font-size:12; align:{LRRL}; paddingX:2;font-family:times;border:B; border-color:#ccc;');
 foreach($header as $h)
 {
    $table->easyCell($h, 'font-color:#234fa7;font-style:B;');
 }
 $table->printRow(true);

 $table->rowStyle('min-height:0.6;bgcolor:#6678b1;paddingY:0.2;');
 $table->easyCell('', 'colspan:4');
 $table->printRow();

 foreach($query as $data)
 { 
    $table->rowStyle('font-color:#666699;');
    $table->easyCell($data['Employee']);
    $table->easyCell('$' . number_format($data['Salary'],2));
    $table->easyCell('$' . number_format($data['Bonus'], 2));
    $table->easyCell($data['Supervisor']);
    $table->printRow();
 }
 $table->endTable(30);

//##############################################################  
//##############################################################  

 $pdf->AddFont('lato','','Lato-Regular.php');
 
 $table=new easyTable($pdf, 3, 'width:150; align:C{CCC};border-width:0.8; border-color:#ddd;font-color:#66686b;line-height:1.3; font-family:lato');

 $table->rowStyle('font-size:10; min-height:20; valign:M; border:T;');
 $table->easyCell('ONE LICENSE', 'border:LT');
 $table->easyCell('THREE LICENSE', 'bgcolor:#e95701; font-color:#fff;');
 $table->easyCell('FIVE LICENSE', 'border:RT');
 $table->printRow();

 $table->easyCell("1 Website\n 1 Year Updates\n 1 Year Email Support", 'border:L;'); 
 $table->easyCell("3 Website\n 1 Year Updates\n 1 Year Email Support", 'bgcolor:#e95701; font-color:#fff;'); 
 $table->easyCell("5 Website\n 1 Year Updates\n 1 Year Email Support", 'border:R'); 
 $table->printRow(); 

 $table->rowStyle('font-size:32;paddingY:3;');
 $table->easyCell("$149", 'border:LB'); 
 $table->easyCell("$249", 'bgcolor:#e95701; font-color:#fff; border:B; border-color:#ec7229'); 
 $table->easyCell("$349", 'border:RB'); 
 $table->printRow(); 

 $table->rowStyle('font-size:11;paddingY:3;');
 $table->easyCell("BUY NOW", 'border:LB'); 
 $table->easyCell("BUY NOW", 'bgcolor:#e95701; font-color:#fff;border:B'); 
 $table->easyCell("BUY NOW", 'border:RB'); 
 $table->printRow(); 
 
 $table->endTable(10);


//##############################################################  
//##############################################################  

 $pdf->addPage();

 $table=new easyTable($pdf, 7, 'width:60;align:C{CCCCCCC}; font-size:6;paddingY:2;');
 $table->rowStyle('min-height:18; border:1; border-color:#ff5050;');
 $table->easyCell('18', 'colspan:7;font-style:B; paddingX:3; font-size:40; align:L;valign:B; font-color:#fff;bgcolor:#ff5050;line-height:0.5;');
 $table->printRow();
 $table->rowStyle('min-height:12; border:1; border-color:#ff5050;');
 $table->easyCell('august', 'colspan:7;font-size:20;paddingX:3;font-color:#fff;align:L; valign:T;paddingY:0;bgcolor:#ff5050;');
 $table->printRow();

 $days=array('MON', 'TUE','WED','THU', 'FRI', 'SAT', 'SUN');
 $table->rowStyle('font-style:B; font-color:#ff5050;');
 foreach($days as $day)
 {
    $table->easyCell($day);
 }
 $table->printRow();
 $w=0;
 while($w<5)
 {
    for($i=0; $i<35; $i++)
    {
       $style='';
       if($i<3 || $i==34)
       {
          $style='font-color:#a1a1a1;';
       }
       $j=($i+28)%31+1;
       $table->easyCell($j, $style);
       if($i%7==6)
       {
          $table->printRow();
          $w++;
       }
    }
 }

 $table->endTable(30);

//##############################################################  
//##############################################################  


 $data=array('temperature.png'=>'Monthly average temperature',
 'temperaturexaltitude.png'=>'Atmosphere temperature by altitude', 
 'julytemperatures.png'=>'July temperatures',
 'monthtemperature.png'=>'Monthly average temperature', 
 'wind.png'=>'Wind speed during two days', 
 'snow.png'=>'Snow depth at Vikjafjellet Norway');
 $table=new easyTable($pdf, 2, 'width:160; valign:B; line-height:2; bgcolor:#eee;paddingX:4;paddingY:4; border-width:3;border:1;border-color:#fff;font-color:#3a3a4f;');

 $table->easyCell('Temperature, wind and snow', 'colspan:2; font-style:B; font-color:#a9a5bf; font-size:12; bgcolor:#3a3a4f; align:C;line-height:1.2');
 $table->printRow();

 $i=0;
 foreach($data as $key=>$value)
 {
    $table->easyCell($value, "img:Pics/$key"); 
    if($i%2==1)
    {
       $table->printRow();
    }
    $i++;
 }

 $table->endTable(10); 


//##############################################################  
//##############################################################  
  
  
 $pdf->Output();  

?>