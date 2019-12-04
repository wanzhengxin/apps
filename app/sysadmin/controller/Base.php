<?php
    namespace app\sysadmin\controller;
    use think\Controller;
    use think\Session;
    class Base extends Controller
    {
     	protected function _initialize(){
     		parent::_initialize();//继承父类初始化1
     		define('USER_ID',Session::get('user_id'));

     	}
     	//判断用户是否登录，放在后台的入口：index/index
     	protected function isLogin(){
     		if(empty(USER_ID)){
     			$this->error('用户未登录，无权访问',url('index/login'));
     		}
     	}
     	//防止用户重复登录user/lgin
     	protected function alreadyLogin(){
     		if(!empty(USER_ID)){
     			$this -> error('用户已经登录，请勿重复登录',url('index/index'));
     		}
     	}
    }