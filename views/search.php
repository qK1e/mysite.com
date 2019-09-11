<html>
<head>
    <title>Mysite</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="/views/css/custom.css">
    <link href="https://fonts.googleapis.com/css?family=PT+Sans" rel="stylesheet">

    <script src="https://kit.fontawesome.com/f8e07077e5.js"></script>
</head>
<body>
    <!--Navigation and authorization block-->
    <header class="container-fluid">
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
    <!--Navigation and authorization block-->

    <!--Search content -->
    <div class="search-result container">
        <div class="search-result__result-row row w-100 d-flex">
            <?php if(!$search_items->empty()) {
                foreach ($search_items as $a => $item) {
                    if($item->getType() === "blog") {?>
                        <div class="search-result__item-container col mt-2">
                            <div class="search-result__blog-header">
                                <a href="/blog/article?id=<?php echo $item->getObject()->getId()?>">
                                    <h1><?php echo $item->getObject()->getHeader()?></h1>
                                </a>
                            </div>
                            <div class="search-result__blog-content">
                                <p><?php echo $item->getObject()->getContent()?></p>
                            </div>
                            <div class="row mb-1">
                                <div class="search-result__blog-date col">
                                    <small><?php echo $item->getObject()->getDate()?></small>
                                </div>
                                <div class="search-result__blog-author col">
                                    <a href="/developer?id=<?php echo $item->getObject()->getAuthorId()?>">
                                        <small>author: <i><?php echo $item->getObject()->getAuthorLogin()?></i></small>
                                    </a>
                                </div>
                            </div>
                        </div>
                    <?php }

                    if($item->getType() === 'dev'){?>
                      <div class="search-result__item-container col mt-2 py-2">
                          <div class="row">
                              <div class="search-result__dev-avatar col-2">
                                  <img class="img-float float-right img-thumbnail dev-preview-img" src="<?php echo $item->getObject()->getProfile()->getPhoto()?>">
                              </div>
                              <div class="search-result__dev-info col">
                                  <a href="/developer?id=<?php echo $item->getObject()->getId()?>">
                                      <h3><?php echo $item->getObject()->getFullName()?></h3>
                                  </a>
                                  <p class="lead"><?php echo $item->getObject()->getProfile()->getAbout()?></p>
                              </div>
                          </div>
                      </div>
                    <?php }
                }
            }
            else { ?>
                <p class="search-result__message text-warning">
                    Nothing found:(
                </p>
            <?php
            }?>
        </div>
    </div>
   <!--Search content -->

    <!--Page javascript -->
    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>

    <script src="/views/js/search.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>

</body>
</html>
