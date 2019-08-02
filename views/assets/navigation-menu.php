<ul class="nav nav-pills justify-content-start">
    <?php if($nav_blog)
    {?>
        <li class="nav-item m-2">
                <a class="nav-link  text-info" href="/blog" >Blog</a>
        </li>
    <?php }?>

    <?php if($nav_devs)
    {?>
        <li class="nav-item m-2">
            <a class="nav-link  text-info" href="/devs" >Developers</a>
        </li>
    <?php }?>
    <?php if($nav_profile)
    {?>
        <li class="nav-item m-2">
            <a class="nav-link  text-info" href="/profile" >Profile</a>
        </li>
    <?php }?>

    <?php if($nav_admin)
    {?>
        <li class="nav-item m-2">
            <a class="nav-link  text-info" href="/admin" >Admin</a>
        </li>
    <?php }?>
</ul>