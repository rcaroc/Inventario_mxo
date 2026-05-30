<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema de Inventario - Login</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
    
    <style>
        body {
            font-family: 'Inter', sans-serif;
            /* Degradado morado como el de tu imagen */
            background: linear-gradient(180deg, #7b61ff 0%, #5a44cc 100%);
            height: 100vh;
            margin: 0;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .login-card {
            background: #ffffff;
            padding: 40px;
            border-radius: 16px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
            width: 100%;
            max-width: 420px;
        }

        .login-title {
            color: #333;
            font-weight: 700;
            font-size: 2rem;
            margin-bottom: 25px;
        }

        .form-label {
            font-weight: 600;
            color: #444;
            margin-bottom: 8px;
        }

        .form-control {
            border-radius: 8px;
            padding: 12px;
            border: 1px solid #ddd;
            background-color: #f8f9fa;
        }

        .form-control:focus {
            box-shadow: 0 0 0 3px rgba(123, 97, 255, 0.2);
            border-color: #7b61ff;
        }

        .btn-login {
            /* Verde esmeralda de tu imagen */
            background-color: #00d1b2; 
            color: white;
            font-weight: 700;
            padding: 12px;
            border-radius: 8px;
            border: none;
            font-size: 1.1rem;
            transition: all 0.3s ease;
            margin-top: 10px;
        }

        .btn-login:hover {
            background-color: #00bfa5;
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(0, 209, 178, 0.3);
        }

        /* Estilo para los mensajes de error */
        .error-text {
            color: #ff3860;
            font-size: 0.85rem;
            margin-top: 5px;
        }
    </style>
</head>
<body>

    <div class="login-card">
        <h1 class="login-title">Sistema de Inventario</h1>

        <form action="{{ route('login') }}" method="POST">
            @csrf

            <div class="mb-4">
                <label for="name" class="form-label">Usuario</label>
                <input type="text" 
                       name="name" 
                       id="name" 
                       class="form-control @error('name') is-invalid @enderror" 
                       placeholder="Administrador" 
                       value="{{ old('name') }}" 
                       required 
                       autofocus>
                @error('name')
                    <span class="error-text">{{ $message }}</span>
                @enderror
            </div>

            <div class="mb-4">
                <label for="password" class="form-label">Contraseña</label>
                <input type="password" 
                       name="password" 
                       id="password" 
                       class="form-control @error('password') is-invalid @enderror" 
                       placeholder="........" 
                       required>
                @error('password')
                    <span class="error-text">{{ $message }}</span>
                @enderror
            </div>

            <button type="submit" class="btn btn-login w-100">
                Iniciar Sesión
            </button>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>