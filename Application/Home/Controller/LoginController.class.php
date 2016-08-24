<?php
namespace Home\Controller;

use Think\Controller;
header("Content-Type: text/html;charset=utf8");
class LoginController extends Controller{
    public function index(){
        $this->display('Index/login');
    }
    
    public function checkLogin(){
        $name=trim($_POST['username']);
        $password=trim($_POST['password']);
        if($name=='admin' && md5($password)=='c938d90e65c29b0556104baa66da6070'){
            setcookie("name",$name, time()+6400);
            $model=M();
            $result=$model->table('game')->select();
            $this->assign('result',$result);
            $this->display('Index/wechatGiftbagIndex');
        }else{
            echo "<script language=javascript>alert('账号名或密码错误，请重新登陆');location.href='index.php?m=Home&c=Login&a=index'</script>";
            exit;
        }
    }
    
}