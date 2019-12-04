<?php
    namespace app\publicapp\controller;
    use think\Session;
    use think\Request;
    use think\Db;
    use app\publicapp\model\Video as VideoModel;
    use app\publicapp\model\Files as FilesModel;
    class Video extends Base
    {
        public function video($count,$t_id){
            $f=new VideoModel();
            $f=$f->where('v_id','>',0)
            ->field(['v_id'=>'id','v_img'=>'img','v_name'=>'course','url'])
            ->where('t_id',$t_id)
            ->order('v_id','desc')
            ->page($count,6)
            ->select();
            $data=$f->toArray();
            
            return json_encode($data);
        }
        public function videoVideo($t_id){
            $f=new VideoModel();
            $f=$f->where('v_id','>',0)
            ->field(['v_id'=>'id','v_img'=>'img','v_name'=>'course','url'])
            ->where('t_id',$t_id)
            ->order('v_id','desc')
            ->select();
            $data=$f->toArray();
            
            return json_encode($data);
        }


        public function videodetail($id){
            $f=new VideoModel();
            $src=$f->where('v_id',$id)->field('src,v_img')->select();
            return json_encode($src);
        }
        public function videos(){
            $t_id=Session::get('user_info.t_id');
            $f=new VideoModel();
            $list = $f->where('t_id',$t_id) ->order('v_id','desc')->paginate(5); // 把分页数据赋值给模板变量list 
            $url='video/del_video';
            $this->assign('list', $list); // 渲染模板输出 
            $this->assign('url',$url ); // 渲染模板输出 
             return $this -> view -> fetch('video/videos');
        }

        //删除视频
          public function del_video(Request $request){
            $res=$request->param();
            $id=$res['id'];
            $exam=new VideoModel();
            $examdata =$exam->where('v_id','=',$id)->delete();  
            return 1;
        }

         public function addvideo(Request $request){
                $data=$request->param();
                $id=$data['id'];
                return $this -> view -> fetch('teacher/addlist',[
                'name'=>'视频',
                'type'=>'file',
                'type1'=>'file',
                'name1'=>'视频封面图',
                'n'=>'',
                'n1'=>'',
                'name2'=>'视频上传',
                'name3'=>'视频简介',
                'id'=>$id
            ]);
        }
        public function upload(Request $request){
            $data=$request->param();
            $type=$data['type'];
            $id=$data['id'];
            $t_id=Session::get('user_info.t_id');
           
                switch ($type) {
                    case '主题':
                    $name=$data["name"];
                    $name1=$data["name1"];
                    $d=['name'=>$name,'miaoshu'=>$name1,'t_id'=>$t_id];
                                    $res=Db::name('theme');
                                    $res->insert($d);
                                   $this -> success('添加成功','teacher/theme');
                        break;
                    case '文章':
                    $name1 =request()->file("name1");
                    $name=$data["name"];
                    $name2=$data["name2"];
                    $name3=$data["name3"];
                    $v_img=$name1;
                 
                       if($v_img){  
                                $v_img = $v_img->move(ROOT_PATH . 'public/static/images/admin','');
                                if($v_img){
                                    $v_url='images/admin/';
                                    $v_img=$v_img->getSaveName();
                                    $v_img = iconv("GB2312", "UTF-8", $v_img);
                                    $d=['f_img'=>$v_url.$v_img,'title'=>$name,'theme'=>$id,'source'=>$name2,'content'=>$name3,'t_id'=>$t_id];
                                    $res=new FilesModel();
                                    $res->save($d);
                                   $this -> success('添加成功','files/fileslist');
                                
                                }else{
                                    // 上传失败获取错误信息
                                    echo $file->getError();
                                   
                                }
                            }else{
                                 $d=['title'=>$name,'theme'=>$id,'source'=>$name2,'content'=>$name3,'t_id'=>$t_id];
                                    $res=new FilesModel();
                                    $res->save($d);
                                   $this -> success('添加成功','files/fileslist');
                            }
                        break;
                    case '话题研讨':
                   
                    $name=$data["name"];
                  
                    $d=['name'=>$name,'theme'=>$id,'t_id'=>$t_id];
                                    $res=Db::name('topic');
                                    $res->insert($d);
                                   $this -> success('添加成功','topic/topiclist');
                        break;
                    case '视频':
                    $name1 =request()->file("name1");   
                    $name2=request()->file("name2");
                    $name=$data["name"];
                    $name3=$data["name3"];
                    $v_img=$name1;
                    $src=$name2;
                 
                       if($v_img &&$src){  
                                $video = $src->move(ROOT_PATH . 'public/static/videos','');
                                $v_img = $v_img->move(ROOT_PATH . 'public/static/images/admin','');
                                if($v_img && $video){
                                    $url='videos/';
                                    $v_url='images/admin/';
                                    $v_img=$v_img->getSaveName();
                                    $v_img = iconv("GB2312", "UTF-8", $v_img);
                                    $video=$video->getSaveName();
                                    $video = iconv("GB2312", "UTF-8", $video);
                                    $d=['v_img'=>$v_url.$v_img,'v_name'=>$name,'theme'=>$id,'src'=> $url.$video,'v_jianjie'=>$name3,'t_id'=>$t_id];
                                    $res=new VideoModel();
                                    $res->save($d);
                                   $this -> success('添加成功','video/videos');
                                
                                }else{
                                    // 上传失败获取错误信息
                                    echo $file->getError();
                                    echo $video->getError();
                                }
                            }
           
                        break;
                    case '学生':
                    $name=$data["name"];
                    $name1=$data["name1"];
                     $name2=$data["name2"];
                     $name3=$data["name3"];
                    $d=['u_id'=>$name1,'password'=>$name1,'name'=>$name,'phone'=>$name2,'role'=>$name3,'t_id'=>$t_id];
                                    $res=Db::name('user');
                                    $res->insert($d);
                                   $this -> success('添加成功','user/userlist');
                        break;
           }
    
        }

    

          
           
        
    }