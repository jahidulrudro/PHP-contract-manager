<?php
include('includes/header.php');
require_once('classes/init.php');
if (isset($_GET['contract_id'])) {
    $contract = Contract::find_by_id($_GET['contract_id']);
    $name = $contract->name;
    $email = $contract->email;
    $body = $contract->body;
    $signature=$contract->signature;
}
if($_SERVER['REQUEST_METHOD']=="POST"){
    $id=$_POST['id'];
    $result = array();
	$imagedata = base64_decode($_POST['img_data']);
	$filename = md5(date("dmYhisA"));
	//Location to where you want to created sign image
	$file_name = './upload/'.$filename.'.png';
	$result=file_put_contents($file_name,$imagedata);
	$file=$filename.'.png';
	DB_object::update_by_id($file,$id);
   $msg= "<p id='msg' class='alert alert-success'>Contract Sign Successfully</p>";
	   
}
	

?>

    <link href="./css/jquery.signaturepad.css" rel="stylesheet">
		<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
		<script src="./js/numeric-1.2.6.min.js"></script> 
		<script src="./js/bezier.js"></script>
		<script src="./js/jquery.signaturepad.js"></script> 
		
		<script type='text/javascript' src="https://github.com/niklasvh/html2canvas/releases/download/0.4.1/html2canvas.js"></script>
		<script src="./js/json2.min.js"></script>
		
		
		<style type="text/css">
		    body{
		        background:#fff !important;
		    }
			#btnSaveSign {
				color: #fff;
				background: #f99a0b;
				padding: 5px;
				border: none;
				border-radius: 5px;
				font-size: 20px;
				margin-top: 10px;
			}
			#signArea{
				width:304px;
				margin: 50px auto;
				margin-left:-20px;
				margin-bottom:10px;
			}
			.sign-container {
				width: 60%;
				margin: auto;
			}
			.sign-preview {
				width: 150px;
				height: 50px;
				border: solid 1px #CFCFCF;
				margin: 10px 5px;
			}
			.tag-ingo {
				font-family: cursive;
				font-size: 12px;
				text-align: left;
				font-style: oblique;
			}
		.panel{
		    outline:none !important;
		    border:none !important;
		}
		.panel-default{
		    border:none !important;
		}
		.panel-footer{
		    border:none !important;
		}
		 .container{
		    background:#fff !important;
		}
		@media print {
		    	.panel{
		    outline:none !important;
		    border:none !important;
		}
		.panel-default{
		    border:none !important;
		}
		.panel-footer{
		    border:none !important;
		}
		 .container{
		    background:#fff !important;
		}
		    
		}
		</style>
	
<div class="row" id="printableArea">
    <div class="col-lg-12">
        <div class="panel panel-default" style="margin-top: 30px">
            <form action="" method="post" id="myForm" enctype="multipart/form-data">
            <div class="panel-heading">
                <?php if(!empty($msg)){echo $msg;} ?>
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
                        <?php if(!empty($signature)){?>
                        <img src="upload/<?php echo $signature; ?>" width="150px" height="100px" class="img-thumbnail" id="empImg">
                        <?php }else{ ?>
                       <div id="signArea" >
			<div class="sig sigWrapper" style="height:auto;">
				<div class="typed"></div>
				<canvas class="sign-pad" id="sign-pad" width="450px" height="100"></canvas>
    			</div>
    		</div>
    		
                        <?php } ?>
                        <br>
                    <label><?= $name; ?></label>
                    <input type="hidden" name="name" value="<?php echo $name; ?>">
                    </div>
                    <div style=" width: 70%; margin-top: 40px;">
                        <label style="border-bottom: 1px solid #222; padding-bottom: 5px;"><?= date('j F Y');?></label><br>
                        <label>Date</label>
                    </div>
                </div>
            </div>
            <div class="container" style="">
                <?= $body; ?>
                </div>
                <br><br>
                
                
            <div class="panel-footer container">
                <input type="hidden" name="id" value="<?=$_GET['contract_id']?>">
                 <?php if(empty($signature)){?>
                <input type="submit" name="send" id="btnSaveSign" class="btn btn-success" value="Save Signature">
                <?php } ?>
            </div>
            </form>
        </div>
    </div>
</div>
	<div class="container">
		<input type="button" class="btn btn-success btn-sm" onclick="printDiv('printableArea')" value="Print contract" />
		</div>
<script>
		
				jQuery('#signArea').signaturePad({drawOnly:true, drawBezierCurves:true, lineTop:90});
			
			
			$("#btnSaveSign").click(function(e){
				html2canvas([document.getElementById('sign-pad')], {
					onrendered: function (canvas) {
						var canvas_img_data = canvas.toDataURL('image/png');
						var img_data = canvas_img_data.replace(/^data:image\/(png|jpg);base64,/, "");
						//ajax call to save image inside folder
						$.ajax({
							url: 'clientcopy.php',
							data: { img_data:img_data },
							type: 'post',
							//dataType: 'json',
							success: function (response) {
							  // window.location.reload();
							}
						});
					}
				});
			});
			
			function printDiv(divName) {
             var printContents = document.getElementById(divName).innerHTML;
             var originalContents = document.body.innerHTML;
        
             document.body.innerHTML = printContents;
        
             window.print();
        
             document.body.innerHTML = originalContents;
        }
		  </script>
		  
		  <!--
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
-->
 
<?php include('includes/footer.php') ?>