<?php
    $filepath = realpath(dirname(__FILE__));
    include_once ($filepath.'/../lib/Session.php');
    Session::init();
    
?>
<div class="container-fluid">
    <div class="row">
        <div class="col-md-10">
            <button type="button" id="sidebarCollapse" class="btn btn-info navbar-btn">
                <i class="glyphicon glyphicon-align-left"></i>
                <span>Thanh tác vụ</span>
            </button>
        </div>
        <div class="col-md-2">
            <button type="button" id="sidebarCollapse" class="btn btn-danger navbar-btn">
                <a href="http://localhost/miniProject/?action=logout"> 
                    <?php //if(isset($acc)){echo $acc ;} ?> 
                    <span><i class="fas fa-sign-out-alt"></i></span> 
                </a>
            </button>
        </div>
    </div>
</div>