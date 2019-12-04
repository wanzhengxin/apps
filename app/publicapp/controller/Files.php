<?php
    namespace app\publicapp\controller;
    use think\Controller;
    use think\Session;
    use think\Request;
    use app\publicapp\model\Files as FilesModel;
    use app\publicapp\model\Comment as Com;
    use app\publicapp\model\Theme as ThemeModel;
    use think\Db;
    class Files extends Base
    {
     	// public function files($count,$t_id){
      //       $f=new FilesModel();
      //       $f=$f->where('f_id','>',0)
      //       ->field(['f_id'=>'id','f_img'=>'img','title'=>'course','url'])
      //       ->where('t_id',$t_id)
      //       ->order('f_id','desc')
      //       ->page($count,3)
      //       ->select();
      //       $data=$f->toArray();
      //       return json_encode($data);
     	// }
        public function files(Request $req){
           $req=$req->param();
          // dump($req);
           $list= ThemeModel::with('FilesModel' , function($query){
                $query->withField();
            })->select($req);

           $data=$list->toArray();
           // dump($data);
           return json_encode($data);

        }
        public function filesdetail($id){
            $f=new FilesModel();
            $f=$f->where('f_id',$id)->field('theme,title,f_img,source,time,red_total')
            ->find();
            $content=$f->where('f_id',$id)->value('content');
            $b=explode("。",$content,4);
            $data=$f->toArray();
            //两个数组连接到一起
            $data=array_merge(array('content1'=>$b['0'],'content2'=>$b['1'],'content3'=>$b['2'],'content4'=>$b['3']),$data);
            return json_encode($data);
        }
        public function testfile($id){
            $f=new FilesModel();
            $f=$f->where('f_id',$id)->field(['content'=>'attr'])
            ->find();
          
            $data=$f->toArray();
            //两个数组连接到一起
            return json_encode($data);
        }
         public function fileslist(){
            $t_id=Session::get('user_info.t_id');
            $f=new FilesModel();
            $list = $f->where('t_id',$t_id) -> field('theme,title,f_img,source,time,f_id')
            ->order('f_id','desc')->paginate(5); // 把分页数据赋值给模板变量list 
            $this->assign('list', $list); // 渲染模板输出 
            return $this -> view -> fetch('files/fileslist');
        }

         //删除文章
          public function del_file(Request $request){
            $res=$request->param();
            $id=$res['id'];
            $exam=new FilesModel();
            $examdata =$exam->where('f_id','=',$id)->delete();  
            return 1;
        }
         public function addfile(Request $request){
                $data=$request->param();
                $id=$data['id'];

                return $this -> view -> fetch('teacher/addlist',[
                'name'=>'文章',
                'type'=>'file',
                'type1'=>'text',
                'name1'=>'文章封面图',
                'n'=>'',
                'n1'=>'',
                'name2'=>'文章来源',
                'name3'=>'文章内容',
                'id'=>$id
            ]);
        }
    }