<div class="container">
    <div class="row w-100 comment-section">
        <?php foreach ($comments as $comment){ ?>
        <div class="comment col-12 media border mb-2 ml-0" id="comment-<?php echo $comment->getId()?>">
            <div class="media-body p-1 ml-0">
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
                            <span><i class="login">@<?php echo $answered->getAuthorLogin()?></i></span>
                            <p class="pl-2"><?php echo $answered->getContent()?></p>
                        </div>
                    </div>
                <?php }?>
                <p class="pl-2 mt-2" style="font-family: "PT Sans", SansSerif "><?php echo $comment->getContent() ?></p>
            </div>
        </div>
        <?php } ?>
    </div>
</div>