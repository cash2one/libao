<?php
namespace Home\Controller;

use Think\Controller;
header("Content-Type: text/html;charset=utf8");
class RecordController extends Controller{
    public function __construct()
    {
        parent::__construct();
        if(!isset($_COOKIE['name']) ||empty($_COOKIE['name']) ){
           $this->redirect('Login/index','',2,"请登录");
        }
       
    }
    
    public function lists(){
        $model=M();
        $result=$model->table('game')->select();
        $this->assign('result',$result);
     
        $this->display('Index/wechatGiftbagIndex');
        
    }
    
    
    public function giftsdata(){
       $model=M();
       $sql="1=1";
       if(isset($_COOKIE['giftname']) && !empty($_COOKIE['giftname'])){
           $gift_name=urldecode($_COOKIE['giftname']);
           $sql.=" and gift_name='".$gift_name."'";
           setcookie(giftname);    
       }
       if(isset($_COOKIE['token']) && !empty($_COOKIE['token']) ){
           $token=urldecode($_COOKIE['token']);
            $sql.=" and token='".$token."'";
           setcookie(token);
       }
       if(isset($_COOKIE['first']) && !empty($_COOKIE['first']) && isset($_COOKIE['last']) && !empty($_COOKIE['last']) ){
           $first_time= strtotime(urldecode($_COOKIE['first']));
           $last_time= strtotime(urldecode($_COOKIE['last']));
           $sql.=" and endtime between '".$first_time."' and '". $last_time."' ";
           setcookie(first);
           setcookie(last);     
       }

       $sql="select *,FROM_UNIXTIME(endtime, '%Y-%m-%d %H:%i:%s') as endtime1 from gamepacks where $sql order by endtime desc";   
       $list['data']= $model->query($sql);
       foreach ($list['data'] as $k=>$v){
           if($v['endtime']==0){
               $list['data'][$k]['endtime1']="永久有效";   
           }
       }
       $a=$this->ajaxReturn($list,'json');            
    }
    
    public function listsdata(){
        $model=M();
        $sql=" a.giftsid=c.giftsid and b.gameid=c.game_id and  flag=1";
        
        if(isset($_COOKIE['userid']) && !empty($_COOKIE['userid'])){
            $userid=urldecode($_COOKIE['userid']);
            $sql.=" and a.openid='".$userid."'";
            setcookie(userid);
        }
        if(isset($_COOKIE['giftname']) && !empty($_COOKIE['giftname']) ){
            $giftname=urldecode($_COOKIE['giftname']);
            $sql.=" and c.gift_name='".$giftname."'";
            setcookie(giftname);
        }
        if(isset($_COOKIE['first5'])&& !empty($_COOKIE['first5']) && isset($_COOKIE['last5']) && !empty($_COOKIE['last5']) ){
            $first_time= strtotime(urldecode($_COOKIE['first5']));
            $last_time= strtotime(urldecode($_COOKIE['last5']));
            $sql.=" and a.gettime between '".$first_time."' and '". $last_time."' ";
            setcookie(first5);
            setcookie(last5);
        }
        
        $sql ="select a.*,FROM_UNIXTIME(a.gettime, '%Y-%m-%d %H:%i:%s') as gettime,game_name,c.gift_name,c.content from code as a, game as b,gamepacks as c
                where $sql";
       
        $list['data']= $model->query($sql);
        
     
        $a=$this->ajaxReturn($list,'json');
    }
    
    
    public function news_step2(){
        $this->assign('gamename',$_GET['name']);
        $this->display('Index/newPackage');
    }
    
    public function checkGameName(){
        $model=M();
        $sql='select gameid from game where game_name="'.$_POST['name'].'"';
        $result=$model->query($sql);
        if(!$result){
            echo "true";
        }else{
            echo "false";
        }
    }
    
    public function checkGiftName(){
        $model=M();
        $sql='select giftsid from gamepacks where gift_name="'.$_POST['giftname'].'"';
        $result=$model->query($sql);
        if(!$result){
            echo "true";
        }else{
            echo "false";
        }
    }
    
    
    public function checkToken(){
        $model=M();
        $sql='select giftsid from gamepacks where token="'.$_POST['token'].'"';
        $result=$model->query($sql);
        if(!$result){
            echo "true";
        }else{
            echo "false";
        }
    }
    
