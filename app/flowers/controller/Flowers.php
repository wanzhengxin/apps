<?php
    namespace app\flowers\controller;
    use think\Controller;
    use think\Session;
    use think\Request;
    use app\flowers\model\Flowers as FlowersModel;
    use think\Db;
    class Flowers extends Base
    {
     	public function flowers($page,$per_page){
            $f=new FlowersModel();
            $f=$f->field(['id','name','img_src','describe','habit','type'=>'title','num'=>'img_num','othername'])
            ->page($page,$per_page)
            ->select();
           // dump($f);
            $data=$f->toArray();
            return json_encode($data);
        }
        public function typeflowers($type){
            $f=new FlowersModel();
            $f=$f->field(['id','name','img_src','describe','habit','type'=>'title','num'=>'img_num','othername'])
            ->where('type','=',$type)
            ->select();
            $data=$f->toArray();
            return json_encode($data);
        }
      
        public function getToken(){

         
            $info_url = ' http://139.199.70.203:61680/api/json/broker/virtual-hosts/sensor/topics/sensors/messages?from=0&max=25&max_body=100';
            $url_sign = 'http://139.199.70.203:61680/api/json/session/signin?username=sensor&password=sensor';
      
            $json = $this->get_head($url_sign);
            $json=base64_decode($json);
            $patterns = "/[\d.]+/"; //第一种
            preg_match_all($patterns,$json,$arr);
            $a=substr($json,1,34);
            $a1=explode(',',$a);
           
            return json_encode($arr);
           
        }
     
        public function getll(){
            while (true) {
                return $this->getToken();
            }
        }
        public function get_head($sUrl){
                $oCurl = curl_init();
                // 设置请求头, 有时候需要,有时候不用,看请求网址是否有对应的要求
                $header[] = "Content-type: application/x-www-form-urlencoded";
                $user_agent = "Mozilla/5.0 (Windows NT 6.1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/33.0.1750.146 Safari/537.36";
                curl_setopt($oCurl, CURLOPT_URL, $sUrl);
                curl_setopt($oCurl, CURLOPT_HTTPHEADER,$header);
                // 返回 response_header, 该选项非常重要,如果不为 true, 只会获得响应的正文
                curl_setopt($oCurl, CURLOPT_HEADER, true);
                // 是否不需要响应的正文,为了节省带宽及时间,在只需要响应头的情况下可以不要正文
                curl_setopt($oCurl, CURLOPT_NOBODY, true);
                // 使用上面定义的 ua
                curl_setopt($oCurl, CURLOPT_USERAGENT,$user_agent);
                curl_setopt($oCurl, CURLOPT_RETURNTRANSFER, 1 );
                // 不用 POST 方式请求, 意思就是通过 GET 请求
                curl_setopt($oCurl, CURLOPT_POST, false);
                 
                $sContent = curl_exec($oCurl);
                // 获得响应结果里的：头大小
                $headerSize = curl_getinfo($oCurl, CURLINFO_HEADER_SIZE);
                // 根据头大小去获取头信息内容
                $header = substr($sContent, 0, $headerSize);
                $Curl = curl_init();
                $Cookie=substr( $header, 134,43);
                $head[] = "Cookie:".$Cookie;
                $agent = "Mozilla/5.0 (Windows NT 6.1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/33.0.1750.146 Safari/537.36";
                curl_setopt($Curl, CURLOPT_URL, "http://139.199.70.203:61680/api/json/broker/virtual-hosts/sensor/topics/sensors/messages?from=0&max=25&max_body=100");
                curl_setopt($Curl, CURLOPT_HTTPHEADER,$head);
              
                // 是否不需要响应的正文,为了节省带宽及时间,在只需要响应头的情况下可以不要正文
                curl_setopt($Curl, CURLOPT_NOBODY, false);
                // 使用上面定义的 ua
                curl_setopt($Curl, CURLOPT_USERAGENT,$agent);
                curl_setopt($Curl, CURLOPT_RETURNTRANSFER, 1 );
                // 不用 POST 方式请求, 意思就是通过 GET 请求
                curl_setopt($Curl, CURLOPT_POST, false);
                 
                $Content = curl_exec($Curl);
                $d=explode(',',$Content);
                curl_close($Curl);
                curl_close($oCurl);
                $d=explode('"',$d[13]);
                return $d[3];
              
        }


        public function essay(){
            $res =Db::name("essay")->where('id','>',0)->select();
            $data=$res->toArray();
            // dump($data);
            return json_encode($data);
        }

      
    }