<div class="container">
    <div class="row w-100 comment-section">
        <?php foreach ($comments as $comment){ ?>
        <div class="comment col-12 media border mb-2 ml-0" id="comment-<?php echo $comment->getId()?>">
            <div class="media-body pt-1 ml-0">
                <span style="display: none" class="comment-id"><?php echo $comment->getId()?></span>
                <span class="text-success"><i class="login">@<?php echo $comment->getAuthorLogin()?></i></span>
                <?php
                if($user)
                {
                $role = $user->getRole();
                if($role == ROLE_ADMIN){ ?>
                    <span class="close delete-comment">&times;</span>
                <?php }
                }
                ?>


                <?php $answered = $comment->getToComment();
                if($answered){?>
                    <div class="answered-comment media border border-rounded">
                        <div class="media-body">
                            <span><i class="comment__login login">@<?php echo $answered->getAuthorLogin()?></i></span>
                            <p class="comment__content pl-2"><?php echo $answered->getContent()?></p>
                        </div>
                    </div>
                <?php }?>
                <p class="comment__content" style="font-family: "PT Sans", SansSerif "><?php echo $comment->getContent() ?></p>
                <button class="comment__reply-button btn btn-info mb-2 ">reply</button>
            </div>
        </div>
        <?php } ?>
    </div>
</div>