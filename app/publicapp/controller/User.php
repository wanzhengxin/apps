<?php

    namespace app\publicapp\controller;

    use app\publicapp\controller\Base;
    use think\Request;
    use app\publicapp\model\User as UserModel;
    use think\Db;
    use think\Session;
    
    class User extends Base
    {
 
    public function index(){
        return $this -> view -> fetch('teacher/login');
     
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
                'u_id'=>$data['u_id'],
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
    public function userlist(){
            $t_id=Session::get('user_info.t_id');
            $f=new UserModel();
            $list = $f->where('t_id',$t_id)->paginate(10); // 把分页数据赋值给模板变量list 
            $this->assign('list', $list); // 渲染模板输出 
            return $this -> view -> fetch('user/userlist');
        }

    public function adduser(){
        
               return $this -> view -> fetch('teacher/addlist',[
                'name'=>'学生',
                'type'=>'text',
                'type1'=>'text',
                'name1'=>'学号',
                'n'=>'',
                 'n1'=>'',
                'name2'=>'手机',
                'name3'=>'角色',
                'id'=>1
            ]);
        }

    public function regin(Request $request){
                $status=0;
                $message='error';//返回错误信息
                $data=$request->param();//保存获取用户提过来的数据
                //验证规则
                //创建验证规则
                $rule=[
                    'u_id'=>"require",//必填
                    't_id'=>"require",//必填
                    'phone|手机号'=>"require",
                    'name|姓名'=>"require",
                ];
                //自定义验证失败信息
                $msg=[
                    'u_id'=>['require'=>'学号为空'],
                    'phone'=>['require'=>'手机为空'],
                    'name'=>['require'=>'姓名为空' ]
                ];
                $t_name=$data['t_id'];
                $t_id=Db::name('teacher')->where('name','=',$t_name)->value('t_id');
                //进行验证
                //只会返回true，或者错误信息
                $message =$this->validate($data,$rule,$msg);
                if($message === true){
                    $map =[
                        'u_id'=>$data['u_id']
                    ];
                    $user=UserModel::get($map);
     
                    if($user==null){ 
                            UserModel::create([
                            'u_id' => $data['u_id'],
                            'password' => $data['u_id'],
                            'name'   => $data['name'],
                            'phone'      => $data['phone'],
                            'sex'      => $data['sex'],
                            't_id'      => $t_id,
                            ]);
                            $status=1;
                            $message="注册成功";
                              
                        }else{
                            $message="学号已存在";
                        }
                }   
            $a = array('status' =>$status , 'message'=>$message,'data' =>$data);  
            return json_encode($a,JSON_UNESCAPED_UNICODE);
    }
}