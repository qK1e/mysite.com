<html>
<head>
    <title>My profile</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="/views/css/custom.css">
    <link href="https://fonts.googleapis.com/css?family=PT+Sans" rel="stylesheet">
    <script src="https://kit.fontawesome.com/f8e07077e5.js"></script>
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
<!--navigation and authorization block -->

<?php if(!isset($error)){
    $profile = $developer->getProfile(); ?>
    <!-- Profile -->
    <div class="profile container mt-3">
        <div class="profile__header row w-100 justify-content-center">
            <div class="profile__image-container col-sm-12 col-lg-3 mb-3">
                <img src="<?php echo $profile->getPhoto()?>" class="profile__avatar" id="photo" alt="Pretty face:)" >
            </div>
            <div class="profile__info col">
                <h1 class="profile__dev-name"><?php echo $developer->getFullName() ?></h1>
                <p id="about" class="profile__about"><?php echo $profile->getAbout() ?></p>
            </div>
        </div>
    </div>
    <!-- Profile -->
<?php }
else{ ?>
    <div class="container">
        <h1 class="text-warning mt-4 text-center"><?php echo $error?></h1>
    </div>
<?php } ?>






<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>

<script src="/views/js/search.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</body>
</html>