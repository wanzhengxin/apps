<?php
namespace app\sysadmin\model;
use think\Model;
use think\Db;
class Classify extends Model{
	// public function getWIdAttr($w_id){
	// 	$res=Db::name('worker')->where('w_id',$w_id)->value('name');
	// 	return $res;
	// }    
	protected $select =[
		        'ad_id',
		        'c_time'
		 
			];


	public function setadIdAttr()
	{
		return time();
	}
	public function getadIdAttr($val)
	{ 
		$res = Db::name('admin')->where('ad_id' ,'=',$val)->value('ad_name');
		return $res;
	}
	public function setcTimeAttr()
	{
		return time();
	}
	public function getcTimeAttr($val)
	{
		return date('Y/m/d H:i',$val);
	}
}
