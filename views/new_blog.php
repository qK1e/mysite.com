<html>
<head>
    <title>Mysite</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css?family=PT+Sans" rel="stylesheet">
    <link rel="stylesheet" href="/views/css/custom.css">
    <script src="https://kit.fontawesome.com/f8e07077e5.js"></script>
</head>
<body>
    <!--navigation and authorization block -->
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


    <div class="container">
        <div class="row">
            <div class="col row d-flex justify-content-center">
                <h1 class="col-12 text-warning text-center">CREATE NEW BLOG</h1>
                <form class="col-12 justify-content-center" method="post" action="new">
                    <div class="form-group w-100 d-flex justify-content-center">
                        <input class="w-75" name="header" type="text" placeholder="Header">
                    </div>

                    <div class="form-group w-100">
                        <textarea class="w-100 textarea-height" name="content" id="editor" placeholder="Content" style="resize: none"></textarea>
                    </div>

                    <input class="btn btn-success" type="submit" value="POST">
                </form>
            </div>
        </div>
    </div>



    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>

    <script src="/views/js/search.js"></script>
    <script src="https://cdn.ckeditor.com/ckeditor5/12.4.0/classic/ckeditor.js"></script>

    <script>
        ClassicEditor
            .create( document.querySelector( '#editor' ), {
                removePlugins: ["Image", "EasyImage", "ImageCaption", "ImageStyle", "ImageUpload", "ImageToolbar", "MediaEmbed"]
            } )
            .catch( error => {
                console.error( error );
            } );
    </script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>

</body>
</html>