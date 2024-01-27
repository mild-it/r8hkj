<?php
session_start();
?>
    <script src="https://code.jquery.com/jquery-2.1.3.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert-dev.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.css">
<?php
if($_REQUEST["act"]==1)
{
    include('connectDB.php');
    include('server.php');
    $cid_case=$_REQUEST["cid_case"];
//     $cid_case=base64_decode($cid_case);
//     echo $cid_case;
    if (isset($_POST['save_locat'])) {
        $lat_value = mysqli_real_escape_string($conn, $_POST['lat_value']);
        $lon_value = mysqli_real_escape_string($conn, $_POST['lon_value']);
        
        $user_check_query = "SELECT * FROM caseDis WHERE cid = '$cid_case'";
        $query = mysqli_query($conn, $user_check_query);
        $result = mysqli_fetch_assoc($query);
        // $row = mysqli_fetch_array($result);
        // $cid = $row['cid'];

        
            if ($result['cid'] == $cid_case) {
                "UPDATE caseDis SET lat='$lat_value' ,lon='$lon_value' where cid = '$cid_case'";
                $query1 = mysqli_query($conn, $sql);
                echo '<script>
                       setTimeout(function() {
                        swal({
                            title: "บันทึกสำเร็จ",
                            text: "",
                            type: "success"
                        }, function() {
                            window.close();
                        });
                      }, 1000);
                  </script>';
            }else {
                // $_SESSION['status'] = "ลงทะเบียนไม่สำเร็จ";
                // $_SESSION['status_code'] = "Error";
                // header("location: register_rpst.php");
                echo '<script>
                           setTimeout(function() {
                            swal({
                                title: "บันทึกไม่สำเร็จ",
                                text: "กรุณาบันทึกใหม่",
                                type: "error"
                            }, function() {
                                window.location = "location.php"; //หน้าที่ต้องการให้กระโดดไป
                            });
                          }, 1000);
                      </script>';
            }
          
        
    }
}
?>
