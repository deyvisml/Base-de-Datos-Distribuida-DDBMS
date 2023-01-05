<?php
        require '../model/General_model.php'; 
        session_start();             
        $obj_clase_x = isset($_SESSION['obj_clase_x'])?unserialize($_SESSION['obj_clase_x']) : new Clase_x();            
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Create Record</title>
    <link rel="stylesheet" href="../libs/bootstrap.css">
    <style type="text/css">
        .wrapper{
            width: 500px;
            margin: 0 auto;
        }
    </style>
</head>
<body>
    <div class="wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="page-header">
                        <h2>Update Sports</h2>
                    </div>
                    <p>Please fill this form and submit to add a record in the database.</p>
                    <form action="../index.php?act=update" method="post" >

                        <div class="form-group <?php echo (!empty($obj_clase_x->campo1_msg)) ? 'has-error' : ''; ?>">
                            <label>Title</label>
                            <input type="text" name="campo1" class="form-control" value="<?php echo $obj_clase_x->campo1; ?>">
                            <span class="help-block"><?php echo $obj_clase_x->campo1_msg;?></span>
                        </div>

                        <div class="form-group <?php echo (!empty($obj_clase_x->campo2_msg)) ? 'has-error' : ''; ?>">
                            <label>Genre</label>
                            <input type="text" name="campo2" class="form-control" value="<?php echo $obj_clase_x->campo2; ?> ">
                            <span class="help-block"><?php echo $obj_clase_x->campo2_msg;?></span>
                        </div>

                        <div class="form-group <?php echo (!empty($obj_clase_x->campo3_msg)) ? 'has-error' : ''; ?>">
                            <label>Release date</label>
                            <input type="text" name="campo3" class="form-control" value="<?php echo $obj_clase_x->campo3; ?> ">
                            <span class="help-block"><?php echo $obj_clase_x->campo3_msg;?></span>
                        </div>

                        <input type="hidden" name="id" value="<?php echo $obj_clase_x->id; ?>"/>
                        <input type="submit" name="updatebtn" class="btn btn-primary" value="Submit">
                        
                        <a href="../index.php" class="btn btn-default">Cancel</a>
                    </form>
                </div>
            </div>        
        </div>
    </div>
</body>
</html>