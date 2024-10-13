<?php 
$userAgent = $_SERVER['HTTP_USER_AGENT'];
$isMobile = preg_match('/Mobile|Android|Silk|Kindle|BlackBerry|Opera Mini|Opera Mobi|iP(hone|od|ad)|IEMobile|Fennec|BB10|Windows Phone|webOS|PlayBook/', $userAgent);

if ($isMobile) {
    $devise = 'mobile';
    
} else {
    $devise = 'desktop';
   
}
?>