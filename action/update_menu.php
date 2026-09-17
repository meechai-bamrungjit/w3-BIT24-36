<?php
session_start();

// ป้องกันการเข้าถึงโดยไม่ได้ล็อกอิน
if (!isset($_SESSION["username"])) {
    header("location: ../login.php");
    exit;
}

// ตรวจสอบว่าได้รับการส่งข้อมูลแบบ POST มาหรือไม่
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    include "connect.php";

    // รับค่าและป้องกัน SQL Injection
    $menu_id = mysqli_real_escape_string($con, $_POST["menu_id"]);
    $menu_name = mysqli_real_escape_string($con, $_POST["menu_name"]);
    $menu_price = mysqli_real_escape_string($con, $_POST["menu_price"]);
    $menu_image = mysqli_real_escape_string($con, $_POST["menu_image"]);

    // คำสั่ง SQL สำหรับอัปเดตข้อมูล (ไม่มี type_id)
    $sql = "UPDATE `menus` 
            SET `menu_name` = '$menu_name',
                `menu_price` = '$menu_price',
                `menu_image` = '$menu_image' 
            WHERE `menu_id` = '$menu_id'";

    $result = mysqli_query($con, $sql);

    if ($result) {
        // ทำงานสำเร็จ กลับไปหน้าจัดการเมนู
        header("location: ../manage_menu.php");
        exit;
    } else {
        // กรณีเกิดข้อผิดพลาดในการบันทึก
        echo "<script>
                alert('เกิดข้อผิดพลาดในการอัปเดตข้อมูล: " . mysqli_error($con) . "');
                window.history.back();
              </script>";
    }
} else {
    header("location: ../manage_menu.php");
    exit;
}
?>