<?php

include 'DB.php';
    // ไฟล์ delete.php
    isset( $_GET['id'] ) ? $id = $_GET['id'] : $id = "";
    if( !empty( $id ) ) {

        $sql = " DELETE FROM member WHERE ( id = '{$id}' ) ";
        if( mysqli_query(  $sql ) ) {
            echo "ลบข้อมูล รหัส {$id} เรียบร้อย";
        }
    }
?>