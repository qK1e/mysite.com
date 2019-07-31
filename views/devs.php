<html>
<head>
    <title>Developers</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="views/css/custom.css">
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
            <div class="col-9 container">
                <!-- Developer preview -->
                <div class="dev-preview row p-3 ml-2 mt-2">
                    <img class="dev-preview-img rounded img-fluid img-thumbnail float-right col-3" src='https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcThi6yrm0NAd4yq1FR_uctbzRyNcZsd_CNJOvy2723qxX8zjqnlhA'>
                    <div class="col-9">
                        <h1>Имя Фамилия</h1>
                        <p class="lead">
                            Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt
                            ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco
                    </div>
                </div>
<!--                --><?php
//                foreach ($devs as $dev){?>
<!--                    <div class="developer-preview">-->
<!---->
<!--                        <h3>--><?php //echo $dev->getName()?><!--</h3>-->
<!--                        --><?php //echo $dev->getImage()?>
<!--                        <p>--><?php //echo $dev->getPreview()?><!--</p>-->
<!--                    </div>-->
<!--                --><?php //}?>
                <nav aria-label="Page navigation example">
                    <ul class="pagination">
                        <li class="page-item"><a class="page-link text-info" href="#">Previous</a></li>
                        <li class="page-item"><a class="page-link text-info" href="#">1</a></li>
                        <li class="page-item"><a class="page-link text-info" href="#">2</a></li>
                        <li class="page-item"><a class="page-link text-info" href="#">3</a></li>
                        <li class="page-item"><a class="page-link text-info" href="#">Next</a></li>
                    </ul>
                </nav>
            </div>

            <!--Ads -->
            <div class="ads col-3 mt-5">
                <p>This could be your ads!</p>
            </div>
        </div>
    </section>

</body>
</html>