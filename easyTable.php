<?php
 /*********************************************************************
 * FPDF easyTable                                                     *
 *                                                                    *
 * Version: 2.0                                                       *
 * Date:    12-10-2017                                                *
 * Author:  Dan Machado                                               *
 * Require  exFPDF v2.0                                              *
 **********************************************************************/
  
class easyTable{
   const LP=0.4;
   const XPadding=1;
   const YPadding=1;
   const IMGPadding=0.5;
   const PBThreshold=30;
   static private $table_counter=false;
   static private $style=array('width'=>false, 'border'=>false, 'border-color'=>false,
   'border-width'=>false, 'line-height'=>false,
   'align'=>'', 'valign'=>'', 'bgcolor'=>false, 'split-row'=>false, 'l-margin'=>false,
   'font-family'=>false, 'font-style'=>false,'font-size'=>false, 'font-color'=>false,
   'paddingX'=>false, 'paddingY'=>false);
   private $pdf_obj;
   private $document_style;
   private $table_style;
   private $col_num;
   private $col_width;
   private $baseX;
   private $row_style_def;
   private $row_style;
   private $row_heights;
   private $row_data;
   private $rows;
   private $total_rowspan;
   private $col_counter;
   private $grid;
   private $blocks;
   private $overflow;
   private $header_row;
   private $new_table;

   private function get_available($colspan, $rowspan){
      static $k=0;
      if(count($this->grid)==0){
         $k=0;
      }
      while(isset($this->grid[$k])){
         $k++;
      }
      for($i=0; $i<=$colspan; $i++){
         for($j=0; $j<=$rowspan; $j++){
            $this->grid[$k+$i+$j*$this->col_num]=true;
         }
      }
      return $k;
   }

   private function get_style($str, $c){
      $result=self::$style;
      if($c=='C'){
         $result['colspan']=0;
         $result['rowspan']=0;
         $result['img']=false;
      }
      if($c=='C' || $c=='R'){
         unset($result['width']);
         unset($result['border-width']);
         unset($result['split-row']);
         unset($result['l-margin']);
      }
      if($c=='R' || $c=='T'){
         if($c=='R'){
            $result['c-align']=array_pad(array(), $this->col_num, 'L');
         }
         else{
            $result['c-align']=array();
         }
      }
      if($c=='R'){
         $result['min-height']=false;
      }
      $tmp=explode(';', $str);
      foreach($tmp as $x){
         if($x && strpos($x,':')>0){
            $r=explode(':',$x);
            $r[0]=trim($r[0]);
            $r[1]=trim($r[1]);
            if(isset($result[$r[0]])){
               $result[$r[0]]=$r[1];
            }
         }
      }
      return $result;
   }

   private function inherating(&$sty, $setting, $c){
      if($c=='C'){
         $sty[$setting]=$this->row_style[$setting];
      }
      elseif($c=='R'){
         $sty[$setting]=$this->table_style[$setting];
      }
      else{
         $sty[$setting]=$this->document_style[$setting];
      }
   }
   

