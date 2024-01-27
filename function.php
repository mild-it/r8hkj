<?php
//แปลงจาก yyyy-mm-dd  เป็น ว ด ปปปป
function Thai_date($day){
	if($day<=0) return "?";
$date = $day;
$thyear = substr($date,0,4);$month = substr($date,5,2);$thday = substr($date,8,2);
    if($thday <10)
       $thday = substr($thday,1,1);
       
    // $thMonth = array("มกราคม","กุมภาพันธ์","มีนาคม","เมษายน","พฤษภาคม","มิถุนายน","กรกฎาคม","สิงหาคม","กันยายน","ตุลาคม","พฤศจิกายน","ธันวาคม");
    
    $thMonth = array("ม.ค.","ก.พ.","มี.ค.","เม.ย.","พ.ค.","มิ.ย.","ก.ค.","ส.ค.","ก.ย.","ต.ค.","พ.ย.","ธ.ค.");
    
    $thyear +=543;
    
    $day = $thday." ".$thMonth[$month-1]." ".$thyear;  
    return $day;
} 
//แปลงจาก yyyymmdd  เป็น ว ด ปปปป
function Thai_date1($day){
	if($day=="") return "?";if($day=="0") return "?";
$date = $day;
$thyear = substr($date,0,4);$month = substr($date,4,2);$thday = substr($date,6,2);
    if($thday <10)
       $thday = substr($thday,1,1);
       
    /*$thMonth = array("มกราคม","กุมภาพันธ์","มีนาคม","เมษายน","พฤษภาคม","มิถุนายน",
                     "กรกฎาคม","สิงหาคม","กันยายน","ตุลาคม","พฤศจิกายน","ธันวาคม");*/
    
    $thMonth = array("ม.ค.","ก.พ.","มี.ค.","เม.ย.","พ.ค.","มิ.ย.",
                     "ก.ค.","ส.ค.","ก.ย.","ต.ค.","พ.ย.","ธ.ค.");
    
    $thyear +=543;
    
    $day = $thday." ".$thMonth[$month-1]." ".$thyear;  
    return $day;
}



function CalAge($birthdate){
  $today = date('Y-m-d');
    list($byear,$bmonth,$bday) = explode('-',$birthdate);
    list($tyear,$tmonth,$tday) = explode('-',$today);

    if($byear < 1970){
      $yearad = 1970 - $byear;
      $byear = 1970;
    }else{
      $yearad = 0;
    }

    $mbirth = mktime(0,0,0, $bmonth,$bday,$byear);
    $mtoday = mktime(0,0,0, $tmonth,$tday,$tyear);

    $mage = ($mtoday - $mbirth);
    $wyear = (date('Y', $mage)-1970+$yearad);
    $wmonth = (date('m', $mage)-1);
    $wday = (date('d', $mage)-1);

    $ystr = ($wyear > 1 ? " ปี" : " ปี");
    $mstr = ($wmonth > 1 ? " เดือน" : " เดือน");
    $dstr = ($wday > 1 ? " วัน" : " วัน");

    if($wyear > 0 && $wmonth > 0 && $wday > 0) {
      $agestr = $wyear.$ystr." ".$wmonth.$mstr." ".$wday.$dstr;
     }else if($wyear == 0 && $wmonth == 0 && $wday > 0) {
       $agestr = $wday.$dstr;
     }else if($wyear > 0 && $wmonth > 0 && $wday == 0) {
       $agestr = $wyear.$ystr." ".$wmonth.$mstr;
     }else if($wyear == 0 && $wmonth > 0 && $wday > 0) {
       $agestr = $wmonth.$mstr." ".$wday.$dstr;
     }else if($wyear > 0 && $wmonth == 0 && $wday > 0) {
       $agestr = $wyear.$ystr." ".$wday.$dstr;
     }else if($wyear == 0 && $wmonth > 0 && $wday == 0) {
       $agestr = $wmonth.$mstr;
     }else {
       $agestr ="";
     }

      return $agestr;
    }

    function changeDatex($datex){
    //ใช้ Function explode ในการแยกไฟล์ ออกเป็น  Array
    $get_datex = explode("-",$datex);
    //กำหนดชื่อเดือนใส่ตัวแปร $month
      $monthx = array("01"=>"ม.ค.","02"=>"ก.พ","03"=>"มี.ค.","04"=>"เม.ย.","05"=>"พ.ค.","06"=>"มิ.ย.","07"=>"ก.ค.","08"=>"ส.ค.","09"=>"ก.ย.","10"=>"ต.ค.","11"=>"พ.ย.","12"=>"ธ.ค.");
    //month
    $get_monthx = $get_datex["1"];
    
    //year	
    $yearx = $get_datex["0"]+543;
    
    return $get_datex["2"]." ".$monthx[$get_monthx]." ".$yearx;
    
    }

    function dateTimex($date_timex){
     
     //ใช้ function explode แยกข้อมูลวันที่ กับ เวลา
     $get_date_timex = explode(' ',$date_timex);
     
     //เรียกใช้ function changeDate สำหรับแสดงวันที่
     $datex = changeDatex($get_date_timex['0']);
     
     //ใช้ funciton substr เพื่อ ตัด ข้อมูลที่เป็น วินาทีออกไปซะ
     $timex = substr($get_date_timex['1'],0,-3);
     
     return $datex." เวลา ".$timex;
    }
  

?>