<?php
$message = '';
if (isset($_POST['submit'])) {
    if (!empty($_POST['name'] && !empty($_POST['email'] && !empty($_POST['body'] && !empty($_POST['type']))))) {
        $contract = new Contract();
        $contract->name = $_POST['name'];
        $contract->email = $_POST['email'];
        $contract->body = $_POST['body'];
        $contract->type = $_POST['type'];
        if ($contract->save()) {
            $message = '<div class="alert alert-success">Record Insert Successfully</div>';
            $_SESSION['message'] = $message; ?>
          <script> window.location.href = "contract.php" </script>
            <?php 
        }
    } else {
        $message = '<div class="alert alert-danger">Please Enter All The Field</div>';
    }
}

if (isset($_POST['send'])) {
    $_SESSION['name'] = $_POST['name'];
    $_SESSION['body'] = $_POST['body'];
    $_SESSION['email'] = $_POST['email'];
    header("Location: contract.php?source=preview_contract");
}

?>

<div class="row">
    <div class="col-lg-12" style="margin-top:20px">
        
    </div>
    <!-- /.col-lg-12 -->
</div>
<!-- /.row -->
<div class="row">
    <div class="col-lg-12">
        <?= $message; ?>
        <div class="panel panel-default">
            <div class="panel-heading">
               
            </div>
            <div class="panel-body">
                <form action="" method="post">
                    <div class="form-group">
                        <label>Recipient Name</label>
                        <input class="form-control" name="name" type="text">
                    </div>
                    <div class="form-group">
                        <label>Recipient Email</label>
                        <input class="form-control" name="email" type="email">
                    </div>
                    <div class="form-group">
                        <label>Contract Body</label>
                        <textarea id="mymce" class="form-control" name="body" rows="3" cols="3"></textarea>
                    </div>
                    <div class="form-group">
                        <a class="btn btn-warning" data-toggle="modal" data-target="#myModal">
                            Save
                        </a>
                        <input type="submit" name="send" class="btn btn-success" value="Send">
                    </div>
                    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
                         aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-body">
                                    <div class="form-group">
                                        <label>Save Contract As</label>
                                        <input class="form-control col-lg-4" name="type" type="text">
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <input type="submit" name="submit" class="btn btn-warning pull-left" value="Save">
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