   private function set_style($str, $c, $pos=''){
      $sty=$this->get_style($str, $c);
      if($c=='T'){
         if(is_numeric($sty['width'])){
            $sty['width']=min(abs($sty['width']),$this->document_style['document_width']);
            if($sty['width']==0){
               $sty['width']=$this->document_style['document_width'];
            }
         }
         else{
            $x=strpos($sty['width'], '%');
            if($x!=false){
               $x=min(abs(substr($sty['width'], 0, $x)), 100);
               if($x){
                  $sty['width']=$x*$this->document_style['document_width']/100.0;
               }
               else{
                  $sty['width']=$this->document_style['document_width'];
               }
            }
            else{
               $sty['width']=$this->document_style['document_width'];
            }
         }
         if(!is_numeric($sty['l-margin'])){
            $sty['l-margin']=0;
         }
         else{
            $sty['l-margin']=abs($sty['l-margin']);
         }
         if(is_numeric($sty['border-width'])){
            $sty['border-width']=abs($sty['border-width']);
         }
         else{
            $sty['border-width']=false;
         }
         if($sty['split-row']=='false'){
            $sty['split-row']=false;
         }
         elseif($sty['split-row']!==false){
            $sty['split-row']=true;
         }
      }
      if($c=='R'){
         if(!is_numeric($sty['min-height']) || $sty['min-height']<0){
            $sty['min-height']=0;
         }
      }
      if(!is_numeric($sty['paddingX'])){
         if($c=='C' || $c=='R'){
            $this->inherating($sty, 'paddingX', $c);
         }
         else{
            $sty['paddingX']=self::XPadding;
         }
      }
      $sty['paddingX']=abs($sty['paddingX']);
      if(!is_numeric($sty['paddingY'])){
         if($c=='C' || $c=='R'){
            $this->inherating($sty, 'paddingY', $c);
         }
         else{
            $sty['paddingY']=self::YPadding;
         }
      }
      $sty['paddingY']=abs($sty['paddingY']);
      if($sty['border']===false && ($c=='C' || $c=='R')){
         $this->inherating($sty, 'border', $c);
      }
      else{
         $border=array('T'=>1, 'R'=>1, 'B'=>1, 'L'=>1);
         if(!(is_numeric($sty['border']) && $sty['border']==1)){
            foreach($border as $k=>$v){
               $border[$k]=0;
               if(strpos($sty['border'], $k)!==false){
                  $border[$k]=1;
               }
            }
         }
         $sty['border']=$border;
      }
      $color_settings=array('bgcolor', 'font-color', 'border-color');
      foreach($color_settings as $setting){
         if($sty[$setting]===false || !($this->pdf_obj->is_hex($sty[$setting]) || $this->pdf_obj->is_rgb($sty[$setting]))){
            if($c=='C' || $c=='R'){
               $this->inherating($sty, $setting, $c);
            }
            elseif($setting=='font-color'){
               $sty[$setting]=$this->document_style[$setting];
            }
         }
         else{
            $sty[$setting]=$sty[$setting];
         }
      }
      $font_settings=array('font-family', 'font-style', 'font-size');
      foreach($font_settings as $setting){
         if($sty[$setting]===false){
            $this->inherating($sty, $setting, $c);
         }
      }
      if(is_numeric($sty['line-height'])){
         $sty['line-height']=self::LP*abs($sty['line-height']);
      }
      else{
         if($c=='C' || $c=='R'){
            $this->inherating($sty,'line-height', $c);
         }
         else{
            $sty['line-height']=self::LP;
         }
      }
      if($c=='C'){
         if($sty['img']){
            $tmp=explode(',', $sty['img']);
            if(file_exists($tmp[0])){
               $sty['img']=array('path'=>'', 'h'=>0, 'w'=>0);
               $img=@ getimagesize($tmp[0]);
               $sty['img']['path']=$tmp[0];
               for($i=1; $i<3; $i++){
                  if(isset($tmp[$i])){
                     $tmp[$i]=trim(strtolower($tmp[$i]));
                     if($tmp[$i][0]=='w' || $tmp[$i][0]=='h'){
                        $t=substr($tmp[$i],1);
                        if(is_numeric($t)){
                           $sty['img'][$tmp[$i][0]]=abs($t);
                        }
                     }
                  }
               }
               $ration=$img[0]/$img[1];
               if($sty['img']['w']+$sty['img']['h']==0){
                  $sty['img']['w']=$img[0];
                  $sty['img']['h']=$img[1];
               }
               elseif($sty['img']['w']==0){
                  $sty['img']['w']=$sty['img']['h']*$ration;
               }
               elseif($sty['img']['h']==0){
                  $sty['img']['h']=$sty['img']['w']/$ration;
               }
            }
            else{
               $sty['img']='failed to open stream: file ' . $tmp[0] .' does not exist';
            }
         }
         if(is_numeric($sty['colspan']) && $sty['colspan']>0){
            $sty['colspan']--;
         }
         else{
            $sty['colspan']=0;
         }
         if(is_numeric($sty['rowspan']) && $sty['rowspan']>0){
            $sty['rowspan']--;
         }
         else{
            $sty['rowspan']=0;
         }
         if($sty['valign']==false && ($sty['rowspan']>0 || $sty['img']!==false)){
            $sty['valign']='M';
         }
         if($sty['align']==false && $sty['img']!==false){
            $sty['align']='C';
         }
      }
      if($c=='T' || $c=='R'){
         $tmp=explode('{',$sty['align']);
         if($c=='T'){
            $sty['align']=trim($tmp[0]);
         }
         if(isset($tmp[1])){
            $tmp[1]=trim($tmp[1], '}');
            if(strlen($tmp[1])){
               for($i=0; $i<strlen($tmp[1]); $i++){
                  if(preg_match("/[LCRJ]/", $tmp[1][$i])!=0){
                     $sty['c-align'][$i]=$tmp[1][$i];
                  }
                  else{
                     $sty['c-align'][$i]='L';
                  }
               }
            }
            if($c=='R'){
               $sty['align']='L';
               $sty['c-align']=array_slice($sty['c-align'],0,$this->col_num);
            }
         }
      }
      if($sty['align']!='L' && $sty['align']!='C' && $sty['align']!='R' && $sty['align']!='J'){
         if($c=='C'){
            $sty['align']=$this->row_style['c-align'][$pos];
         }
         elseif($c=='R'){
            $sty['align']='L';
            $sty['c-align']=$this->table_style['c-align'];
         }
         else{
            $sty['align']='C';
         }
      }
      elseif($c=='T' && $sty['align']=='J'){
         $sty['align']='C';
      }
      if($sty['valign']!='T' && $sty['valign']!='M' && $sty['valign']!='B'){
         if($c=='C' || $c=='R'){
            $this->inherating($sty, 'valign', $c);
         }
         else{
            $sty['valign']='T';
         }
      }
      return $sty;
   }

