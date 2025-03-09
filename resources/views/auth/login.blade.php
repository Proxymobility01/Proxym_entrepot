<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion - Système d'Entrepôt</title>
    
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@400;500;600;700&family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        :root {
            --primary-color: #DCDC34;
            --primary-dark: #b4b42a;
            --primary-light: #ebeb79;
            --text-dark: #333333;
            --text-light: #666666;
            --background-light: #f9f9f9;
            --card-light: #ffffff;
            --error-color: #dc3545;
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Roboto', sans-serif;
            background-color: var(--background-light);
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            position: relative;
            overflow: hidden;
        }
        
        .background-shapes {
            position: absolute;
            width: 100%;
            height: 100%;
            z-index: -1;
            opacity: 0.5;
        }
        
        .shape {
            position: absolute;
            background-color: var(--primary-color);
            border-radius: 50%;
            filter: blur(60px);
        }
        
        .shape-1 {
            width: 300px;
            height: 300px;
            top: -150px;
            left: -150px;
        }
        
        .shape-2 {
            width: 400px;
            height: 400px;
            bottom: -200px;
            right: -200px;
        }
        
        .shape-3 {
            width: 200px;
            height: 200px;
            top: 50%;
            left: 60%;
            transform: translate(-50%, -50%);
        }
        
        .login-container {
            display: flex;
            background-color: var(--card-light);
            border-radius: 16px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
            width: 1000px;
            max-width: 90%;
            height: 600px;
            overflow: hidden;
            position: relative;
            z-index: 1;
        }
        
        .login-image {
            flex: 1;
            background-color: var(--primary-color);
            background-size: cover;
            background-position: center;
            position: relative;
            display: flex;
            flex-direction: column;
            justify-content: flex-end;
            padding: 40px;
            color: white;
        }
        
        .image-overlay {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(to top, rgba(0, 0, 0, 0.7), transparent);
        }
        
        .login-image-content {
            position: relative;
            z-index: 2;
        }
        
        .login-image h2 {
            font-family: 'Orbitron', sans-serif;
            font-size: 2rem;
            margin-bottom: 1rem;
        }
        
        .login-image p {
            font-size: 1rem;
            margin-bottom: 2rem;
            opacity: 0.9;
        }
        
        .login-form {
            flex: 1;
            padding: 60px;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }
        
        .login-header {
            margin-bottom: 40px;
            text-align: center;
        }
        
        .login-logo {
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 20px;
        }
        
        .login-logo img {
            height: 50px;
            margin-right: 10px;
        }
        
        .login-logo h1 {
            font-family: 'Orbitron', sans-serif;
            font-size: 1.8rem;
            color: var(--primary-color);
            margin: 0;
        }
        
        .login-title {
            font-family: 'Orbitron', sans-serif;
            font-size: 1.5rem;
            color: var(--text-dark);
            margin-bottom: 10px;
        }
        
        .login-subtitle {
            color: var(--text-light);
            font-size: 0.9rem;
        }
        
        .form-group {
            margin-bottom: 25px;
            position: relative;
        }
        
        .form-group label {
            display: block;
            font-weight: 600;
            margin-bottom: 8px;
            color: var(--text-dark);
            font-size: 0.9rem;
        }
        
        .input-with-icon {
            position: relative;
        }
        
        .input-with-icon i {
            position: absolute;
            top: 50%;
            left: 15px;
            transform: translateY(-50%);
            color: var(--text-light);
        }
        
        .form-control {
            width: 100%;
            padding: 15px 15px 15px 45px;
            border: 1px solid #e0e0e0;
            border-radius: 8px;
            font-size: 1rem;
            transition: all 0.3s ease;
            background-color: #f5f5f5;
        }
        
        .form-control:focus {
            outline: none;
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px rgba(0, 123, 255, 0.2);
            background-color: white;
        }
        
        .error-message {
            color: var(--error-color);
            font-size: 0.8rem;
            margin-top: 5px;
            display: none;
        }
        
        .password-toggle {
            position: absolute;
            top: 50%;
            right: 15px;
            transform: translateY(-50%);
            color: var(--text-light);
            cursor: pointer;
            z-index: 10;
        }
        
        .form-options {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
            font-size: 0.9rem;
        }
        
        .remember-me {
            display: flex;
            align-items: center;
            cursor: pointer;
        }
        
        .custom-checkbox {
            width: 18px;
            height: 18px;
            border: 2px solid #e0e0e0;
            border-radius: 4px;
            margin-right: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s ease;
        }
        
        .custom-checkbox i {
            color: white;
            font-size: 10px;
            visibility: hidden;
        }
        
        #remember:checked + .custom-checkbox {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
        }
        
        #remember:checked + .custom-checkbox i {
            visibility: visible;
        }
        
        #remember {
            display: none;
        }
        
        .forgot-password {
            color: var(--primary-color);
            text-decoration: none;
            font-weight: 500;
            transition: color 0.3s ease;
        }
        
        .forgot-password:hover {
            color: var(--primary-dark);
            text-decoration: underline;
        }
        
        .btn-login {
            background-color: var(--primary-color);
            color: white;
            font-weight: 600;
            padding: 15px;
            border: none;
            border-radius: 8px;
            font-size: 1rem;
            cursor: pointer;
            transition: all 0.3s ease;
            font-family: 'Roboto', sans-serif;
            letter-spacing: 0.5px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        
        .btn-login:hover {
            background-color: var(--primary-dark);
            transform: translateY(-2px);
            box-shadow: 0 6px 8px rgba(0, 0, 0, 0.15);
        }
        
        .btn-login:active {
            transform: translateY(0);
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        
        /* Notification alerts */
        .notification {
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            font-size: 0.9rem;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
            max-height: 0;
            overflow: hidden;
            opacity: 0;
        }
        
        .notification.show {
            max-height: 100px;
            opacity: 1;
            margin-bottom: 20px;
        }
        
        .notification i {
            margin-right: 10px;
            font-size: 1.2rem;
        }
        
        .notification-error {
            background-color: rgba(220, 53, 69, 0.1);
            color: var(--error-color);
            border-left: 4px solid var(--error-color);
        }
        
        .notification-success {
            background-color: rgba(40, 167, 69, 0.1);
            color: var(--success-color);
            border-left: 4px solid var(--success-color);
        }
        
        /* Loaders and animations */
        .loading .btn-login {
            color: transparent;
            position: relative;
        }
        
        .loading .btn-login::after {
            content: "";
            position: absolute;
            top: 50%;
            left: 50%;
            width: 20px;
            height: 20px;
            margin-left: -10px;
            margin-top: -10px;
            border: 2px solid transparent;
            border-top-color: white;
            border-radius: 50%;
            animation: spin 0.8s linear infinite;
        }
        
        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
        
        /* Error state */
        .form-group.error .form-control {
            border-color: var(--error-color);
            box-shadow: 0 0 0 3px rgba(220, 53, 69, 0.2);
        }
        
        .form-group.error .error-message {
            display: block;
        }
        
        /* Media Queries */
        @media (max-width: 768px) {
            .login-container {
                flex-direction: column;
                height: auto;
            }
            
            .login-image {
                display: none;
            }
            
            .login-form {
                padding: 40px 20px;
            }
        }
    </style>
</head>
<body>
    <div class="background-shapes">
        <div class="shape shape-1"></div>
        <div class="shape shape-2"></div>
        <div class="shape shape-3"></div>
    </div>
    
    <div class="login-container">
        <div class="login-image">
            <div class="image-overlay"></div>
            <div class="login-image-content">
                <h2>Système d'Entrepôt</h2>
                <p>Gérez efficacement votre inventaire et vos ressources</p>
            </div>
        </div>
        
        <div class="login-form">
            <div class="login-header">
                <div class="login-logo">
                    <i class="fas fa-warehouse" style="font-size: 32px; color: var(--primary-color);"></i>
                    <h1>EntrepôtSys</h1>
                </div>
                <h2 class="login-title">Connexion</h2>
                <p class="login-subtitle">Accédez à votre compte pour gérer votre entrepôt</p>
            </div>
            
            <div id="notification" class="notification notification-error">
                <i class="fas fa-exclamation-circle"></i>
                <span id="notification-message">Message d'erreur</span>
            </div>
            
            <form id="loginForm" action="{{ url('login') }}" method="POST">
                @csrf
                
                <div class="form-group" id="entrepotIdGroup">
                    <label for="entrepot_unique_id">ID de l'entrepôt</label>
                    <div class="input-with-icon">
                        <i class="fas fa-warehouse"></i>
                        <input type="text" id="entrepot_unique_id" name="entrepot_unique_id" class="form-control" placeholder="Entrez l'ID de votre entrepôt" required>
                    </div>
                    <p class="error-message">Veuillez entrer un ID d'entrepôt valide.</p>
                </div>
                
                <div class="form-group" id="passwordGroup">
                    <label for="password">Mot de passe</label>
                    <div class="input-with-icon">
                        <i class="fas fa-lock"></i>
                        <input type="password" id="password" name="password" class="form-control" placeholder="Votre mot de passe" required>
                        <div class="password-toggle" id="passwordToggle">
                            <i class="fas fa-eye"></i>
                        </div>
                    </div>
                    <p class="error-message">Veuillez entrer votre mot de passe.</p>
                </div>
                
                <div class="form-options">
                    <label class="remember-me">
                        <input type="checkbox" id="remember" name="remember">
                        <div class="custom-checkbox">
                            <i class="fas fa-check"></i>
                        </div>
                        Se souvenir de moi
                    </label>
                    <a href="#" class="forgot-password">Mot de passe oublié?</a>
                </div>
                
                <button type="submit" class="btn-login" id="loginBtn">Se connecter</button>
            </form>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const loginForm = document.getElementById('loginForm');
            const entrepotIdGroup = document.getElementById('entrepotIdGroup');
            const passwordGroup = document.getElementById('passwordGroup');
            const entrepotIdInput = document.getElementById('entrepot_unique_id');
            const passwordInput = document.getElementById('password');
            const passwordToggle = document.getElementById('passwordToggle');
            const loginBtn = document.getElementById('loginBtn');
            const notification = document.getElementById('notification');
            const notificationMessage = document.getElementById('notification-message');
            
            // Masquer la notification au démarrage
            notification.classList.remove('show');
            
            // Toggle password visibility
            passwordToggle.addEventListener('click', function() {
                const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
                passwordInput.setAttribute('type', type);
                
                // Toggle eye icon
                const eyeIcon = passwordToggle.querySelector('i');
                eyeIcon.classList.toggle('fa-eye');
                eyeIcon.classList.toggle('fa-eye-slash');
            });
            
            // Fonction pour afficher une notification
            function showNotification(message, type = 'error') {
                notification.classList.remove('notification-error', 'notification-success');
                notification.classList.add(type === 'error' ? 'notification-error' : 'notification-success');
                notificationMessage.textContent = message;
                notification.classList.add('show');
                
                // Masquer la notification après 5 secondes
                setTimeout(() => {
                    notification.classList.remove('show');
                }, 5000);
            }
            
            // Gérer les erreurs de validation Laravel
            @if ($errors->any())
                showNotification("{{ $errors->first() }}", 'error');
            @endif
            
            // Form validation
            loginForm.addEventListener('submit', function(e) {
                let isValid = true;
                
                // Entrepot ID validation
                if (entrepotIdInput.value.trim() === '') {
                    entrepotIdGroup.classList.add('error');
                    isValid = false;
                } else {
                    entrepotIdGroup.classList.remove('error');
                }
                
                // Password validation
                if (passwordInput.value.trim() === '') {
                    passwordGroup.classList.add('error');
                    isValid = false;
                } else {
                    passwordGroup.classList.remove('error');
                }
                
                if (!isValid) {
                    e.preventDefault();
                    showNotification('Veuillez remplir tous les champs requis.', 'error');
                } else {
                    // Add loading state
                    loginBtn.parentElement.classList.add('loading');
                }
            });
            
            // Clear error states on input
            entrepotIdInput.addEventListener('input', function() {
                entrepotIdGroup.classList.remove('error');
            });
            
            passwordInput.addEventListener('input', function() {
                passwordGroup.classList.remove('error');
            });
            
            // Add subtle animation to background shapes
            const shapes = document.querySelectorAll('.shape');
            
            shapes.forEach((shape, index) => {
                shape.style.animation = `float${index + 1} ${10 + index * 5}s ease-in-out infinite`;
            });
            
            document.styleSheets[0].insertRule(`
                @keyframes float1 {
                    0%, 100% { transform: translate(0, 0); }
                    50% { transform: translate(20px, 20px); }
                }
            `, document.styleSheets[0].cssRules.length);
            
            document.styleSheets[0].insertRule(`
                @keyframes float2 {
                    0%, 100% { transform: translate(0, 0); }
                    50% { transform: translate(-20px, -20px); }
                }
            `, document.styleSheets[0].cssRules.length);
            
            document.styleSheets[0].insertRule(`
                @keyframes float3 {
                    0%, 100% { transform: translate(-50%, -50%); }
                    50% { transform: translate(-40%, -60%); }
                }
            `, document.styleSheets[0].cssRules.length);
            
            // Traitement des messages d'erreur de l'API
            @if (session('error'))
                showNotification("{{ session('error') }}", 'error');
            @endif
            
            @if (session('success'))
                showNotification("{{ session('success') }}", 'success');
            @endif
        });
    </script>
</body>
</html>