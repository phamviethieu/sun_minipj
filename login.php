<?php
    $filepath = realpath(dirname(__FILE__));
    
    include_once ($filepath.'/classes/Admin.php');
    include_once ($filepath.'/../lib/Cookie.php');
    include_once ($filepath.'/../core/Database.php');

    $ad = new Admin();
    $db = new Database(); 
?>
<?php
    if(Cookie::get("loginInfor")){
        parse_str(Cookie::get("loginInfor"));
        $query = "select * from users where account = '$acc' and password = '$pass'";
        $result = $db->select($query);
        if($result!=false){
            header('location:index.php');
        }
    }
    else{
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            $adminData = $ad->login($_POST);
        }
    }
    
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Login</title>
     <!-- Bootstrap CSS CDN -->
     <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <!-- Our Custom CSS -->
    <link rel="stylesheet" href="css/login-style.css">
    <script src="js/jquery.js"></script>
</head>
<body>
    <div class="form-login">
        <form method="post" name = "login">
            <div class="form-group">
                <label for="exampleInputEmail1">Tài khoản</label>
                <input type="text" id = "acc" name = "adminAccount" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Nhập tài khoản">
            </div>
            <div class="form-group">
                <label for="exampleInputPassword1">Mật khẩu</label>
                <input type="password" id = "pwd" name = "adminPassword" class="form-control" id="exampleInputPassword1" placeholder="Mật khẩu">
            </div>
            <div class="form-check">
                <div class = "col-9">
                    <input type="checkbox" class="form-check-input" name = "remember" id="exampleCheck1" value = "1" checked>
                    <label class="form-check-label" for="exampleCheck1">Nhớ mật khẩu</label>
                </div>
                <div class="col-3"><button type="submit" id = "loginSubmit" class="btn btn-primary">Đăng nhập</button></div>

            </div>
        </form>
    </div>
    <script type="text/javascript" src = "js/validate.js">
    
    </script>
</body>
</html>