   private function row_content_loop($counter, $f){
      $t=0;
      if($counter>0){
         $t=$this->rows[$counter-1];
      }
      for($index=$t; $index<$this->rows[$counter]; $index++){
         $f($index);
      }
   }

   private function mk_border($i, $y, $split){
      $w=$this->row_data[$i][2];
      $h=$this->row_data[$i][5];
      if($split){
         $h=$this->pdf_obj->PageBreak()-$y;
      }
      if($this->row_data[$i][1]['border-color']!=false){
         $this->pdf_obj->resetColor($this->row_data[$i][1]['border-color'], 'D');
      }
      $a=array(1, 1, 1, 0);
      $borders=array('L'=>3, 'T'=>0, 'R'=>1, 'B'=>2);
      foreach($borders as $border=>$j){
         if($this->row_data[$i][1]['border'][$border]){
            if($border=='B'){
               if($split==0){
                  $this->pdf_obj->Line($this->row_data[$i][6]+(1+$a[($j+2)%4])%2*$w, $y+(1+$a[($j+1)%4])%2 * $h, $this->row_data[$i][6]+$a[$j%4]*$w, $y+($a[($j+3)%4])%2 *$h);
               }
            }
            else{
               $this->pdf_obj->Line($this->row_data[$i][6]+(1+$a[($j+2)%4])%2*$w, $y+(1+$a[($j+1)%4])%2 * $h, $this->row_data[$i][6]+$a[$j%4]*$w, $y+($a[($j+3)%4])%2 *$h);
            }
         }
      }
      
      if($this->row_data[$i][1]['border-color']!=false){
         $this->pdf_obj->resetColor($this->document_style['bgcolor'], 'D');
      }
      if($split){
         $this->pdf_obj->row_data[$i][1]['border']['T']=0;
      }
   }

   private function print_text($i, $y, $split){
      $padding=$this->row_data[$i][1]['padding-y'];
      $k=$padding;
      if($this->row_data[$i][1]['img']!==false){
         if($this->row_data[$i][1]['valign']=='B'){
            $k+=$this->row_data[$i][1]['img']['h']+self::IMGPadding;
         }
      }
      $l=0;
      if(count($this->row_data[$i][0])){
         $x=$this->row_data[$i][6]+$this->row_data[$i][1]['paddingX'];
         $xpadding=2*$this->row_data[$i][1]['paddingX'];
         $l=count($this->row_data[$i][0])* $this->row_data[$i][1]['line-height']*$this->row_data[$i][1]['font-size'];
         $this->pdf_obj->SetXY($x, $y+$k);
         $this->pdf_obj->CellBlock($this->row_data[$i][2]-$xpadding, $this->row_data[$i][1]['line-height'], $this->row_data[$i][0], $this->row_data[$i][1]['align']);
         $this->pdf_obj->resetFont($this->document_style['font-family'], $this->document_style['font-style'], $this->document_style['font-size']);
         $this->pdf_obj->resetColor($this->document_style['font-color'], 'T');
      }
      if($this->row_data[$i][1]['img']!==false ){
         $x=$this->row_data[$i][6];
         $k=$padding;
         if($this->row_data[$i][1]['valign']!='B'){
            $k+=$l+self::IMGPadding;
         }
         if($this->imgbreak($i, $y)==0 && $y+$k+$this->row_data[$i][1]['img']['h']<$this->pdf_obj->PageBreak()){
            $x+=$this->row_data[$i][1]['paddingX'];
            if($this->row_data[$i][2]>$this->row_data[$i][1]['img']['w']){
               if($this->row_data[$i][1]['align']=='C'){
                  $x-=$this->row_data[$i][1]['paddingX'];
                  $x+=($this->row_data[$i][2]-$this->row_data[$i][1]['img']['w'])/2;
               }
               elseif($this->row_data[$i][1]['align']=='R'){
                  $x+=$this->row_data[$i][2]-$this->row_data[$i][1]['img']['w'];
                  $x-=2*$this->row_data[$i][1]['paddingX'];
               }
            }
            $this->pdf_obj->Image($this->row_data[$i][1]['img']['path'], $x, $y+$k, $this->row_data[$i][1]['img']['w'], $this->row_data[$i][1]['img']['h']);
         }
      }
   }
   

