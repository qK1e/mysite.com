<div class="container">
    <div class="row comment-section">
        <?php foreach ($comments as $comment){ ?>
        <div class="comment col-12 media">
            <div class="media-body">
                <span><?php echo $comment->getAuthorLogin()?></span>
                <?php $answered = $comment->getToComment();
                if($answered){?>
                    <div class="answered-comment media border">
                        <div class="media-body">
                            <span><?php echo $answered->getAuthorLogin()?></span>
                            <p><?php echo $answered->getContent()?></p>
                        </div>
                    </div>
                <?php }?>
                <p><?php echo $comment->getContent() ?></p>
            </div>
        </div>
        <?php } ?>
    </div>
</div>