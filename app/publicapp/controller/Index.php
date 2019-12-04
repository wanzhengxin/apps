<?php
    namespace app\publicapp\controller;
    use think\Controller;
    use think\Session;
    use think\Request;
    use think\Db;
    /**
    * 
    */
    class Index extends Base
    {
    	
        public function config(){
           dump(config());
        }
    	public function unit(){
            $res =Db::name('unit')->select();
            return json_encode($res->toArray());
    	}
    	public function teacherlist(Request $res){
            $data=$res->param();

            $res = Db::name('teacher')->where('unit_id','=',$data['id'])->column('name');
            return json_encode($res);

    	}
    }