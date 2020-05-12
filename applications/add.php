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
   
        header('location:../login.php');
        }
    }
    if(isset($_GET['action']) && $_GET['action'] == 'logout'){
        Session::destroy();
        Cookie::destroy($cookie_name);
        header("Location:../login.php");
        exit();
    }
    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        $ad = new Admin();
        $ad->add($_POST); 
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
                        <h3><b> Thêm truyện: </b></h3>
                        </br>
                        <form method="post">
                            <div class="form-group">
                                <label for="name" id="name">Tên truyện:</label>
                                <input type="text" class="form-control" name = "name" id="name">
                            </div>
                            <div class="form-group">
                                <label for="author" id="author">Tác giả:</label>
                                <input type="text" class="form-control" name = "author" id="author">
                            </div>
                            <div class="form-group">
                                <label for="describe" id="describe">Mô tả:</label>
                                <textarea class="form-control" rows="5" name = "describe" id="describe"></textarea>
                            </div>
                            <input type="submit" name = "submit" id = "addSubmit" class="btn btn-success" value="Thêm">
                        </form>
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
                 $('name').keyup(function(){
                     if($('name').val()==''){
                         alert('ok');
                     }
                 });
             });
         </script>
    </body>
</html>
