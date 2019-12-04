<?php
    namespace app\sysadmin\controller;
    use think\Controller;
    use think\Session;
    use think\Db;
    use app\sysadmin\model\Apply as ApplyModel;
    // use app\sysadmin\model\Classify as ClassifyModel;
    class Apply extends Base
    {
     

        
        public function applyview(){
            $res= new ApplyModel();
            $list = $res->where('ap_id','=',0)->paginate(5); // 把分页数据赋值给模板变量list 
            $this->assign('list', $list); // 渲染模板输出 
             $list2 = $res->where('ap_id','=',1)->paginate(5); // 把分页数据赋值给模板变量list 
            $this->assign('list2', $list2); // 渲染模板输出 
            return $this-> view->fetch('apply/applyview');
        }
        // public function addview(){
        //     $res =new ClassifyModel();
        //     $list = $res ->where("cl_id",'>',0)->field('cl_id,c_name')->select();
           
        //     $this->assign('list', $list); // 渲染模板输出 
          
        //     return $this-> view->fetch('yiqi/addview');
        // }

        // public function drugview(){
        //     $res= new YiqiModel();
        //     $list = $res->where('cl_id','=',3)->paginate(10); // 把分页数据赋值给模板变量list 
        //     $this->assign('list', $list); // 渲染模板输出 
        //     return $this-> view->fetch('yiqi/drugview');
        // }
 
    }