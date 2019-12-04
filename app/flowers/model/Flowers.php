<?php
namespace app\flowers\model;
use think\Model;
class Flowers extends Model{
	
	public function getImgSrcAttr($val)
	{
		return "http://localhost/ThinkPHP/apps/public/static".$val;
	}
}