    public function importAgain(){
        $model=M();
        $giftsid=$_GET['giftsid'];
        
       $sql="select a.*,b.game_name,FROM_UNIXTIME(a.endtime, '%Y-%m-%d %H:%i:%s') as endtime1 from gamepacks as a, game as b where a.game_id=b.gameid and a.giftsid='".$giftsid."'";
       $list= $model->query($sql);
       foreach ($list as $k=>$v){
           if($v['endtime']==0){
               $list[$k]['endtime1']="永久有效";
           }
       }     
        $this->assign('list',$list[0]);
      
        $this->display('Index/importPackage');
    }
    
   
     public function export(){

         $model=M();
         $sql=" a.giftsid=c.giftsid and b.gameid=c.game_id and  flag=1";     
         
         if(isset($_COOKIE['userid']) && !empty($_COOKIE['userid'])){
             $userid=urldecode($_COOKIE['userid']);
             $sql.=" and a.openid='".$userid."'";
             setcookie(userid);
         }
         if(isset($_COOKIE['giftname']) && !empty($_COOKIE['giftname']) ){
             $giftname=urldecode($_COOKIE['giftname']);
             $sql.=" and c.gift_name='".$giftname."'";
             setcookie(giftname);
         }
         if(isset($_COOKIE['first5'])&& !empty($_COOKIE['first5']) && isset($_COOKIE['last5']) && !empty($_COOKIE['last5']) ){
             $first_time= strtotime(urldecode($_COOKIE['first5']));
             $last_time= strtotime(urldecode($_COOKIE['last5']));
             $sql.=" and a.gettime between '".$first_time."' and '". $last_time."' ";
             setcookie(first5);
             setcookie(last5);
         }
         $sql ="select a.*,FROM_UNIXTIME(a.gettime, '%Y-%m-%d %H:%i:%s') as gettime,game_name,c.gift_name,c.content from code as a, game as b,gamepacks as c
                where  $sql";
          $result= $model->query($sql);
          vendor('PHPExcel.PHPExcel');
          $objExcel = new \PHPExcel();
          //set document Property
          $objWriter = \PHPExcel_IOFactory::createWriter($objExcel, 'Excel2007');
          
          $objActSheet = $objExcel->getActiveSheet();
          
          $key = ord("A");
          $objActSheet->setCellValue('A1',"游戏名称");
          $objActSheet->setCellValue('B1',"礼包名称");
          $objActSheet->setCellValue('C1',"礼包码");
          $objActSheet->setCellValue('D1',"用户openid");
          $objActSheet->setCellValue('E1',"礼包内容");
          $objActSheet->setCellValue('F1',"领取时间");
          
          foreach ($result as $k => $value){           
              $objActSheet->setCellValue('A'.($k+2),$value['game_name']);
              $objActSheet->setCellValue('B'.($k+2),$value['gift_name']);
              $objActSheet->setCellValue('C'.($k+2),$value['code']);
              $objActSheet->setCellValue('D'.($k+2),$value['openid']);
              $objActSheet->setCellValue('E'.($k+2),$value['content']);
              $objActSheet->setCellValue('F'.($k+2),$value['gettime']);  
          }
          $objExcel->getActiveSheet()->getColumnDimension('A')->setWidth(20);
          $objExcel->getActiveSheet()->getColumnDimension('B')->setWidth(20);
          $objExcel->getActiveSheet()->getColumnDimension('C')->setWidth(25);
          $objExcel->getActiveSheet()->getColumnDimension('D')->setWidth(20);
          $objExcel->getActiveSheet()->getColumnDimension('E')->setWidth(20);
          $objExcel->getActiveSheet()->getColumnDimension('F')->setWidth(25);
        
          $outfile = "Record.xls";         
          //export to exploer
          header("Content-Type: application/force-download");
          header("Content-Type: application/octet-stream");
          header("Content-Type: application/download");
          header('Content-Disposition:inline;filename="'.$outfile.'"');
          header("Content-Transfer-Encoding: binary");
          header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
          header("Pragma: no-cache");
          $objWriter->save('php://output');
          exit;
         
     }
     
     public function deleGift(){
         $Model=M();
         $giftsid=$_POST['giftsid'];
         $Model->table('code')->where('giftsid="'.$giftsid.'"')->delete();
         $result=$Model->table('gamepacks')->where('giftsid="'.$giftsid.'"')->delete();
           
         if($result){
             echo 'true';
         }else{
             echo 'false';              
         }
        
     }
     
     public function editGift(){  
         $id=$_GET['giftsid'];
         $data=M()->table('gamepacks')->join('game on gamepacks.game_id=game.gameid')->field('gamepacks.*,game.*,FROM_UNIXTIME(gamepacks.endtime, "%Y-%m-%d") as endtime1')->where('gamepacks.giftsid="'.$id.'"')->select();
         foreach ($list as $k=>$v){
             if($v['endtime']==0){
                 $list[$k]['endtime1']=0;
             }
         }
         $this->assign('list',$data[0]);
        $this->display('Index/editPage');
     
     }
     
     public function editGiftSave(){
         $Model=M();
         $where['giftsid']=$_POST['giftsid'];
         $data['gift_name']=$_POST['gift_name'];
         $data['token']=$_POST['token'];
         $data['content']=$_POST['content'];
         $data['content'] = str_replace("\n", '<br>', $data['content']);
         if(strtotime($_POST['endtime'])!=0){
             $data['endtime']=strtotime($_POST['endtime'])+86399;
         }

         $data['shuoming']=$_POST['shuoming'];
         $data['shuoming'] = str_replace("\n", '<br>', $data['shuoming']);
         $data['platform']=$_POST['platform'];

         $result=$Model->table('gamepacks')->where($where)->save($data);
         if($result){
             echo 'true';
         }else{
             echo 'false';
         }
         
     }
    

    
}