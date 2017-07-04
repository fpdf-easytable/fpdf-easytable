 <?php
 /*********************************************************************
 * exFPDF  extend FPDF v1.81                                                    *
 *                                                                    *
 * Version: 1.01                                                       *
 * Date:    17-03-2017                                                *
 * Author:  Dan Machado                                               *
 * Require  FPDF v1.81                                                *
 **********************************************************************/
// include 'fpdf.php';
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
   
   /***********************************************************************
   *
   * Based on FPDF method MultiCell
   *
   ************************************************************************/
   

   public function extMultiCell($font_family, $font_style, $font_size, $w, $txt){
      $result=array();
      $font=$this->FontData($font_family, $font_style, $font_size);
      $cw = $font['CurrentFont']['cw'];
      if($w==0){
         return $result;
      }
      $wmax = ($w-2*$this->cMargin)*1000/($font['FontSize']);
      
      $s = trim(str_replace("\r",'',$txt));
      $chs = strlen($s);
      $sep = -1;
      $i = 0;
      $j = 0;
      $l = 0;
      while($i<$chs){
         $c = $s[$i];
         if($c=="\n"){
            $result[]=substr($s,$j,$i-$j);
            $i++;
            $sep = -1;
            $j = $i;
            $l = 0;
            continue;
         }
         if($c==' '){
            if($l==0){
               while($s[$i]==' '){
                  $i++;
               }
               $j=$i;
            }
            $sep = $i;
         }
         $l += $cw[$c];
         if($l>$wmax){
            if($sep==-1){
               if($i==$j)
               $i++;
               $result[]=substr($s,$j,$i-$j);
            }
            else{
               $result[]=substr($s,$j,$sep-$j);
               $i = $sep+1;
            }
            $sep = -1;
            $j = $i;
            $l = 0;
         }
         else{
            $i++;
         }
      }
      $s=trim(substr($s,$j,$i-$j));
      if($s!=''){
         $result[]=$s;
      }
      return $result;
   }
   /***********************************************************************
   *
   * Based on FPDF method Cell
   *
   ************************************************************************/
   

   public function CellBlock($w, $h, &$array_txt, $align='J',$link=''){
      if(!isset($this->CurrentFont))
      $this->Error('No font has been set');
      foreach($array_txt as $ti=>$txt){
         $k = $this->k;
         if($this->y+$h>$this->PageBreakTrigger){
            break;
         }
         if($w==0){
            return;
         }
         $s = '';
         if($txt!==''){
            $stringWidth=$this->GetStringWidth($txt);
            if($align=='R'){
               $dx = $w-$this->cMargin-$stringWidth;
            }
            elseif($align=='C'){
               $dx = ($w-$stringWidth)/2;
            }
            else{
               $dx = $this->cMargin;
            }
            if($align=='J'){
               $ns=count(explode(' ', $txt));
               $wx = $w-2*$this->cMargin;
               $this->ws = ($ns>1) ? (($wx-$stringWidth)*(1/($ns-1))) : 0;
               $this->_out(sprintf('%.3F Tw',$this->ws*$this->k));
            }
            if($this->ColorFlag)
            $s .= 'q '.$this->TextColor.' ';
            $s .= sprintf('BT %.2F %.2F Td (%s) Tj ET',($this->x+$dx)*$k,($this->h-($this->y+.5*$h+.3*$this->FontSize))*$k,$this->_escape($txt));
            if($this->underline)
            $s .= ' '.$this->_dounderline($this->x+$dx,$this->y+.5*$h+.3*$this->FontSize,$txt);
            if($this->ColorFlag)
            $s .= ' Q';
            if($link)
            $this->Link($this->x+$dx,$this->y+.5*$h-.5*$this->FontSize,$stringWidth,$this->FontSize,$link);
            unset($array_txt[$ti]);
         }
         if($s)
         $this->_out($s);
         $this->lasth = $h;
         $this->y += $h;
      }
      if($this->ws>0){
         $this->ws = 0;
         $this->_out('0 Tw');
      }
   }
}
?>
