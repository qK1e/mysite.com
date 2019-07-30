<ul class="nav nav-pills justify-content-start">
    <?php if($nav_blog)
    {?>
        <li class="nav-item">
                <a class="nav-link" href="blog" >Blog</a>
        </li>
    <?php }?>

    <?php if($nav_devs)
    {?>
        <li class="nav-item">
            <a class="nav-link" href="devs" >Developers</a>
        </li>
    <?php }?>
    <?php if($nav_profile)
    {?>
        <li class="nav-item">
            <a class="nav-link" href="profile" >Profile</a>
        </li>
    <?php }?>

    <?php if($nav_admin)
    {?>
        <li class="nav-item">
            <a class="nav-link" href="admin" >Admin</a>
        </li>
    <?php }?>
</ul>