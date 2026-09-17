<?php
session_start();

if (!isset($_SESSION["username"])) {
    header("location: login.php");
    exit;
}

// เชื่อมต่อฐานข้อมูล
$con = mysqli_connect("localhost", "root", "", "fruit_db");

if (!$con) {
    die("เชื่อมต่อฐานข้อมูลล้มเหลว: " . mysqli_connect_error());
}

// ดึงข้อมูลเมนูอาหารทั้งหมด
$sql = "SELECT * FROM menus";
$result = mysqli_query($con, $sql);
?>
<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - เมนูอาหาร</title>
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
            padding: 30px 20px;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
        }

        /* แถบด้านบน (Header Bar) */
        .header-bar {
            background: rgba(15, 21, 32, 0.75);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            border: 1px solid rgba(255, 255, 255, 0.08);
            border-radius: 16px;
            padding: 20px 28px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 35px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.5);
            flex-wrap: wrap;
            gap: 15px;
        }

        .welcome-text {
            font-size: 18px;
            font-weight: 700;
            background: linear-gradient(135deg, #818cf8 0%, #c084fc 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        /* กลุ่มปุ่มด้านขวา */
        .header-actions {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        /* ปุ่มจัดการเมนู สไตล์ Indigo-Purple Glass */
        .btn-manage {
            padding: 10px 18px;
            background: rgba(99, 102, 241, 0.15);
            border: 1px solid rgba(129, 140, 248, 0.4);
            color: #c084fc;
            text-decoration: none;
            border-radius: 8px;
            font-size: 12px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1px;
            transition: all 0.3s ease;
            backdrop-filter: blur(8px);
        }

        .btn-manage:hover {
            background: rgba(99, 102, 241, 0.35);
            color: #ffffff;
            box-shadow: 0 0 15px rgba(129, 140, 248, 0.4);
            transform: translateY(-2px);
        }

        /* ปุ่ม Logout สไตล์ Rose Neon */
        .btn-logout {
            padding: 10px 18px;
            background: linear-gradient(135deg, #f43f5e 0%, #e11d48 100%);
            color: #ffffff;
            text-decoration: none;
            border-radius: 8px;
            font-size: 12px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1.5px;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(244, 63, 94, 0.3);
        }

        .btn-logout:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(225, 29, 72, 0.5);
        }

        /* ตารางการ์ดเมนู (Menu Grid) */
        .food-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(260px, 1fr));
            gap: 25px;
        }

        .food-card {
            background: rgba(15, 21, 32, 0.75);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            border-radius: 16px;
            border: 1px solid rgba(255, 255, 255, 0.08);
            overflow: hidden;
            transition: all 0.3s ease;
            display: flex;
            flex-direction: column;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.5);
        }

        .food-card:hover {
            transform: translateY(-6px);
            border-color: rgba(129, 140, 248, 0.4);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.7), 0 0 25px rgba(99, 102, 241, 0.2);
        }

        .food-img-box {
            position: relative;
            width: 100%;
            height: 180px;
            background-color: rgba(9, 13, 22, 0.7);
            overflow: hidden;
        }

        .food-img-box img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.5s ease;
        }

        .food-card:hover .food-img-box img {
            transform: scale(1.08);
        }

        .type-badge {
            position: absolute;
            top: 12px;
            right: 12px;
            background: rgba(8, 11, 17, 0.8);
            color: #c084fc;
            border: 1px solid rgba(192, 132, 252, 0.3);
            backdrop-filter: blur(8px);
            padding: 4px 10px;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 600;
        }

        .food-details {
            padding: 20px;
            display: flex;
            flex-direction: column;
            flex-grow: 1;
        }

        .food-id {
            font-size: 0.75rem;
            color: #64748b;
            margin-bottom: 6px;
        }

        .food-title {
            font-size: 1.1rem;
            font-weight: 600;
            color: #f8fafc;
            margin-bottom: 15px;
        }

        .food-footer {
            margin-top: auto;
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding-top: 15px;
            border-top: 1px solid rgba(255, 255, 255, 0.08);
        }

        .food-price {
            font-size: 1.3rem;
            font-weight: 700;
            color: #34d399;
        }

        .btn-order {
            background: linear-gradient(135deg, #6366f1 0%, #a855f7 100%);
            color: #ffffff;
            text-decoration: none;
            padding: 8px 16px;
            border-radius: 8px;
            font-size: 0.85rem;
            font-weight: 700;
            transition: all 0.3s ease;
        }

        .btn-order:hover {
            filter: brightness(1.15);
            box-shadow: 0 4px 12px rgba(168, 85, 247, 0.4);
        }

        .empty-state {
            grid-column: 1 / -1;
            text-align: center;
            padding: 60px 20px;
            color: #94a3b8;
            background: rgba(15, 21, 32, 0.75);
            border-radius: 16px;
            border: 1px solid rgba(255, 255, 255, 0.08);
        }
    </style>
</head>
<body>

    <div class="container">
        <!-- Header Bar -->
        <div class="header-bar">
            <div class="welcome-text">
                👋 สวัสดีคุณ <?= htmlspecialchars($_SESSION["fname"] ?? $_SESSION["username"]) ?>
            </div>
            
            <div class="header-actions">
                <a href="manage_menu.php" class="btn-manage">⚙️ จัดการเมนู</a>
                <a href="logout.php" class="btn-logout">Logout</a>
            </div>
        </div>

        <!-- Food Grid -->
        <div class="food-grid">
            <?php if ($result && mysqli_num_rows($result) > 0): ?>
                <?php while ($menu = mysqli_fetch_assoc($result)): ?>
                    <div class="food-card">
                        <div class="food-img-box">
                            <img src="<?= htmlspecialchars($menu["menu_image"]) ?>" 
                                 alt="<?= htmlspecialchars($menu["menu_name"]) ?>" 
                                 onerror="this.src='https://via.placeholder.com/300x180/0f1520/818cf8?text=No+Image';">
                            <span class="type-badge">ประเภท #<?= htmlspecialchars($menu["type_id"]) ?></span>
                        </div>
                        <div class="food-details">
                            <span class="food-id">รหัสเมนู: #<?= htmlspecialchars($menu["menu_id"]) ?></span>
                            <h3 class="food-title"><?= htmlspecialchars($menu["menu_name"]) ?></h3>
                            <div class="food-footer">
                                <span class="food-price">฿<?= number_format($menu["menu_price"], 2) ?></span>
                                <a href="#" class="btn-order">🛒 สั่งซื้อ</a>
                            </div>
                        </div>
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <div class="empty-state">
                    ไม่พบรายการเมนูในระบบขณะนี้
                </div>
            <?php endif; ?>
        </div>
    </div>

</body>
</html>