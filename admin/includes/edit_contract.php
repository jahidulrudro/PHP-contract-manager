<?php

$contract = Contract::find_by_id($_GET['contract_id']);
$message = '';

if (isset($_POST['submit'])) {
    if (!empty($_POST['name'] && !empty($_POST['email'] && !empty($_POST['body'] && !empty($_POST['type']))))) {
        $contract->name = $_POST['name'];
        $contract->email = $_POST['email'];
        $contract->body = $_POST['body'];
        $contract->type = $_POST['type'];
        if ($contract->save()) {
            $message = '<div class="alert alert-success">Record Updated Successfully</div>';
            $_SESSION['message'] = $message;
            header("Location: contract.php");
        }
    } else {
        $message = '<div class="alert alert-danger">Record Updated Failed</div>';
    }
}

?>

<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">Add</h1>
    </div>
    <!-- /.col-lg-12 -->
</div>
<!-- /.row -->
<div class="row">
    <div class="col-lg-6">
        <?= $message; ?>
        <div class="panel panel-default">
            <div class="panel-heading">
                Add Contract
            </div>
            <div class="panel-body">
                <form action="" method="post">
                    <div class="form-group">
                        <label>Recipient Name</label>
                        <input class="form-control" name="name" value="<?= $contract->name; ?>" type="text">
                    </div>
                    <div class="form-group">
                        <label>Recipient Email</label>
                        <input class="form-control" name="email" value="<?= $contract->email; ?>" type="email">
                    </div>
                    <div class="form-group">
                        <label>Contract Body</label>
                        <textarea id="mymce" class="form-control" name="body" rows="3"
                                  cols="3"><?= $contract->body; ?></textarea>
                    </div>
                    <div class="form-group">
                        <!--<input type="submit" name="submit" class="btn btn-success" value="Submit">-->
                        <a class="btn btn-primary" data-toggle="modal" data-target="#myModal">
                            Save
                        </a>
                    </div>
                    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
                         aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-body">
                                    <div class="form-group">
                                        <label>Save Contract As</label>
                                        <input class="form-control" value="<?= $contract->type; ?>" name="type"
                                               type="text">
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <input type="submit" name="submit" class="btn btn-primary" value="Save">
                                </div>
                            </div>
                            <!-- /.modal-content -->
                        </div>
                        <!-- /.modal-dialog -->
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- /.row -->
<!-- /.row -->