   private function mk_bg($i, $T, $split){
      $h=$this->row_data[$i][5];
      if($split){
         $h=$this->pdf_obj->PageBreak()-$T;
      }
      if($this->row_data[$i][1]['bgcolor']!=false){
         $this->pdf_obj->resetColor($this->row_data[$i][1]['bgcolor']);
         $this->pdf_obj->Rect($this->row_data[$i][6], $T, $this->row_data[$i][2], $h, 'F');
         $this->pdf_obj->resetColor($this->document_style['bgcolor']);
      }
   }

   private function printing_loop($swap=false){
      $this->swap_data($swap);
      $y=$this->pdf_obj->GetY();
      $tmp=array();
      $rw=array();
      $ztmp=array();
      $total_cells=count($this->row_data);
      while(count($tmp)!=$total_cells){
         $a=count($this->rows);
         $h=0;
         $y=$this->pdf_obj->GetY();
         for($j=0; $j<count($this->rows); $j++){
            $T=$y+$h;
            if($T<$this->pdf_obj->PageBreak()){

                  $this->row_content_loop($j, function($index)use($T, $tmp){
                  if(!isset($tmp[$index])){
                     $split_cell=$this->scan_for_breaks($index,$T, false);
                     $this->mk_bg($index, $T, $split_cell);
                  }
               });
               if(!isset($rw[$j])){
                  if($this->pdf_obj->PageBreak()-($T+$this->row_heights[$j])>=0){
                     $h+=$this->row_heights[$j];
                  }
                  else{
                     $a=$j+1;
                     break;
                  }
               }
            }
            else{
               $a=$j+1;
               break;
            }
         }
         $h=0;
         for($j=0; $j<$a; $j++){
            $T=$y+$h;
            if($T<$this->pdf_obj->PageBreak()){

                  $this->row_content_loop($j, function($index)use($T, &$tmp, &$ztmp){
                  if(!isset($tmp[$index])){
                     $split_cell=$this->scan_for_breaks($index,$T);
                     $this->mk_border($index, $T, $split_cell);
                     $this->print_text($index, $T, $split_cell);
                     if($split_cell==0){
                        $tmp[$index]=$index;
                     }
                     else{
                        $ztmp[]=$index;
                     }
                  }
               });
               if(!isset($rw[$j])){
                  $tw=$this->pdf_obj->PageBreak()-($T+$this->row_heights[$j]);
                  if($tw>=0){
                     $h+=$this->row_heights[$j];
                     $rw[$j]=$j;
                  }
                  else{
                     $this->row_heights[$j]=$this->overflow-$tw;
                  }
               }
            }
         }
         if(count($tmp)!=$total_cells){
            foreach($ztmp as $index){
               $this->row_data[$index][5]=$this->row_data[$index][7]+$this->overflow;
               if(isset($this->row_data[$index][8])){
                  $this->row_data[$index][1]['padding-y']=$this->row_data[$index][8];
                  unset($this->row_data[$index][8]);
               }
            }
            $this->overflow=0;
            $ztmp=array();
            $this->pdf_obj->addPage($this->document_style['orientation']);
         }
         else{
            $y+=$h;
         }
      }
      $this->pdf_obj->SetXY($this->baseX, $y);
      $this->swap_data($swap);
   }

