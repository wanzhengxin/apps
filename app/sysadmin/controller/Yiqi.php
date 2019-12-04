<?php
    namespace app\sysadmin\controller;
    use think\Controller;
    use think\Session;
    use think\Db;
    use think\Request;
    use app\sysadmin\model\Yiqi as YiqiModel;
    use app\sysadmin\model\Classify as ClassifyModel;
    class Yiqi extends Base
    {
     

        
        public function yiqiview(){
            $res= new YiqiModel();
            $list = $res->where('yq_id','>',0)->paginate(10); // 把分页数据赋值给模板变量list 
            $this->assign('list', $list); // 渲染模板输出 
            return $this-> view->fetch('yiqi/yiqiview');
        }
        public function addview(){
            $res =new ClassifyModel();
            $list = $res ->where("cl_id",'>',0)->field('cl_id,c_name')->select();
            $list1 =Db::name("company")->where("com_id",'>',0)->field('com_id,com_name')->select();
            $this->assign('list', $list); // 渲染模板输出 
            $this->assign('list1', $list1); // 渲染模板输出 
          
            return $this-> view->fetch('yiqi/addview');
        }

        public function drugview(){
            $res= new YiqiModel();
            $list = $res->where('cl_id','=',3)->paginate(10); // 把分页数据赋值给模板变量list 
            $this->assign('list', $list); // 渲染模板输出 
            return $this-> view->fetch('yiqi/drugview');
        }

        //添加一条数据
        public function addone(Request $request){
            $data=$request->param();
            $yiqi = new YiqiModel(); 
            $yiqi->save([ 'cl_id' => $data['cla'], 'yq_name' => $data['name'], 'yq_ggxh' => $data['ggxh'],'com_id' => $data['com'],'yq_num' => $data['num'] ]); 
            $this -> success('添加成功','yiqi/yiqiview');
        }
 
    }