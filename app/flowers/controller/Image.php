<?php
    namespace app\flowers\controller;
    use think\Controller;
    use think\Loader;
    use think\Request;
	const APP_ID = '14778297';
    const API_KEY = 'z9G7LDmewwP2eXbNVCGQ3nVD';
    const SECRET_KEY = 'X6DVY7mgGY0Zyy0Nixfys3HwR7mMHztQ';
    class Image extends Controller
    {

     	public function image_dist()
     	{
     		//植物识别算法，调用百度api
     		$a=Loader::import('php_sdk.AipImageClassify',EXTEND_PATH);
		    
		  	
		  	$image =request()->file("image");


		  	if($image == null){
		  		return -1;
		  	}else{
		  		$img=$image->move(ROOT_PATH . 'public/static/image/flower_image','');
                if($image){
                    $v_url='public\static\image\flower_image';
                    $v_img=$img->getSaveName();
                    $root= ROOT_PATH . $v_url . DS . $v_img;
	                $image = file_get_contents($root);
				  	// 调用植物识别
					// 实例化需要加\斜杠
					$client = new \AipImageClassify(APP_ID, API_KEY, SECRET_KEY);
					$client->plantDetect($image);
					// // 如果有可选参数
					$options = array();
					$options["baike_num"] = 1;//返回5条数据
					// // 带参数调用植物识别
					$data=$client->plantDetect($image, $options);
					
					return json_encode($data);
                }
		  		
		  	}
			
			

     		
     	}
     
     	

	}
