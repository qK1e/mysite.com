<html>
<head>
    <title>Blog</title>
    <link href="https://fonts.googleapis.com/css?family=PT+Sans" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="/views/css/custom.css">

    <script src="https://kit.fontawesome.com/f8e07077e5.js"></script>
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


    <section class="container">
        <div class="row">
            <!--Main content -->
            <div class="col">
                <div class="article pt-4">
                    <h3 class="text-center text-secondary mb-2"><?php echo $article->getHeader() ?></h3>
                    <p class="text-left "><?php echo $article->getContent()?></p>
                    <small class="text-right">Submitted by <i><?php echo $article->getAuthorLogin() ?></i> in <?php echo $article->getDate() ?></small>
                </div>
            </div>
        </div>

        <!--comment section -->
        <div class="row justify-content-center mt-4">
            <!--comment form -->
            <div id="reply" class="comment__reply-x col-12">
                <span class="comment__x-text">reply</span>
                <span class="comment__x close">&times;</span>
            </div>
            <div class="col-12 d-flex w-75" id="comment-form">
                <form class="row w-100 justify-content-center comment-form">
                    <input id="blog-id" type="hidden" value="<?php echo $article->getId();?>">
                    <input id="answer-to" name="answer-to" type="hidden">
                    <textarea id="comment-textarea" class="d-flex col pt-2 rounded-left" name="comment" style="resize: none; height: 3rem; word-wrap: break-word"></textarea>
                    <button class="btn btn-info col-3 rounded" type="button" name="send" value="send" id="send-comment-btn">Send</button>
                </form>
            </div>
            <!--comment form -->

            <!--comment container -->
            <div id="comment-section" class="col-12 px-0">
            </div>
            <!--comment container -->
        </div>
        <!--comment section -->
    </section>



    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>

    <script src="/views/js/article.js"></script>
    <script src="/views/js/search.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>

</body>
</html>
