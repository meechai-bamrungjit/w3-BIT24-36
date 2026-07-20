<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>เพิ่มรายการเมนูอาหาร</title>
    
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
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            padding: 40px 20px;
        }

        /* การ์ดฟอร์มกลางหน้าจอ */
        .card {
            background: #ffffff;
            padding: 35px 30px;
            border-radius: 16px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
            max-width: 480px;
            width: 100%;
        }

        .card-header {
            text-align: center;
            margin-bottom: 25px;
        }

        .card-header h2 {
            font-size: 1.6rem;
            color: #2c3e50;
            margin-bottom: 6px;
            font-weight: 700;
        }

        .card-header p {
            color: #7f8c8d;
            font-size: 0.9rem;
        }

        /* จัดระยะห่างแต่ละช่องกรอก */
        .form-group {
            margin-bottom: 18px;
        }

        label {
            display: block;
            font-weight: 600;
            color: #34495e;
            margin-bottom: 6px;
            font-size: 0.95rem;
        }

        /* ตกแต่ง Input และ Select */
        input[type="text"],
        input[type="number"],
        select {
            width: 100%;
            padding: 12px 14px;
            border: 1.5px solid #dcdde1;
            border-radius: 8px;
            font-size: 0.95rem;
            color: #2f3640;
            background-color: #fafafa;
            transition: all 0.3s ease;
            outline: none;
        }

        input[type="text"]:focus,
        input[type="number"]:focus,
        select:focus {
            border-color: #e74c3c;
            background-color: #ffffff;
            box-shadow: 0 0 0 3px rgba(231, 76, 60, 0.15);
        }

        /* ตกแต่งปุ่มบันทึก */
        button[type="submit"] {
            width: 100%;
            background-color: #27ae60; /* สีเขียวสำหรับบันทึก */
            color: white;
            border: none;
            padding: 13px;
            font-size: 1rem;
            font-weight: 600;
            border-radius: 8px;
            cursor: pointer;
            margin-top: 10px;
            transition: all 0.2s ease;
            box-shadow: 0 4px 10px rgba(39, 174, 96, 0.2);
        }

        button[type="submit"]:hover {
            background-color: #219150;
            transform: translateY(-1px);
        }

        button[type="submit"]:active {
            transform: translateY(0);
        }

        /* ลิงก์ย้อนกลับ */
        .btn-back {
            display: block;
            text-align: center;
            margin-top: 20px;
            color: #7f8c8d;
            text-decoration: none;
            font-size: 0.9rem;
            font-weight: 500;
            transition: color 0.2s ease;
        }

        .btn-back:hover {
            color: #2c3e50;
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
                <label for="menu_id">🔑 รหัสเมนู</label>
                <input type="text" name="menu_id" id="menu_id" placeholder="ระบุรหัส เช่น M001" required>
            </div>

            <div class="form-group">
                <label for="menu_name">🍱 ชื่อเมนูอาหาร</label>
                <input type="text" name="menu_name" id="menu_name" placeholder="ระบุชื่อเมนู" required>
            </div>

            <div class="form-group">
                <label for="menu_price">💵 ราคา (บาท)</label>
                <input type="number" step="any" name="menu_price" id="menu_price" placeholder="0.00" required>
            </div>

            <div class="form-group">
                <label for="menu_image">🖼️ ลิงก์รูปภาพ (Path / URL)</label>
                <input type="text" name="menu_image" id="menu_image" placeholder="images/food.jpg หรือลิงก์ URL" required>
            </div>

            <?php
                include "action/connect.php";
                // ดึงข้อมูลประเภทเมนูจากตาราง menu_types
                $sql = "SELECT * FROM menu_types";
                $result = mysqli_query($con, $sql);
            ?>

            <div class="form-group">
                <label for="type_id">🏷️ ประเภทเมนู</label>
                <select name="type_id" id="type_id" required>
                    <option value="" disabled selected>-- เลือกประเภทเมนู --</option>
                    <?php foreach($result as $type): ?>
                        <option value="<?= $type["type_id"] ?>">
                            <?= $type["type_name"] ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <button type="submit">💾 บันทึกข้อมูลเมนู</button>

        </form>

        <a href="manage_menu.php" class="btn-back">⬅️ กลับหน้าจัดการเมนู (manage_menu)</a>

    </div>

</body>
</html>