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
        <div class="search col">
            <div class="search__search-icon">
                <i class="fas fa-search text-info"></i>
            </div>
            <div class="search__input">
                <form class="search__form" action="/search" method="get" id="search-form">
                    <textarea class="search__textarea" rows="1" wrap="hard" name="search-text"></textarea>
                </form>
            </div>
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


<!--Page javascript -->

<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</body>
</html>
