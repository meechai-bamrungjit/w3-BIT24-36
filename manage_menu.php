<?php
session_start();

// ป้องกันการเข้าถึงโดยไม่ได้ล็อกอิน
if (!isset($_SESSION["username"])) {
    header("location: login.php");
    exit;
}

error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);

include "action/connect.php";

$sql = "SELECT * FROM menus";
$result = mysqli_query($con, $sql);
?>
<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ระบบจัดการเมนูอาหาร</title>
    
    <style>
        * {
            box-sizing: border-box;
            font-family: 'Segoe UI', system-ui, -apple-system, sans-serif;
            margin: 0;
            padding: 0;
        }

        body {
            /* ธีม Dark Cyber / Glassmorphism */
            background-color: #080b11;
            background-image: 
                radial-gradient(at 15% 15%, rgba(99, 102, 241, 0.18) 0px, transparent 50%),
                radial-gradient(at 85% 85%, rgba(168, 85, 247, 0.18) 0px, transparent 50%);
            min-height: 100vh;
            color: #f8fafc;
            padding: 40px 20px;
            display: flex;
            flex-direction: column;
        }

        .container {
            max-width: 1100px;
            margin: 0 auto;
            width: 100%;
            flex-grow: 1;
        }

        /* ส่วนหัว Admin Header (Glassmorphism) */
        .admin-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
            background: rgba(15, 21, 32, 0.75);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            padding: 24px 30px;
            border-radius: 20px;
            border: 1px solid rgba(255, 255, 255, 0.08);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.6), 0 0 30px rgba(99, 102, 241, 0.1);
            flex-wrap: wrap;
            gap: 15px;
        }

        .admin-title h2 {
            font-size: 1.6rem;
            font-weight: 800;
            background: linear-gradient(135deg, #818cf8 0%, #c084fc 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            letter-spacing: 0.5px;
        }

        .admin-title p {
            color: #94a3b8;
            font-size: 0.85rem;
            margin-top: 4px;
        }

        /* ปุ่มกดด้านขวาบน */
        .header-actions {
            display: flex;
            gap: 12px;
            align-items: center;
        }

        /* ปุ่มกลับหน้าหลัก */
        .btn-index {
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.1);
            color: #f8fafc;
            text-decoration: none;
            padding: 10px 18px;
            border-radius: 10px;
            font-size: 0.85rem;
            font-weight: 700;
            transition: all 0.3s ease;
        }

        .btn-index:hover {
            background: rgba(255, 255, 255, 0.15);
            transform: translateY(-2px);
        }

        /* ปุ่มเพิ่มเมนูอาหาร (Green Emerald Glow) */
        .btn-add {
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
            color: #ffffff;
            text-decoration: none;
            padding: 10px 20px;
            border-radius: 10px;
            font-size: 0.85rem;
            font-weight: 700;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(16, 185, 129, 0.3);
        }

        .btn-add:hover {
            filter: brightness(1.15);
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(16, 185, 129, 0.5);
        }

        /* ตารางข้อมูลแบบ Dark Card */
        .table-card {
            background: rgba(15, 21, 32, 0.75);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            border-radius: 20px;
            border: 1px solid rgba(255, 255, 255, 0.08);
            box-shadow: 0 30px 60px rgba(0, 0, 0, 0.7);
            overflow: hidden;
        }

        .table-responsive {
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            text-align: left;
        }

        thead {
            background-color: rgba(9, 13, 22, 0.8);
            border-bottom: 1px solid rgba(255, 255, 255, 0.08);
        }

        th {
            padding: 18px 22px;
            font-weight: 700;
            font-size: 0.85rem;
            color: #818cf8;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        td {
            padding: 16px 22px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.05);
            vertical-align: middle;
            color: #cbd5e1;
            font-size: 0.95rem;
        }

        tr:last-child td {
            border-bottom: none;
        }

        tr:hover td {
            background-color: rgba(99, 102, 241, 0.04);
        }

        /* ภาพเมนูในตาราง */
        .menu-thumb {
            width: 70px;
            height: 50px;
            object-fit: cover;
            border-radius: 8px;
            border: 1px solid rgba(255, 255, 255, 0.1);
            background-color: rgba(9, 13, 22, 0.7);
        }

        .price-text {
            font-weight: 700;
            color: #34d399;
            font-size: 1.05rem;
        }

        /* ปุ่มจัดการ (แก้ไข / ลบ) */
        .action-btns {
            display: flex;
            gap: 8px;
            justify-content: center;
        }

        .btn-edit {
            background: rgba(99, 102, 241, 0.15);
            border: 1px solid rgba(129, 140, 248, 0.4);
            color: #818cf8;
            text-decoration: none;
            padding: 8px 14px;
            border-radius: 8px;
            font-size: 0.8rem;
            font-weight: 600;
            transition: all 0.2s ease;
        }

        .btn-edit:hover {
            background: rgba(99, 102, 241, 0.35);
            color: #ffffff;
            box-shadow: 0 0 12px rgba(129, 140, 248, 0.4);
        }

        .btn-delete {
            background: rgba(244, 63, 94, 0.15);
            border: 1px solid rgba(244, 63, 94, 0.4);
            color: #f43f5e;
            text-decoration: none;
            padding: 8px 14px;
            border-radius: 8px;
            font-size: 0.8rem;
            font-weight: 600;
            transition: all 0.2s ease;
        }

        .btn-delete:hover {
            background: linear-gradient(135deg, #f43f5e 0%, #e11d48 100%);
            color: #ffffff;
            box-shadow: 0 0 12px rgba(244, 63, 94, 0.5);
        }

        footer {
            margin-top: 50px;
            text-align: center;
            padding: 20px;
            font-size: 0.85rem;
            color: #64748b;
            border-top: 1px solid rgba(255, 255, 255, 0.05);
        }
    </style>
</head>
<body>

<div class="container">

    <!-- ส่วนหัว Admin Header -->
    <div class="admin-header">
        <div class="admin-title">
            <h2>⚙️ ระบบจัดการเมนูอาหาร</h2>
            <p>เพิ่ม แก้ไข หรือลบรายการอาหารในระบบ</p>
        </div>
        
        <!-- กลุ่มปุ่มกดด้านขวาบน -->
        <div class="header-actions">
            <a href="index.php" class="btn-index">🏪 หน้าหลัก (index)</a>
            <a href="add_menu.php" class="btn-add">➕ เพิ่มเมนูอาหาร</a>
        </div>
    </div>

    <!-- ตารางรายการเมนู -->
    <div class="table-card">
        <div class="table-responsive">
            <table>
                <thead>
                    <tr>
                        <th>รหัสเมนู</th>
                        <th>ภาพ</th>
                        <th>ชื่อเมนู</th>
                        <th>ราคา</th>
                        <th style="text-align: center;">จัดการ</th>
                    </tr>
                </thead>
                <tbody>
                <?php if ($result && mysqli_num_rows($result) > 0): ?>
                    <?php while ($menu = mysqli_fetch_assoc($result)): ?>
                        <tr>
                            <td><strong style="color: #f8fafc;">#<?= htmlspecialchars($menu["menu_id"]) ?></strong></td>
                            <td>
                                <img src="<?= htmlspecialchars($menu["menu_image"]) ?>" 
                                     alt="<?= htmlspecialchars($menu["menu_name"]) ?>" 
                                     class="menu-thumb"
                                     onerror="this.src='https://via.placeholder.com/70x50/0f1520/818cf8?text=No+Img';">
                            </td>
                            <td style="font-weight: 600; color: #f8fafc;"><?= htmlspecialchars($menu["menu_name"]) ?></td>
                            <td class="price-text">฿<?= number_format($menu["menu_price"], 2) ?></td>
                            <td>
                                <div class="action-btns">
                                    <a href="edit_menu.php?id=<?= $menu["menu_id"] ?>" class="btn-edit">✏️ แก้ไข</a>
                                    <a href="action/delete_menu.php?id=<?= $menu["menu_id"] ?>" class="btn-delete" onclick="return confirm('คุณแน่ใจหรือไม่ว่าต้องการลบเมนูนี้?');">🗑️ ลบ</a>
                                </div>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="5" style="text-align: center; padding: 40px; color: #64748b;">
                            ยังไม่มีรายการเมนูในระบบ
                        </td>
                    </tr>
                <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

</div>

<!-- ส่วน Footer ท้ายเว็บ -->
<footer>
    <p>&copy; เมนูอาหารสุดอร่อย - All Rights Reserved Meechai Bamringjit BIT2/4 36</p>
</footer>

</body>
</html>