<?php
 /**********************************************************************
 * formateString                                                       *
 *                                                                     *
 * Version: 1.2                                                        *
 * Date:    04-10-2017                                                 *
 * Author:  Dan Machado                                                *
 * Use within exfpdf class                                             *
 **********************************************************************/
 class formatedString{
    public $parced_str;
    public $style_map;
    public $positions;
    private $np;
    public $iterator;
    public $width;
    public $lines;
    public $linesmap;
    public $used_fonts;

    private function get_style($str){
       $style=array('font-family'=>false, 'font-weight'=>false, 'font-style'=>false,
       'font-size'=>false, 'font-color'=>false, 'href'=>'');
       $tmp=explode(';', trim($str, '",\', '));
       foreach($tmp as $x){
          if($x && strpos($x,':')>0){
             $r=explode(':',$x);
             $r[0]=trim($r[0]);
             $r[1]=trim($r[1]);
             if(isset($style[$r[0]]) || $r[0]=='style'){
                if($r[0]=='style' || $r[0]=='font-style'){
                   $r[1]=strtoupper($r[1]);
                   if(strpos($r[1], 'B')!==false){
                      $style['font-weight']='B';
                  }
                  if(strpos($r[1], 'I')!==false){
                     $style['font-style']='I';
                  }
                  if(strpos($r[1], 'U')!==false){
                     $style['font-style'].='U';
                  }
               }
               elseif($r[1]){
                  if($r[0]=='href'){
                     $style[$r[0]]=implode(':', array_slice($r,1));
                  }
                  else{
                     $style[$r[0]]=$r[1];
                  }
               }
            }
         }
      }
      return $style;
   }
    

   private function style_merge($style1, $style2){
      $result=$style1;
      foreach($style2 as $k=>$v){
         if($v){
            $result[$k]=$v;
         }
      }
      return $result;
   }

   private function style_parcer($text, &$font_data){
      $str=trim(strtr($text, array("\r"=>'', "\t"=>'')));
      $rep=array('[bB]{1}'=>'B', '[iI]{1}'=>'I', '[iI]{1}[ ]*[bB]{1}'=>'BI', '[bB]{1}[ ]*[iI]{1}'=>'BI' );
      foreach($rep as $a=>$v){
         $str=preg_replace('/<[ ]*'.$a.'[ ]*>/', "<$v>", $str);
         $str=preg_replace('/<[ ]*\/+[ ]*'.$a.'[ ]*>/', "</$v>", $str);
      }
      $str=preg_replace('/<BI>/', '<s "font-weight:B;font-style:I">', $str);
      $str=preg_replace('/<\/BI>/', "</s>", $str);
      $str=preg_replace('/<B>/', '<s "font-weight:B;">', $str);
      $str=preg_replace('/<\/B>/', "</s>", $str);
      $str=preg_replace('/<I>/', '<s "font-style:I;">', $str);
      $str=preg_replace('/<\/I>/', "</s>", $str);
      $open=array();
      $total=array();
      $lt="<s";
      $rt="</s>";
      $j=strpos($str, $lt, 0);
      while($j!==false){
            if($j>0 && ord($str[$j-1])==92){
            $j=strpos($str, $lt, $j+1);
            continue;
         }
         $k=strpos($str, '>',$j+1);
         $open[$j]=substr($str, $j+2, $k-($j+2));
         $total[]=$j;
         $j=strpos($str, $lt, $j+1);
      }
      $j=strpos($str, $rt, 0);
      while($j!==false){
         $total[]=$j;
         $j=strpos($str, $rt, $j+1);
      }
      sort($total);
      
      $cs='';
      foreach($font_data as $k=>$v){
         $cs.=$k . ':'. $v . '; ';
      }
      $cs=$this->get_style($cs);
      $tmp=array($cs);
      $blocks=array();
      $blockstyle=array();
      $n=count($total);
      $k=0;
      for($i=0; $i<$n; $i++){
         $blocks[]=substr($str, $k, $total[$i]-$k);
         $blockstyle[]=$cs;
         if(isset($open[$total[$i]])){
            $cs=$this->style_merge($cs, $this->get_style($open[$total[$i]]));
            array_push($tmp, $cs);
            $k=strpos($str, '>',$total[$i]+1)+1;
         }
         else{
            $k=$total[$i]+4;
            array_pop($tmp);
            $l=count($tmp)-1;
            $cs=$tmp[$l];
         }
      }
      if($k<strlen($str)){
         $blocks[]=substr($str, $k);
         $blockstyle[]=$cs;
      }
      $n=count($blocks);
      for($i=0; $i<$n; $i++){
         $this->parced_str.=strtr($blocks[$i], array('\<s'=>'<s'));
         if(strlen($blocks[$i])>0){
            $blockstyle[$i]['style']=$blockstyle[$i]['font-weight'] . $blockstyle[$i]['font-style'];
            unset($blockstyle[$i]['font-weight']);
            unset($blockstyle[$i]['font-style']);
            $this->style_map[strlen($this->parced_str)-1]=$blockstyle[$i];
         }
      }
   }

   public function __construct($text, $width, &$font_data){
      $this->iterator=0;
      $this->parced_str='';
      $this->style_map=array();
      $this->style_parcer($text, $font_data);
      $this->positions=array_keys($this->style_map);
      $this->np=(bool)count($this->positions);
      $this->width=$width;
      $this->lines=array('');
      $this->linesmap[0]=array(0, 0, 0);
      $this->used_fonts=array();
   }

   public function get_str(){
      return $this->parced_str;
   }

   public function get_current_style($i){
      if(!$this->np){
         return '';
      }
      while($this->positions[$this->iterator]<$i){
         $this->iterator++;
      }
      return $this->style_map[$this->positions[$this->iterator]];
   }
   

      public function break_by_style($t){
      $i=$this->linesmap[$t][0];
      $j=$this->linesmap[$t][1];
      $this->iterator=0;
      $result=array('chunks'=>array(), 'style'=>array(), 'height'=>0, 'width'=>$this->linesmap[$t][2]);
      if(strlen($this->parced_str)==0){
         return $result;
      }
      $cs=$this->get_current_style($i);
      $result['height']=$cs['font-size'];
      $r=0;
      $result['chunks'][$r]='';
      $result['style'][$r]=$cs;
      while($this->parced_str[$j]==' '){
         $j--;
      }
      $tmp=$i;
         for($k=$i; $k<=$j; $k++){
         if($this->parced_str[$tmp]==' ' && $this->parced_str[$k]==' '){
            $tmp=$k;
            continue;
         }
            if($cs!=$this->get_current_style($k)) {
            $r++;
            $cs=$this->get_current_style($k);
            $result['chunks'][$r]='';
            $result['style'][$r]=$cs;
            if($result['height']<$cs['font-size']){
               $result['height']=$cs['font-size'];
            }
         }
         $result['chunks'][$r].=$this->parced_str[$k];
         $tmp=$k;
      }
      return $result;
   }
}
?>
