<html>
    <head>
        <title>Форма логина</title>
    </head>

    <body>
        <div class="login-form">
            <form action="/src/controllers/login-controller.php" method="post" name="login">
                <input name="username" type="text" placeholder="login">
                <input name="password" type="password" placeholder="password">
                <input name="submit" type="submit">
            </form>
        </div>
    </body>
</html>