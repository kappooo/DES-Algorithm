<?php

function covert($m){

for($i=0;$i<strlen($m);$i++)
{
$assci[$i]=ord($m[$i]);
}

for($i=0;$i<count($assci);$i++)
{
$hex[$i]=dechex($assci[$i]);
}
$bin=NULL;
for($i=0;$i<count($hex);$i++)
{
$len=strlen(base_convert($hex[$i],16,2));
for($j=0;$j<8-$len;$j++)
{$bin.="0";}
$bin.=base_convert($hex[$i],16,2);
}
return$bin;
}

function selectionTable($Er,$sele){



$ret=NULL;
for($i=0;$i<count($sele);$i++)
$ret.=$Er[$sele[$i]-1];
return $ret;

}
function xorFun($param1,$param2)
{
    $ret=NULL;
    for($i=0;$i<strlen($param1);$i++)
    {
        $ret.=$param1[$i]!= $param2[$i]?'1':'0';
    }
    
  
    return $ret;
    
    
}
function sBoxes($param) {
    $ret=NULL;
    $s1="14 4 13 1 2 15 11 8 3 10 6 12 5 9 0 7 0 15 7 4 14 2 13 1 10 6 12 11 9 5 3 8 4 1 14 8 13 6 2 11 15 12 9 7 3 10 5 0 15 12 8 2 4 9 1 7 5 11 3 14 10 0 6 13";
    $s1= explode( " ",$s1);
    $s1=  array_chunk($s1, 16);
    $s2="15 1 8 14 6 11 3 4 9 7 2 13 12 0 5 10 3 13 4 7 15 2 8 14 12 0 1 10 6 9 11 5 0 14 7 11 10 4 13 1 5 8 12 6 9 3 2 15 13 8 10 1 3 15 4 2 11 6 7 12 0 5 14 9";
    $s2= explode( " ",$s2);
    $s2=  array_chunk($s2, 16);
    $s3="10 0 9 14 6 3 15 5 1 13 12 7 11 4 2 8 13 7 0 9 3 4 6 10 2 8 5 14 12 11 15 1 13 6 4 9 8 15 3 0 11 1 2 12 5 10 14 7 1 10 13 0 6 9 8 7 4 15 14 3 11 5 2 12";
    $s3= explode( " ",$s3);
    $s3=  array_chunk($s3, 16);
    $s4="7 13 14 3 0 6 9 10 1 2 8 5 11 12 4 15 13 8 11 5 6 15 0 3 4 7 2 12 1 10 14 9 10 6 9 0 12 11 7 13 15 1 3 14 5 2 8 4 3 15 0 6 10 1 13 8 9 4 5 11 12 7 2 14";
    $s4= explode( " ",$s4);
    $s4=  array_chunk($s4, 16);
    $s5="2 12 4 1 7 10 11 6 8 5 3 15 13 0 14 9 14 11 2 12 4 7 13 1 5 0 15 10 3 9 8 6 4 2 1 11 10 13 7 8 15 9 12 5 6 3 0 14 11 8 12 7 1 14 2 13 6 15 0 9 10 4 5 3";
    $s5= explode( " ",$s5);
    $s5=  array_chunk($s5, 16);
    $s6="12 1 10 15 9 2 6 8 0 13 3 4 14 7 5 11 10 15 4 2 7 12 9 5 6 1 13 14 0 11 3 8 9 14 15 5 2 8 12 3 7 0 4 10 1 13 11 6 4 3 2 12 9 5 15 10 11 14 1 7 6 0 8 13";
    $s6= explode( " ",$s6);
    $s6=  array_chunk($s6, 16);
    $s7="4 11 2 14 15 0 8 13 3 12 9 7 5 10 6 1 13 0 11 7 4 9 1 10 14 3 5 12 2 15 8 6 1 4 11 13 12 3 7 14 10 15 6 8 0 5 9 2 6 11 13 8 1 4 10 7 9 5 0 15 14 2 3 12";
    $s7= explode( " ",$s7);
    $s7=  array_chunk($s7, 16);
    $s8="13 2 8 4 6 15 11 1 10 9 3 14 5 0 12 7 1 15 13 8 10 3 7 4 12 5 6 11 0 14 9 2 7 11 4 1 9 12 14 2 0 6 10 13 15 3 5 8 2 1 14 7 4 10 8 13 15 12 9 0 3 5 6 11";
    $s8= explode( " ",$s8);
    $s8=  array_chunk($s8, 16);
  
  
    for($i=0;$i<48;$i+=6)
    {   
          $row=NULL;
      $col=NULL;
      
      $row.=$param[$i];
      $row.=$param[$i+5];
      for($j=$i+1;$j<=$i+4;$j++)
      {
          $col.=$param[$j];
      }
          $row=  bindec($row);
          $col=  bindec($col);
        
         $current=NULL;
         switch ($i) {
             case 0:
                 $current=intval($s1[$row][$col]);
                 break;
              case 6:
                 $current=intval($s2[$row][$col]);
                 break;
              case 12:
                 $current=intval($s3[$row][$col]);
                 break;
              case 18:
                 $current=intval($s4[$row][$col]);
                 break;
              case 24:
                 $current=intval($s5[$row][$col]);
                 break;
             case 30:
                 $current=intval($s6[$row][$col]);
                 break;
             
              case 36:
                 $current=intval($s7[$row][$col]);
                 break;

             default:
                 $current=intval($s8[$row][$col]);
                 break;
         }
         
         $current=  decbin($current);
         $temp=NULL;
         for($k=0;$k<(4-strlen($current));$k++)
               $temp.="0"; 
         
            $current=$temp.$current;
            $ret.=$current;
        
        
}
 
  return $ret;
}