<html>
<head>
    <title>My profile</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="views/css/custom.css">
    <link href="https://fonts.googleapis.com/css?family=PT+Sans" rel="stylesheet">
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



    <?php $profile = $developer->getProfile() ?>
    <form name="profile-info" action="/profile" id="profile-info" method="post" enctype="multipart/form-data">
        <input name="profile-id" form="profile-info" value="<?php echo $developer->getProfileId() ?>" type="hidden">
        <input name="developer-id" form="profile-info" value="<?php echo $developer->getId() ?>" type="hidden">
        <div class="profile-content">
            <div class="image-container">
                <img src="<?php echo $profile->getPhoto()?>" class="avatar" id="photo" alt="Pretty face:)" >
                <label for="photo-input" class="edit-photo-button"><i class="fas fa-pen-square "></i></label>
                <input type="file" accept="image/*" class="hidden" name="photo" id="photo-input" onchange="displayPhoto(this.files)">
            </div>
            <textarea form="profile-info" name="full-name" class="dev-name" wrap="off"><?php echo $developer->getFullName() ?></textarea>

            <h2>About</h2>
            <textarea form="profile-info" name="about"><?php echo $profile->getAbout() ?></textarea>
            <input form="profile-info" name="submit" type="submit" value="Save"/>
        </div>
    </form>

    <!--Page javascript -->
    <script src="/views/js/edit_photo.js"></script>

    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</body>
</html>