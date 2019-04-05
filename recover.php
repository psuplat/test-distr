<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    //extract data from the post
    $request = file_get_contents('php://input');
    $request = json_decode($request);
    
    //set cURL POST variables
    $url = 'http://localhost/helloprint/consumer/queue.php';
    $fields = array(
        'action' => 'recover',
        'user' => urlencode($request->user)
    );

    //url-ify the data for the POST
    $fields_string = '';
    foreach($fields as $key=>$value) { $fields_string .= $key.'='.$value.'&'; }
    rtrim($fields_string, '&');

    //open connection
    $ch = curl_init();
    
    $optArray = array(
        CURLOPT_URL => $url,
        CURLOPT_POST => count($fields),
        CURLOPT_POSTFIELDS => $fields_string,
        CURLOPT_RETURNTRANSFER => true
    );

    curl_setopt_array($ch, $optArray);

    //execute post
    $result = curl_exec($ch);

    //close connection
    curl_close($ch);

    http_response_code(200);
    echo $result;
}
else
{
    // mehod not allowed
    http_response_code(405);
}

?>
