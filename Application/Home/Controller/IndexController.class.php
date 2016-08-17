<?php

namespace Home\Controller;

use Think\Controller;
header("Content-Type: text/html;charset=utf8");
class IndexController extends Controller
{
    public function index()
    {
       date_default_timezone_set('PRC');
       $Model=M();
   
       if(isset($_POST['submit'])){ 
        
           $game['game_name']=$_POST['gamename'];
           
           $sql='select gameid from game where game_name="'.$game['game_name'].'"';
           $result=$Model->query($sql);
           if($result){
               $data['game_id']=$result[0]['gameid'];
           }else{
               $data['game_id']=$Model->table('game')->add($game);
           }
           
          
           $data['gift_name']=$_POST['giftname'];
           $data['token']=$_POST['token'];
           $data['content']=$_POST['content'];
           $data['content'] = str_replace("\n", '<br>', $data['content']);
           $data['endtime']=strtotime($_POST['time'])+86399;
           $data['shuoming']=$_POST['shuoming'];
           $data['shuoming'] = str_replace("\n", '<br>', $data['shuoming']);
           $data['platform']=$_POST['platform'];
           $giftsid=$Model->table('gamepacks')->add($data);
           $a=$this->upload();
           $this->importExcel($a,$giftsid);
        
      
       }
      // $this->display('Index/wechatGiftbagIndex');
    }
    
    
    public function importExcel($save,$id){
        $Model=M();
        vendor('PHPExcel.PHPExcel');
        $PHPExcel = new \PHPExcel();
        $saveFile = 'Public/'.$save;
        $PHPReader = new \PHPExcel_Reader_Excel2007();
        if(!$PHPReader->canRead($saveFile)){
            $PHPReader = new \PHPExcel_Reader_Excel5();
            if(!$PHPReader->canRead($saveFile)){
                echo 'no Excel';
                return ;
            }
        }
    
        $PHPExcel = $PHPReader->load($saveFile);
        $currentSheet = $PHPExcel->getSheet(0);
        /**get max column*/
        $allColumn = $currentSheet->getHighestColumn();
        /**get max row*/
        $allRow = $currentSheet->getHighestRow();
        $return = array();
        $i=0;
        for($currentRow = 1;$currentRow <= $allRow;$currentRow++){
            for($currentColumn= 'A';$currentColumn<= $allColumn; $currentColumn++){
                $count = ord($currentColumn) - 65;
                $val = $currentSheet->getCellByColumnAndRow($count,$currentRow)->getValue();
            }
            if(!empty($val)){
                $data[$i]['giftsid']=$id;
                $data[$i]['code']=trim($val);
                $i++;
            }
           
        }
     
        $result=$Model->table('code')->addAll( $data);
        if($result){
            $Model->table('gamepacks')->where("giftsid='$id'")->setInc('stock',$i);
            echo "<script language=javascript>alert('上传完成\\n礼包数量$i');location.href='index.php?m=Home&c=Record&a=lists'</script>";
            exit;
        }else{
            echo "<script language=javascript>alert('上传失败\\n礼包码存在重复，请检查文件');location.href='index.php?m=Home&c=Record&a=lists'</script>";
            exit;
          //  $this->error("上传失败\n礼包码存在重复，请检查文件","index.php?m=Home&c=Record&a=lists");
        }       
       
    }
     
    
    //上传文件
    public function upload() {
     //  import("Think.Upload"); 
        $upload = new \Think\Upload();// 实例化上传类
        $upload->maxSize  = 31457280000 ;// 设置附件上传大小
        $upload->exts  = array('xls', 'xlsx');// 设置附件上传类型
        $upload->rootPath='./Public/';
        $upload->savePath =  'Uploads/';// 设置附件上传目录
        $upl=$upload->upload();
        if(!$upl) {// 上传错误提示错误信息       
        $message=$upload->getError();
          echo "<script language=javascript>alert('$message');location.href='index.php?m=Home&c=Record&a=lists'</script>";
          exit; 
        }

        return $upl;
        
    }
    
    public function importAgainDeal(){
        $a=$this->upload();
        $giftsid=$_POST['giftsid'];   
        try {
           $this->importExcel($a,$giftsid);     
        } catch (\Exception $e) {
            echo "<script>alert('上传失败\\n礼包码存在重复，请检查文件');location.href='index.php?m=Home&c=Record&a=lists'</script>";
            exit;
        }
        
       // $this->display('Index/wechatGiftbagIndex');      
    }
   
}
