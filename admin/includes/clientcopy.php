<?php
include('header.php');
echo $_GET['contract_id'];
if (isset($_GET['contract_id'])) {
    $contract = Contract::find_by_id($_GET['contract_id']);
    $name = $contract->name;
    $email = $contract->email;
    $body = $contract->body;
}

?>
<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default" style="margin-top: 30px">
            <form action="" method="post" id="myForm" enctype="multipart/form-data">
            <div class="panel-heading">
                
            </div>
            <div class="panel-body container" >
                 <div class="form-group" style="display: flex">
                     <div class="dr-sign-img" style="  width: 30%;">
                         <img src="image/demo.jpg" width="100px" height="50px" class="img-thumbnail"><br>
                    <label>Dr. Cherry! Baumann MD</label>

                     </div>
                    <div class="dr-sign-date" style=" width: 70%; margin-top: 40px;">
                        <label  style="border-bottom: 1px solid #222; padding-bottom: 5px;"><?= date('j F Y');?></label><br>
                    
                        <label>Date</label>
                    </div>
                </div>
                <div class="form-group" style="display: flex">
                    <div style="width: 30%;">
                        <img src="http://placehold.it/100x50" width="100px" height="50px" class="img-thumbnail" id="empImg">
                    <input name="file" type="file" id="contract" onchange="imagePreview(this);">
                    <label><?= $name; ?></label>
                    <input type="hidden" name="name" value="<?php echo $name; ?>">
                    </div>
                    <div style=" width: 70%; margin-top: 40px;">
                        <label style="border-bottom: 1px solid #222; padding-bottom: 5px;"><?= date('j F Y');?></label><br>
                        <label>Date</label>
                    </div>
                </div>
            </div>
            <div class="container" style="border:1px solid gray; padding:20px">
                <?= $body; ?>
                </div>
                <br><br>
                
                
            <div class="panel-footer">
                
                <input type="submit" name="send" class="btn btn-success" value="Send">
            </div>
            </form>
        </div>
    </div>
</div>

<script>
    function imagePreview(input) {
        if (input.files && input.files[0]) {
            var fileReader = new FileReader();
            fileReader.onload = function (ev) {
                $('#empImg').attr('src', ev.target.result);
            };
            fileReader.readAsDataURL(input.files[0]); 
        }
    }
</script>
<?php include('footer.php') ?>