<?php
define("TOKEN", "shiva");
class Wechatsign extends Back_Controller{
    private $appId;
    private $appSecret;
    public function  __construct($appId, $appSecret){
       $this->appId = '你自己的APPID';  
       $this->appSecret= '你自己的APPSECRET';  
       
    }
    
    public function getBaseInfo(){
        //1.获取到code        
        $redirect_uri=urlencode("http://你的域名/Wechatsign/getUserOpenId");//这里的地址需要http://
        $url="https://open.weixin.qq.com/connect/oauth2/authorize?appid=".$this->appId."&redirect_uri=".$redirect_uri."&response_type=code&scope=snsapi_userinfo&state=123#wechat_redirect";
        header('location:'.$url);
    }
 
    public function getUserOpenId(){
        //2.获取到网页授权的access_token        
        $code = $_GET['code'];
        $url="https://api.weixin.qq.com/sns/oauth2/access_token?appid=".$this->appId."&secret=".$this->appSecret."&code=".$code."&grant_type=authorization_code ";
        //3.拉取用户的openid
        $res = $this->http_curl($url);
        echo $res;//打印即可看到用户的openid
        $data = json_decode($res,true);
        if(!empty($data['access_token']) && !empty($data['openid'])){
            $url = "https://api.weixin.qq.com/sns/userinfo?access_token=".$data['access_token']."&openid=".$data['openid']."&lang=zh_CN"; 
            $userInfo = $this->http_curl($url);
            echo $userInfo;
        }
    }
    
    public function valid(){
        $echoStr = $_GET["echostr"];
        //valid signature , option
        if($this->checkSignature()){
            echo $echoStr;
            exit;        
        }
    }
    
    
    private function checkSignature(){
        $signature = $_GET["signature"];
        $timestamp = $_GET["timestamp"];
        $nonce = $_GET["nonce"];     
        $token = TOKEN;
        $tmpArr = array($token, $timestamp, $nonce);
        sort($tmpArr);
        $tmpStr = implode( $tmpArr );
        $tmpStr = sha1( $tmpStr );
        if( $tmpStr == $signature ){
            return true;
        }else{
            return false;
        }
 
    }
    
    
    public function http_curl($url){
        $curl = curl_init();
        //设置抓取的url
        curl_setopt($curl, CURLOPT_URL, $url);
        //设置头文件的信息作为数据流输出
        curl_setopt($curl, CURLOPT_HEADER, 0);
        //设置获取的信息以文件流的形式返回，而不是直接输出。
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        //执行命令
        $data = curl_exec($curl);
        //关闭URL请求
        curl_close($curl);
        //显示获得的数据
        return $data;
    }
    
}
