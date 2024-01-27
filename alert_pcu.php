<?php
session_start();
?>
    <script src="https://code.jquery.com/jquery-2.1.3.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert-dev.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.css">

    <?php
    echo '<script>
        setTimeout(function() {
            swal({
                title: "ยังไม่ได้รับอนุญาตเข้าใช้งาน",
                text: "",
                type: "error"
            }, function() {
                window.close();
                window.location = "check_login_rpst.php";
            });
        }, 1000);
    </script>';
    ?>
