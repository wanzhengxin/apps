<?php
namespace app\publicapp\model;
use think\Model;
use app\publicapp\model\Teacher as TeacherModel;
class ExamAnswer extends Model{
	protected $insert =[
		    
		        'time',
			];

	
	public function gettimeAttr($val)
	{
		return date('Y-m-d H-i',$val);
	}
	public function settimeAttr()
	{
		return time();
	}
	
}