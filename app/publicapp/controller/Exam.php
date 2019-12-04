<?php
    namespace app\publicapp\controller;
    use think\Controller;
    use think\Session;
    use think\Request;
    use think\Db;
    use app\publicapp\model\Exam as ExamModel;
    use app\publicapp\model\ExamAnswer as AnswerModel;
    /**
    * 
    */
    class Exam extends Base
    {
    
        public function examadd(Request $request){
             $res=$request->param();
            $id=$res['id'];
            $this->assign('id', $id);
            return $this -> view -> fetch('exam/examindex',[
                'name'=>'考试',
                'type'=>'text',
                'type1'=>'text',
                'name1'=>'',
                'n'=>'none',
                'n1'=>'none',
                'name2'=>'',
                'name3'=>'结束语',
                'id'=>1
            ]);
        }


        public function examlist(Request $request){
            $res=$request->param();
            $id=$res['id'];
            $question=Db::name('exam_question')->where('exam_id','=',$id )
            ->field(['id','title','extra','score','answer','intro'])
            ->order('id','desc')->select();

            $question=$question->toArray();
            $len=count($question);
            for($i=0;$i<$len;$i++){
                    $answer=$question[$i]['answer'];
                    $id=$question[$i]['id'];
                    $list=$question[$i]['extra'];
                    //换掉空格换行等
                    $str = str_replace(array("\r\n", "\r", "\n"), "", $list);
                    $num=substr_count($str,'，');
                    $b=explode("，",$str,$num+1);

                    for($j=0;$j<$num+1;$j++){
                        $A=substr($b[$j],0,1);
                        $list = array('name'=>$id.$A,'value'=>$b[$j] );
                        $question[$i]['list'][$j]=$list;
                    }
                    }

            return json_encode($question);  
        }
        public function exams(Request $request){
            $res=$request->param();
             if( empty($res) ){
               $id=0;
            }else{
                 $id=$res['id'];
            }
           
            $t_id=Session::get('user_info.t_id');
            $exam = new ExamModel();
            $examdata = $exam->where('t_id','=',$t_id)->field(['id','title','begin_time','end_time'])
            ->order('id','desc')
            ->select();
            $list=$examdata->toArray();
            $this->assign('list', $list);
            $this->assign('id', $id);
         return $this -> view -> fetch('exam/exams');
            
            
        }
        public function exam_sub(Request $request){
            $res=$request->param();
            $id=$res['id'];
            $exam = Db::name('exam_question')
            ->where('exam_id','=',$id)
            ->field(['title','extra','score','answer','intro'])
            ->order('id','desc')
            ->select();
           
            $list=$exam->toArray();
            // dump($list); 
            $this->assign('exam_id', $id);
            $this->assign('list', $list);
            return $this->view->fetch('exam/exam_sub');
            
            
        }
        //插入题目数据
        public function insert_sub(Request $request){
            $data=$request->param();
            $exam_sub=Db::name('exam_question');
            $data=[
                    'title'=>$data["title"],
                    'extra'=>$data["extra"],
                    'intro'=>$data["intro"],
                    'exam_id'=>$data["exam_id"],
                    'score'=>$data["score"],
                    'answer'=>$data["answer"],
                ];
            $exam_sub->insert($data);
            return 1;
        }
         //插入试卷数据
        public function insert_exam(Request $request){
            $t_id=Session::get('user_info.t_id');
            $data=$request->param();
            $exam_sub=new ExamModel();
            $exam_sub->data([
                'theme_id'=>$data["id"],
                    'title'=>$data["title"],
                    'finish_tip'=>$data["finish_ship"],
                    'begin_time'=>$data["begin_time"],
                    'end_time'=>$data["end_time"],
                    't_id'=>$t_id
                ]);
            $exam_sub->save();
            return 1;
        }
        public function examTitle(Request $request){
            $res=$request->param();
            $id=$res['id'];
            $exam = new ExamModel();
            $examdata = $exam->where('id','>',0)->field(['id','title','begin_time','end_time','t_id','theme_id','theme_id'=>'the_id'])->select();
            $examdata=$examdata->toArray();
           
            $sub_sum=Db::name('exam_question')->where('exam_id','=',$id)->count();
            $sorce=Db::name('exam_question')->where('exam_id','=',$id)->sum('score');
            $examdata[0]['sub_sum']=$sub_sum;
            $examdata[0]['sorce']=$sorce;
            return json_encode($examdata);
        }
        //exam_answer
        
        public function insert_answer(Request $request){
            $data=$request->param();
            $exam=new AnswerModel();
            $exam->data([
                    'answer'=>$data["answer"],
                    'u_id'=>$data["u_id"],
                    'exam_id'=>$data["exam_id"],
                    'score'=>$data["score"],
                ]);
            $exam->save();
            return 1;
        }

         public function exam_answer(Request $request){
            $res=$request->param();
            $id=$res['id'];
            $exam=new AnswerModel();
            $examdata =$exam->where('exam_id','=',$id)->field(['id','u_id','exam_id','score','time'])
            ->order('id','desc')
            ->select();
            $list=$examdata->toArray();
            $this->assign('list', $list);
         return $this -> view -> fetch('exam/exam_answer');
        }

    }