<?php
namespace app\sysadmin\model;
use think\Model;
use think\Db;
class Yiqi extends Model{
	// public function getWIdAttr($w_id){
	// 	$res=Db::name('worker')->where('w_id',$w_id)->value('name');
	// 	return $res;
	// }    
	protected $select =[
		        'cl_id',
		        'com_id'
		 
			];


	// public function setadIdAttr()
	// {
	// 	return time();
	// }
	public function getclIdAttr($val)
	{ 
		$res = Db::name('classify')->where('cl_id' ,'=',$val)->value('c_name');
		return $res;
	}
	// public function setcTimeAttr()
	// {
	// 	return time();
	// }
	public function getcomIdAttr($val)
	{
		$res = Db::name('company')->where('com_id' ,'=',$val)->value('com_name');
		return $res;
	}
}
