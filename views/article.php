<html>
    <head>
        <title>Blog</title>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    </head>
    <body>
        <?php //navigation block
        if(isset($nav_block))
        {
            include($nav_block);
        }
        ;
        ?>

        <?php //register sign-in buttons
        if(isset($login_block))
        {
            include($login_block);
        }
        ?>

        <div>
            <h3><?php echo $article["header"] ?></h3>
            <p><?php echo $article["content"] ?></p>
            <p><?php echo "Author: ".$article["author"] ?></p>
            <p><?php echo "Date: ".$article["date"] ?></p>
        </div>

    </body>
</html>
