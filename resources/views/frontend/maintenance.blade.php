<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $setting->app_name ?? 'Starrtix' }} - Under Maintenance</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .maintenance-container {
            background: rgba(255, 255, 255, 0.95);
            border-radius: 20px;
            padding: 3rem;
            text-align: center;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
            backdrop-filter: blur(10px);
            max-width: 600px;
            width: 90%;
        }
        .maintenance-icon {
            font-size: 4rem;
            color: #667eea;
            margin-bottom: 1.5rem;
            animation: pulse 2s infinite;
        }
        @keyframes pulse {
            0% { transform: scale(1); }
            50% { transform: scale(1.1); }
            100% { transform: scale(1); }
        }
        .maintenance-title {
            color: #333;
            font-size: 2.5rem;
            font-weight: bold;
            margin-bottom: 1rem;
        }
        .maintenance-message {
            color: #666;
            font-size: 1.2rem;
            line-height: 1.6;
            margin-bottom: 2rem;
        }
        .admin-link {
            background: #667eea;
            color: white;
            padding: 0.8rem 2rem;
            border-radius: 50px;
            text-decoration: none;
            display: inline-block;
            transition: all 0.3s ease;
            font-weight: 500;
        }
        .admin-link:hover {
            background: #5a6fd8;
            color: white;
            text-decoration: none;
            transform: translateY(-2px);
        }
        .logo {
            max-height: 60px;
            margin-bottom: 1rem;
        }
    </style>
</head>
<body>
    <div class="maintenance-container">
        @if($setting->logo)
            <img src="{{ $setting->imagePath . $setting->logo }}" alt="{{ $setting->app_name }}" class="logo">
        @endif
        
        <div class="maintenance-icon">
            <i class="fas fa-tools"></i>
        </div>
        
        <h1 class="maintenance-title">We're Working on Something Amazing!</h1>
        
        <p class="maintenance-message">
            {{ $setting->maintenance_text ?? 'Our website is currently under maintenance. We are working hard to improve your experience and will be back shortly.' }}
        </p>
        
        <div class="mt-4">
            <a href="{{ url('/admin/home') }}" class="admin-link">
                <i class="fas fa-user-shield me-2"></i>
                Admin Access
            </a>
        </div>
        
        <div class="mt-4">
            <small class="text-muted">
                <i class="fas fa-clock me-1"></i>
                Please check back soon!
            </small>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
