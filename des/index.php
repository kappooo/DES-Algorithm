<?php
//shif for key and iteration
function shift($array) {
    $sz=count($array);
    $temp=$array[0];
    for($i=0;$i<$sz-1;$i++)
    {
        $array[$i]=$array[$i+1];
    }
    $array[$sz-1]=$temp;
    return $array;
    
}
include 'functions.php';
echo "<form method='get'>"
."<label>plain text</label><input type='text' name='text'/><br/>"
        . "<label>key</label><input type='text' name='key'/><br/>"
        ."<input type='submit' name='submit' value='des'/>"
. "</form>";
if(isset($_GET['submit'])&&$_GET['submit']=="des"){
$k=$_GET['key'];
$bin=covert($k);
echo "key in binary </br>";
echo $bin ."<br/>";
$pc1=array(57,49,41,33,25,17,9,
1,58,50,42,34,26,18,
10,2,59,51,43,35,27,
19,11,3,60,52,44,36,
63,55,47,39,31,23,15,
7,62,54,46,38,30,22,
14,6,61,53,45,37,29,
21,13,5,28,20,12,4);

$key=str_split($bin);
for($i=0;$i< count($pc1);$i++)
{
    $newkey[]=$key[$pc1[$i]-1];
    if($i<28)
        $c0[]=$key[$pc1[$i]-1];
    else
        $d0[]=$key[$pc1[$i]-1];
}
echo "<br/>  after applying pc1 <br>".implode($newkey)."<br/><br/>";
for($i=0;$i<16;$i++)
{       
    if($i==0)
    {
        $C[]=shift($c0);
        $D[]=  shift($d0);
    }
    else if($i==1||$i==8||$i==15)
    {
        $C[]=  shift($C[count($C)-1]);
        $D[]=  shift($D[count($D)-1]);
    }
    else
    {
        $x= shift($C[count($C)-1]);
        $C[]=  shift($x);
        
         $x= shift($D[count($D)-1]);
        $D[]=  shift($x);
        
    }
    $K[]= implode($C[$i]).implode($D[$i]);
}

    echo "C0 and D0";
    var_dump(implode($C[0]));var_dump(implode($D[0]));
echo "CnDn";
var_dump($K);
$pc2="14 17 11 24 1 5 3 28 15 6 21 10 23 19 12 4 26 8 16 7 27 20 13 2 41 52 31 37 47 55 30 40 51 45 33 48 44 49 39 56 34 53 46 42 50 36 29 32";
$pc2=  explode(" ", $pc2);
for($i=0;$i<16 ;$i++)
{
    for($j=0;$j<count($pc2);$j++)
    {
        $NK[$i][$j]= $K[$i][intval($pc2[$j])-1];
    }
     $K[$i]=  implode($NK[$i]);
}

echo "key after pc2 </br>";
var_dump($K);   
//code her for message

$m=$_GET["text"];
$mbin= covert($m);
 $ip="58 50 42 34 26 18 10 2 60 52 44 36 28 20 12 4 62 54 46 38 30 22 14 6 64 56 48 40 32 24 16 8 57 49 41 33 25 17 9 1 59 51 43 35 27 19 11 3 61 53 45 37 29 21 13 5 63 55 47 39 31 23 15 7";
 $ip= explode(' ',$ip);
$newm=NULL;$L0=NULL;$R0=NULL;
 for($i=0;$i<count($ip);$i++)
 {$newm.=$mbin[intval($ip[$i])-1];
 if($i< count($ip)/2)
     $L0.=$mbin[intval($ip[$i])-1];
 else
     $R0.=$mbin[intval($ip[$i])-1];
 }
echo "<br/>message <br/>$mbin<br/> ";
echo "<br/>message  after applying ip<br/>$newm<br/> ";
echo "<br/>L0 --- $L0<br/>R0 ---  $R0<br/> ";
 $sele=array(32,1,2,3,4,5,
4,5,6,7,8,9,
8,9,10,11,12,13,
12,13,14,15,16,17,
16,17,18,19,20,21,
20,21,22,23,24,25,
24,25,26,27,28,29,
28,29,30,31,32,1);
 
 //permutaion array
 $P="16 7 20 21 29 12 28 17 1 15 23 26 5 18 31 10 2 8 24 14 32 27 3 9 19 13 30 6 22 11 4 25";
 $P=  explode(" ", $P);
 
 $L=array($L0);
 $R=array($R0);
 for($i=0;$i<16;$i++)
 {
  $L[]=$R[$i] ;
  $Er=$R[$i];
 $Er=selectionTable($Er,$sele);
  $KER=xorFun($Er,$K[$i]);
  $sbox=sBoxes($KER);
  $permu=  selectionTable($sbox, $P);
  $R[] =  xorFun($permu, $L[$i]);
  $full[]=$R[$i+1].$L[$i+1];
 }
 echo " L <br/>";
 var_dump($L);
 echo " R <br/>";
 var_dump($R);
 $ip="40 8 48 16 56 24 64 32 39 7 47 15 55 23 63 31 38 6 46 14 54 22 62 30 37 5 45 13 53 21 61 29 36 4 44 12 52 20 60 28 35 3 43 11 51 19 59 27 34 2 42 10 50 18 58 26 33 1 41 9 49 17 57 25";
 $ip=  explode(" ", $ip);
 $ipRev=  selectionTable($full[15], $ip);
    echo "message after ip -1 --- $ipRev<br/>";
 $E=NULL;
 $AS=NULL;
for($i=0;$i<strlen($ipRev);$i+=4)
{
     $x=substr($ipRev, $i,4);
    $E.=$f=dechex(bindec($x));
   
    
}
for($i=0;$i<strlen($ipRev);$i+=8)
{
    
    $y=  substr($ipRev, $i,8);
    $AS.=chr(bindec($y));
    
}
 echo "<br/>hex message encrypted<br/>".$E." <br/>";
 echo "<br/>Message After encryption<br/><br/>".$AS;
 

}
 ?>