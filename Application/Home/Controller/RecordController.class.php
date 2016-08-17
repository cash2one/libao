<?php
namespace Home\Controller;

use Think\Controller;

class RecordController extends Controller{
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
         $model=M();
       $sql="select a.*,b.game_name,FROM_UNIXTIME(a.endtime, '%Y-%m-%d %H:%i:%s') as endtime from gamepacks as a, game as b where a.game_id=b.gameid and a.giftsid='".$giftsid."'";
       $list= $model->query($sql);     
        $this->assign('list',$list[0]);
      
        $this->display('Index/importPackage');
    }
    
    //start
    public function exportExcel(){
        vendor('PHPExcel.PHPExcel');
        $objExcel = new \PHPExcel();
        //set document Property
        $objWriter = \PHPExcel_IOFactory::createWriter($objExcel, 'Excel2007');
    
        $objActSheet = $objExcel->getActiveSheet();
        $key = ord("A");
    
        $objActSheet->setCellValue("A1", 'test1');
        $objActSheet->setCellValue("A2", 'test2');
        $objActSheet->setCellValue("B1", 'test3');
        $objActSheet->setCellValue("B2", 'test4');
    
        $outfile = "test.xls";
    
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
    //end
     public function export(){

         $model=M();
         $sql=" a.giftsid=c.giftsid and b.gameid=c.game_id and  flag=1";
        // $sql=" a.giftsid=c.giftsid and b.gameid=c.game_id and  flag=1";
         
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
    

    
}