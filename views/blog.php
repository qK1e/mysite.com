<html>
<head>
    <title>Blog</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="views/css/custom.css">
    <link href="https://fonts.googleapis.com/css?family=PT+Sans" rel="stylesheet">

    <script src="https://kit.fontawesome.com/f8e07077e5.js"></script>
</head>
<body>
    <header class="container-fluid">
        <div class="row align-items-center">
            <!-- navigation block -->
            <div class="navigation col">
                <?php
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



    <section class="content content-clr container-fluid">
        <div class="row">
            <!-- Blog section -->
            <div class="blogs col-9 container">
                <!--buttons -->
                <div class="row justify-content-end">
                    <?php //the buttons that creates new blog. Should be available only to developers and admin(and Ricardo)
                    if($user_role == ROLE_DEVELOPER || $user_role == ROLE_ADMIN || $user_role == ROLE_RICARDO)
                    {
                        include("assets/new-blog-button.php");
                    }
                    ?>
                </div>
                <!-- articles -->
                <div class="row m-2">
                    <?php
                    if(isset($recent_articles)) {
                        foreach ($recent_articles as $article) {
                            ?>
                            <!--article -->
                            <div class="blog-article col-12 m-1 p-1 pl-4 py-3 border border-light shadow-sm row" id="article-<?php echo $article->getId()?>">
                                <span class="article-id" style="display: none"><?php echo $article->getId()?></span>
                                <div class="col-12 row article-header border-bottom">
                                    <a class="text-capitalize ml-2 text-secondary col" href="blog/article?id=<?php echo $article->getId()?>">
                                        <h3><?php echo $article->getHeader() ?></h3>
                                    </a>
                                    <?php if($user_role == ROLE_ADMIN){ ?>
                                        <span class="close col-1 d-flex justify-content-end delete-blog">x</span>
                                    <?php } ?>
                                </div>

                                <p class="article-content ml-2 col-12 lead"><?php echo $article->getContent() ?></p>
                                <small class="article-author col-12 mt-0 ml-2">Submitted by <?php echo "<i>".$article->getAuthorLogin()."</i>"?> in <?php echo $article->getDate() ?></small>
                            </div>
                            <!--article -->
                            <?php
                        }
                    }
                    if(empty($recent_articles))
                    {
                        ?>
                      <div class="d-flex col justify-content-center">
                          <div>
                              <h1 class="text-monospace text-warning">Whoopsie!</h1>
                              <p class="text-secondary offset-2">We ran out of blogs:(</p>
                          </div>

                      </div>

                        <?php
                    }
                    ?>
                </div>
                <!-- blog pagination -->
                <nav aria-label="Page navigation example" class="row m-2">
                    <ul class="pagination ml-4">
                        <li class="page-item"><a class="page-link  text-info" href="blog?page=<?php echo $blog_page-1?>">Previous</a></li>
                        <li class="page-item"><a class="page-link  text-info" href="blog?page=<?php echo $blog_page?>"><?php echo $blog_page?></a></li>
                        <li class="page-item"><a class="page-link  text-info" href="blog?page=<?php echo $blog_page+1?>"><?php echo $blog_page+1?></a></li>
                        <li class="page-item"><a class="page-link  text-info" href="blog?page=<?php echo $blog_page+2?>"><?php echo $blog_page+2?></a></li>
                        <li class="page-item"><a class="page-link  text-info" href="blog?page=<?php echo $blog_page+1?>">Next</a></li>
                    </ul>
                </nav>
                <!--blog pagination -->
            </div>
        </div>

    </section>


    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>

    <script src="/views/js/blog.js"></script>
    <script src="/views/js/search.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>

</body>
</html>