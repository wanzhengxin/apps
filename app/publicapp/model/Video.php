<?php
namespace app\publicapp\model;
use think\Model;
class Video extends Model{
	protected $insert =[
		        'v_time'
			];

	public function setvTimeAttr()
		{
			return time();
		}
	public function getvTimeAttr($val)
	{
		return date('Y-m-d H-i-s',$val);
	}
}