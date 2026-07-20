<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>แก้ไขรายการเมนู</title>
    
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
            border-color: #e67e22;
            background-color: #ffffff;
            box-shadow: 0 0 0 3px rgba(230, 126, 34, 0.15);
        }

        /* ตัวอย่างรูปภาพปัจจุบัน */
        .current-img-box {
            text-align: center;
            margin-top: 8px;
            padding: 10px;
            background-color: #f1f2f6;
            border-radius: 8px;
        }

        .current-img-box img {
            max-width: 100%;
            height: 120px;
            object-fit: cover;
            border-radius: 6px;
            box-shadow: 0 2px 6px rgba(0,0,0,0.1);
        }

        .img-hint {
            font-size: 0.8rem;
            color: #7f8c8d;
            margin-top: 4px;
        }

        /* ตกแต่งปุ่มบันทึกการแก้ไข */
        button[type="submit"] {
            width: 100%;
            background-color: #e67e22; /* สีส้มอมน้ำตาลสำหรับโหมดแก้ไข */
            color: white;
            border: none;
            padding: 13px;
            font-size: 1rem;
            font-weight: 600;
            border-radius: 8px;
            cursor: pointer;
            margin-top: 10px;
            transition: all 0.2s ease;
            box-shadow: 0 4px 10px rgba(230, 126, 34, 0.25);
        }

        button[type="submit"]:hover {
            background-color: #d35400;
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

    <?php
        $id = $_GET['id'];

        include "action/connect.php";
        
        $sql = "SELECT * FROM menus WHERE menu_id = '$id' ";
        $result = mysqli_query($con, $sql);
        $menu = mysqli_fetch_assoc($result);
    ?>

    <div class="card">
        
        <div class="card-header">
            <h2>✏️ แก้ไขรายการเมนูอาหาร</h2>
            <p>ปรับปรุงข้อมูลเมนู: <strong><?= $menu['menu_name'] ?></strong></p>
        </div>

        <form action="action/update_menu.php" method="post">

            <div class="form-group">
                <label for="menu_id">🔑 รหัสเมนู</label>
                <input type="text" name="menu_id" id="menu_id" value="<?= $menu['menu_id'] ?>" required>
            </div>

            <div class="form-group">
                <label for="menu_name">🍱 ชื่อเมนูอาหาร</label>
                <input type="text" name="menu_name" id="menu_name" value="<?= $menu['menu_name'] ?>" required>
            </div>

            <div class="form-group">
                <label for="menu_price">💵 ราคา (บาท)</label>
                <input type="number" step="any" name="menu_price" id="menu_price" value="<?= $menu['menu_price'] ?>" required>
            </div>

            <div class="form-group">
                <label for="menu_image">🖼️ ลิงก์รูปภาพ (Path / URL)</label>
                <input type="text" name="menu_image" id="menu_image" value="<?= $menu['menu_image'] ?>" required>
                
                <!-- แสดงตัวอย่างรูปภาพเดิม -->
                <div class="current-img-box">
                    <img src="<?= $menu['menu_image'] ?>" alt="ตัวอย่างรูปภาพ">
                    <div class="img-hint">รูปภาพปัจจุบัน</div>
                </div>
            </div>

            <?php
                include "action/connect.php";
                $sql = "SELECT * FROM menu_types";
                $result = mysqli_query($con, $sql);
            ?>

            <div class="form-group">
                <label for="type_id">🏷️ ประเภทเมนู</label>
                <select name="type_id" id="type_id" required>
                    <?php foreach($result as $type): ?>
                        <option value="<?= $type["type_id"] ?>" <?= $type["type_id"] == $menu["type_id"] ? "selected" : ''?>>
                            <?= $type["type_name"] ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <button type="submit">💾 บันทึกการแก้ไข</button>

        </form>

        <a href="manage_menu.php" class="btn-back">⬅️ ยกเลิก / กลับหน้าจัดการเมนู</a>

    </div>

</body>
</html>