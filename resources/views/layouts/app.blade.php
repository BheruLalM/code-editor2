<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>KL Codes</title>
    <style>
        :root {
            --blue-700: #1d4ed8;
            --blue-600: #2563eb;
            --blue-100: #dbeafe;
            --slate-900: #0f172a;
            --slate-700: #334155;
            --slate-300: #cbd5e1;
            --white: #ffffff;
            --danger: #dc2626;
        }
        * { box-sizing: border-box; }
        body {
            font-family: "Segoe UI", Arial, sans-serif;
            margin: 0;
            background: linear-gradient(180deg, var(--blue-100), #eff6ff 35%, #ffffff 100%);
            color: var(--slate-900);
        }
        .container {
            max-width: 1100px;
            margin: 0 auto;
            padding: 28px 20px 40px;
        }
        .topbar {
            background: var(--white);
            border: 1px solid var(--slate-300);
            border-radius: 14px;
            padding: 16px 18px;
            margin-bottom: 18px;
            box-shadow: 0 10px 24px rgba(37, 99, 235, 0.08);
        }
        .brand { margin: 0; color: var(--blue-700); font-size: 28px; font-weight: 700; }
        .brand-sub { margin: 4px 0 0; color: var(--slate-700); font-size: 14px; }
        .card {
            background: var(--white);
            border: 1px solid var(--slate-300);
            border-radius: 14px;
            padding: 18px;
            margin-bottom: 16px;
            box-shadow: 0 8px 20px rgba(15, 23, 42, 0.05);
        }
        .btn {
            display: inline-block;
            text-decoration: none;
            background: var(--blue-600);
            color: var(--white);
            border: none;
            border-radius: 10px;
            padding: 9px 15px;
            font-weight: 600;
            cursor: pointer;
        }
        .btn:hover { background: var(--blue-700); }
        .btn-danger { background: var(--danger); }
        input, textarea, select {
            width: 100%;
            padding: 10px 11px;
            margin: 6px 0 12px;
            border: 1px solid var(--slate-300);
            border-radius: 10px;
            background: var(--white);
            color: var(--slate-900);
        }
        input:focus, textarea:focus, select:focus {
            outline: 2px solid rgba(37, 99, 235, 0.2);
            border-color: var(--blue-600);
        }
        table { border-collapse: collapse; width: 100%; background: var(--white); border-radius: 12px; overflow: hidden; }
        th, td { border: 1px solid var(--slate-300); padding: 9px; text-align: left; }
        th { background: #eff6ff; color: var(--blue-700); }
        a { color: var(--blue-700); }
        a:hover { color: var(--blue-600); }
        .error {
            color: #991b1b;
            background: #fee2e2;
            border: 1px solid #fecaca;
            border-radius: 10px;
            padding: 8px 10px;
            margin-bottom: 10px;
        }
        .ok {
            color: #065f46;
            background: #d1fae5;
            border: 1px solid #a7f3d0;
            border-radius: 10px;
            padding: 8px 10px;
            margin-bottom: 10px;
        }
        .grid-2 { display: grid; grid-template-columns: 1fr 1fr; gap: 16px; }
    </style>
</head>
<body>
    <div class="container">
        <div class="topbar">
            <h1 class="brand">KL Codes</h1>
            <p class="brand-sub">Coding Assessment Platform</p>
        </div>
        @yield('content')
    </div>
</body>
</html>
