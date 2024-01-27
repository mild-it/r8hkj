<?php session_start(); if($_SESSION["level"]=="etc"){header("Location: sendCase.php");} ?>
<?php
@session_start();
$id_line = $_SESSION['id_line'];
$province = $_SESSION['provinces'];
echo "aaa=$province";
include('server.php');
include('connectDB.php');
?> 
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>R8:NDS</title>
    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="images/disLogo.png">
    <!-- Pignose Calender -->
    <link href="./plugins/pg-calendar/css/pignose.calendar.min.css" rel="stylesheet">
    <!-- Chartist -->
    <!-- <link rel="stylesheet" href="./plugins/chartist/css/chartist.min.css">
    <link rel="stylesheet" href="./plugins/chartist-plugin-tooltips/css/chartist-plugin-tooltip.css"> -->
    <!-- Custom Stylesheet -->
    <link href="css/style.css" rel="stylesheet">
	<link rel="stylesheet" href="jquery.datetimepicker.css">
  <!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"> -->
  
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css">
<link rel="stylesheet" href="dist/css/bootstrap-select.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
<!-- <script src="dist/js/bootstrap-select.js"></script> -->

</head>
<script language="javascript">
function checkID(id)
{
if(id.length != 13) return false;
for(i=0, sum=0; i < 12; i++)
sum += parseFloat(id.charAt(i))*(13-i); if((11-sum%11)%10!=parseFloat(id.charAt(12)))
return false; return true;}

function checkForm()
{ if(!checkID(document.form1.cid.value))
  document.form1.cid.value='';
// alert('รหัสประชาชนไม่ถูกต้อง');
}
function chktsb(a){
	document.getElementById('ok').innerHTML='';
	document.getElementById('ok').innerHTML = "<center>loading</center>";
	if (window.XMLHttpRequest)   {   xmlhttp=new XMLHttpRequest();   }
	else   {   xmlhttp=new ActiveXObject('Microsoft.XMLHTTP');   }
	xmlhttp.onreadystatechange=function()  { if (xmlhttp.readyState==4 && xmlhttp.status==200) 
	{ document.getElementById('ok').innerHTML=xmlhttp.responseText; } }
	xmlhttp.open('GET','chktsb.php?pop='+a+'&moo='+document.getElementById('birth_month').value,true); 
	xmlhttp.send();}
function closeWin() { myWindow.close();  }
</script>
<script language="javascript">
function CheckNum(){  if (event.keyCode < 48 || event.keyCode > 57){  event.returnValue = false;   } }
</script>

<script  language="javascript">  
	function confirmAdd()  {  return confirm('ต้องการเพิ่มรายการนี้? / โปรดยืนยัน!');   }  
	function reload_view(t) { 	window.opener.location.reload();	setTimeout("self.close()",(t * 10000)); }
</script>
<link href='https://fonts.googleapis.com/css?family=Kanit:400,300&subset=thai,latin' rel='stylesheet' type='text/css'>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <style>	body { font-family: 'Kanit', sans-serif;	} h1,h2,h3,h4,h5,h6 {  font-family: 'Kanit', sans-serif;		} </style>

<body>

    <!--*******************       Preloader start    ********************-->
    <div id="preloader">
        <div class="loader">
            <svg class="circular" viewBox="25 25 50 50">
                <circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="3" stroke-miterlimit="10" />
            </svg>
        </div>
    </div>
    <!--*******************     Preloader end   ********************-->  
    <!--**********************************     Main wrapper start   ***********************************-->
    <div id="main-wrapper">
     <!--**********************************     Nav header start    ***********************************-->
       
        <div class="content-body">
            

