<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Sarabun:wght@400;500;600&display=swap');

        body {
            font-family: 'Sarabun', sans-serif;
            background-color: #f4f7f6;
            padding: 40px;
        }

        /* ตกแต่งตัวตารางเดิม */
        table {
            width: 100%;
            max-width: 1000px;
            margin: 0 auto;
            border-collapse: collapse !important;
            border: none !important; /* เอาขอบเส้นดำแบบเก่าออก */
            background: #ffffff;
            box-shadow: 0 4px 12px rgba(0,0,0,0.08);
            border-radius: 10px;
            overflow: hidden;
        }

        /* ตกแต่งส่วนหัวตาราง */
        thead {
            background-color: #2c3e50;
            color: #ffffff;
        }

        th {
            padding: 16px;
            text-align: left;
            font-weight: 500;
            font-size: 1.05rem;
        }

        /* ตกแต่งเนื้อหาในตาราง */
        tr {
            border-bottom: 1px solid #eef2f5;
        }

        /* สลับสีแถวให้ดูง่าย */
        tr:nth-child(even) {
            background-color: #fafbfc;
        }

        /* ไฮไลท์ตอนเมาส์ชี้ */
        tr:hover {
            background-color: #f1f5f9;
        }

        td {
            padding: 16px;
            color: #4a5568;
            vertical-align: middle;
        }

        /* ตกแต่งรูปภาพในตาราง */
        td img {
            width: 120px !important; /* ปรับขนาดให้โมเดิร์นขึ้น */
            height: 80px;
            object-fit: cover;
            border-radius: 6px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }

        /* =================================================== */
        /* [ส่วนที่เพิ่ม] ตกแต่งปุ่ม .btn-back ให้สวยงามและโมเดิร์น   */
        /* =================================================== */
        .btn-back {
            display: block;
            width: max-content;
            margin: 30px auto 0 auto; /* จัดปุ่มให้อยู่กึ่งกลางใต้ตาราง */
            padding: 12px 28px;
            background-color: #34495e; /* สีปุ่มโทนเดียวกับหัวตาราง */
            color: #ffffff;
            text-decoration: none; /* เอาเส้นใต้ลิงก์ออก */
            border-radius: 8px;
            font-weight: 500;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            transition: all 0.2s ease-in-out; /* หน่วงเวลาเอฟเฟกต์ให้นุ่มนวล */
        }

        /* เอฟเฟกต์ตอนเอาเมาส์ไปชี้ที่ปุ่ม */
        .btn-back:hover {
            background-color: #1a252f; /* เปลี่ยนสีปุ่มให้เข้มขึ้น */
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.15); /* เพิ่มเงาให้ดูเด่น */
            transform: translateY(-2px); /* ทำให้ปุ่มลอยขึ้นมาเล็กน้อย */
        }
    </style>
    </head>
<body>
    
    <?php
//แสดง error

// Report all PHP errors
    error_reporting(E_ALL);
// Force errors to be displayed on the screen
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);

        include "action/connect.php";
// SELECT * FROM menus ดึง ทั้งหมดจากตะราง menus
        $sql = "SELECT * FROM menu_types";
//                            ที่อยู่ฐาน , คิวรี่ 
        $result = mysqli_query($con, $sql);
//      ทดสอบ
//  var_dump($result);
    ?>

    <table border=1>

        <thead>
            <th>รหัสเมนู</th>
            <th>ชื่อเมนู</th>
        </thead>

        <?php
            foreach($result as $menu_types){
                ?>
                <tr>
                    <td><?= $menu_types["type_id"] ?></td>
                    <td><?= $menu_types["type_name"] ?></td>
                </tr>
                <?php

            }
        ?>

    </table>

     <a href="index.php" class="btn-back"> ไปหน้าเมนูindex</a>

</body>
</html>