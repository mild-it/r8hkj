<?php
@session_start();
include ("connect.php");
$amper=$_REQUEST["amper"];
$moo=$_REQUEST["moo"];
$pop=$_REQUEST["pop"];
//$sql = "SELECT * FROM districts WHERE amphure_id=$amper";
echo $sql;
//$result = mysqli_query($conn,$sql);
//$row = mysqli_fetch_array($result);
//$id=$row['id'];
$addr=$pop.$moo;

$sql1= "SELECT * FROM tesaban WHERE villcode=$addr";
//echo $sql1;
$result1 = mysqli_query($conn,$sql1);
$row1 = mysqli_fetch_array($result1);
$hname=$row1['hospname'];
$tcode=$row1['tcode'];
if($hname=="") 
	{  echo str_repeat('&nbsp;',20)."<font color=red><b>ข้อมูลที่อยู่ >> ไม่ปรากฎเขตเทศบาล/อบต.ที่รับผิดชอบ(กรุณาตรวจสอบข้อมูลที่อยู่อีกครั้ง)</b></font>";  /*echo $pop;*/	 }
else { echo str_repeat('&nbsp;',20)."<font color=red><b>suggest :: </b></font>อบต./เทศบาลในเขตคือ <font color=red><b>$hname</b></font>"; /*echo $pop; */ ?>

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
                      <select class="form-control" id="obt" name="obt" required>
                      <option value="">-เลือกหน่วยงาน-</option>
                          <?php
						  
                         // include('connect.php');
                          $sql0 = "SELECT * FROM tesaban group by tcode";
                          $query0 = mysqli_query($conn, $sql0);
                          while($result0 = mysqli_fetch_assoc($query0)): 
                            $obtx=$result0['tcode'];
                            if($tcode==$obtx){$obt0='selected';}else{$obt0='';}
                           ?>
                            <option value="<?=$result0['tcode']?>" <?=$obt0?>><?=$result0['hospname']?></option>
                          <?php endwhile; ?>
                      </select>
                      </select>
                    </div> 

<?php   } ?>