<?php
if($_REQUEST["act"]==1)
{
  include ("connectDB.php");

  $cid=$_REQUEST["cid"];
    $q1="SELECT cid FROM caseDis where cid='$cid'";          
    $result1 = $mysqli->query($q1);                                                                   
    $row=$result1->fetch_row();
    
  $fname=$_REQUEST["fname"]; 
  $lname=$_REQUEST["lname"]; 
  $sex=$_REQUEST["sex"]; 
  $birth=$_REQUEST["birth"];
        // $y_th1=substr($birth,6,4);
        // $y_en1=$y_th1-543;
        // $d_th1=substr($birth,0,2);
        // $m_th1=substr($birth,3,2);
        // $birth=$y_en1."-".$m_th1."-".$d_th1;
  // $disType=$_REQUEST["disType"];
  $homeNo=$_REQUEST["homeNo"]; 
  $mu=$_REQUEST["mu"]; 
  $tambol=$_REQUEST["district_id"]; 
  $amper=$_REQUEST["amphure_id"]; 
    $q1="SELECT code as ampCode FROM amphures where id='$amper'";          
    $result1 = $mysqli->query($q1);                                                                   
    $rs1=$result1->fetch_object();
    $ampCode=$rs1->ampCode;
    $q1="SELECT * FROM office where distid='$ampCode' and off_type in('05','06','07')";          
    $result1 = $mysqli->query($q1);                                                                   
    $rs1=$result1->fetch_object();
    $hospcode=$rs1->off_id;
    $off_name=$rs1->off_name;
  
  $tel=$_REQUEST["tel"]; 
  $obt=$_REQUEST["obt"]; 
  
      if($row>=1){echo "<h4><center>เลขประชาชนนี้ ได้ขอขึ้นทะเบียนคนพิการแล้ว</h4>";}
      elseif($cid>0){
         //upload file
         if($_FILES['fileIdCard']['name']!="")
         {
           $output_dir = "temp/";
           $sur = strrchr($_FILES['fileIdCard']['name'], "."); //ตัดนามสกุลไฟล์เก็บไว้
           $fileIdCard = ('Idcard'.$cid.$sur); //ชื่อไฟล์ตาม id
           move_uploaded_file($_FILES["fileIdCard"]["tmp_name"],$output_dir.$fileIdCard);
         }
         if($_FILES['fileHome']['name']!="")
         {
           $output_dir = "temp/";
           $sur = strrchr($_FILES['fileHome']['name'], "."); //ตัดนามสกุลไฟล์เก็บไว้
           $fileHome = ('Home'.$cid.$sur); //ชื่อไฟล์ตาม id
           move_uploaded_file($_FILES["fileHome"]["tmp_name"],$output_dir.$fileHome);
         }
         if($_FILES['fileFace']['name']!="")
         {
           $output_dir = "temp/";
           $sur = strrchr($_FILES['fileFace']['name'], "."); //ตัดนามสกุลไฟล์เก็บไว้
           $fileFace = ('Face'.$cid.$sur); //ชื่อไฟล์ตาม id
           move_uploaded_file($_FILES["fileFace"]["tmp_name"],$output_dir.$fileFace);
         }
         if($_FILES['filePict']['name']!="")
         {
           $output_dir = "temp/";
           $sur = strrchr($_FILES['filePict']['name'], "."); //ตัดนามสกุลไฟล์เก็บไว้
           $filePict = ('Pict'.$cid.$sur); //ชื่อไฟล์ตาม id
           move_uploaded_file($_FILES["filePict"]["tmp_name"],$output_dir.$filePict);
         }
         if($_FILES['fileBank']['name']!="")
         {
          $output_dir = "temp/";
          $sur = strrchr($_FILES['fileBank']['name'], "."); //ตัดนามสกุลไฟล์เก็บไว้
          $fileBank = ('Bank'.$cid.$sur); //ชื่อไฟล์ตาม id
          move_uploaded_file($_FILES["fileBank"]["tmp_name"],$output_dir.$fileBank);
        }
        if($_FILES['fileIdCard2']['name']!="")
         {
          $output_dir = "temp/";
          $sur = strrchr($_FILES['fileIdCard2']['name'], "."); //ตัดนามสกุลไฟล์เก็บไว้
          $fileIdCard2 = ('IdCard2'.$cid.$sur); //ชื่อไฟล์ตาม id
          move_uploaded_file($_FILES["fileIdcard2"]["tmp_name"],$output_dir.$fileIdCard2);
        }
        if($_FILES['fileHome2']['name']!="")
         {
          $output_dir = "temp/";
          $sur = strrchr($_FILES['fileHome2']['name'], "."); //ตัดนามสกุลไฟล์เก็บไว้
          $fileHome2 = ('Home2'.$cid.$sur); //ชื่อไฟล์ตาม id
          move_uploaded_file($_FILES["fileHome2"]["tmp_name"],$output_dir.$fileHome2);
        }
        

            $sql = "REPLACE INTO caseDis(hospcode,cid,fname,lname,sex,birth,homeNo,mu,tambol,amper,tel,obt,statusCase,fileIdCard,fileHome,fileFace,filePict,fileBank,fileIdCard2,fileHome2,dateSend,idSend,fileConsent)
            VALUES ('$hospcode','$cid','$fname','$lname','$sex','$birth','$homeNo','$mu','$tambol','$amper','$tel','$obt','HOS','$fileIdCard','$fileHome','$fileFace','$filePict','$fileBank','$fileIdCard2','$fileHome2',now(),'$id_line','mobile.png')";
            $mysqli->query($sql);
            echo "<center><h3>ยื่นคำขอเรียบร้อยแล้ว</h3>";
           
          
            //-----------แจ้ง Line
            $sql0 = "SELECT * FROM member WHERE hospcode='$hospcode' and id_line is not null";
                          $query0 = mysqli_query($conn, $sql0);
                          while($result0 = mysqli_fetch_assoc($query0)){ 
                            $id_line=$result0['id_line'];
                            // echo "$id_line <br>";
            // Access Token
            // $access_token = 'eNQ1Evl9snf9RLTTYTSYMoF1BkKVRFatm33B/ZdQmuPhjb913O+RT8l8t+2Ujxew3NtjmTbL8JYET5YGgGh0d5LY8eiq/JAAmbZVFmBuM7ZWekaas7LgtQ3Vl5KtuW0JSgFfq4h4XUGQ4Vuu+0s9sQdB04t89/1O/w1cDnyilFU=';
            // User ID
            // $userId = 'U80b248f7031744090346ea54c520a1b2';
            $userId = $id_line;
            // ข้อความที่ต้องการส่ง
            $messages = array(
                'type' => 'text',
                'text' => 'แจ้ง'.$off_name.' -->มีการยื่นคำขอขึ้นทะเบียนคนพิการรายใหม่ โปรดตรวจสอบในระบบ',
            );
            $post = json_encode(array(
                'to' => array($userId),
                'messages' => array($messages),
            ));
            // URL ของบริการ Replies สำหรับการตอบกลับด้วยข้อความอัตโนมัติ
            $url = 'https://api.line.me/v2/bot/message/multicast';
            $headers = array('Content-Type: application/json', 'Authorization: Bearer '.$access_token);
            $ch = curl_init($url);
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
            $result = curl_exec($ch);
            echo $result;
          }//ปิด while ค้นหา line _id

        }
  ?>
<!-- <META HTTP-EQUIV="Refresh" CONTENT="0;URL=./page1.php"> -->
<?php
}//ปิด add
else{
  
?>
<div class="container">

        <FORM name="form1" class="form-inline" ACTION ='sendCase.php?act=1' METHOD='post'  enctype='multipart/form-data'>
        <div class="container">       

          <div class="input-group mb-3 input-group-sm">
          <?php
          include('connect.php');
          $sql = "SELECT * FROM amphures where code like '$province%'";
          $query = mysqli_query($conn, $sql);
          ?>
          <div class="container my-5">
          <!-- <button onclick="window.close()" class="btn btn-danger btn-xl">ปิด</button>  -->
    <div class="card">
    <div class="card-header">
      <!-- <div class="card-body"> -->
            <h4>ยื่นคำขอขึ้นทะเบียนคนพิการรายใหม่</h4>
            <div class="input-group mb-3 input-group">
                      <div class="input-group-prepend">
                        <span class="input-group-text">เลขประชาชน : </span>
                      </div>
                    <input type="text" class="form-control"  name="cid" onfocusout="checkForm()" placeholder="ไม่ต้องมีเครื่องหมายขีดคั่น" required>
                    </div> 
            <div class="input-group mb-3 input-group">
            <div class="input-group-prepend">
              <span class="input-group-text">ชื่อ :</span>
            </div>
          <input type="text" class="form-control"  name="fname" required>
          </div>
          <div class="input-group mb-3 input-group">
          <div class="input-group-prepend">
              <span class="input-group-text">สกุล :</span>
            </div>
          <input type="text" class="form-control"  name="lname" required>
          </div>  
          <div class="input-group mb-3 input-group">
            <div class="input-group-prepend">
              <span class="input-group-text">เพศ :</span>
            </div>
            <select class="form-control" id="sex" name="sex" required>
            <option value="">-เลือก-</option>
            <option value="ชาย">ชาย</option>
            <option value="หญิง">หญิง</option>
            </select>
            </div>
            <div class="input-group mb-3 input-group">
          <div class="input-group-prepend">
              <span class="input-group-text">วันเดือนปีเกิด :</span>
            </div>
          <input type="date" class="form-control"  data-date-format="yyyy-mm-dd" name="birth" required>
          <!-- <input type="text" class="form-control" name="birth"  id="birth" value="" required> -->


          </div>  

        </div> 
   



    <div class="card-header">
            <h5>ข้อมูลที่อยู่</h5>
            <div class="input-group mb-3 input-group">
            <div class="input-group-prepend">
              <span class="input-group-text">บ้านเลขที่ :</span>
            </div>
          <input type="text" class="form-control"  name="homeNo" >
          </div>
          <div class="input-group mb-3 input-group">
          <div class="input-group-prepend">
              <span class="input-group-text">หมู่ที่ :</span>
            </div>
          <select class="form-control" id="birth_month" name="mu" required>
            <option value="">-เลือก-</option>
            <option value="01">1</option>
            <option value="02">2</option>
            <option value="03">3</option>
            <option value="04">4</option>
            <option value="05">5</option>
            <option value="06">6</option>
            <option value="07">7</option>
            <option value="08">8</option>
            <option value="09">9</option>
            <option value="10">10</option>
            <option value="11">11</option>
            <option value="12">12</option>
            <option value="13">13</option>
            <option value="14">14</option>
            <option value="15">15</option>
            <option value="16">16</option>
            <option value="17">17</option>
            <option value="18">18</option>
            <option value="19">19</option>
            <option value="20">20</option>
            <option value="21">21</option>
            <option value="22">22</option>
            <option value="23">23</option>
            <option value="24">24</option>
            <option value="25">25</option>
            <option value="26">26</option>
            <option value="27">27</option>
            <option value="28">28</option>
            <option value="29">29</option>
            <option value="30">30</option>
            </select>
          </div>  

                <div class="input-group mb-3 input-group">
                  <div class="input-group-prepend">
                    <span class="input-group-text">อำเภอ : </span>
                  </div>
                        <select name="amphure_id" id="amphure" class="form-control" required>
                            <option value="">-เลือกอำเภอ-</option>
                            <?php while($result = mysqli_fetch_assoc($query)): ?>
                                <option value="<?=$result['id']?>" ><?=$result['name_th']?></option>
                            <?php endwhile; ?>
                        </select>
                    </div>

                        <div class="input-group mb-3 input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text">ตำบล : </span>
                        </div>
                        <select name="district_id" id="district" class="form-control"  required >
                            <option value="">-เลือกตำบล-</option>
                        </select>
                       </div>

                       <div class="input-group mb-3 input-group">
                      <div class="input-group-prepend">
                        <span class="input-group-text">โทรศัพท์มือถือ : </span>
                      </div>
                    <input type="text" class="form-control"  name="tel" required>
                    </div> 
                    <div class="input-group mb-3 input-group">
                      <div class="input-group-prepend">
                        <span class="input-group-text">อยูในเขตเทศบาล/อบต.</span>
                      </div>
                      <select id="select-testing" class="selectpicker" data-live-search="true" title="กรุณาเลือก" name="obt" required>
                      <!-- <select class="form-control" id="obt" name="obt" required> -->
                      <option value="">-เลือกหน่วยงาน-</option>
                          <?php
						  
                         // include('connect.php');
                          $sql0 = "SELECT * FROM tesaban WHERE province='$province' group by tcode";
                          $query0 = mysqli_query($conn, $sql0);
                          while($result0 = mysqli_fetch_assoc($query0)): 
                            $obtx=$result0['tcode'];
                            if($tcode==$obtx){$obt0='selected';}else{$obt0='';}
                           ?>
                            <option value="<?=$result0['tcode']?>" <?=$obt0?>><?=$result0['hospname']?></option>
                          <?php endwhile; ?>
                      </select>
						
							<!-- <span id='ok'></span> -->
							<script>
							
							</script>
         
          </div>
        </div>   
        <div class="card">
        <div class="card-header">
            <h5>ข้อมูลเอกสาร</h5>
                    <div class="input-group mb-3 input-group">    
                      <div class="input-group-prepend">
                        <span class="input-group-text">สำเนาบัตรประชาชนคนพิการ : </span>
                      </div>
                    <input type="file" class="form-control"  name="fileIdCard">
                    </div> 
                    <div class="input-group mb-3 input-group">    
                      <div class="input-group-prepend">
                        <span class="input-group-text">สำเนาทะเบียนบ้านคนพิการ : </span>
                      </div>
                    <input type="file" class="form-control"  name="fileHome">
                    </div> 
                    <div class="input-group mb-3 input-group">    
                      <div class="input-group-prepend">
                        <span class="input-group-text">สำเนาบัตรประชาชนผู้ดูแล : </span>
                      </div>
                    <input type="file" class="form-control"  name="fileIdCard2">
                    </div> 
                    <div class="input-group mb-3 input-group">    
                      <div class="input-group-prepend">
                        <span class="input-group-text">สำเนาทะเบียนบ้านผู้ดูแล : </span>
                      </div>
                    <input type="file" class="form-control"  name="fileHome2">
                    </div> 
                    <div class="input-group mb-3 input-group">    
                      <div class="input-group-prepend">
                        <span class="input-group-text">รูปถ่ายคนพิการ(หน้าตรง) : </span>
                      </div>
                    <input type="file" class="form-control"  name="fileFace">
                    </div> 
                    <div class="input-group mb-3 input-group">    
                      <div class="input-group-prepend">
                        <span class="input-group-text">รูปถ่ายความพิการ : </span>
                      </div>
                    <input type="file" class="form-control"  name="filePict">
                    </div> 
                    <div class="input-group mb-3 input-group">    
                      <div class="input-group-prepend">
                        <span class="input-group-text">รูปถ่ายหน้าบัญชีธนาคาร : </span>
                      </div>
                    <input type="file" class="form-control"  name="fileBank">
                    </div>
                    <button type="submit" class="btn btn-success"><span class="glyphicon glyphicon-save"></span>ส่งคำขอ</button>
</form>

<script src="assets/script.js"></script>
<script src="assets/script0.js"></script>
        

<?php
}
?>
        </div>
        <!--**********************************      Content body end     ***********************************-->    
        <!--**********************************         Footer start      ***********************************-->
        <!-- <div class="footer">
            <div class="copyright">
                <p>Copyright &copy; Designed & Developed by <a href="https://themeforest.net/user/quixlab">Quixlab</a> 2018</p>
            </div>
        </div> -->
        <!--**********************************     Footer end    ***********************************-->
    </div>
    <!--**********************************     Main wrapper end   ***********************************-->
    <!--**********************************        Scripts    ***********************************-->
    <script src="plugins/common/common.min.js"></script>
    <script src="js/custom.min.js"></script>
    <script src="js/settings.js"></script>
    <script src="js/gleek.js"></script>
    <script src="js/styleSwitcher.js"></script>

    <!-- Chartjs -->
    <script src="./plugins/chart.js/Chart.bundle.min.js"></script>
    <!-- Circle progress -->
    <script src="./plugins/circle-progress/circle-progress.min.js"></script>
    <!-- Datamap -->
    <script src="./plugins/d3v3/index.js"></script>
    <script src="./plugins/topojson/topojson.min.js"></script>
    <script src="./plugins/datamaps/datamaps.world.min.js"></script>
    <!-- Morrisjs -->
    <script src="./plugins/raphael/raphael.min.js"></script>
    <script src="./plugins/morris/morris.min.js"></script>
    <!-- Pignose Calender -->
    <script src="./plugins/moment/moment.min.js"></script>
    <script src="./plugins/pg-calendar/js/pignose.calendar.min.js"></script>
    <!-- ChartistJS -->
    <script src="./plugins/chartist/js/chartist.min.js"></script>
    <script src="./plugins/chartist-plugin-tooltips/js/chartist-plugin-tooltip.min.js"></script>



    <script src="./js/dashboard/dashboard-1.js"></script>
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>   
<script src="jquery.datetimepicker.full.js"></script>
<script type="text/javascript">   
$(function(){
    $.datetimepicker.setLocale('th'); // ต้องกำหนดเสมอถ้าใช้ภาษาไทย และ เป็นปี พ.ศ.
    // กรณีใช้แบบ input
    $("#birth").datetimepicker({
        timepicker:false,
		//defaultDate: '01/07/1922',
		//yearStart: 1922,  ดูค่าในเจเอสไฟล์เป็นหลัก
		//yearEnd: 2022,
        format:'d-m-Y',  // กำหนดรูปแบบวันที่ ที่ใช้ เป็น 00-00-0000      
		//defaultDate: '31/12/2022',
		maxDate: new Date('31/12/2565'),
		//minDate: new Date('2017-12-5'),
		//yearRange: '-200:+0', // last hundred years or
		yearRange: '1950:2025', // specifying a hard coded year range
        lang:'th',  // ต้องกำหนดเสมอถ้าใช้ภาษาไทย และ เป็นปี พ.ศ.
        onSelectDate:function(dp,$input){
            var yearT=new Date(dp).getFullYear()-0;  
            var yearTH=yearT+543;
            var fulldate=$input.val();
            //var fulldateTH=fulldate.replace(yearT,yearTH);
			var fulldateTH=fulldate.replace(yearT,yearTH);
            $input.val(fulldateTH);
        },
    });       
    // กรณีใช้กับ input ต้องกำหนดส่วนนี้ด้วยเสมอ เพื่อปรับปีให้เป็น ค.ศ. ก่อนแสดงปฏิทิน
    $("#birth").on("mouseenter mouseleave",function(e){
        var dateValue=$(this).val();
        if(dateValue!=""){
                var arr_date=dateValue.split("-"); // ถ้าใช้ตัวแบ่งรูปแบบอื่น ให้เปลี่ยนเป็นตามรูปแบบนั้น
                // ในที่นี้อยู่ในรูปแบบ 00-00-0000 เป็น d-m-Y  แบ่งด่วย - ดังนั้น ตัวแปรที่เป็นปี จะอยู่ใน array
                //  ตัวที่สอง arr_date[2] โดยเริ่มนับจาก 0 
                if(e.type=="mouseenter"){
                    var yearT=arr_date[2]-543;
                }       
                if(e.type=="mouseleave"){
                    var yearT=parseInt(arr_date[2])+543;
                }   
                dateValue=dateValue.replace(arr_date[2],yearT);
                $(this).val(dateValue);                                                 
        }       
    });
     
});
</script>
</body>

</html>