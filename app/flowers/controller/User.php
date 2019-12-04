<?php

    namespace app\flowers\controller;

    use app\flowers\controller\Base;
    use think\Request;
    use app\flowers\model\User as UserModel;
    use think\Db;
    use think\Session;
    // use extend\php_sdk\AipImageClassify;
        // const APP_ID = '14778297';
        // const API_KEY = 'z9G7LDmewwP2eXbNVCGQ3nVD';
        // const SECRET_KEY = 'X6DVY7mgGY0Zyy0Nixfys3HwR7mMHztQ';

    class User extends Base
    {
 
    public function index(){
       dump(config());
     
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
            $user=UserModel::get($map);
            if($user == null){
                $result='没有找到用户';
               
            }else{
                $status=1;
                $result='登录成功';
                $user=$user->toArray();
            }
            }
            $a = array('status' => $status,'result'=>$result,'userinfo'=>$user);
            return json_encode($a);
    }

     public function users(){
        $res=Db::table('user')->order('u_id','ace')
                        ->where('u_id','>',0)
                        ->select();   
            $data=$res->toArray();
            return json_encode($data);
     }

   
}