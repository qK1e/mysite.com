<html>
    <head>
        <title>Login</title>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
        <link rel="stylesheet" href="/views/css/custom.css">
        <link href="https://fonts.googleapis.com/css?family=PT+Sans" rel="stylesheet">
    </head>

    <body>

    <header class="container-fluid hdr-clr">
        <div class="row align-items-center">
            <div class="col">
                <?php //navigation block
                if(isset($nav_block))
                {
                    include($nav_block);
                }
                ;
                ?>
            </div>
        </div>
    </header>
    <hr class="m-0">


        <div class="container">
            <div class="row justify-content-center align-items-center">
                <div class="login-form col-3">
                    <form action="sign-in" method="post" name="login">
                        <h1>Sign In</h1>
                        <div class="form-group">
                            <label>Your login:</label>
                            <input class="pl-1" name="username" type="text" placeholder="login"><br>
                        </div>

                        <div class="form-group">
                            <label>Your password:</label>
                            <input class="pl-1" name="password" type="password" placeholder="password"><br>
                        </div>
                        <input class="btn btn-primary" name="sign-in" type="submit">
                    </form>
                </div>
            </div>
        </div>




        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    </body>
</html>