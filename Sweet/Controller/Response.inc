<?php
class ResponseController{
    /**
     * ��Ӧ��
     * @var array 
     */
	private $_responseBody = array();
	
    /**
     * ͷ��Ϣ������
     * @var array 
     */
    private $_header = array();
    
    public function __construct() {
    }
    
    /**
     * ����reponse
     * @return void
     * @author zhouwei 2013-1-23 
     */
    public function sendResonse(){
        $this->sendHead();
        $this->sendBody();
    }
    
    /**
     * ����head
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
     * �����Ҫչʾ��body
     * @param string $key ��ӵ�key
     * @param string $appendBody ��ӷ��ص���
     * @return void
     * @author zhouwei 2013-1-23
     */
	public function appendBody($key,$appendBody){
        $key = (string) $key;
		$this->_responseBody[$key] = (string) $appendBody;
	}
	
    /**
     * չʾ���ص���Ϣ
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
     * ��ȡ���ص�body��
     * @return array
     * @author zhouwei 2013-1-23 
     */
	public function getResponseBody(){
		return $this->_responseBody;
	}
    
    /**
     * ����ͷ����Ϣ
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
     * ������ת
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
     * �ύһ��alert��
     * @param string $message 
     * @author zhouwei 2013-1-25
     */
    public function alert($message){
        $this->appendBody('alert','<script>alert("'.$message.'");</script>');
        $this->sendBody('alert');
        $this->clearBody('alert');
    }
    
    /**
     * ������Ҫ����boby��
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
     * ������Ҫ���͵�head
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