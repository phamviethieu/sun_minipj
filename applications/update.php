<?php
    $filepath = realpath(dirname(__FILE__));

    include_once ($filepath.'/../lib/Session.php');
    include_once ($filepath.'/../lib/Cookie.php');
    include_once ($filepath.'/../core/Database.php');
    include_once ($filepath.'/../classes/Admin.php');

    if(!Cookie::get("loginInfor")){
        Session::checkAdminLogin();
    }
    else{
        parse_str(Cookie::get("loginInfor"));
        $db = new Database();
        if(isset($acc)&&isset($pass)){
            $query = "select * from users where account = '$acc' and password = '$pass'";
            $result = $db->select($query);
            if($result!=true){
                header('location:../login.php');
            }
        }
        else {
        Cookie::set("loginInfor",'',0);
        echo "done";
        header('location:../login.php');
        }
    }
    if(isset($_GET['action']) && $_GET['action'] == 'logout'){
        Session::destroy();
        Cookie::destroy($cookie_name);
        header("Location:../login.php");
        exit();
    }
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>Admin - Truyện tranh</title>
         <!-- Bootstrap CSS CDN -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
        <!-- Our Custom CSS -->
        <link rel="stylesheet" href="../css/style.css">
        <!-- Font Awesome -->
        <link rel="stylesheet" href="../css/fontawesome/css/all.css">
    </head>
    <body>
        <div class="wrapper">
            <!-- Sidebar Holder -->
            <?php
                include ('../layouts/sidebar.php');
            ?>
            <!-- Page Content Holder -->
            <div id="content">
                    <?php
                        include ('../layouts/menubar.php');
                    ?>
                    <div class="container">
                        <h3><b> Cập nhật truyện: </b></h3>
                        <!-- <?php
                        if(Cookie::get("update_status")==1){
                            echo '<div class="alert alert-success" role="alert">
                             <i class="far fa-check-square fa-2x"></i> Cập nhật thành công
                            </div>';
                    
                        }
                    ?> -->
                        </br>

                        <?php
                            if(isset($_GET['id'])){
                                $ad = new Admin();
                                $id = $_GET['id'];
                                $ad->render_update($id);
                                if($_SERVER['REQUEST_METHOD'] == 'POST'){
                                    $rs = $ad->update_comic($_POST,$id);
                                }
                            }
                        ?>
                        <br>
                         
                    </div>
            </div>
        </div>
        <!-- jQuery CDN -->
        <script src="https://code.jquery.com/jquery-1.12.0.min.js"></script>
        <!-- Bootstrap Js CDN -->
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
        <script type="text/javascript" src="../js/alert.js"></script>
        <script type="text/javascript">
            $(document).ready(function () {
                $('#sidebarCollapse').on('click', function () {
                    $('#sidebar').toggleClass('active');
                });
                // $('#name').keyup(function(){
                //     this.value = this.value.trim();
                    
                // });
            });
            
         </script>
    </body>
</html>
