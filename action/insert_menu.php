<?php
session_start();

// ป้องกันการเข้าถึงโดยไม่ได้ล็อกอิน
if (!isset($_SESSION["username"])) {
    header("location: ../login.php");
    exit;
}

// ตรวจสอบว่าได้รับการส่งข้อมูลแบบ POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    include "connect.php";

    // รับค่าและป้องกัน SQL Injection
    $menu_name  = mysqli_real_escape_string($con, $_POST["menu_name"]);
    $menu_price = mysqli_real_escape_string($con, $_POST["menu_price"]);
    $menu_image = mysqli_real_escape_string($con, $_POST["menu_image"]);

    // คำสั่ง SQL สำหรับเพิ่มรายการเมนูใหม่ (menu_id รันอัตโนมัติ)
    $sql = "INSERT INTO `menus` (`menu_name`, `menu_price`, `menu_image`)
            VALUES ('$menu_name', '$menu_price', '$menu_image')";

    $result = mysqli_query($con, $sql);

    if ($result) {
        // เพิ่มข้อมูลสำเร็จ กลับไปหน้าจัดการเมนู
        header("location: ../manage_menu.php");
        exit;
    } else {
        // กรณีเกิดข้อผิดพลาด
        echo "<script>
                alert('เกิดข้อผิดพลาดในการเพิ่มเมนูอาหาร: " . mysqli_error($con) . "');
                window.history.back();
              </script>";
    }
} else {
    header("location: ../manage_menu.php");
    exit;
}
?>