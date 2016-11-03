<?php

class Index extends Controller{
    
    public function __construct(){
        parent::__construct();
    }

    public function index(){
        $this->view->view("index");
    }

    public function login(){
        $true_nickname = $this->checkPost('nickname');
        $true_password = $this->checkPost('password');

        if($true_nickname && $true_password){
            $nickname = $this->protect($_POST['nickname']);
            $password = sha1($_POST['password']);
            $login_info = $this->model->checkUser($nickname, $password);
            if($login_info){
                Session::set('nickname',$nickname);
                $info = [
                    'nickname' => $nickname,
                    'success' => false
                ];
            }else{
                $info = [
                    'err' => 1,
                    'success' => true
                ];
            }
        }else{
            $info = [
                'err' => 2,
                'success' => true
            ];
        }
        echo json_encode($info);
    }

    public function chat(){
        // $true_msg = $this->checkPost('msg');

        // if($true_msg && isset($_SESSION['nickname'])){

        //     $msg = $this->protect($_POST['msg']);
        //     $nickname = Session::get('nickname');
        //     $this->model->newMsg($nickname, $msg);
        // }
        if(isset($_SESSION['nickname'])){  // 
            $all = $this->model->getAllMsgs();
            // echo "<pre>";
            print_r(json_encode($all));
        }
        
    }

    public function newMsg(){
        $true_msg = $this->checkPost('msg');
        $true_nickname = $this->checkPost('nickname');
        if($true_msg && $true_nickname)
        {
            $msg = trim($this->protect($_POST['msg']));
            $nickname = trim($this->protect($_POST['nickname']));

            if($msg != "" && $nickname != "")
            {
                $this->model->newMsg($msg, $nickname);
                print("GOod");
            }
        }
    }

    public function logout(){
        session_destroy();
    }
}
?>