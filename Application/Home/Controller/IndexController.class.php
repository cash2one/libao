<?php
namespace Home\Controller;

use Think\Controller;

class IndexController extends Controller
{
    public function index()
    {
       date_default_timezone_set('PRC');
       $Model=M();
       if(isset($_POST['submit'])){
          
           $game['game_name']=$_POST['game_name'];
           $data['game_id']=$Model->table('game')->add($game);
           $data['gift_name']=$_POST['gift_name'];
           $data['token']=$_POST['token'];
           $data['content']=$_POST['content'];
           $data['endtime']=strtotime($_POST['endtime']);
           $giftsid=$Model->table('gamepacks')->add($data);
           $a=$this->upload();
           $this->importExcel($a,$giftsid);
       }
      
       
       // $this->display('input');
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
            $data['giftsid=']=$id;
            $data['code=']=trim($val);
            $Model->table('code')->add( $data);
            $i++;
        }
       
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
            $this->error($upload->getError());
        }else{// 上传成功
            $this->success('上传成功！');
        }
        return $upl;
        
    }
   
}