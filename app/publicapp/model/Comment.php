<?php
namespace app\publicapp\model;
use think\Model;
use app\publicapp\model\User as UserModel;
class Comment extends Model
{
	 protected $select =[
		        'u_id'
			];
    public function getuIdAttr($u_id)
    {
      $user=UserModel::get($u_id);
      return $user['name'];
    }

}