   private function imgbreak($i, $y){
      $li=$y+$this->row_data[$i][1]['padding-y'];
      $ls=$this->row_data[$i][1]['img']['h'];
      if($this->row_data[$i][1]['valign']=='B'){
         $ls+=$li;
      }
      else{
         $li+=$this->row_data[$i][3]-$this->row_data[$i][1]['img']['h'];
         $ls+=$li;
      }
      $result=0;
      if($li<$this->pdf_obj->PageBreak() && $this->pdf_obj->PageBreak()<$ls){
         $result=$this->pdf_obj->PageBreak()-$li;
      }
      return $result;
   }

   private function scan_for_breaks($index, $H, $l=true){
      $print_cell=0;
      $h=($H+$this->row_data[$index][5])-$this->pdf_obj->PageBreak();
      if($h>0){
         if($l){
            $rr=$this->pdf_obj->PageBreak()-($H+$this->row_data[$index][1]['padding-y']);
            if($rr>0){
               $mx=0;
               if(count($this->row_data[$index][0]) && $this->row_data[$index][1]['img']!==false){
                  $mx=$this->imgbreak($index, $H);
                  if($mx==0){
                     if($this->row_data[$index][1]['valign']=='B'){
                        $rr-=$this->row_data[$index][1]['img']['h'];
                     }
                  }
               }
               $nh=0;
               $keys=array_keys($this->row_data[$index][0]);
               foreach($keys as $i){
                  $nh+=$this->row_data[$index][0][$i]['height'];
               }
               $nh*=$this->row_data[$index][1]['line-height'];
               if($mx==0 && $rr<$nh){
                  $nw=0;
                  foreach($keys as $i){
                     $nw+=$this->row_data[$index][0][$i]['height']*$this->row_data[$index][1]['line-height'];
                     if($nw>$rr){
                        $nw-=$this->row_data[$index][0][$i]['height']*$this->row_data[$index][1]['line-height'];
                        $mx=$rr-$nw;
                        break;
                     }
                  }
               }
               $this->overflow=max($this->overflow, $mx);
               $this->row_data[$index][8]=1;
            }
            else{
               $this->row_data[$index][8]=-1*$rr;
            }
            $this->row_data[$index][7]=$h;
         }
         $print_cell=1;
      }
      return $print_cell;
   }

   private function swap_data($swap){
      if($swap==false){
         return;
      }
      static $data=array();
      if(count($data)==0){
         $data=array('header_data'=>$this->header_row['row_data'], 'row_heights'=>&$this->row_heights, 'row_data'=>&$this->row_data, 'rows'=>&$this->rows);
         unset($this->row_heights, $this->row_data, $this->rows);
         $this->row_heights=&$this->header_row['row_heights'];
         $this->row_data=&$this->header_row['row_data'];
         $this->rows=&$this->header_row['rows'];
      }
      else{
         $this->header_row['row_data']=$data['header_data'];
         unset($this->row_heights, $this->row_data, $this->rows);
         $this->row_heights=$data['row_heights'];
         $this->row_data=$data['row_data'];
         $this->rows=$data['rows'];
         $data=array();
      }
   }
   /********************************************************************

   function __construct( FPDF-object $fpdf_obj, Mix $num_cols[, string $style = '' ])
   -----------------------------------------------------
   Description:
   Constructs an easyTable object
   Parameters:
   fpdf_obj
   the current FPDF object (constructed with the FPDF library)
   that is being used to write the current PDF document
   num_cols
   this parameter can be a positive integer (the number of columns)
   or a string of the following form
   I) a positive integer, the number of columns for the table. The width
   of every column will be equal to the width of the table (given by the width property)
   divided by the number of columns ($num_cols)
   II) a string of the form '{c1, c2, c3,... cN}'. In this case every
   element in the curly brackets is a positive numeric value that represent
   the width of a column. Thus, the n-th numeric value is the width
   of the n-th colum. If the sum of all the width of the columns is bigger than
   the width of the table but less than the width of the document, the table
   will stretch to the sum of the columns width. However, if the sum of the
   columns is bigger than the width of the document, the width of every column
   will be reduce proportionally to make the total sum equal to the width of the document.
   III) a string of the form '%{c1, c2, c3,... cN}'. Similar to the previous case, but
   this time every element represents a percentage of the width of the table.
   In this case it the sum of this percentages is bigger than 100, the execution will
   be terminated.
   style
   the global style for the table (see documentation)
   a semicolon-separated string of attribute values that defines the
   default layout of the table and all the cells and their contents
   (see Documentation section in README.md)
   Examples:
   $table= new easyTable($fpdf, 3);
   $table= new easyTable($fpdf, '{35, 45, 55}', 'width:135;');
   $table= new easyTable($fpdf, '%{35, 45, 55}', 'width:190;');
   Return value:
   An easyTable object
   ***********************************************************************/

