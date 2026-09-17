<?php
session_start();

// ป้องกันการเข้าถึงโดยไม่ได้ล็อกอิน
if (!isset($_SESSION["username"])) {
    header("location: login.php");
    exit;
}

error_reporting(E_ALL);
ini_set('display_errors', 1);
?>
<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>เพิ่มรายการเมนูอาหาร</title>
    
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
            box-shadow: 0 30px 60px rgba(0, 0, 0, 0.7), 0 0 30px rgba(16, 185, 129, 0.1);
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
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            margin-bottom: 6px;
        }

        .card-header p {
            color: #94a3b8;
            font-size: 0.88rem;
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
            border-color: #10b981;
            background-color: rgba(9, 13, 22, 0.9);
            box-shadow: 0 0 15px rgba(16, 185, 129, 0.25);
        }

        /* ปุ่มบันทึกข้อมูล (Green Emerald Glow) */
        button[type="submit"] {
            width: 100%;
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
            color: #ffffff;
            border: none;
            padding: 14px;
            font-size: 0.95rem;
            font-weight: 700;
            border-radius: 10px;
            cursor: pointer;
            margin-top: 10px;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(16, 185, 129, 0.3);
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        button[type="submit"]:hover {
            filter: brightness(1.15);
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(16, 185, 129, 0.5);
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
            <h2>➕ เพิ่มรายการเมนูอาหาร</h2>
            <p>กรอกข้อมูลรายละเอียดเมนูเพื่อบันทึกลงในระบบ</p>
        </div>

        <form action="action/insert_menu.php" method="post">

            <div class="form-group">
                <label for="menu_name">🍱 ชื่อเมนูอาหาร</label>
                <input type="text" name="menu_name" id="menu_name" placeholder="เช่น ผัดไทยกุ้งสด" required>
            </div>

            <div class="form-group">
                <label for="menu_price">💵 ราคา (บาท)</label>
                <input type="number" step="any" name="menu_price" id="menu_price" placeholder="0.00" required>
            </div>

            <div class="form-group">
                <label for="menu_image">🖼️ ลิงก์รูปภาพ (Path / URL)</label>
                <input type="text" name="menu_image" id="menu_image" placeholder="images/food.jpg หรือลิงก์ URL" required>
            </div>

            <button type="submit">💾 บันทึกข้อมูลเมนู</button>

        </form>

        <a href="manage_menu.php" class="btn-back">⬅️ ยกเลิก / กลับหน้าจัดการเมนู</a>

    </div>

</body>
</html>