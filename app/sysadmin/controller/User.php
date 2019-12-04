<?php
    namespace app\sysadmin\controller;
    use app\syaadmin\controller\Base;
    use think\Request;
    use think\Db;
    use think\Session;
    
    class User extends Base
    {
 
    public function index(){
        $this->isLogin();
     
    }
    public function login(Request $request){
            $status=0;
            $data=$request->param();//保存获取用户提过来的数据
            $result=0;//返回错误信息
            // dump($data);
            if( empty($data) ){
                $user=null;
                $result="数据为空";
            }else{
         //构造查询条件
            $map =[
                'tel'=>$data['tel'],
                'password'=>$data['password']
            ];
            //查询用户信息
            $user=new UserModel();
            $user=$user->get($map);
            if($user == null){
                $result='没有找到用户';
               
            }else{
                $status=1;
                $result='登录成功';

               

            }
            }
             return $status; 
    }

     public function users(){
        $res=Db::table('user')->order('u_id','ace')
                        ->where('u_id','>',0)
                        ->select();   
            $data=$res->toArray();
            return json_encode($data);
     }  

        public function regin(Request $request){
                $status=0;
                $message='error';//返回错误信息
                $data=$request->param();//保存获取用户提过来的数据
                //验证规则
                //创建验证规则
                $rule=[
                    'w_id'=>"require",//必填
                    'tel|手机号'=>"require",
                    'name|姓名'=>"require"
                ];
                //自定义验证失败信息
                $msg=[
                    'w_id'=>['require'=>'未选择办卡员工'],
                    'tel'=>['require'=>'手机号不能为空,请检查'],
                    'name'=>['require'=>'姓名不能为空，请检查' ]
                ];
                //进行验证
                //只会返回true，或者错误信息
                $message =$this->validate($data,$rule,$msg);
                if($message === true){
                    $map =[
                        'tel'=>$data['tel']
                    ];
                    $user=UserModel::get($map);
     
                    if($user==null){ 
                            UserModel::create([
                            'w_id' => $data['w_id'],
                            'name'   => $data['name'],
                            'tel'      => $data['tel']
                            ]);
                            $status=1;
                            $message="注册成功";
                                Session::set('user_id',$user->u_id);//用户id

                                Session::set('user_info',$user->getData());//获取用户所有信息
                                $w_id=Session::get('user_info.w_id');
                                $Session_Shop=Db::table('worker')->where('w_id',$w_id)->value('Session_Shop');
                                $ShopUserCodeSession=Db::table('worker')->where('w_id',$w_id)->value('ShopUserCodeSession');
                                Session::set('Session_Shop',$Session_Shop);
                                Session::set('ShopUserCodeSession',$ShopUserCodeSession);
                        }else{
                            $message="该手机号已存在";
                        }
                }   
            $a = array('status' =>$status , 'message'=>$message,'data' =>$data);  
            return json_encode($a,JSON_UNESCAPED_UNICODE);
            }

        public function userlist(){
            $f=new UserModel();
            $list = $f->where('u_id','>',0)->order('u_id','desc')->paginate(10); // 把分页数据赋值给模板变量list 
            $this->assign('list', $list); // 渲染模板输出 
            return $this -> view -> fetch('admin/userlist');
        }
   
}