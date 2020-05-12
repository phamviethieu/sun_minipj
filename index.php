<?php
    $filepath = realpath(dirname(__FILE__));
    
    include_once ($filepath.'/lib/Session.php');
    include_once ($filepath.'/lib/Cookie.php');
    include_once ($filepath.'/classes/Admin.php');
    include_once ($filepath.'/../core/Database.php');
    
    Session::init();

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
                header('location:login.php');
            }
        }
        else {
        Cookie::set("loginInfor",'',0);
        echo "done";
        header('location:login.php');
        }
    }
    // }
    // if(Session::checkAdminLogin()){
    //     echo '<div class="alert alert-success" role="alert">
    //     <i class="far fa-check-square fa-2x"></i> Đăng nhập thành công
    //    </div>';
    // };
    // echo(Session::get("adminAccount"));
  
    
?>
 
<?php
    if(isset($_GET['action']) && $_GET['action'] == 'logout'){
        Session::destroy();
        Cookie::destroy($cookie_name);
        header("Location:login.php");
        exit();
    }
    if(isset($_GET['update'])){
        $ad = new Admin();
        $id = $_GET['update'];
        header("Location:applications/update.php?id=".$id);

    }
    if(isset($_GET['action'])&& $_GET['action'] == 'add'){
          header("Location:applications/add.php");
    }
    if(isset($_GET['delete'])){
        $ad = new Admin();
        $id = $_GET['delete'];
        header("Location:applications/delete.php?id=".$id);
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
        <link rel="stylesheet" href="css/style.css">
        <!-- Font Awesome -->
        <link rel="stylesheet" href="css/fontawesome/css/all.css">
    </head>
    <body>
        <div class="wrapper">
            <!-- Sidebar Holder -->
            <?php
                include ('layouts/sidebar.php');
            ?>
            <!-- Page Content Holder -->
            <div id="content">
                    <?php
                        include ('layouts/menubar.php');
                    ?>
                    <div class="container ">
                        <?php
                            if(Session::checkAddStatus()){
                                echo'<div class="alert alert-success" role="alert">
                                    <i class="far fa-check-square fa-2x"></i> Thành công!
                                    </div>';
                            };
                        ?>
                        <table class="table pt-5">
                            <thead>
                                <tr>
                                    <th>STT</th>
                                    <th>Tên truyện</th>
                                    <th>Tác giả</th>
                                    <th>Mô tả</th>
                                    <th>Chức năng</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $ad  = new Admin();
                                $ad->show();
                                ?>
                            </tbody>
                        </table> 
                        <a href="?action=add" class="btn btn-primary"><i class="far fa-plus-square"></i></a>
                    </div>
            </div>
        </div>
        <!-- jQuery CDN -->
         <script src="https://code.jquery.com/jquery-1.12.0.min.js"></script>
         <!-- Bootstrap Js CDN -->
         <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
         <script type="text/javascript">
             $(document).ready(function () {
                $('#sidebarCollapse').on('click', function () {
                    $('#sidebar').toggleClass('active');
                     
                });
                $(".alert").hide();
                $(".alert").fadeIn(3000);
                $(".alert").fadeOut(1000);
                $('.delete').on("click", function (e) {
                    e.preventDefault();

                    var choice = confirm($(this).attr('data-confirm'));

                    if (choice) {
                        window.location.href = $(this).attr('href');
                    }
                });
             });
         </script>
         <script>
                function deleletconfig() {
                    alert ("Xóa Thành Công");
                }
                
              
         </script>
    </body>
</html>