   public function __construct($fpdf_obj, $num_cols, $style=''){
      if(self::$table_counter){
         error_log('Please use the end_table method to terminate the last table');
         exit();
      }
      self::$table_counter=true;
      $this->pdf_obj=&$fpdf_obj;
      $this->document_style['bgcolor']=$this->pdf_obj->get_color('fill');
      $this->document_style['font-family']=$this->pdf_obj->current_font('family');
      $this->document_style['font-style']=$this->pdf_obj->current_font('style');
      $this->document_style['font-size']=$this->pdf_obj->current_font('size');
      $this->document_style['font-color']=$this->pdf_obj->get_color('text');
      $this->document_style['document_width']=$this->pdf_obj->GetPageWidth()-$this->pdf_obj->get_margin('l')-$this->pdf_obj->get_margin('r');
      $this->document_style['orientation']=$this->pdf_obj->get_orientation();
      $this->document_style['line-width']=$this->pdf_obj->get_linewidth();
      $this->table_style=$this->set_style($style, 'T');
      $this->col_num=false;
      $this->col_width=array();
      if(is_int($num_cols) && $num_cols!=0){
         $this->col_num=abs($num_cols);
         $this->col_width=array_pad(array(), abs($num_cols), $this->table_style['width']/abs($num_cols));
      }
      elseif(is_string($num_cols)){
         $num_cols=trim($num_cols, '}, ');
         if($num_cols[0]!='{' && $num_cols[0]!='%'){
            error_log('Bad format for columns in Table constructor');
            exit();
         }
         $tmp=explode('{', $num_cols);
         $tp=trim($tmp[0]);
         $num_cols=explode(',', $tmp[1]);
         $w=0;
         foreach($num_cols as $c){
            if(!is_numeric($c)){
               error_log('Bad parameter format for columns in Table constructor');
               exit();
            }
            if(abs($c)){
               $w+=abs($c);
               $this->col_width[]=abs($c);
            }
            else{
               error_log('Column width can not be zero');
            }
         }
         $this->col_num=count($this->col_width);
         if($tp=='%'){
            if($w!=100){
               error_log('The sum of the percentages of the columns is not 100');
               exit();
            }
            foreach($this->col_width as $i=>$c){
               $this->col_width[$i]=$c*$this->table_style['width']/100;
            }
         }
         elseif($w!=$this->table_style['width'] && $w){
            if($w<$this->document_style['document_width']){
               $this->table_style['width']=$w;
            }
            else{
               $this->table_style['width']=$this->document_style['document_width'];
               $d=$this->table_style['width']/$w;
               for($i=0; $i<count($num_cols); $i++){
                  $this->col_width[$i]*=$d;
               }
            }
         }
      }
      if($this->col_num==false){
         error_log('Unspecified number of columns in Table constructor');
         exit();
      }
      $this->table_style['c-align']=array_pad($this->table_style['c-align'], $this->col_num, 'L');
      if($this->table_style['l-margin']){
         $this->baseX=$this->pdf_obj->get_margin('l')+min($this->table_style['l-margin'],$this->document_style['document_width']-$this->table_style['width']);
      }
      else{
         if($this->table_style['align']=='L'){
            $this->baseX=$this->pdf_obj->get_margin('l');
         }
         elseif($this->table_style['align']=='R'){
            $this->baseX=$this->pdf_obj->get_margin('l')+$this->document_style['document_width']-$this->table_style['width'];
         }
         else{
            $this->baseX=$this->pdf_obj->get_margin('l')+($this->document_style['document_width']-$this->table_style['width'])/2;
         }
      }
      $this->row_style_def=$this->set_style('', 'R');
      $this->row_style=$this->row_style_def;
      $this->row_heights=array();
      $this->row_data=array();
      $this->rows=array();
      $this->total_rowspan=0;
      $this->col_counter=0;
      $this->grid=array();
      $this->blocks=array();
      $this->overflow=0;
      if($this->table_style['border-width']!=false){
         $this->pdf_obj->SetLineWidth($this->table_style['border-width']);
      }
      $this->header_row=array();
      $this->new_table=true;
   }
   /***********************************************************************

   function rowStyle( string $style )
   -------------------------------------------------------------
   Description:
   Set or overwrite the style for all the cells in the current row.
   Parameters:
   style
   a semicolon-separated string of attribute values that defines the
   layout of all the cells and its content in the current row
   (see Documentation section in README.md)
   Return values
   Void
   Notes:

   This function should be called before the first cell of the current row
   ***********************************************************************/

