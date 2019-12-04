<?php
namespace app\publicapp\model;
use think\Model;
use app\publicapp\model\Teacher as TeacherModel;
use app\publicapp\model\Theme as ThemeModel;
class Exam extends Model{
	protected $insert =[
		        'begin_time',
		        'end_time',
		        'cTime',
		        'theme_id'
			];

	
	public function getbeginTimeAttr($val)
	{
		return date('Y-m-d H-i',$val);
	}
	public function setbeginTimeAttr($val)
	{
		return strtotime($val);
	}
	public function setcTimeAttr()
	{
		return time();
	}
	public function getendTimeAttr($val)
	{
		return date('Y-m-d H-i',$val);
	}
	public function setendTimeAttr($val)
	{
		return strtotime($val);
	}
	public function gettIdAttr($val)
	{   $res=new TeacherModel();
		$name = $res->where('t_id','=',$val)->value('name');
		return $name;
	}
	public function getthemeIdAttr($val)
	{   $res=new ThemeModel();
		$name = $res->where('theme_id','=',$val)->value('name');
		return $name;
	}
}