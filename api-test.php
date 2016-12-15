<?php
require_once 'app/Mage.php';

umask(0);

Mage::app();

$API_username   = '';  // Insert your API Username
$API_Key        = '';  // Insert your API Key

$result = array();
$method = 'customapi';
$args   = '';

if ( !empty($_GET['list']) ) {
    $method .= ( $_GET['list'] == 'block' ) ? '.blocklist' : '.pagelist';
    $args = !empty($_GET['sortby']) ? $_GET['sortby'] : 'created';
}
elseif ( !empty($_GET['content']) ) {
    $method .= ( $_GET['content'] == 'block' ) ? '.blockcontent' : '.pagecontent';
    $args = !empty($_GET['id']) ? (int)$_GET['id'] : 0;
}
else {
    $method .= '.pagelist';
    $args = 'created';
}

try {
    $soap = new SoapClient(Mage::getBaseUrl().'/api/soap/?wsdl');
    $session = $soap->login($API_username, $API_Key);
    $result = $soap->call($session, $method, array($args));
    $soap->endSession($session);    
} catch(Exception $e) {
    $result = array(
        'messages' => array(
            'code'    => 401,
            'message' => $e->getMessage()
        )
    );
}

echo '<pre>';
print_r($result);