   public function rowStyle($style){
      $this->row_style=$this->set_style($style, 'R');
   }
   /***********************************************************************

   function easyCell( string $data [, string $style = '' ])
   ------------------------------------------------------------------------
   Description:
   Makes a cell in the table
   Parameters:
   data
   the content of the respective cell
   style (optional)
   a semicolon-separated string of attribute values that defines the
   layout of the cell and its content (see Documentation section in README.md)
   Return value
   void
   ***********************************************************************/

   public function easyCell($data, $style=''){
      if($this->col_counter<$this->col_num){
         $sty=$this->set_style($style, 'C', $this->col_counter);
         $this->col_counter++;
         $row_number=count($this->rows);
         $cell_index=count($this->row_data);
         $cell_pos=$this->get_available($sty['colspan'], $sty['rowspan']);
         $colm=$cell_pos %$this->col_num;
         if($sty['img']!=false && $data!='' && $sty['valign']=='M'){
            $sty['valign']=$this->row_style['valign'];
         }
         if($sty['rowspan']){
            $this->total_rowspan=max($this->total_rowspan, $sty['rowspan']);
            $this->blocks[$cell_index]=array($cell_index, $row_number, $sty['rowspan']);
         }
         $w=$this->col_width[$colm];
         $r=0;
         while($r<$sty['colspan'] && $this->col_counter<$this->col_num){
            $this->col_counter++;
            $colm++;
            $w+=$this->col_width[$colm];
            $r++;
         }
         $w-=2*$sty['paddingX'];
         if($sty['img']!==false && is_string($sty['img'])){
            $data=$sty['img'];
            $sty['img']=false;
         }
         $data=& $this->pdf_obj->extMultiCell($sty['font-family'], $sty['font-style'], $sty['font-size'], $sty['font-color'], $w, $data);
         $h=0;
         $rn=count($data);
         for($ri=0; $ri<$rn; $ri++){
            $h+=$data[$ri]['height']*$sty['line-height'];
         }
         if($sty['img']){
            if($sty['img']['w']>$w){
               $sty['img']['h']=$w*$sty['img']['h']/$sty['img']['w'];
               $sty['img']['w']=$w;
            }
            if($h){
               $h+=self::IMGPadding;
            }
            $h+=$sty['img']['h'];
         }
         $w+=2*$sty['paddingX'];
         
         $posx=$this->baseX;
         $d=$cell_pos %$this->col_num;
         for($k=0; $k<$d; $k++){
            $posx+=$this->col_width[$k];
         }
         $this->row_data[$cell_index]=array($data, $sty, $w, $h, $cell_pos, 0, $posx, 0);
         
      }
   }
   /***********************************************************************

   function printRow ( [ bool $setAsHeader = false ] )
   ------------------------------------------------------------------------
   Description:

   This function indicates the end of the current row.
   Parameters:
   setAsHeader (optional)
   Optional. When it is set as true, it sets the current row as the header
   for the table; this means that the current row will be printed as the first
   row of the table (table header) on every page that the table splits on.
   Remark: 1. In order to work, the table attribute split-row should set as true.
   2. Just the first row where this parameter is set as true will be
   used as header any other will printed as a normal row.
   Return values
   Void
   Note:

   This function will print the current row as far as the following holds:
   total_rowspan=0
   where total_rowspan is set as
   total_rowspan=max(total_rowspan, max(rowspan of cell in the current row))-1;
   ***********************************************************************/

