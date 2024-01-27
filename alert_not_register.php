
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
                    title: "ยังไม่ได้ลงทะเบียน กรุณาลงทะเบียน",
                    text: "",
                    type: "error"
                }, function() {
                    window.location = "register_rpst.php"; //หน้าที่ต้องการให้กระโดดไป
                });
            }, 1000);
    </script>';
    ?>
