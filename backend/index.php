<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="styles/logo.png">
    <title>TermoPhysics - Login</title>
    <style>
        @font-face {
            font-family: 'Quicksand';
            src: url('styles/quicksand/Quicksand_Book.otf') format('opentype');
            font-weight: normal;
            font-style: normal;
        }
        @import url('https://fonts.googleapis.com/css2?family=Italiana&display=swap');

        :root {
            --tar-blue: #003366;
            --gold: #FFD700;
        }

        body {
            font-family: 'Quicksand', sans-serif;
            background-color: white;
            color: var(--tar-blue);
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .container {
            display: flex;
            align-items: center;
            justify-content: space-between;
            width: 80%;
            max-width: 1200px;
        }

        .app-header {
            flex: 1;
            text-align: center;
        }

        .logo {
            width: 200px;
            height: auto;
            margin-bottom: 10px;
        }

        h1 {
            font-family: 'Italiana', serif;
            font-size: 2.5em;
            color: var(--tar-blue);
            margin-bottom: 20px;
        }

        .form-section {
            flex: 1;
            padding: 20px;
        }

        .form-section h2 {
            font-family: 'Italiana', serif;
            color: var(--tar-blue);
            margin-bottom: 20px;
        }

        form {
            display: flex;
            flex-direction: column;
        }

        label {
            margin-bottom: 5px;
            text-align: left;
        }

        input[type="email"], input[type="password"] {
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 0; /* Straight corners */
            font-family: 'Quicksand', sans-serif;
        }

        button {
            padding: 10px;
            background-color: var(--gold);
            color: var(--tar-blue);
            border: none;
            border-radius: 0; /* Straight corners */
            cursor: pointer;
            font-family: 'Quicksand', sans-serif;
            font-weight: bold;
        }

        button:hover {
            background-color: #E6C200;
        }

        /* Mobile responsiveness */
        @media (max-width: 600px) {
            body {
                padding: 20px;
                height: auto;
                min-height: 100vh;
            }

            .logo {
                width: 80px;
            }

            h1 {
                font-size: 2em;
            }

            .card {
                padding: 20px;
                max-width: 100%;
            }

            input[type="email"], input[type="password"] {
                font-size: 16px; /* Prevent zoom on iOS */
            }

            button {
                font-size: 16px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="app-header">
            <img src="styles/logo.png" alt="TermoPhysics Logo" class="logo">
            <h1>TermoPhysics</h1>
        </div>
        <div class="form-section">
            <h2>Login</h2>
            <form action="login.php" method="post">
                <label for="username">Username</label>
                <input type="text" id="username" name="username" required>

                <label for="password">Password</label>
                <input type="password" id="password" name="password" required>

                <button type="submit">Login</button>
            </form>
        </div>
    </div>
</body>
</html>
