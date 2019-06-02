<?php
if (isset($_SESSION['admin_id'])) {
    $admin = Admin::find_by_id($_SESSION['admin_id']);
}

?>
<!--<nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
   <div class="navbar-header">
        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </button>
        <a class="navbar-brand" href="index.php"><?= $admin->name; ?></a>
    </div>-->
    <!-- /.navbar-header -->


    <div class="navbar-default sidebar" role="navigation">
        <div class="sidebar-nav navbar-collapse">
            <ul class="nav" id="side-menu" style="backgorund:#000">
                <li>
                    <a href="logout.php" style="color:#000; font-weight:700"> Logout</a>
                </li>
                <li>
                    <a href="index.php" style="color:#000; font-weight:700"> Create New</a>
                </li>
                <li>
                    <a href="contract.php" style="color:#000; font-weight:700">Load Contact</a>
                </li>
            </ul>
        </div>
        <!-- /.sidebar-collapse -->
    </div>
    <!-- /.navbar-static-side -->
</nav>