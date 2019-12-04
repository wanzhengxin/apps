<?php
    namespace app\sysadmin\controller;
    use think\Controller;
    use think\Session;
    use think\Db;
    use app\sysadmin\model\Classify as ClassifyModel;
    class Index extends Base
    {
     

        public function config(){
            dump(config());
           
        }
        public function index(){
          
            return $this->view->fetch('index');
        }
        public function login(){
            $this -> alreadyLogin();//防止重复登录
            return $this->view->fetch('index/login');
        }
        public function reg(){
            
            return $this->view->fetch('index/reg');
        }
       //导出Excel表格
        public function daochu(){
            //导出Excel表格
            $expTitle = '导出测试';
            //表头
            $expCellName = [];
            $expCellName[] = ['id','ID'];
            $expCellName[] = ['name','姓名'];
            $expCellName[] = ['shouji','手机'];
            $expCellName[] = ['qq','QQ'];
            $expCellName[] = ['weixin','微信'];
            //导出数据，实际数据可以是从mysql导出
            $data = [];
            $data[] = ['id'=>1,'name'=>'张三','shouji'=>'15098881234','qq'=>'\'947803117','weixin'=>'zouseu'];
            $data[] = ['id'=>2,'name'=>'李四','shouji'=>'15098881234','qq'=>'\'947803117','weixin'=>'zouseu'];
            $expTableData = $data;
            exportExcel($expTitle, $expCellName, $expTableData);
        }
        public function classify(){
            $res=new ClassifyModel() ;
            $list=$res->all();
            return $list;
           
        }

    }