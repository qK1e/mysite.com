<html>
<head>
    <title>Blog</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>
<body>
    <h1>Блог</h1>
    <?php
    include $_SERVER["DOCUMENT_ROOT"]."/views/assets/navigation-menu.php";
    ?>

    <?php
    include $_SERVER["DOCUMENT_ROOT"]."/views/assets/login-block.php";
    ?>

    <div class="blog-content">
        <?php
            foreach ($this->recent_articles as $article){?>
                <div class="blog-article">
                    <h3><?php echo $article->getHeader()?></h3>
                    <p><?php echo $article->getTextcontent()?></p>
                    <p><?php echo "Автор: ".$article->getAuthor()?></p>
                    <p><?php echo "Дата: ".$article->getDate()?></p>
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