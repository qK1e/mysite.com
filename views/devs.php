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

        <!--filter section -->
        <div class="row border">
            <div class="col-1 d-flex justify-content-center align-items-center bg-light">
                <b>Filter</b>
            </div>
            <div class="col row">
                <form class="d-flex align-items-center mb-2 mt-2" action="/devs" method="GET" name="filter">
                    <div class="input-group d-inline-block col" id="first-name-filter">
                        <div class="input-group-prepend">
                            <label class="input-group-text" for="first-name-input">Name</label>
                        </div>
                        <textarea name="first-name" id="first-name-input" style="height: 2rem; resize: none"></textarea>
                    </div>
                    <div class="input-group d-inline-block col" id="second-name-filter">
                        <div class="input-group-prepend">
                            <label class="input-group-text" for="second-name-input">Surname</label>
                        </div>
                        <textarea name="second-name" id="second-name-input" style="height: 2rem; resize: none"></textarea>
                    </div>
                    <div class="d-inline-block col">
                        <input type="submit" value="Filter">
                    </div>
                </form>
            </div>
        </div>
        <!--filter section -->

        <div class="row">
            <div class="col-7 offset-2 container">
                <?php
                if(empty($devs))
                {?>
                    <h1 class="text-warning">No developers found:(</h1>
                    <?php
                }
                foreach ($devs as $dev){?>
                <div class="dev-preview row p-3 mt-2 border-top border-bottom">
                    <div class="col-2">
                        <img class="img-float float-right img-thumbnail dev-preview-img" src="<?php echo $dev->getProfile()->getPhoto()?>">
                    </div>
                    <div class="col-9">
                        <a href="/developer?id=<?php echo $dev->getId()?>">
                            <h3><?php echo $dev->getFullName()?></h3>
                        </a>
                        <p class="lead"><?php echo $dev->getProfile()->getAbout()?></p>
                    </div>
                </div>
                <?php }?>
            </div>
        </div>
        <!-- blog pagination -->
        <?php if(!isset($devs_page)){ $devs_page = 1;}?>
        <nav aria-label="Page navigation example" class="row m-2">
            <ul class="pagination ml-4">
                <li class="page-item"><a class="page-link  text-info" href="devs?page=<?php echo $devs_page-1?>">Previous</a></li>
                <li class="page-item"><a class="page-link  text-info" href="devs?page=<?php echo $devs_page?>"><?php echo $devs_page?></a></li>
                <li class="page-item"><a class="page-link  text-info" href="devs?page=<?php echo $devs_page+1?>"><?php echo $devs_page+1?></a></li>
                <li class="page-item"><a class="page-link  text-info" href="devs?page=<?php echo $devs_page+2?>"><?php echo $devs_page+2?></a></li>
                <li class="page-item"><a class="page-link  text-info" href="devs?page=<?php echo $devs_page+1?>">Next</a></li>
            </ul>
        </nav>
    </section>


    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>

</body>
</html>