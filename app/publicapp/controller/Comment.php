<?php
    namespace app\publicapp\controller;
    use think\Controller;
    use think\Session;
    use think\Request;
    use app\publicapp\model\Comment as Comments;
    use think\Db;
    class Comment extends Base
    {
     	public function insert(Request $request){
            $status=0;
            $data=$request->param();//保存获取用户提过来的数据
            if( empty($data) ){
                $result="数据为空";
            }else{
            $con=new Comments();
            $con->data([
                    'u_id'=>$data["u_id"],
                    'comment'=>$data["comment"],
                    'time'=>$data["time"],
                    'f_id'=>$data["f_id"]
                ]);
              $con->save();
              $result="评论成功";
              $status=1;
            }

         
            $data=array('status' => $status , 'result'=>$result);
            
            return json_encode($data);
     	}
        public function vinsert(Request $request){
            $status=0;
            $data=$request->param();//保存获取用户提过来的数据
            if( empty($data) ){
                $result="数据为空";
            }else{
            $con=new Comments();
            $con->data([
                    'u_id'=>$data["u_id"],
                    'comment'=>$data["comment"],
                    'time'=>$data["time"],
                    'v_id'=>$data["v_id"]
                ]);
              $con->save();
              $result="评论成功";
              $status=1;
            }

         
            $data=array('status' => $status , 'result'=>$result);
            
            return json_encode($data);
        }
        public function tinsert(Request $request){
            $status=0;
            $data=$request->param();//保存获取用户提过来的数据
            if( empty($data) ){
                $result="数据为空";
            }else{
            $con=new Comments();
            $con->data([
                    'u_id'=>$data["u_id"],
                    'comment'=>$data["comment"],
                    'time'=>$data["time"],
                    'topic'=>$data["t_id"]
                ]);
              $con->save();
              $result="评论成功";
              $status=1;
            }

         
            $data=array('status' => $status , 'result'=>$result);
            
            return json_encode($data);
        }
        public function fcomment($id){
            $f=new Comments();
            $f=$f->where('f_id',$id)
            ->field(['u_id'=>'name','time'=>'v_time','comment'])
            ->order('c_id','desc')
            ->page(1,10)
            ->select();
            $data=$f->toArray();
            return json_encode($data);
        }
        public function vcomment($id){
            $f=new Comments();
            $f=$f->where('v_id',$id)
            ->field(['u_id'=>'name','time'=>'v_time','comment'])
            ->order('c_id','desc')
            ->page(1,4)
            ->select();
            $data=$f->toArray();
            return json_encode($data);
        }
        public function tcomment($id){
            $f=new Comments();
            $f=$f->where('topic',$id)
            ->field(['u_id'=>'name','time'=>'v_time','comment'])
            ->order('c_id','desc')
            ->page(1,4)
            ->select();
            $data=$f->toArray();
            return json_encode($data);
        }
     public function commentlist($id){
          
           $t_id=Session::get('user_info.t_id');
            $f=new Comments();
              
            if( strlen($id)<4){
                 $list = $f->whereOr('v_id',$id)->whereOr('topic',$id) 
                -> field('c_id,u_id,comment,time')
                ->order('c_id','desc')->paginate(5); // 把分页数据赋值给模板变量list 
            }elseif (strlen($id)>=4) {
                $list = $f->where('f_id',$id)
                -> field('c_id,u_id,comment,time')
                ->order('c_id','desc')->paginate(5); // 把分页数据赋值给模板变量list 
            }
           
            $this->assign('list', $list); // 渲染模板输出 
            return $this  -> fetch('comment/commentlist');
           
        }

        public function mycomments($id){
            $f=new Comments();
            $f=$f->where('u_id',$id)->where('topic','>',0)
            ->field(['comment'=>'key','time'=>'value'])
            ->order('c_id','desc')
            ->select();
            $data=$f->toArray();
            return json_encode($data);
        }
    }