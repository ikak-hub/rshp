<x-teemplate title="Login - RSHP Unair">
    
<!-- </head>
<body>
    <header class="top-nav">
        <nav>
            <img src="https://rshp.unair.ac.id/wp-content/uploads/2024/06/UNIVERSITAS-AIRLANGGA-scaled.webp" alt="Universitas Airlangga Logo" class="left-logo">
           <ul>
                <li><a href="index.html">Home</a></li>
                <li><a href="#">About</a></li>
                <li><a href="#">Services</a></li>
            </ul>
        </nav>
    </header> -->

    <div class="login-container">
        <h2>Login to RSHP UNAIR</h2>
        
        <?php if (!empty($flash_error)): ?>
            <div class="error"><?php echo $flash_error; ?></div>
        <?php endif; ?>
        
        <form method="POST" action="./Login/login_post.php">
            <div class="form-group">
                <label for="username">Username:</label>
                <input type="text" id="username" name="username" required>
            </div>
            
            <div class="form-group">
               <label for="password">Password:</label>
                <input type="password" id="password" name="password" required>
            </div>
            
            <button type="submit" class="btn-login">Login</button>
        </form>
    </div>
 <footer>
        <p>&copy; Copyright 2025 Universitas Airlangga. All Rights Reserved</p>
    </footer>
<style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }
        .login-container {
            max-width: 400px;
            margin: 100px auto;
            padding: 20px;
            background: white;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        .login-container h2 {
            text-align: center;
            margin-bottom: 10px;
            color: #2c3e50;
        }
        .form-group {
            margin-bottom: 15px;
        }
        .form-group label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }
        .form-group input {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
            box-sizing: border-box;
        }
        .btn-login {
            width: 100%;
            padding: 12px;
            background-color: #3498db;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 10px;
        }
        .btn-login:hover {
            background-color: #2980b9;
        }
		
		.top-nav nav {
			display: flex;
			justify-content: space-between;
			align-items: center;
		}
		.top-nav nav img {
			height: 50px;
		}
		.top-nav nav ul {
			list-style: none;
			margin: 0;
			padding: 0;
			display: flex;
		}
		.top-nav nav ul li {
			margin-left: 20px;
		}
		.top-nav nav ul li a {
			color: white;
			text-decoration: none;
		}
        main {
        flex-grow: 1;
        margin-bottom: 0; /* Pastikan tidak ada margin bawah pada konten utama */
        }

    footer {
        background-color: #212529;
        color: white;
        text-align: center;
        padding: 20px 0;
        width: 100%;
        margin-top: 0; /* Pastikan tidak ada margin atas pada footer */
        bottom: 0;
    }
    
    </style>
</x-teemplate>
