<?php
require_once("classes/init.php");

if (!$session->is_signed_in()) {
    header("Location: ../");
}
?>
<?php include('includes/header.php'); ?>
<!-- Navigation -->
<?php include('includes/navigation.php'); ?>

<div id="page-wrapper">
    <?php include('includes/add_contract.php'); ?>
</div>
<!-- /#page-wrapper -->
<?php include('includes/footer.php'); ?>
