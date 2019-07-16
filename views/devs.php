<html>
<head>
    <title>Developers</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>
<body>
    <h1>Разрабы</h1>
    <?php
    include $_SERVER["DOCUMENT_ROOT"]."/views/assets/navigation-menu.php";
    ?>
    <?php
    //include $_SERVER["DOCUMENT_ROOT"]."/views/assets/login-block.php";
    include $login_block;
    ?>

    <div class="developers-list">
        <?php
        foreach ($devs as $dev){?>
            <div class="developer-preview">

                <h3><?php echo $dev->getName()?></h3>
                <?php echo $dev->getImage()?>
                <p><?php echo $dev->getPreview()?></p>
            </div>
        <?php }?>
    </div>

    <nav aria-label="Page navigation example">
        <ul class="pagination">
            <li class="page-item"><a class="page-link" href="#">Previous</a></li>
            <li class="page-item"><a class="page-link" href="#">1</a></li>
            <li class="page-item"><a class="page-link" href="#">2</a></li>
            <li class="page-item"><a class="page-link" href="#">3</a></li>
            <li class="page-item"><a class="page-link" href="#">Next</a></li>
        </ul>
    </nav>
</body>
</html>