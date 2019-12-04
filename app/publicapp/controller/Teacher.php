<?php
    namespace app\publicapp\controller;
    use app\publicapp\controller\Base;
    use think\Request;
    use think\Session;
    use app\publicapp\model\Teacher as TeacherModel;
    use think\Db;
    class Teacher extends Base
    {
        public function index(){
            $t_id=Session::get('user_info.t_id');
            $filesnum =Db::table('files')->where('t_id', $t_id)->count();
            $videonum =Db::table('video')->where('t_id', $t_id)->count(); 
            $commentnum =Db::table('theme')->where('t_id', $t_id)->count(); 
            $usernum =Db::table('user')->where('t_id', $t_id)->count(); 

             return $this -> view -> fetch('teacher/index',[
                'filesnum'=>$filesnum,
                'videonum'=>$videonum,
                'commentnum'=>$commentnum,
                'usernum'=>$usernum,
            ]);
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
                't_id'=>$data['t_id'],
                'password'=>$data['password']
            ];
            //查询用户信息
            $user=TeacherModel::get($map);
            if($user == null){
                $result='没有找到用户';
               
            }else{
                $status=1;
                $result='登录成功';
              
               
                Session::set('user_info',$user->getData());//获取用户所有信息
            }
            }
             return $status; 
    }
    public function theme(){
            $t_id=Session::get('user_info.t_id');
            $f=Db::name('theme');
            $list =$f->where('t_id',$t_id) ->order('theme_id','desc')->paginate(8); // 把分页数据赋值给模板变量list 
            $this->assign('list', $list); // 渲染模板输出 
            return $this -> view -> fetch('teacher/theme');
        }
    public function addtheme(){

             return $this -> view -> fetch('teacher/addlist',[
                'name'=>'主题',
                'type'=>'text',
                'type1'=>'text',
                'name1'=>'主题描述',
                'n'=>'none',
                'n1'=>'',
                'name2'=>'',
                'name3'=>'其他',
                'id'=>1
            ]);
    }

    
}