<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        * {
            box-sizing: border-box;
            font-family: 'Segoe UI', system-ui, -apple-system, sans-serif;
        }

        body {
            /* พื้นหลังธีม Dark Sci-Fi / Cyber Glow ไม่ซ้ำใคร */
            background-color: #080b11;
            background-image: 
                radial-gradient(at 15% 15%, rgba(99, 102, 241, 0.18) 0px, transparent 50%),
                radial-gradient(at 85% 85%, rgba(168, 85, 247, 0.18) 0px, transparent 50%);
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            margin: 0;
        }

        form {
            /* กระจกมืด (Dark Glassmorphism) พร้อมขอบเรืองแสง */
            background: rgba(15, 21, 32, 0.75);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            padding: 44px 36px;
            border-radius: 20px;
            border: 1px solid rgba(255, 255, 255, 0.08);
            box-shadow: 
                0 30px 60px rgba(0, 0, 0, 0.7),
                0 0 35px rgba(99, 102, 241, 0.12);
            width: 100%;
            max-width: 360px;
            position: relative;
        }

        /* ข้อความหัวข้อสไตล์ไล่เฉดสีเรืองแสง */
        form::before {
            content: "AUTHENTICATION";
            display: block;
            text-align: center;
            font-size: 18px;
            font-weight: 800;
            letter-spacing: 2px;
            background: linear-gradient(135deg, #818cf8 0%, #c084fc 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            margin-bottom: 28px;
        }

        label {
            display: block;
            margin-bottom: 8px;
            font-size: 11px;
            font-weight: 700;
            color: #94a3b8;
            text-transform: uppercase;
            letter-spacing: 1.2px;
        }

        input {
            width: 100%;
            padding: 13px 40px 13px 16px;
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 10px;
            font-size: 14px;
            outline: none;
            transition: all 0.25s ease;
            background-color: rgba(9, 13, 22, 0.7);
            color: #f8fafc;
        }

        /* เมื่อกดพิมพ์ จะเกิดแสงเรืองออร่า (Neon Glow Effect) */
        input:focus {
            border-color: #818cf8;
            background-color: rgba(15, 23, 42, 0.95);
            box-shadow: 0 0 18px rgba(129, 140, 248, 0.3);
        }

        button {
            width: 100%;
            padding: 14px;
            margin-top: 28px;
            background: linear-gradient(135deg, #6366f1 0%, #a855f7 100%);
            color: #ffffff;
            border: none;
            border-radius: 10px;
            font-size: 13px;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.3s ease;
            text-transform: uppercase;
            letter-spacing: 2px;
            box-shadow: 0 8px 20px rgba(99, 102, 241, 0.35);
        }

        button:hover {
            transform: translateY(-2px);
            box-shadow: 0 12px 25px rgba(168, 85, 247, 0.5);
            filter: brightness(1.15);
        }

        button:active {
            transform: translateY(0);
        }

        br {
            display: none;
        }

        input + label {
            margin-top: 20px;
        }

        /* จัดการสไตล์ไอคอนเปิด-ปิดตา */
        .password-wrapper {
            position: relative;
            width: 100%;
        }

        .toggle-eye {
            position: absolute;
            right: 14px;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
            user-select: none;
            font-size: 15px;
            color: #64748b;
            transition: color 0.2s ease;
        }

        .toggle-eye:hover {
            color: #c084fc;
        }
    </style>
</head>
<body>

    <form action="check_login.php" method="post">

        <label for="username">username</label>
        <input type="text" id="username" name="username"> <br>

        <label for="password">password</label>
        <input type="password" id="password" name="password"> <br>

        <button>login</button>

    </form>

</body>
</html>