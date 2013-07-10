<?php
/**
 * ��ҳ�沼�ֵ��ṩ�ֲ��һ��������
 * 
 * @author zhouwei 2013-1-23
 */
class SweetLayout{
    /**
     * ���е�ͷ��js�ű�
     * @var array 
     */
	private $_headScript = array();
	
    /**
     * ���е�ͷ����CSS
     * @var array 
     */
	private $_headStyle = array();
	
    /**
     * ���еĵײ���js�ű�
     * @var type 
     */
	private $_footScript = array();
	
    /**
     * foot
     * @var array 
     */
	private $_foot = array();
	
    /**
     * tdk
     * @var string 
     */
	private $_tdk = null;
	
    /**
     * head
     * @var array 
     */
	private $_head = array();

    /**
     * layout��·��
     * @var string 
     */
	private $_layoutDir = null;
    
    /**
     * @var SweetLayout 
     */
    private static $_instance = null;
	
	const LAYOUT_HEADSCRIPT = 'layout_headscript';
	
	const LAYOUT_HEADSTYLE = 'layout_headstyle';
	
	const LAYOUT_HEAD = 'layout_head';
	
	const LAYOUT_TDK = 'layout_tdk';
	
	const LAYOUT_BODY = 'layout_body';
	
	const LAYOUT_FOOTSCRIPT = 'layout_footscript';
	
	const LAYOUT_FOOT = 'layout_foot';
    
    private function __construct(){
        $this->_layoutDir = SweetConfig::getInstance()->getLayoutDir();
	}
    
    /**
     * ��ȡlayout�ĵ���
     * @return SweetLayout
     * @author zhouwei 2013-1-25 
     */
    public static function getInstance(){
        if (null === self::$_instance){
            self::$_instance = new self();
        }
        return self::$_instance;
    }
	
    /**
     * ��ʼ��layout����������Ѿ����Ƶ�body��
     * @return void
     * @author zhouwei 2013-1-25 
     */
    public function initLayout(){
        $this->_headScript  = array();
        $this->_headStyle   = array();
        $this->_footScript  = array();
        $this->_foot        = array();
        $this->_tdk         = null;
        $this->_head        = array();
    }
    
	/**
	 * �õ�layoutչʾ��ȥ�����б���
	 * @param array $params
     * @return array
	 * @author zhouwei 2013-1-23
	 */
	public function getLayoutBodys(array $params = array()){
		$layoutparams = array(
			self::LAYOUT_HEADSCRIPT 	=> $this->getHeadScript(true),
			self::LAYOUT_HEADSTYLE  	=> $this->getHeadStyle(true),
			self::LAYOUT_HEAD	   		=> $this->getHead(true),
			self::LAYOUT_TDK			=> $this->getTDK(),	
			self::LAYOUT_BODY			=> $params[self::LAYOUT_BODY],
			self::LAYOUT_FOOTSCRIPT		=> $this->getFootScript(true),
			self::LAYOUT_FOOT			=> $this->getFoot(true)
		);
		unset($params[self::LAYOUT_BODY]);
		return array_merge($layoutparams,$params);
	}
	
	/**
	 * ���ͷ�ű�����
	 * @param string $content
     * @return void
	 * @author zhouwei 2013-1-23
	 */
	public function appendHeadScript($content){
		$this->_headScript[] = $content;
	}
	
	/**
	 * ���ͷ��ʽ����
	 * @param string $content
     * @return void
	 * @author zhouwei 2013-1-23
	 */
	public function appendHeadStyle($content){
		$this->_headStyle[] = $content;
	}
	
	/**
	 * ���TDK
	 * @param string $content
     * @return void
	 * @author zhouwei 2013-1-23
	 */
	public function appendTDK($content){
		$this->_tdk = $content;
	}
	
	/**
	 * ���ͷ���Զ����һЩ����
	 * @param string $content
     * @return void
	 * @author zhouwei 2013-1-23
	 */
	public function appendHead($content){
		$this->_head[] = $content;
	}
	
	/**
	 * ��ӽ�JS�ļ�����
	 * @param string $content
     * @return void
	 * @author zhouwei 2013-1-23
	 */
	public function appendFootScript($content){
		$this->_footScript[] = $content;
	}
	
	/**
	 * ��ӽŲ�����
	 * @param string $content
     * @return void
	 * @author zhouwei 2013-1-23
	 */
	public function appendFoot($content){
		$this->_foot[] = $content;
	}
	
	/**
	 * �õ�ͷjs����
	 * @param boolean $flag
     * @return array
	 * @author zhouwei 2013-1-23
	 */
	public function getHeadScript($flag = false){
        $headscript = '';
		if (true === $flag){
			foreach ($this->_headScript as $value){
				$headscript .= $value;
			}
			return $headscript;
		}
		return $this->_headScript;
	}
	
	/**
	 * �õ�ͷcss����
	 * @param boolean $flag
     * @return array
	 * @author zhouwei 2013-1-23
	 */
	public function getHeadStyle($flag = false){
        $headstyle = '';
		if (true === $flag){
			foreach ($this->_headStyle as $value){
				$headstyle .= $value;
			}
			return $headstyle;
		}
		return $this->_headStyle;
	}
	
	/**
	 * �õ�tdk
     * @return string
	 * @author zhouwei 2013-1-23
	 */
	public function getTDK(){
		return $this->_tdk;
	}
	
	/**
	 * �õ�ͷ����һЩ����
	 * @param boolean $flag
     * @return array
	 * @author zhouwei 2013-1-23
	 */
	public function getHead($flag = false){
        $head = '';
		if (true === $flag){
			foreach ($this->_head as $value){
				$head .= $value;
			}
			return $head;
		}
		return $this->_head;
	}
	
	/**
	 * �õ���js����
	 * @param boolean $flag
     * @return array
	 * @author zhouwei 2013-1-23
	 */
	public function getFootScript($flag = false){
        $footscript = '';
		if (true === $flag){
			foreach ($this->_footScript as $value){
				$footscript .=  $value;
			}
			return $footscript;
		}
		return $this->_footScript;
	}
	
	/**
	 * �õ��Ŵ���
	 * @param boolean $flag
     * @return array
	 * @author zhouwei 2013-1-23
	 */
	public function getFoot($flag = false){
        $foot = '';
		if (true === $flag){
			foreach ($this->_foot as $value){
				$foot .= $value;
			}
			return $foot;
		}
		return $this->_foot;
	}
    
    /**
     * ��ȡlayout��dir
     * @return string
     * @author zhouwei 2013-1-23 
     */
    public function getLayoutDir(){
        return $this->_layoutDir;
    }
}