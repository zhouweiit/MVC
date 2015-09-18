<?php
class ResponseController{
    /**
     * 响应体
     * @var array 
     */
    private $_responseBody = array();

    /**
     * 头信息的数组
     * @var array 
     */
    private $_header = array();

    public function __construct() {
    }

    /**
     * 发送reponse
     * @return void
     * @author zhouwei 2013-1-23 
     */
    public function sendResonse(){
        $this->sendHead();
        $this->sendBody();
    }

    /**
     * 发送head
     * @return void
     * @author zhouwei 2013-1-23 
     */
    private function sendHead($key = null){
        if (null === $key){
            foreach ($this->_header as $value){
                header($value['header'],$value['replace'],$value['httpCode']);
            }
        } else {
            header($this->_header[$key]['header'],$this->_header[$key]['replace'],$this->_header[$key]['httpCode']);
        }
    }

    /**
     * 添加需要展示的body
     * @param string $key 添加的key
     * @param string $appendBody 添加返回的体
     * @return void
     * @author zhouwei 2013-1-23
     */
    public function appendBody($key,$appendBody){
        $key = (string) $key;
        $this->_responseBody[$key] = (string) $appendBody;
    }

    /**
     * 展示返回的信息
     * @return void
     * @author zhouwei 2013-1-23  
     */
    public function sendBody($key = null){
        if (null === $key){
            foreach ($this->_responseBody as $value){
                echo $value;
            }
        } else {
            echo $this->_responseBody[$key];
        }
    }

    /**
     * 获取返回的body提
     * @return array
     * @author zhouwei 2013-1-23 
     */
    public function getResponseBody(){
        return $this->_responseBody;
    }

    /**
     * 设置头部信息
     * @param string $header
     * @param boolean $replace 
     * @param int $httpCodes
     * @return array
     * @author zhouwei 2013-1-23 
     */
    public function setHead($key,$header,$replace = true,$httpCode = null){
        $this->_header[$key] = array(
                'header'    => $header,
                'replace'   => $replace,
                'httpCode'  => $httpCode
                );
    }

    /**
     * 设置跳转
     * @param string $url 
     * @author zhouwei 2013-1-23
     */
    public function redirect($url){
        $this->appendBody('location','<script>location.href = "'.$url.'";</script>');
        $this->sendBody('location');
        $this->clearBody('location');
        exit;
    }

    /**
     * 提交一个alert框
     * @param string $message 
     * @author zhouwei 2013-1-25
     */
    public function alert($message){
        $this->appendBody('alert','<script>alert("'.$message.'");</script>');
        $this->sendBody('alert');
        $this->clearBody('alert');
    }

    /**
     * 清理需要发送boby体
     * @return void
     * @author zhouwei 2013-1-23  
     */
    public function clearBody($key = null){
        if (null === $key){
            $this->_responseBody = array();
        }
        unset($this->_responseBody[(string)$key]);
    }

    /**
     * 清理需要发送的head
     * @return void
     * @author zhouwei 2013-1-23 
     */
    public function clearHead($key = null){
        if (null === $key){
            $this->_header = array();
        }
        unset($this->_header[(string)$key]);
    }
}
