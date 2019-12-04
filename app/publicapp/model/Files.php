<?php
namespace app\publicapp\model;
use think\Model;
class Files extends Model{
	protected $insert =[
		        'time',"f_img"
			];

	public function setTimeAttr()
		{
			return time();
		}
	public function getTimeAttr($val)
	{
		return date('Y-m-d H-i-s',$val);
	}
	public function getFImgAttr($val)
	{
		return 'http://localhost/ThinkPHP/apps/public/static/'.$val;
	}
}