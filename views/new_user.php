<!doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="/views/css/custom.css">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <script src="https://kit.fontawesome.com/f8e07077e5.js"></script>
    <title>New User</title>
</head>
<body>
    <!--navigation and authorization block -->
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
            <?php if(isset($search))
                include($search);
            ?>
            <div class="col justify-content-end">
                <?php //register sign-in buttons
                if(isset($login_block))
                {
                    include($login_block);
                }
                ?>
            </div>
        </div>
    </header>
    <hr class="m-0">

    <section class="container">
        <div class="row mt-2">
            <form class="col row d-flex justify-content-center p-2 pl-0 ml-0" id="user-info-form" action="new-user" method="post">
                <div id="user-info-fields" class="w-100">
                    <div class="form-group d-flex justify-content-center col-12 row">
                        <label for="username" class="col-2 d-flex justify-content-end">Username:</label>
                        <input id="username" name="username" type="text" class="col-3">
                    </div>
                    <div class="form-group d-flex justify-content-center col-12 row">
                        <label for="password" class="col-2 d-flex justify-content-end">Password:</label>
                        <input id="password" name="password" type="password" class="col-3">
                    </div>
                    <div class="form-group d-flex justify-content-center col-12 w-100 row">
                        <label for="role_select" class="col-2 d-flex justify-content-end">Role:</label>
                        <select id="role_select" name="role" class="col-3">
                            <option>Reader</option>
                            <option>Developer</option>
                            <option>Admin</option>
                        </select>
                    </div>
                </div>
                <div class="w-100">
                    <div class="form-group col-12 d-flex row justify-content-center w-100">
                        <div class="col-2 d-flex"></div>
                        <div class="col-3 d-flex justify-content-end pr-0">
                            <button class="btn btn-success" type="submit">Submit</button>
                        </div>
                    </div>
                </div>


            </form>
        </div>

    </section>

    <!--Page javascript -->
    <script src="/views/js/new_user.js"></script>
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>

    <script src="/views/js/search.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</body>
</html>