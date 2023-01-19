<?php
$error="";
$data=null;

if(!isset($_GET['id'])){
    $error="Error Encountered: The Parameter You Provided In The URL Location is Not valid.";
    $notFoundMessage="";
  //exit();
}
else{
$target=$_GET['id'];
$error="";
$data=getUserInformation();
if($data==null)
$notFoundMessage="This ID is Not Exist In The Database";
else
$notFoundMessage="";

}

function getUserInformation(){
    include './config/conn.php';
    $data = array();
    $sql= "select Username,Email,Role,Status from users where USERID=".$_GET['id'].";";
$result=Connections::Connect()->query($sql);
if($result){
    if(mysqli_num_rows($result)>0)
        {
            while($rows=$result->fetch_assoc()){
                $data= array(
                    "username"=>$rows['Username'],
                    "Email"=>$rows['Email'],
                    "Status"=>$rows['Status'],
                    "Role"=>$rows['Role'],
                );
            }
            return $data;
        }
    else
    $notFoundMessage="The ID You Provide is Not Exist...";
}

}


?>

<!DOCTYPE html>
<html dir="ltr" lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="keywords"
        content="wrappixel, admin dashboard, html css dashboard, web dashboard, bootstrap 5 admin, bootstrap 5, css3 dashboard, bootstrap 5 dashboard, Xtreme lite admin bootstrap 5 dashboard, frontend, responsive bootstrap 5 admin template, Xtreme admin lite design, Xtreme admin lite dashboard bootstrap 5 dashboard template">
    <meta name="description"
        content="Xtreme Admin Lite is powerful and clean admin dashboard template, inpired from Bootstrap Framework">
    <meta name="robots" content="noindex,nofollow">
    <title>ZOOM ELECTIONS | CJICT</title>
    <link rel="canonical" href="https://www.wrappixel.com/templates/xtreme-admin-lite/" />
    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="../../assets/images/favicon.png">
    <!-- Custom CSS -->
    <link href=".././assets/libs/chartist/dist/chartist.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link href=".././dist/css/style.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">
    <link rel="stylesheet" href="sweetalert2.min.css">
    <!-- / <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous"> -->
    
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
<![endif]-->
</head>

<body>
    <!-- ============================================================== -->
    <!-- Preloader - style you can find in spinners.css -->
    <!-- ============================================================== -->
    <!-- <div class="preloader">
        <div class="lds-ripple">
            <div class="lds-pos"></div>
            <div class="lds-pos"></div>
        </div>
    </div> -->
    <!-- ============================================================== -->
    <!-- Main wrapper - style you can find in pages.scss -->
    <!-- ============================================================== -->
  
    <div id="main-wrapper" data-layout="vertical" data-navbarbg="skin5" data-sidebartype="full"
        data-sidebar-position="absolute" data-header-position="absolute" data-boxed-layout="full">
        <!-- ============================================================== -->
        <!-- Topbar header - style you can find in pages.scss -->
        <!-- ============================================================== -->
        <?php include './include/header.php'?>
        <!-- ============================================================== -->
        <!-- End Topbar header -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- Left Sidebar - style you can find in sidebar.scss  -->
        <!-- ============================================================== -->
    <?PHP include './include/sidebar.php'?>
        <!-- ============================================================== -->
        <!-- End Left Sidebar - style you can find in sidebar.scss  -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
       
        <!-- Page wrapper  -->
        <!-- ============================================================== -->
        <div class="page-wrapper">
          <div class="row">
          <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                              
                              
                  <div class="container">
                    <?php if ($error!=""):?>
                    <div class="alert alert-danger" role="alert">
                    <?php echo $error;?>
                    </div>
<?php endif;?>

<?php if ($notFoundMessage!=""):?>
                    <div class="alert alert-danger" role="alert">
                    <?php echo $notFoundMessage;?>
                    </div>
<?php endif;?>
                  <h4 class="card-title">EDIT USER | XEEZOOMS ELECTIONS</h4><br>
                    <form action="" method="post" >
                    <div class="form-group">
                    <div class="mb-3">
                    <?php if ($data!=null):?>
    

                            <label for="exampleFormControlInput1" class="form-label fw-bold 
                            " style="font-size: 18px; ">Username</label>
                            <input type="text"  value="<?php echo $data['username']?>" required style="border: 1px solid #2b2b2b;" class="form-control fw-bold" id="username" placeholder="username">
                        </div>
                    </div>

                        <div class="form-group">
                        <div class="mb-3">
                            <label for="email" class="form-label fw-bold">Email</label>
                            <input value="<?php echo $data['Email']?>" required style="border: 1px solid #2b2b2b;" type="email" class="form-control" id="email" placeholder="name@example.com">
                        </div>
                        </div>
                       
                      

                     <div class="form-group">
                     <div class="mb-3">
                            <label for="exampleFormControlInput1" class="form-label fw-bold">User Type</label>
                            <select name="" class="form-control"  style="border: 1px solid #2b2b2b;" id="type">
                                <option value="<?php echo $data['Role']?>"><?php echo $data['Role']?></option>
                                <option value="Admin">Admin</option>
                                <option value="User">User</option>
                            </select>
                        </div>
                     </div>
<input type="hidden" name="targetID" id="targetID" value="<?php  echo $_GET['id'] ?>">
                     <div class="form-group">
                     <div class="mb-3">
                            <label for="exampleFormControlInput1" class="form-label fw-bold">Status</label>
                            <select name="" class="form-control"  style="border: 1px solid #2b2b2b;" id="status">
                                <option value="<?php echo $data['Status']?>"><?php echo $data['Status']?></option>
                                <option value="Active">Active</option>
                                <option value="Blocked">Blocked</option>
                            </select>
                        </div>
                     </div>
                     
                     <div class="mb-3">
                          <button type="submit" class="btn btn-secondary fw-bold " id="saveChanges" style="font-size: 19px; font-family:poppins; width: 100px; border-radius: 5px;">Save</button>
                        </div>
                      </div>
                     <?php endif;?>
                    
                    
                       
                            </form>
                            </div>
                           
                        </div>
                    </div>
                    </form>
                  </div>
          </div>
            <!-- ===================
            =========================================== -->
            <!-- Bread crumb and right sidebar toggle -->
            <!-- ============================================================== -->

            <!-- ============================================================== -->
            <!-- End Container fluid  -->
            <!-- ============================================================== -->
            <!-- ============================================================== -->
            <!-- footer -->
            <!-- ============================================================== -->
            <?php include './include/footer.php'?>
            <!-- ============================================================== -->
            <!-- End footer -->
            <!-- ============================================================== -->
        </div>
        <!-- ============================================================== -->
        <!-- End Page wrapper  -->
        <!-- ============================================================== -->
    </div>
    <!-- ============================================================== -->
    <!-- End Wrapper -->
    <!-- ============================================================== -->
    <!-- ============================================================== -->
    <!-- All Jquery -->
    <!-- ============================================================== -->
  

    <!-- modal add User -->

    
    <!-- end modal add User -->
    <script src="sweetalert2.min.js"></script>

    <script src="./Controlers/jquery-3.6.0.min.js"></script>
<!-- <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script> -->
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
    <script src="./Controlers/user.js"></script>
</body>

</html>