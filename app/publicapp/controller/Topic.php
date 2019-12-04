<?php
    namespace app\publicapp\controller;
    use think\Controller;
    use think\Session;
    use think\Request;
    use think\Db;
    class Topic extends Base
    {
     	public function topic($t_id,$u_id){
           $f=Db::table('topic')->distinct(true)->field('b.topic_id,b.name')
                        ->alias(['topic'=>'b','theme'=>'c','comment'=>'d'])
                        ->join('theme','b.theme= c.theme_id')
                        ->join('comment','b.topic_id=d.topic')
                        ->where('topic_id','>',0)
                        ->where('d.u_id',$u_id)
                        ->where('c.t_id',$t_id)
                        ->select();      
            $data1=$f->toArray();

            $v=Db::table('topic')->distinct(true)->field('b.topic_id,b.name')
                        ->alias(['topic'=>'b','theme'=>'c'])
                        ->join('theme','b.theme= c.theme_id')
                        ->where('topic_id','>',0)
                        ->where('c.t_id',$t_id)
                        ->select();      
            $data2=$v->toArray();

            if($data1==$data2){
                $data3=[];
            } else{
                 $data3=$this->RestaDeArrays($data2,$data1);
                
            }
           
            $a = array('a' =>$data1 ,'b'=>$data3);
            return json_encode($a);
     	}
        function RestaDeArrays($vectorA,$vectorB)
        {
          $cantA=count($vectorA);
          $cantB=count($vectorB);
          $No_saca=0;
          for($i=0;$i<$cantA;$i++)
          {
            for($j=0;$j<$cantB;$j++)
            {
             if($vectorA[$i]==$vectorB[$j])
             $No_saca=1;
            }
           if($No_saca==0)
           $nuevo_array[]=$vectorA[$i];
           else
           $No_saca=0;
           }
           return $nuevo_array;
        }
      public function progress($t_id,$u_id){
           $a=Db::table('topic')
                        ->alias(['topic'=>'b','comment'=>'d'])
                        ->join('comment','b.topic_id=d.topic')
                        ->where('d.u_id',$u_id)
                        ->count();
            $b=Db::table('files')
            ->alias(['files'=>'b','comment'=>'d'])
            ->join('comment','b.f_id=d.f_id')
            ->where('d.u_id',$u_id)
            ->count();  

            $c=Db::table('video')
            ->alias(['video'=>'b','comment'=>'d'])
            ->join('comment','b.v_id=d.v_id')
            ->where('d.u_id',$u_id)
            ->count();  
                      
            $a1=Db::table('topic')->where('t_id',$t_id)->count();
            $b1=Db::table('files')->where('t_id',$t_id)->count();
            $c1=Db::table('video')->where('t_id',$t_id)->count();

            if($a>=$a1){
               $a=$a1;
            }
            if($b>=$b1){
               $b=$b1;
            }
            if($c>=$c1){
               $c=$c1;
            }
            $array = array('a1' =>$a ,'b1'=>$a1,'a2' =>$b ,'b2'=>$b1,'a3' =>$c ,'b3'=>$c1);
            return json_encode($array);
      }
      public function addtopic(Request $request){
        $data=$request->param();
                $id=$data['id'];
               return $this -> view -> fetch('teacher/addlist',[
                'name'=>'话题研讨',
                'type'=>'text',
                'type1'=>'text',
                'name1'=>'',
                'n'=>'none',
                 'n1'=>'none',
                'name2'=>'',
                'name3'=>'其他',
                'id'=>$id
            ]);
        }
        public function topiclist(){
            $t_id=Session::get('user_info.t_id');
            $f=Db::name('topic');
            $list = $f->where('t_id',$t_id)->order('topic_id','desc')->paginate(10); // 把分页数据赋值给模板变量list 
            $this->assign('list', $list); // 渲染模板输出 
            return $this -> view -> fetch('topic/topiclist');
        }
    }