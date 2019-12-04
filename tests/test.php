<?php
$sql = "INSERT INTO `qrcode` (`addtime`) VALUES ('" . time() . "')"; 
 
mysql_query($sql); 
$scene_id = mysql_insert_id(); 
 
$url = 'https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=' . $appid . '&secret=' . $appsecret; 
$access_token_array = json_decode(curlGet($url), true); 
$access_token = $access_token_array['access_token']; 
//echo $access_token;exit;http://www.sucaihuo.com/project/wxvalid/index.php  
$qrcode_url = 'https://api.weixin.qq.com/cgi-bin/qrcode/create?access_token=' . $access_token; 
 
$post_data = array(); 
$post_data['expire_seconds'] = 3600 * 24; //有效时间 
$post_data['action_name'] = 'QR_SCENE'; 
$post_data['action_info']['scene']['scene_id'] = $scene_id; //传参用户uid，微信端可获取 
$json = curlPost($qrcode_url, json_encode($post_data)); 
if (!$json['errcode']) { 
 
    $ticket = $json['ticket']; 
    $ticket_img = 'https://mp.weixin.qq.com/cgi-bin/showqrcode?ticket=' . urlencode($ticket); 
} else { 
    echo '发生错误：错误代码 ' . $json['errcode'] . '，微信返回错误信息：' . $json['errmsg']; 
    exit; 
}

$postObj = simplexml_load_string($postStr, 'SimpleXMLElement', LIBXML_NOCDATA); 
$scene_id = str_replace("qrscene_", "", $postObj->EventKey); 
 
$openid = $postObj->FromUserName; //openid 
$ToUserName = $postObj->ToUserName;  //转换角色 
$Event = strtolower($postObj->Event); 
if ($Event == 'subscribe') {//首次关注 
    $is_first = 0; 
} elseif ($Event == 'scan') {//已关注 
    $is_first = 1; 
} 
$access_token = $this->getAccessToken(); 
 
$userinfo = $this->getUserinfo($openid, $access_token); 
$sql = "UPDATE `qrcode` SET `openid` = '" . $openid . "',logintime='" . time() . "',is_first=" . $is_first . ",nickname='" . $userinfo['nickname'] . "'" 
        . ",avatar='" . $userinfo['avatar'] . "',sex='" . $userinfo['sex'] . "',province='" . $userinfo['province'] . "',city='" . $userinfo['city'] . "',country='" . $userinfo['country'] . "' WHERE `id` =" . $scene_id . ""; 
 
mysql_query($sql);