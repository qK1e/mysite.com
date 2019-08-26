<!DOCTYPE html>
<html>
<head>
    <title>Admin page</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css?family=PT+Sans" rel="stylesheet">
    <link rel="stylesheet" href="/views/css/custom.css">


    <script src="https://kit.fontawesome.com/f8e07077e5.js"></script>
</head>
<body>
    <!--Навигационное меню и блок авторизации -->
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

    <!--Admin navigation-->
    <section class="container-flex">
        <div class="row">
            <div class="col-2 mt-2 ml-2">
                <form action="admin/new-user" method="get">
                    <button type="submit" class="btn btn-outline-success">New user</button>
                </form>
            </div>
        </div>
    </section>
    <!--Admin navigation-->

    <!--users list -->
    <div class="container">

        <?php foreach ($users as $user){ ?>
        <div class="row pt-1 pb-1 border align-items-center">
            <!--user info -->
            <div class="col-1">
                <p class="user-info-item"><b>id:</b> <?php echo $user->getUserId()?></p>
            </div>
            <div class="col-2">
                <p class="user-info-item"><b>login:</b> <?php echo $user->getLogin() ?> </p>
            </div>
            <div class="col-2">
                <p class="user-info-item"><b>role:</b> <?php $role = $user->getRole(); echo $role?></p>
            </div>
            <?php if($role == ROLE_DEVELOPER || $role == ROLE_ADMIN){?>
            <div class="col-2">
                <p class="user-info-item"><b>name:</b> <?php echo $user->getFirstName() ?></p>
            </div>
            <div class="col-2">
                <p class="user-info-item"><b>surname:</b> <?php echo $user->getSecondName()?></p>
            </div>
            <?php }?>
            <!--user info-->

            <!--actions -->
            <div class="col d-flex justify-content-end">
                <div>
                    <button onclick="edit_role()">
                        <i class="fas fa-user-tag"></i>
                    </button>
                </div>

                <div>
                    <button onclick="change_visibility()">
                        <i class="fas fa-eye-slash"></i>
                    </button>
                </div>

                <div>
                    <button onclick="delete_user()">
                        <i class="fas fa-user-slash"></i>
                    </button>
                </div>
            </div>
            <!--actions -->
        </div>


        <?php
        }?>
    </div>

    <!--Modals -->
    <div class="modal" id="editUserModal">
        <div class="modal-content container">
            <div class="row">
                <h1 class="col">Edit user info</h1>
                <span class="x-close col-1" onclick="closeEditUserModal()">&times;</span>
            </div>


            <form name="user-info">
                <select>
                    <option>Reader</option>
                    <option>Developer</option>
                    <option>Admin</option>
                </select>
                <input type="submit" value="Save">
            </form>
        </div>
    </div>

    <!--Modals -->


    <script src="/views/js/admin_users.js"></script>

    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>

</body>
</html>