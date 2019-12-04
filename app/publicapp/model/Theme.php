<?php
namespace app\publicapp\model;
use think\Model;
class Theme extends Model{
	 public function filesmodel()
    {
        return $this->hasMany('Files','theme','theme_id')->field('theme_id,name');;
    }
}