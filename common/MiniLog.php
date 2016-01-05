<?php
class MiniLog{
    private static $_instance;//锟斤拷锟斤拷
    private $_path;//锟斤拷志目录
    private $_pid;//锟斤拷锟斤拷id
    private $_handleArr;//锟斤拷锟芥不同锟斤拷志锟斤拷锟斤拷锟侥硷拷fd
    /**
     * 锟斤拷锟届函锟斤拷
     * @param $path 锟斤拷志锟斤拷锟斤拷锟接︼拷锟斤拷锟街灸柯�
     */
    function __construct ($path){
        $this->_path=$path;
        $this->pid=getmypid();
    }
    private function __clone(){
        
    }
    
    /*
     * 锟斤拷锟斤拷锟斤拷锟斤拷
     * */
    public static function instance($path = '/tmp/'){
        if(!(self::$_instance instanceof self)){
            self::$instance=new self($path);
        }
        
        return self::$_instance;
    }
    
    /*
     * 锟斤拷锟斤拷锟侥硷拷锟斤拷锟斤拷取锟侥硷拷fd
     * 
     * @param $fileName
     * return wenjan fd
     * */
    private function getHandle ($filename){
        if($this->_handleArr[$filename]){
            return $this->_handleArr[$filename];
        }
        date_default_timezone_set('PRC');
        $nowTime = time();
        $logSuffix = date('Ymd',$nowTime);
        $handle = fopen($this->_path.'/'.$filename.$logSuffix.".log",'a');
        $this->_handleArr[$filename] = $handle;
        return $handle;
    }
    
    /*
     * 向文件中写文件
     *
     * @param $fileName
     * @param $message
     * */
    public function log($fileName,$message){
        $handle = $this->getHandle($fileName);
        //获取当前时间并进行格式化
        $nowTime = time();
        $logPreffix = date('Y-m-d H:i:s',$nowTime);
        //写文件
        fwrite($handle, "[$logPreffix][$this->_pid]$message\n");
        return true;
    }
    /*
     * 构造函数,关闭所有fd
     *
     * */
    function __destruct(){
        foreach ($this->_handleArr as $key => $item){
            if($item){
                fclose($item);
            }
        }
    }
    
}