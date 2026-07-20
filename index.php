<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>เมนูอาหารสุดอร่อย</title>

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
            max-width: 1200px;
            margin: 0 auto;
        }

        /* หัวข้อหน้าเว็บ */
        .page-header {
            text-align: center;
            margin-bottom: 40px;
        }

        .page-header h1 {
            font-size: 2.2rem;
            color: #e74c3c;
            font-weight: 700;
        }

        .page-header p {
            color: #7f8c8d;
            font-size: 1rem;
            margin-top: 5px;
        }

        /* จัดเลย์เอาต์การ์ดอาหารด้วย CSS Grid */
        .food-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(260px, 1fr));
            gap: 25px;
        }

        /* ตัวการ์ดอาหาร */
        .food-card {
            background: #ffffff;
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.06);
            transition: all 0.3s ease;
            display: flex;
            flex-direction: column;
        }

        .food-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 12px 25px rgba(0, 0, 0, 0.12);
        }

        /* โซนรูปภาพ */
        .food-img-box {
            position: relative;
            width: 100%;
            height: 180px;
            overflow: hidden;
            background-color: #eee;
        }

        .food-img-box img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.5s ease;
        }

        .food-card:hover .food-img-box img {
            transform: scale(1.08); /* เอฟเฟกต์รูปขยายตอนเมาส์ชี้ */
        }

        /* ป้ายประเภทอาหารลอยบนรูป */
        .type-badge {
            position: absolute;
            top: 12px;
            right: 12px;
            background: rgba(0, 0, 0, 0.65);
            color: #ffffff;
            backdrop-filter: blur(4px);
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 500;
        }

        /* โซนรายละเอียดอาหาร */
        .food-details {
            padding: 20px;
            display: flex;
            flex-direction: column;
            flex-grow: 1;
        }

        .food-id {
            font-size: 0.8rem;
            color: #b2bec3;
            margin-bottom: 4px;
        }

        .food-title {
            font-size: 1.2rem;
            font-weight: 600;
            color: #2d3436;
            margin-bottom: 15px;
            line-height: 1.4;
        }

        /* โซนล่างสุดของการ์ด (ราคา + ปุ่ม) */
        .food-footer {
            margin-top: auto;
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding-top: 12px;
            border-top: 1px dashed #eef2f5;
        }

        .food-price {
            font-size: 1.35rem;
            font-weight: 700;
            color: #e67e22; /* สีส้มอาหารน่าทาน */
        }

        .btn-order {
            background-color: #e74c3c;
            color: #ffffff;
            border: none;
            padding: 8px 16px;
            border-radius: 8px;
            font-weight: 600;
            cursor: pointer;
            transition: background 0.2s ease;
            text-decoration: none;
            font-size: 0.9rem;
        }

        .btn-order:hover {
            background-color: #c0392b;
        }

        /* ปุ่มกลับ/ไปหน้าจัดการเมนู */
        .btn-back {
            display: block;
            width: max-content;
            margin: 50px auto 0 auto;
            padding: 12px 28px;
            background-color: #2c3e50;
            color: #ffffff;
            text-decoration: none;
            border-radius: 30px;
            font-weight: 500;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
            transition: all 0.3s ease;
        }

        .btn-back:hover {
            background-color: #1a252f;
            transform: translateY(-2px);
            box-shadow: 0 6px 16px rgba(0, 0, 0, 0.2);
        }
    </style>
</head>
<body>

    <?php
        // แสดง error สำหรับตรวจสอบ
        error_reporting(E_ALL);
        ini_set('display_errors', 1);
        ini_set('display_startup_errors', 1);

        include "action/connect.php";
        
        // ดึงข้อมูลทั้งหมดจากตาราง menus
        $sql = "SELECT * FROM menus";
        $result = mysqli_query($con, $sql);
    ?>

    <div class="container">
        
        <!-- Header หน้าเว็บ -->
        <div class="page-header">
            <h1>🍽️ เมนูอาหารแนะนำ</h1>
            <p>เลือกสรรความอร่อย ปรุงสดใหม่ทุกวันส่งตรงถึงคุณ</p>
        </div>

        <!-- รายการเมนูอาหารแบบ การ์ด -->
        <div class="food-grid">
            <?php foreach($result as $menu): ?>
                <div class="food-card">
                    <!-- รูปภาพ + ป้ายประเภท -->
                    <div class="food-img-box">
                        <img src="<?= $menu["menu_image"] ?>" alt="<?= $menu["menu_name"] ?>">
                        <span class="type-badge">ประเภท #<?= $menu["type_id"] ?></span>
                    </div>

                    <!-- รายละเอียดเมนู -->
                    <div class="food-details">
                        <span class="food-id">รหัสเมนู: <?= $menu["menu_id"] ?></span>
                        <h3 class="food-title"><?= $menu["menu_name"] ?></h3>
                        
                        <div class="food-footer">
                            <span class="food-price">฿<?= number_format($menu["menu_price"], 2) ?></span>
                            <a href="#" class="btn-order">🛒 สั่งซื้อ</a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

        <!-- ปุ่มไปหน้าจัดการเมนู -->
        <a href="manage_menu.php" class="btn-back">⚙️ ไปหน้าจัดการเมนู (manage_menu)</a>

    </div>

</body>
</html>