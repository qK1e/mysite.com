<html>
<head>
    <title>Blog</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>
<body>
    <header class="container">
        <div class="row">
            <div class="col-sm">
                <?php //navigation block
                if(isset($nav_block))
                {
                    include($nav_block);
                }
                ;
                ?>
            </div>
            <div class="col-sm">
                <?php //register sign-in buttons
                if(isset($login_block))
                {
                    include($login_block);
                }
                ?>
            </div>
        </div>
    </header>


    <?php //the buttons that creates new blog. Should be available only to developers and admin(and Ricardo)
    if($user_role == ROLE_DEVELOPER || $user_role == ROLE_ADMIN || $user_role == ROLE_RICARDO)
    {
        include("assets/new-blog-button.php");
    }
    ?>

    <div class="container">
        <?php
        if(isset($recent_articles)) {
            foreach ($recent_articles as $article) {
                ?>
                <div class="blog-article">
                    <a href="blog/article?id=<?php echo $article->getId()?>">
                        <h3><?php echo $article->getHeader() ?></h3>
                    </a>
                    <p><?php echo $article->getContent() ?></p>
                    <p><?php echo "Author: ".$article->getAuthorLogin() ?></p>
                    <p><?php echo "Date: ".$article->getDate() ?></p>
                </div>
            <?php
            }
        }
        if(empty($recent_articles))
        {
            ?>
            <p>Sorry! We ran out of blogs :(</p>
            <?php
        }
        ?>
    </div>

    <nav aria-label="Page navigation example" class="container">
        <ul class="pagination">
            <li class="page-item"><a class="page-link" href="blog?page=<?php echo $blog_page-1?>">Previous</a></li>
            <li class="page-item"><a class="page-link" href="blog?page=<?php echo $blog_page?>"><?php echo $blog_page?></a></li>
            <li class="page-item"><a class="page-link" href="blog?page=<?php echo $blog_page+1?>"><?php echo $blog_page+1?></a></li>
            <li class="page-item"><a class="page-link" href="blog?page=<?php echo $blog_page+2?>"><?php echo $blog_page+2?></a></li>
            <li class="page-item"><a class="page-link" href="blog?page=<?php echo $blog_page+1?>">Next</a></li>
        </ul>
    </nav>

    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>

</body>
</html>