   public function printRow($setAsHeader=false){
      $this->col_counter=0;
      $row_number=count($this->rows);
      $this->rows[$row_number]=count($this->row_data);
      $mx=$this->row_style['min-height'];

         $this->row_content_loop($row_number, function($index)use(&$mx){
         if($this->row_data[$index][1]['rowspan']==0){
            $mx=max($mx, $this->row_data[$index][3]+2*$this->row_data[$index][1]['paddingY']);
         }
      });
      $this->row_heights[$row_number]=$mx;
      
      if($this->total_rowspan>0){
         $this->total_rowspan--;
      }
      else{
         $row_number=count($this->rows);
         if(count($this->blocks)>0){
            
            foreach($this->blocks as $bk_id=>$block){
               $h=0;
               for($i=$block[1]; $i<=$block[1]+$block[2]; $i++){
                  $h+=$this->row_heights[$i];
               }
               $t=$this->row_data[$block[0]][3]+2*$this->row_data[$block[0]][1]['paddingY'];
               if($h>0 && $h<$t){
                  for($i=$block[1]; $i<=$block[1]+$block[2]; $i++){
                     $this->row_heights[$i]*=$t/$h;
                  }
               }
            }
            foreach($this->blocks as $j=>$block){
               $h=0;
               for($i=$block[1]; $i<=$block[1]+$block[2]; $i++){
                  $h+=$this->row_heights[$i];
               }
               $this->row_data[$j][5]=$h;
            }
         }
         $block_height=0;
         for($j=0; $j<$row_number; $j++){

               $this->row_content_loop($j, function($index)use($j, $block_height){
               if($this->row_data[$index][1]['rowspan']==0){
                  $this->row_data[$index][5]=$this->row_heights[$j];
               }
               $this->row_data[$index][1]['padding-y']=$this->row_data[$index][1]['paddingY'];
               if($this->row_data[$index][1]['valign']=='M' || ($this->row_data[$index][1]['img'] && count($this->row_data[$index][0]))){
                  $this->row_data[$index][1]['padding-y']=($this->row_data[$index][5]-$this->row_data[$index][3])/2;
               }
               elseif($this->row_data[$index][1]['valign']=='B'){
                  $this->row_data[$index][1]['padding-y']=$this->row_data[$index][5]-($this->row_data[$index][3]+$this->row_data[$index][1]['paddingY']);
               }
            });
            $block_height+=$this->row_heights[$j];
         }
         if($setAsHeader===true){
            if(count($this->header_row)==0){
               $this->header_row['row_heights']=$this->row_heights;
               $this->header_row['row_data']=$this->row_data;
               $this->header_row['rows']=$this->rows;
            }
         }
         if($this->table_style['split-row']==false && $this->pdf_obj->PageBreak()<$this->pdf_obj->GetY()+max($block_height,$this->row_heights[0])){
            $this->pdf_obj->addPage($this->document_style['orientation']);
            if(count($this->header_row)>0){
               $this->printing_loop(true);
            }
         }
         
         if($this->new_table){
            if(count($this->header_row)>0){
               $r=$this->pdf_obj->PageBreak()-($this->pdf_obj->GetY()+$block_height);
               if($r<0 || $r<self::PBThreshold){
                  $this->pdf_obj->addPage($this->document_style['orientation']);
               }
            }
            $this->new_table=false;
         }
         $this->printing_loop();
         $this->grid=array();
         $this->row_data=array();
         $this->rows=array();
         $this->row_heights=array();
         $this->blocks=array();
         $this->overflow=0;
         $this->new_table=false;
      }
      $this->row_style=$this->row_style_def;
   }
   /***********************************************************************

   function endTable( [int $bottomMargin=2])
   ------------------------------------------
   Description:
   Unset all the data members of the easyTable object
   Parameters:
   bottomMargin (optional)
   Optional. Specify the number of white lines left after
   the last row of the table. Default 2.
   If it is negative, the vertical position will be set before
   the end of the table.
   Return values
   Void
   ***********************************************************************/

   public function endTable($bottomMargin=2){
      self::$table_counter=false;
      if($this->table_style['border-width']!=false){
         $this->pdf_obj->SetLineWidth($this->document_style['line-width']);
      }
      $this->pdf_obj->SetX($this->pdf_obj->get_margin('l'));
      $this->pdf_obj->Ln($bottomMargin);
      $this->pdf_obj->resetStaticData();
      unset($this->pdf_obj);
      unset($this->document_style);
      unset($this->table_style);
      unset($this->col_num);
      unset($this->col_width);
      unset($this->baseX);
      unset($this->row_style_def);
      unset($this->row_style);
      unset($this->row_heights);
      unset($this->row_data);
      unset($this->rows);
      unset($this->total_rowspan);
      unset($this->col_counter);
      unset($this->grid);
      unset($this->blocks);
      unset($this->overflow);
      unset($this->header_row);
   }
   
}
?>
