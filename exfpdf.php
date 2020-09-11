<?php
 /*********************************************************************
 * exFPDF  extend FPDF v1.81                                                    *
 *                                                                    *
 * Version: 2.2                                                       *
 * Date:    12-10-2017                                                *
 * Author:  Dan Machado                                               *
 * Require  FPDF v1.81, formatedstring v1.0                                                *
 **********************************************************************/
 include 'formatedstring.php';
 class exFPDF extends FPDF{

    public function PageBreak(){
       return $this->PageBreakTrigger;
   }

   public function current_font($c){
      if($c=='family'){
         return $this->FontFamily;
      }
      elseif($c=='style'){
         return $this->FontStyle;
      }
      elseif($c=='size'){
         return $this->FontSizePt;
      }
   }

   public function get_color($c){
      if($c=='fill'){
         return $this->FillColor;
      }
      elseif($c=='text'){
         return $this->TextColor;
      }
   }

   public function get_page_width(){
      return $this->w;
   }

   public function get_margin($c){
      if($c=='l'){
         return $this->lMargin;
      }
      elseif($c=='r'){
         return $this->rMargin;
      }
      elseif($c=='t'){
         return $this->tMargin;
      }
   }

   public function get_linewidth(){
      return $this->LineWidth;
   }

   public function get_orientation(){
      return $this->CurOrientation;
   }
   static private $hex=array('0'=>0,'1'=>1,'2'=>2,'3'=>3,'4'=>4,'5'=>5,'6'=>6,'7'=>7,'8'=>8,'9'=>9,
   'A'=>10,'B'=>11,'C'=>12,'D'=>13,'E'=>14,'F'=>15);

   public function is_rgb($str){
      $a=true;
      $tmp=explode(',', trim($str, ','));
      foreach($tmp as $color){
         if(!is_numeric($color) || $color<0 || $color>255){
            $a=false;
            break;
         }
      }
      return $a;
   }

   public function is_hex($str){
      $a=true;
      $str=strtoupper($str);
      $n=strlen($str);
      if(($n==7 || $n==4) && $str[0]=='#'){
         for($i=1; $i<$n; $i++){
            if(!isset(self::$hex[$str[$i]])){
               $a=false;
               break;
            }
         }
      }
      else{
         $a=false;
      }
      return $a;
   }

   public function hextodec($str){
      $result=array();
      $str=strtoupper(substr($str,1));
      $n=strlen($str);
      for($i=0; $i<3; $i++){
         if($n==6){
            $result[$i]=self::$hex[$str[2*$i]]*16+self::$hex[$str[2*$i+1]];
         }
         else{
            $result[$i]=self::$hex[$str[$i]]*16+self::$hex[$str[$i]];
         }
      }
      return $result;
   }
   static private $options=array('F'=>'', 'T'=>'', 'D'=>'');

   public function resetColor($str, $p='F'){
      if(isset(self::$options[$p]) && self::$options[$p]!=$str){
         self::$options[$p]=$str;
         $array=array();
         if($this->is_hex($str)){
            $array=$this->hextodec($str);
         }
         elseif($this->is_rgb($str)){
            $array=explode(',', trim($str, ','));
            for($i=0; $i<3; $i++){
               if(!isset($array[$i])){
                  $array[$i]=0;
               }
            }
         }
         else{
            $array=array(null, null, null);
            $i=0;
            $tmp=explode(' ', $str);
            foreach($tmp as $c){
               if(is_numeric($c)){
                  $array[$i]=$c*256;
                  $i++;
               }
            }
         }
         if($p=='T'){
            $this->SetTextColor($array[0],$array[1],$array[2]);
         }
         elseif($p=='D'){
            $this->SetDrawColor($array[0],$array[1], $array[2]);
         }
         elseif($p=='F'){
            $this->SetFillColor($array[0],$array[1],$array[2]);
         }
      }
   }
   static private $font_def='';

   public function resetFont($font_family, $font_style, $font_size){
      if(self::$font_def!=$font_family .'-' . $font_style . '-' .$font_size){
         self::$font_def=$font_family .'-' . $font_style . '-' .$font_size;
         $this->SetFont($font_family, $font_style, $font_size);
      }
   }

   public function resetStaticData(){
      self::$font_def='';
      self::$options=array('F'=>'', 'T'=>'', 'D'=>'');
   }
   /***********************************************************************
   *
   * Based on FPDF method SetFont
   *
   ************************************************************************/

   private function &FontData($family, $style, $size){
      if($family=='')
      $family = $this->FontFamily;
      else
      $family = strtolower($family);
      $style = strtoupper($style);
      if(strpos($style,'U')!==false){
         $this->underline = true;
         $style = str_replace('U','',$style);
      }
      if($style=='IB')
      $style = 'BI';
      $fontkey = $family.$style;
      if(!isset($this->fonts[$fontkey])){
         if($family=='arial')
         $family = 'helvetica';
         if(in_array($family,$this->CoreFonts)){
            if($family=='symbol' || $family=='zapfdingbats')
            $style = '';
            $fontkey = $family.$style;
            if(!isset($this->fonts[$fontkey]))
            $this->AddFont($family,$style);
         }
         else
         $this->Error('Undefined font: '.$family.' '.$style);
      }
      $result['FontSize'] = $size/$this->k;
      $result['CurrentFont']=&$this->fonts[$fontkey];
      return $result;
   }
    

   private function setLines(&$fstring, $p, $q){
      $parced_str=& $fstring->parced_str;
      $lines=& $fstring->lines;
      $linesmap=& $fstring->linesmap;
      $cfty=$fstring->get_current_style($p);
      $ffs=$cfty['font-family'] . $cfty['style'];
      if(!isset($fstring->used_fonts[$ffs])){
         $fstring->used_fonts[$ffs]=& $this->FontData($cfty['font-family'], $cfty['style'], $cfty['font-size']);
      }
      $cw=& $fstring->used_fonts[$ffs]['CurrentFont']['cw'];
      $wmax = $fstring->width*1000*$this->k;
      $j=count($lines)-1;
      $k=strlen($lines[$j]);
         if(!isset($linesmap[$j][0])) {
         $linesmap[$j]=array($p,$p, 0);
      }
      $sl=$cw[' ']*$cfty['font-size'];
      $x=$a=$linesmap[$j][2];
      if($k>0){
         $x+=$sl;
         $lines[$j].=' ';
         $linesmap[$j][2]+=$sl;
      }
      $u=$p;
      $t='';
      $l=$p+$q;
      $ftmp='';
      for($i=$p; $i<$l; $i++){
            if($ftmp!=$ffs){
            $cfty=$fstring->get_current_style($i);
            $ffs=$cfty['font-family'] . $cfty['style'];
            if(!isset($fstring->used_fonts[$ffs])){
               $fstring->used_fonts[$ffs]=& $this->FontData($cfty['font-family'], $cfty['style'], $cfty['font-size']);
            }
            $cw=& $fstring->used_fonts[$ffs]['CurrentFont']['cw'];
            $ftmp=$ffs;
         }
         $x+=$cw[$parced_str[$i]]*$cfty['font-size'];
         if($x>$wmax){
            if($a>0){
               $t=substr($parced_str,$p, $i-$p);
               $lines[$j]=substr($lines[$j],0,$k);
               $linesmap[$j][1]=$p-1;
               $linesmap[$j][2]=$a;
               $x-=($a+$sl);
               $a=0;
               $u=$p;
            }
            else{
               $x=$cw[$parced_str[$i]]*$cfty['font-size'];
               $t='';
               $u=$i;
            }
            $j++;
            $lines[$j]=$t;
            $linesmap[$j]=array();
            $linesmap[$j][0]=$u;
            $linesmap[$j][2]=0;
         }
         $lines[$j].=$parced_str[$i];
         $linesmap[$j][1]=$i;
         $linesmap[$j][2]=$x;
      }
      return;
   }

   public function &extMultiCell($font_family, $font_style, $font_size, $font_color, $w, $txt){
      $result=array();
      if($w==0){
         return $result;
      }
      $this->current_font=array('font-family'=>$font_family, 'style'=>$font_style, 'font-size'=>$font_size, 'font-color'=>$font_color);
      $fstring=new formatedString($txt, $w, $this->current_font);
      $word='';
      $p=0;
      $i=0;
      $n=strlen($fstring->parced_str);
      while($i<$n){
         $word.=$fstring->parced_str[$i];
         if($fstring->parced_str[$i]=="\n" || $fstring->parced_str[$i]==' ' || $i==$n-1){
            $word=trim($word);
            $this->setLines($fstring, $p, strlen($word));
            $p=$i+1;
            $word='';
            if($fstring->parced_str[$i]=="\n" && $i<$n-1){
               $z=0;
               $j=count($fstring->lines);
               $fstring->lines[$j]='';
               $fstring->linesmap[$j]=array();
            }
         }
         $i++;
      }
      if($n==0){
         return $result;
      }
      $n=count($fstring->lines);
         for($i=0; $i<$n; $i++){
         $result[$i]=$fstring->break_by_style($i);
      }
      return $result;
   }

   private function GetMixStringWidth($line){
      $w = 0;
      foreach($line['chunks'] as $i=>$chunk){
         $t=0;
         $cf=& $this->FontData($line['style'][$i]['font-family'], $line['style'][$i]['style'], $line['style'][$i]['font-size']);
         $cw=& $cf['CurrentFont']['cw'];
         $s=implode('', explode(' ',$chunk));
         $l = strlen($s);
         for($j=0;$j<$l;$j++){
            $t+=$cw[$s[$j]];
         }
         $w+=$t*$line['style'][$i]['font-size'];
      }
      return $w;
   }

   public function CellBlock($w, $lh, &$lines, $align='J'){
      if($w==0){
         return;
      }
      $ctmp='';
      $ftmp='';
      foreach($lines as $i=>$line){
         $k = $this->k;
         if($this->y+$lh*$line['height']>$this->PageBreakTrigger){
            break;
         }
         $dx=0;
         $dw=0;
         if($line['width']!=0){
            if($align=='R'){
               $dx = $w-$line['width']/($this->k*1000);
            }
            elseif($align=='C'){
               $dx = ($w-$line['width']/($this->k*1000))/2;
            }
            if($align=='J'){
               $tmp=explode(' ', implode('',$line['chunks']));
               $ns=count($tmp);
               if($ns>1){
                  $sx=implode('',$tmp);
                  $delta=$this->GetMixStringWidth($line)/($this->k*1000);
                  $dw=($w-$delta)*(1/($ns-1));
               }
            }
         }
         $xx=$this->x+$dx;
         foreach($line['chunks'] as $tj=>$txt){
            $this->resetFont($line['style'][$tj]['font-family'], $line['style'][$tj]['style'], $line['style'][$tj]['font-size']);
            $this->resetColor($line['style'][$tj]['font-color'], 'T');
            $y=$this->y+0.5*$lh*$line['height'] +0.3*$line['height']/$this->k;
            if($dw){
               $tmp=explode(' ', $txt);
               foreach($tmp as $e=>$tt){
                  if($e>0){
                     $xx+=$dw;
                     if($tt==''){
                        continue;
                     }
                  }
                  $this->Text($xx, $y, $tt);
                     if($line['style'][$tj]['href']){
                     $yr=$this->y+0.5*($lh*$line['height']-$line['height']/$this->k);
                     $this->Link($xx, $yr, $this->GetStringWidth($txt),$line['height']/$this->k, $line['style'][$tj]['href']);
                  }
                  $xx+=$this->GetStringWidth($tt);
               }
            }
            else{
               $this->Text($xx, $y, $txt);
                  if($line['style'][$tj]['href']){
                  $yr=$this->y+0.5*($lh*$line['height']-$line['height']/$this->k);
                  $this->Link($xx, $yr, $this->GetStringWidth($txt),$line['height']/$this->k, $line['style'][$tj]['href']);
               }
               $xx+=$this->GetStringWidth($txt);
            }
         }
         unset($lines[$i]);
         $this->y += $lh*$line['height'];
      }
   }
   
}
?>
