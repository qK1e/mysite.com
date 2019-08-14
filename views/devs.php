<html>
<head>
    <title>Developers</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="/views/css/custom.css">
    <link href="https://fonts.googleapis.com/css?family=PT+Sans" rel="stylesheet">

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


    <!--Developers list -->
    <section class="content content-clr container-flex">
        <div class="row">
            <div class="col-7 offset-2 container">
                <?php
                foreach ($devs as $dev){?>
                <div class="dev-preview row p-3 mt-2 border-top border-bottom">
                    <div class="col-2">
                        <img class="img-float float-right img-thumbnail dev-preview-img" src="<?php echo $dev->getProfile()->getPhoto()?>">
                    </div>
                    <div class="col-9">
                        <h3><?php echo $dev->getFullName()?></h3>
                        <p class="lead"><?php echo $dev->getProfile()->getAbout()?></p>
                    </div>
                </div>
                <?php }?>
            </div>

            <!--Ads -->
            <div class="ads col-3 mt-5">
                <p>This could be your ads!</p>
            </div>
        </div>
    </section>


    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>

</body>
</html>