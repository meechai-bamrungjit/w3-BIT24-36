<?php
session_start();

// ป้องกันการเข้าถึงโดยไม่ได้ล็อกอิน
if (!isset($_SESSION["username"])) {
    header("location: ../login.php");
    exit;
}

include "connect.php";

// รับค่า id และกรองข้อมูลเพื่อป้องกัน SQL Injection
$id = isset($_GET['id']) ? mysqli_real_escape_string($con, $_GET['id']) : '';

if (!empty($id)) {
    // คำสั่ง SQL สำหรับลบรายการเมนู
    $sql = "DELETE FROM menus WHERE menu_id = '$id'";
    $result = mysqli_query($con, $sql);

    if ($result) {
        // ลบข้อมูลสำเร็จ กลับไปหน้าจัดการเมนู
        header("location: ../manage_menu.php");
        exit;
    } else {
        // กรณีเกิดข้อผิดพลาดในการลบ
        echo "<script>
                alert('เกิดข้อผิดพลาดในการลบข้อมูล: " . mysqli_error($con) . "');
                window.history.back();
              </script>";
    }
} else {
    header("location: ../manage_menu.php");
    exit;
}
?>