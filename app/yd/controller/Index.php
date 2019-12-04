<?php
    namespace app\yd\controller;
    use think\Controller;
    use think\Session;
    use think\Db;
    class Index extends Base
    {
     

        public function config(){
            dump(config());
           
        }
        public function index(){
            $w_id=Session::get('user_info.w_id');

            $Session_Shop=Session::get('Session_Shop');
            $ShopUserCodeSession=Session::get('Session_Shop');
           
            return $this->view->fetch('index',[
                    'Session_Shop'=> $Session_Shop,
                    'ShopUserCodeSession'=> $ShopUserCodeSession
                ]);
        }
        public function login(){
            $this -> alreadyLogin();//防止重复登录
            return $this->view->fetch('index/login');
        }
        public function reg(){
            
            return $this->view->fetch('index/reg');
        }
        public function selectworker($p_id){
            
            $res =Db::table('worker')->where('place','=',$p_id)->column('w_id,name');
            
            return json_encode($res,JSON_UNESCAPED_UNICODE);
        }

        public function admin(){
            $f=Db::table('place');
            $list = $f->where('p_id','>',0)->order('p_id','desc')->paginate(10); // 把分页数据赋值给模板变量list 
            $this->assign('list', $list); // 渲染模板输出 
            return $this->fetch('admin/shoplist');
        }

         public function workerlist(){
            $f=Db::table('worker');
            $list = $f->where('w_id','>',0)->order('w_id','desc')->paginate(10); // 把分页数据赋值给模板变量list 
            $this->assign('list', $list); // 渲染模板输出 
            return $this-> view->fetch('admin/workerlist');
        }
        public function conghuafei(){
            $this -> isLogin();//防止重复登录
            $Session_Shop=Session::get('Session_Shop');
            $ShopUserCodeSession=Session::get('Session_Shop');
            $this->redirect("https://touch.10086.cn/i/mobile/rechargecredit.html?Session_Shop=".$Session_Shop."&isWd=1&OfficeBossNoSession=".$Session_Shop."&ShopUserCodeSession=".$ShopUserCodeSession);

        }
        public function bankuandai(){
            $this -> isLogin();//防止重复登录
            $Session_Shop=Session::get('Session_Shop');
            $ShopUserCodeSession=Session::get('Session_Shop');
            $this->redirect("http://wap.hi.10086.cn/hnlottery/broadbandorder/broadbandorder.do?Session_Shop=".$Session_Shop."&isWd=1&OfficeBossNoSession=".$Session_Shop."&ShopUserCodeSession=".$ShopUserCodeSession);

        }
        public function yd(){
            $this -> isLogin();//防止重复登录
            $Session_Shop=Session::get('Session_Shop');
            $ShopUserCodeSession=Session::get('Session_Shop');
            $this->redirect("http://wap.hi.10086.cn/fjwd/index.html?Session_Shop=".$Session_Shop."&ShopUserCodeSession=".$ShopUserCodeSession);

        }


       public function getToken(){

            $burl="https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=wx7316676cbe8e5c4b&secret=6dfc4a96ff94897912e5ef97f18399d9";
            $access_token_array = $this->get_curl_json($burl);
            $access_token = $access_token_array['access_token']; 
            // dump($access_token_array);
            $qrcode_url = 'https://api.weixin.qq.com/cgi-bin/qrcode/create?access_token=' . $access_token;
            // dump($qrcode_url);
            //post参数
            $post_data = '{"action_name": "QR_LIMIT_SCENE", "action_info": {"scene": {"scene_id":1001}}}'; 
            // dump($post_data);
            $json = $this->api_notice_increment($qrcode_url, $post_data); 
            dump($json);
             
        }
        public function api_notice_increment($url, $data){
            $ch = curl_init();
            $header = "Accept-Charset: utf-8";
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
            //curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
            curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (compatible; MSIE 5.01; Windows NT 5.0)');
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
            curl_setopt($ch, CURLOPT_AUTOREFERER, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $tmpInfo = curl_exec($ch);
            if (curl_errno($ch)) {
                curl_close( $ch );
                return $ch;
            }else{
                curl_close( $ch );
                return $tmpInfo;
            }

        }
        //curl操作,获取返回值,为数组类型
        public function get_curl_json($url){
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER,true);
            $result = curl_exec($ch);
            if(curl_errno($ch)){
                print_r(curl_error($ch));
            }
            curl_close($ch);
            return json_decode($result,TRUE);
        }



    }