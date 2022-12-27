<?php

echo "Hello from the docker yooooo container 2";
// get request header 
echo "<pre>";
print_r(arrayToJson($_SERVER));
echo "</pre>";
// get request from wocommerce hook
$myRequest = $_REQUEST;
// get the order id
$order_id = $myRequest['order_id'];
// get random string
$randomString = substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, 10);

$redis_key = '';
if ($order_id) {
    $redis_key = $order_id;
} else {
    $redis_key = $randomString;
}


// save request on log file
file_put_contents('log.txt', print_r($myRequest, true), FILE_APPEND);

// save order on redis database
$redis = new Redis();
$redis->connect('redis', 6379);
$redis->set($randomString, arrayToJson($_SERVER));


?>

<?php 
// function to stringfy the array request
function arrayToString($array) {
    $string = '';
    foreach ($array as $key => $value) {
        $string .= $key . ' => ' . $value . ', ';
    }
    return $string;
}

// function array to json
function arrayToJson($array) {
    $json = json_encode($array);
    return $json;
}
?>