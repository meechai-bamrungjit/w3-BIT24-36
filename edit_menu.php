<?php
session_start();

// ตรวจสอบการล็อกอิน
if (!isset($_SESSION["username"])) {
    header("location: login.php");
    exit;
}

error_reporting(E_ALL);
ini_set('display_errors', 1);

include "action/connect.php";

$id = $_GET['id'] ?? '';

// ดึงข้อมูลเมนูที่ต้องการแก้ไข
$sql = "SELECT * FROM menus WHERE menu_id = '$id'";
$result = mysqli_query($con, $sql);
$menu = mysqli_fetch_assoc($result);

if (!$menu) {
    header("location: manage_menu.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>แก้ไขรายการเมนู</title>
    
    <style>
        * {
            box-sizing: border-box;
            font-family: 'Segoe UI', system-ui, -apple-system, sans-serif;
            margin: 0;
            padding: 0;
        }

        body {
            /* ธีม Dark Cyber Glassmorphism */
            background-color: #080b11;
            background-image: 
                radial-gradient(at 15% 15%, rgba(99, 102, 241, 0.18) 0px, transparent 50%),
                radial-gradient(at 85% 85%, rgba(168, 85, 247, 0.18) 0px, transparent 50%);
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            padding: 40px 20px;
            color: #f8fafc;
        }

        /* การ์ดฟอร์ม Glassmorphism */
        .card {
            background: rgba(15, 21, 32, 0.75);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            border-radius: 20px;
            border: 1px solid rgba(255, 255, 255, 0.08);
            box-shadow: 0 30px 60px rgba(0, 0, 0, 0.7), 0 0 30px rgba(99, 102, 241, 0.1);
            padding: 40px 35px;
            max-width: 480px;
            width: 100%;
        }

        .card-header {
            text-align: center;
            margin-bottom: 28px;
        }

        .card-header h2 {
            font-size: 1.6rem;
            font-weight: 800;
            background: linear-gradient(135deg, #f59e0b 0%, #ea580c 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            margin-bottom: 6px;
        }

        .card-header p {
            color: #94a3b8;
            font-size: 0.88rem;
        }

        .card-header strong {
            color: #c084fc;
        }

        .form-group {
            margin-bottom: 20px;
        }

        label {
            display: block;
            font-weight: 600;
            color: #cbd5e1;
            margin-bottom: 8px;
            font-size: 0.9rem;
        }

        /* ช่องกรอกข้อมูล Cyber Input */
        input[type="text"],
        input[type="number"] {
            width: 100%;
            padding: 12px 16px;
            background-color: rgba(9, 13, 22, 0.7);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 10px;
            font-size: 0.95rem;
            color: #f8fafc;
            transition: all 0.3s ease;
            outline: none;
        }

        input[type="text"]:focus,
        input[type="number"]:focus {
            border-color: #f59e0b;
            background-color: rgba(9, 13, 22, 0.9);
            box-shadow: 0 0 15px rgba(245, 158, 11, 0.25);
        }

        input[readonly] {
            background-color: rgba(255, 255, 255, 0.03);
            color: #64748b;
            border-color: rgba(255, 255, 255, 0.05);
            cursor: not-allowed;
        }

        /* กรอบแสดงภาพตัวอย่าง */
        .current-img-box {
            text-align: center;
            margin-top: 10px;
            padding: 12px;
            background-color: rgba(9, 13, 22, 0.6);
            border: 1px dashed rgba(255, 255, 255, 0.15);
            border-radius: 10px;
        }

        .current-img-box img {
            max-width: 100%;
            height: 130px;
            object-fit: cover;
            border-radius: 8px;
            border: 1px solid rgba(255, 255, 255, 0.1);
        }

        .img-hint {
            font-size: 0.75rem;
            color: #64748b;
            margin-top: 6px;
        }

        /* ปุ่มบันทึกการแก้ไข */
        button[type="submit"] {
            width: 100%;
            background: linear-gradient(135deg, #f59e0b 0%, #ea580c 100%);
            color: #ffffff;
            border: none;
            padding: 14px;
            font-size: 0.95rem;
            font-weight: 700;
            border-radius: 10px;
            cursor: pointer;
            margin-top: 10px;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(245, 158, 11, 0.3);
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        button[type="submit"]:hover {
            filter: brightness(1.15);
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(245, 158, 11, 0.5);
        }

        button[type="submit"]:active {
            transform: translateY(0);
        }

        /* ลิงก์ย้อนกลับ */
        .btn-back {
            display: block;
            text-align: center;
            margin-top: 22px;
            color: #94a3b8;
            text-decoration: none;
            font-size: 0.85rem;
            font-weight: 600;
            transition: color 0.2s ease;
        }

        .btn-back:hover {
            color: #f8fafc;
        }
    </style>
</head>
<body>

    <div class="card">
        
        <div class="card-header">
            <h2>✏️ แก้ไขรายการเมนูอาหาร</h2>
            <p>ปรับปรุงข้อมูลเมนู: <strong><?= htmlspecialchars($menu['menu_name']) ?></strong></p>
        </div>

        <form action="action/update_menu.php" method="post">

            <div class="form-group">
                <label for="menu_id">🔑 รหัสเมนู</label>
                <input type="text" name="menu_id" id="menu_id" value="<?= htmlspecialchars($menu['menu_id']) ?>" readonly required>
            </div>

            <div class="form-group">
                <label for="menu_name">🍱 ชื่อเมนูอาหาร</label>
                <input type="text" name="menu_name" id="menu_name" value="<?= htmlspecialchars($menu['menu_name']) ?>" required>
            </div>

            <div class="form-group">
                <label for="menu_price">💵 ราคา (บาท)</label>
                <input type="number" step="any" name="menu_price" id="menu_price" value="<?= htmlspecialchars($menu['menu_price']) ?>" required>
            </div>

            <div class="form-group">
                <label for="menu_image">🖼️ ลิงก์รูปภาพ (Path / URL)</label>
                <input type="text" name="menu_image" id="menu_image" value="<?= htmlspecialchars($menu['menu_image']) ?>" required>
                
                <div class="current-img-box">
                    <img src="<?= htmlspecialchars($menu['menu_image']) ?>" 
                         alt="ตัวอย่างรูปภาพ"
                         onerror="this.src='https://via.placeholder.com/300x130/0f1520/818cf8?text=No+Image';">
                    <div class="img-hint">รูปภาพปัจจุบัน</div>
                </div>
            </div>

            <button type="submit">💾 บันทึกการแก้ไข</button>

        </form>

        <a href="manage_menu.php" class="btn-back">⬅️ ยกเลิก / กลับหน้าจัดการเมนู</a>

    </div>

</body>
</html>