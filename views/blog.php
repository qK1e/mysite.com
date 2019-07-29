<html>
<head>
    <title>Blog</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>
<body>
    <h1>Blog</h1>
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

    <?php //the buttons that creates new blog. Should be available only to developers and admin(and Ricardo)

    if($user_role == ROLE_DEVELOPER || $user_role == ROLE_ADMIN || $user_role == ROLE_RICARDO)
    {
        include("assets/new-blog-button.php");
    }
    ?>

    <div class="blog-content">
        <?php
        if(isset($recent_articles)) {
            foreach ($recent_articles as $article) {
                ?>
                <div class="blog-article">
                    <h3><?php echo $article["header"] ?></h3>
                    <p><?php echo $article["content"] ?></p>
                    <p><?php echo "Author: ".$article["author"] ?></p>
                    <p><?php echo "Date: ".$article["date"] ?></p>
                </div>
            <?php
            }
        }?>
    </div>

    <nav aria-label="Page navigation example">
        <ul class="pagination">
            <li class="page-item"><a class="page-link" href="blog?page=<?php echo $blog_page-1?>">Previous</a></li>
            <li class="page-item"><a class="page-link" href="blog?page=<?php echo $blog_page?>"><?php echo $blog_page?></a></li>
            <li class="page-item"><a class="page-link" href="blog?page=<?php echo $blog_page+1?>"><?php echo $blog_page+1?></a></li>
            <li class="page-item"><a class="page-link" href="blog?page=<?php echo $blog_page+2?>"><?php echo $blog_page+2?></a></li>
            <li class="page-item"><a class="page-link" href="blog?page=<?php echo $blog_page+1?>">Next</a></li>
        </ul>
    </nav>
</body>
</html>