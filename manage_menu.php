<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ระบบจัดการเมนูอาหาร</title>
    
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Sarabun:wght@400;500;600;700&display=swap');

        * {
            box-sizing: border-box;
            font-family: 'Sarabun', sans-serif;
            margin: 0;
            padding: 0;
        }

        body {
            background-color: #f8f9fa;
            color: #2d3436;
            padding: 40px 20px;
        }

        .container {
            max-width: 1050px;
            margin: 0 auto;
        }

        /* ส่วนหัว + ปุ่มเพิ่มเมนู */
        .admin-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 25px;
            background: #ffffff;
            padding: 20px 25px;
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
        }

        .admin-title h2 {
            font-size: 1.5rem;
            color: #2c3e50;
            font-weight: 700;
        }

        .admin-title p {
            color: #7f8c8d;
            font-size: 0.85rem;
            margin-top: 2px;
        }

        /* ปุ่มเพิ่มเมนูอาหาร */
        .btn-add {
            background-color: #27ae60;
            color: #ffffff;
            text-decoration: none;
            padding: 10px 20px;
            border-radius: 8px;
            font-weight: 600;
            font-size: 0.95rem;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            transition: all 0.2s ease;
            box-shadow: 0 4px 10px rgba(39, 174, 96, 0.2);
        }

        .btn-add:hover {
            background-color: #219150;
            transform: translateY(-1px);
        }

        /* ตารางข้อมูลแบบ Admin Dashboard */
        .table-card {
            background: #ffffff;
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
            overflow: hidden;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            text-align: left;
        }

        thead {
            background-color: #2c3e50;
            color: #ffffff;
        }

        th {
            padding: 16px 20px;
            font-weight: 600;
            font-size: 0.95rem;
            letter-spacing: 0.3px;
        }

        td {
            padding: 14px 20px;
            border-bottom: 1px solid #f1f2f6;
            vertical-align: middle;
            color: #2f3640;
            font-size: 0.95rem;
        }

        tr:last-child td {
            border-bottom: none;
        }

        tr:hover {
            background-color: #f8f9fa;
        }

        /* ภาพเมนูในตาราง */
        .menu-thumb {
            width: 70px;
            height: 50px;
            object-fit: cover;
            border-radius: 6px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }

        /* Badge แสดงประเภท */
        .badge-type {
            background-color: #e1b12c;
            color: #ffffff;
            padding: 4px 10px;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 600;
            display: inline-block;
        }

        .price-text {
            font-weight: 700;
            color: #e67e22;
        }

        /* ปุ่มจัดการ (แก้ไข / ลบ) */
        .action-btns {
            display: flex;
            gap: 8px;
            justify-content: center;
        }

        .btn-edit {
            background-color: #3498db;
            color: #ffffff;
            text-decoration: none;
            padding: 6px 14px;
            border-radius: 6px;
            font-size: 0.85rem;
            font-weight: 500;
            transition: background 0.2s;
        }

        .btn-edit:hover {
            background-color: #2980b9;
        }

        .btn-delete {
            background-color: #e74c3c;
            color: #ffffff;
            text-decoration: none;
            padding: 6px 14px;
            border-radius: 6px;
            font-size: 0.85rem;
            font-weight: 500;
            transition: background 0.2s;
        }

        .btn-delete:hover {
            background-color: #c0392b;
        }

        /* ลิงก์ไปหน้าเมนูฝั่งลูกค้า */
        .btn-view-store {
            display: block;
            width: max-content;
            margin: 30px auto 0 auto;
            color: #7f8c8d;
            text-decoration: none;
            font-size: 0.95rem;
            font-weight: 500;
            transition: color 0.2s;
        }

        .btn-view-store:hover {
            color: #2c3e50;
        }
    </style>
</head>
<body>

<?php
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);

    include "action/connect.php";

    $sql = "SELECT * FROM menus";
    $result = mysqli_query($con, $sql);
?>

<div class="container">

    <!-- ส่วนหัว Admin Header -->
    <div class="admin-header">
        <div class="admin-title">
            <h2>⚙️ ระบบจัดการเมนูอาหาร</h2>
            <p>เพิ่ม แก้ไข หรือลบรายการอาหารในระบบ</p>
        </div>
        <a href="add_menu.php" class="btn-add">➕ เพิ่มเมนูอาหาร</a>
    </div>

    <!-- ตารางรายการเมนู -->
    <div class="table-card">
        <table>
            <thead>
                <tr>
                    <th>รหัสเมนู</th>
                    <th>ภาพ</th>
                    <th>ชื่อเมนู</th>
                    <th>ราคา</th>
                    <th>ประเภท</th>
                    <th style="text-align: center;">จัดการ</th>
                </tr>
            </thead>
            <tbody>
            <?php foreach($result as $menu): ?>
                <tr>
                    <td><strong><?= $menu["menu_id"] ?></strong></td>
                    <td>
                        <img src="<?= $menu["menu_image"] ?>" alt="<?= $menu["menu_name"] ?>" class="menu-thumb">
                    </td>
                    <td><?= $menu["menu_name"] ?></td>
                    <td class="price-text">฿<?= number_format($menu["menu_price"], 2) ?></td>
                    <td><span class="badge-type">ประเภท #<?= $menu["type_id"] ?></span></td>
                    <td>
                        <div class="action-btns">
                            <a href="edit_menu.php?id=<?=$menu["menu_id"]?>" class="btn-edit">✏️ แก้ไข</a>
                            <a href="action/delete_menu.php?id=<?=$menu["menu_id"]?>" class="btn-delete" onclick="return confirm('คุณแน่ใจหรือไม่ว่าต้องการลบเมนูนี้?');">🗑️ ลบ</a>
                        </div>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <!-- ลิงก์กลับไปดูหน้าร้านฝั่งลูกค้า -->
    <a href="index.php" class="btn-view-store">🏪 ไปยังหน้าแสดงเมนูอาหาร (ฝั่งลูกค้า)</a>

</div>

</body>
</html>