<html>
<head>
    <title>Blog</title>
</head>
<body>
    <h1>Blog</h1>
    <?php
    include $_SERVER["DOCUMENT_ROOT"]."/views/assets/navigation-menu.php";
    ?>

    <?php
    include $_SERVER["DOCUMENT_ROOT"]."/views/assets/login-block.php";
    ?>

    <div class="blog-content">
        <?php
            foreach ($_GLOBALS["articles"] as $article){?>
                <div class="blog-article">
                    <h3><?php echo $article->getHeader()?></h3>
                    <p><?php echo $article->getTextcontent()?></p>
                    <p><?php echo "Автор: ".$article->getAuthor()?></p>
                    <p><?php echo "Дата: ".$article->getDate()?></p>
                </div>
        <?php }?>
    </div>
</body>
</html>