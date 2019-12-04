<?php
    namespace app\publicapp\controller;
    use think\Controller;
    use think\Session;
    use think\Request;
    use app\publicapp\model\Scan as ScanModel;
    class Scan extends Base
    {
     	public function scan(Request $request){
            $status=0;
            $data=$request->param();//保存获取用户提过来的数据
            if( empty($data) ){
                $result="数据为空";
            }else{
                if($data['f_id']!=''){
                    $map =[
                        'f_id'=>$data['f_id']
                    ];
                }else{
                    $map =[
                        'v_id'=>$data['v_id']
                    ];
                }
            
           
            $s=ScanModel::get($map);
            if($s==null){
                 $con=new ScanModel();
            $con->data([
                    'u_id'=>$data["u_id"],
                    'time'=>$data["time"],
                    'f_id'=>$data["f_id"],
                    'v_id'=>$data["v_id"],
                ]);
              $con->save();
              $result="浏览成功";
              $status=1;
            }else{
              $result="已浏览过";
            }
           
            }

         
            $data=array('status' => $status , 'result'=>$result);
            
            return json_encode($data);
        }

        public function scandetail($id){
            $f=new ScanModel();
            $f=$f->where('u_id',$id)
            ->field(['v_id'=>'key2','time'=>'value','f_id'=>'key'])
            ->order('s_id','desc')
            ->select();
            $data=$f->toArray();
            return json_encode($data);
        }
    }