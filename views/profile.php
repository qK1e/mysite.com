<html>
<head>
    <title>My profile</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="views/css/custom.css">
    <link href="https://fonts.googleapis.com/css?family=PT+Sans" rel="stylesheet">
    <script src="https://kit.fontawesome.com/f8e07077e5.js"></script>
</head>

<body>
    <!--Navigation and authorization block-->
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
    <!--Navigation and authorization block-->


    <?php $profile = $developer->getProfile() ?>
    <!--Profile-->
    <div class="container-flex mt-3">
        <form name="profile-info" action="/profile" id="profile-info" method="post" enctype="multipart/form-data">
            <input name="profile-id" form="profile-info" value="<?php echo $developer->getProfileId() ?>" type="hidden">
            <input name="developer-id" form="profile-info" value="<?php echo $developer->getId() ?>" type="hidden">
            <div class="profile-content row">
                <div class="image-container d-flex justify-content-center col-3">
                    <img src="<?php echo $profile->getPhoto()?>" class="avatar" id="photo" alt="Pretty face:)" >
                    <label for="photo-input" class="edit-photo-button">
                        <i class="fas fa-pen-square"></i>
                    </label>
                    <input type="file" accept="image/*" class="hidden" name="photo" id="photo-input" onchange="displayPhoto(this.files)">
                </div>
                <div class="col">
                    <textarea form="profile-info" name="full-name" class="dev-name h1 d-block hidden-textarea"><?php echo $developer->getFullName() ?></textarea>
                    <textarea form="profile-info" name="about" class="p d-block w-75 hidden-textarea"><?php echo $profile->getAbout() ?></textarea>
                    <input form="profile-info" name="submit" type="submit" class="d-block" value="Save"/>
                </div>


            </div>
        </form>
    </div>

    <!--Profile-->

    <!--Page javascript -->
    <script src="/views/js/edit_photo.js"></script>

    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</body>
</html>