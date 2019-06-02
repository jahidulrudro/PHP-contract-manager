<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">Contract Template</h1>
    </div>
    <!-- /.col-lg-12 -->
</div>
<?php
ob_start();
$contracts = Contract::find_all();
$message = '';
if (isset($_SESSION['message'])) {
    $message = $_SESSION['message'];
}
unset($_SESSION['message']);

if (isset($_GET['delete_contract'])) {
    $contract = Contract::find_by_id($_GET['delete_contract']);
    if ($contract->delete()) {?>
     <script>window.location.href = "contract.php"</script>
      <?php
    }
}

?>
<div class="row">
    <div class="col-lg-12">
        <?= $message; ?>
        <div class="panel panel-default">
            <!-- /.panel-heading -->
            <div class="panel-body">
                <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                    <thead>
                    <tr>
                        <th>Serial No.</th>
                        <th>Contract Template</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php $i = 0;
                    foreach ($contracts as $contract): ?>
                        <tr class="odd gradeX">
                            <td><?php echo $i += 1; ?></td>
                            <td><?php echo $contract->type; ?></td>
                            <td>
                                <a href="contract.php?source=preview_contract&contract_id=<?php echo $contract->id; ?>"
                                   target="_blank"
                                   class="btn btn-info" title="Load">Load</a>
                                <a href="contract.php?source=edit_contract&contract_id=<?php echo $contract->id; ?>"
                                   class="btn btn-success" title="Edit">Edit</a>
                                <a href="contract.php?delete_contract=<?php echo $contract->id; ?>"
                                   class="btn btn-danger"
                                   title="Delete" onclick="return confirm('Are you sure want to delete!!')">Delete</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
                <!-- /.table-responsive -->
            </div>
            <!-- /.panel-body -->
        </div>
        <!-- /.panel -->
    </div>
    <!-- /.col-lg-12 -->
</div>