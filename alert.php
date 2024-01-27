<?php
session_start();
// $go_url = 'page1.php';
// switch ($_SESSION['levelx']) {
//     case 'pcu':
//         $go_url = 'page1.php';
//         break;
//     case 'pmj':
//         $go_url = 'page2.php';
//         break;
//     case 'opt':
//         $go_url = 'page3.php';
//         break;
//     case 'etc':
//         $go_url = 'register_rpst.php';
//         break;
//     default:
//         $go_url = 'page1.php';
//         break;
// }
?>
        <!-- <script>
        alert('ยังไม่ได้ลงทะเบียน กรุณาลงทะเบียน');
        window.location='register_rpst.php';
        </script> -->
    <script src="https://code.jquery.com/jquery-2.1.3.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert-dev.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.css">

    <?php
    echo '<script>
        setTimeout(function() {
            swal({
                title: "User ID ของท่านได้ลงทะเบียนแล้ว",
                text: "",
                type: "success"
            }, function() {
                window.close();
                window.location = "check_login_rpst.php";
            });
        }, 1000);
    </script>';
    ?>
