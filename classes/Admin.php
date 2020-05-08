<?php
    $filepath = realpath(dirname(__FILE__));
    include_once ($filepath.'/../lib/Session.php');
    include_once ($filepath.'/../core/Database.php');
    include_once ($filepath.'/../lib/Cookie.php');
    include_once ('Validate.php');

class Admin{
    private $db;
    public function __construct(){
        $this->db = new Database();
    }
    public function login($_data){
        $acc = $_data['adminAccount'];
        $pass = md5($_data['adminPassword']);
        $query = "select * from users where account = '$acc' and password = '$pass'";
        $result = $this->db->select($query);
        
        if($result!=false){
            foreach($result as $key => $value){
                $account = $value->account;
                $id = $value->id;
            }
            Session::init();
            Session::set("login", true);
            Session::set("adminAccount", $account);
            Session::set("adminId",$id);
            if (isset($_data['remember'])){
                if($_data['remember']== 1){
                    Cookie::set("loginInfor", 'acc='.$acc.'&pass='.$pass,3600 * 24 * 30);
                    // echo Cookie::get("loginInfor");
                    // echo "<br>". $_data['remember'];
                    header("location:index.php");
                    
                }
            } else{
                Cookie::destroy("loginInfor");
                header("location:index.php");
            }
        } else{
            if(($_data['adminAccount']=='') || ($_data['adminPassword']=='')){
                echo '<div class="alert alert-danger" role="alert">Hãy nhập đầy đủ tài khoản và mật khẩu!</div>';
            } else{
                echo '<div class="alert alert-danger" role="alert">Sai tên đăng nhập hoặc mật khẩu!</div>'; 
            }
        }
    }
    public function show(){
        $query = "SELECT * FROM comics ORDER BY id DESC";
        $result = $this->db->select($query);
        $msg = "bạn chắc chắn muốn xóa ?";
        if($result){
            foreach ($result as  $key => $value) {    
            $key++;       
            echo '<tr><td scope="row">'.$key.'</td><td>'.$value->name.'</td>
                                        <td>'.$value->description.'</td>
                                        <td>'.$value->author.'</td>
                                        <td>
                                            <a href="?update='.$value->id.'" style="color:green;" ><i class="fas fa-pencil-alt"></i></a> 
                                            <a href="?delete='.$value->id.'"style="color:red;" class="delete" data-confirm="Bạn chắc chắn muốn xóa?""><i class="fas fa-trash-alt"></i></a>
                                        </td>
                  </tr>';
            }
        } else{
           echo '<div class="alert alert-danger" role="alert">Không có bản ghi nào</div>';
        }
        $this->db->disconnect();
    }
    public function add($_post){
        if(isset($_post['submit'])){
            
            if(!empty($_post['name']&&!empty($_post['author'])&&!empty($_post['describe']))){
                $vld = new Validate();
                $name = $vld->test_input($_post['name']);
                $author = $vld->test_input($_post['author']);
                $describe = $vld->test_input($_post['describe']);
                $query = "INSERT INTO `comics`( `name`, `description`, `author`) VALUES ('".$name."','".$author."','".$describe."')";
                $this->db->insert($query);
                Session::init();
                Session::set("add_status", true);
                header('Location:../index.php');
            } else{                
                echo '<div class="alert alert-danger" role="alert"><i class="far fa-check-square fa-2x"></i> Hãy điền đầy đủ tất cả các trường!</div>';
            }
        }
        $this->db->disconnect();
    }
    public function render_update($id){
        $query = "SELECT * FROM comics WHERE id = ".$id;
        $result = $this->db->select($query);
        
        foreach($result as $rs){
            $name =  $rs->name;
             $author = $rs->author;
             $describe = $rs->description;
        }
        echo '
            <form method="post" name="update">
                    <div class="form-group">
                        <label for="name">Tên truyện:</label>
                        <input type="text" class="form-control" name = "name" id="name" value = "'.$name.'">
                    </div>
                    <div class="form-group">
                        <label for="author">Tác giả:</label>
                        <input type="text" class="form-control" name = "author" id="author" value = "'.$author.'">
                    </div>
                    <div class="form-group">
                        <label for="describe">Describe:</label>
                        <textarea class="form-control" rows="5" name = "describe" id="describe" value="'.$describe.'">'.$describe.'</textarea>
                    </div>
                <input type="submit" name = "submit" class="btn btn-success" value="Cập nhật">
            </form> 
            ';
    
    }
    public function update_comic($_data, $id){
        if(!empty($_data['name']&&!empty($_data['author'])&&!empty($_data['describe']))){
            $name = $_data['name'];
            $description = $_data['describe'];
            $author = $_data['author'];
            $query = "UPDATE `comics` SET `name`='".$name."',`description`='".$description."',`author`='".$author."' WHERE id = ".$id;
            $result = $this->db->update($query);
            if($result){
                Cookie::set('update_status',1,10);
            } else Cookie::set('update_status',0,10);
            header("Location:update.php?id=".$id);
            $this->db->disconnect();
        } else {                
            echo '<div class="alert alert-danger" role="alert">
                    <i class="far fa-check-square fa-2x"></i> Hãy điền đầy đủ tất cả các trường!
                 </div>';
        }
    }

    public function delete($id){
        $query = "DELETE FROM `comics` WHERE id=".$id;
        $result = $this->db->delete($query);
        header("Location:../index.php");
        echo '<script>alert("xóa thành công");</script>';
        $this->db->disconnect();
    }
    public function deleteAll(){
        
    }
}
?>