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
    <?php
    if (isset($_GET['source'])) {
        $source = $_GET['source'];
    } else {
        $source = '';
    }
    switch ($source) {
        case 'edit_contract':
            require_once("includes/edit_contract.php");
            break;
        case 'preview_contract':
            require_once("includes/preview_contract.php");
            break;
        default:
            require_once("includes/view_contract.php");
            break;
    }
    ?>
</div>
<!-- /#page-wrapper -->

<?php include('includes/footer.php'); ?>
