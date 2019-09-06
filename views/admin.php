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
    <!--Navigation and authorization -->
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
    <!--Navigation and authorization -->

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

    <!--filter section -->
    <div class="container-flex row border mt-2">
        <div class="col-1 d-flex justify-content-center align-items-center bg-light">
            <b>Filter</b>
        </div>
        <div class="col">
            <form class="d-flex align-items-center mb-2 mt-2 row" action="/admin" method="GET" name="filter">
                <div class="input-group d-flex col" id="role-filter">
                    <span class="input-group-prepend" style="height: 2.5rem">
                        <label class="input-group-text" for="role-input">Role</label>
                    </span>
                    <select class="form-control custom-select" style="height: 2.5rem">
                        <option>
                            <p>any</p>
                        </option>
                        <option>
                            <p><?php echo ROLE_READER ?></p>
                        </option>
                        <option>
                            <p><?php echo ROLE_DEVELOPER ?></p>
                        </option>
                        <option>
                            <p><?php echo ROLE_ADMIN ?></p>

                        </option>
                    </select>
                </div>
                <div class="input-group d-flex col" id="username-filter">
                    <span class="input-group-prepend" style="height: 2.5rem">
                        <label class="input-group-text" for="username-input">Username</label>
                    </span>
                    <textarea class="form-control" name="username" id="username-input" style="height: 2.5rem; resize: none"></textarea>
                </div>
                <div class="input-group d-flex col" id="first-name-filter">
                    <span class="input-group-prepend" style="height: 2.5rem">
                        <label class="input-group-text" for="first-name-input">Name</label>
                    </span>
                    <textarea class="form-control" name="first-name" id="first-name-input" style="height: 2.5rem; resize: none"></textarea>
                </div>

                <div class="input-group d-flex col" id="second-name-filter">
                    <span class="input-group-prepend" style="height: 2.5rem">
                        <label class="input-group-text" for="second-name-input">Surname</label>
                    </span>
                    <textarea class="form-control" name="second-name" id="second-name-input" style="height: 2.5rem; resize: none"></textarea>
                </div>

                <div class="d-flex col">
                    <input type="submit" value="Filter">
                </div>
            </form>
        </div>
    </div>
    <!--filter section -->

    <!--users list-->
    <div class="container">

        <?php foreach ($users as $user){ ?>
        <div class="row pt-1 pb-1 border align-items-center user-container" id="user-<?php echo $user->getUserId()?>">
            <!--user info-->
            <div class="col-1" id="user_id">
                <p class="user-info-item"><b>id:</b> <span class="id"><?php echo $user->getUserId()?></span> </p>
            </div>
            <div class="col-2" id="login">
                <p class="user-info-item"><b>login:</b> <span class="login"> <?php echo $user->getLogin() ?>  </span> </p>
            </div>
            <div class="col-2" id="role">
                <p class="user-info-item"><b>role:</b> <span class="role">  <?php $role = $user->getRole(); echo $role?> </span></p>
            </div>
            <?php if($role == ROLE_DEVELOPER || $role == ROLE_ADMIN){?>
            <div class="col-2" id="name">
                <p class="user-info-item"><b>name:</b> <span class="name">  <?php echo $user->getFirstName() ?> </span></p>
            </div>
            <div class="col-2" id="surname">
                <p class="user-info-item"><b>surname:</b><span class="surname"> <?php echo $user->getSecondName()?> </span> </p>
            </div>
            <?php }?>
            <!--user info-->

            <!--actions -->
            <div class="col d-flex justify-content-end">
                <div>
                    <button class="edit-user-button btn btn-outline-dark" id="edit-user-button">
                        <i class="fas fa-user-tag"></i>
                    </button>
                </div>

                <div>
                    <?php if($role == ROLE_DEVELOPER || $role == ROLE_ADMIN){ ?>
                    <button class="change-visibility-button btn btn-outline-dark" id="change-visibility-button">

                        <?php $visible = $user->isVisible(); ?>

                        <?php if($visible){?>
                        <i class="fas fa-eye" ></i>
                        <?php }
                        else {?>
                        <i class="fas fa-eye-slash" ></i>
                        <?php }?>
                    </button>
                    <?php } ?>
                </div>

                <div>
                    <button class="delete-user-button btn btn-outline-dark" id="delete-user-button">
                        <i class="fas fa-user-slash"></i>
                    </button>
                </div>
            </div>
            <!--actions -->
        </div>
        <?php }?>
    </div>

    <!--Modals -->
    <div class="modal" id="editUserModal">
        <div class="modal-content container">
            <div class="row">
                <h1 class="col">Edit user info</h1>
                <span class="x-close col-1 close-user-edit" id="close-user-edit">&times;</span>
            </div>


            <form action="" name="user-info" method="post">
                <input name="user-id" id="edited-user-id" type="hidden">
                <select name="role" id="edited-user-role">
                    <option selected value="reader">Reader</option>
                    <option value="developer">Developer</option>
                    <option value="admin">Admin</option>
                </select>
                <input type="button" value="Save" id="save-user-info-button">
            </form>
        </div>
    </div>

    <!--Modals -->




    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
    <script src="/views/js/admin_users.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>

</body>
</html>