<?php
include('../../Sources/yocto_api.php');
YAPI::DisableExceptions();

$error = "";
if(YAPI::TestHub("callback", 10, $error) == YAPI::SUCCESS) {
    YAPI::RegisterHub("callback");
    $module = YModule::FirstModule();
    $debug_msg = "\ndebugLogs:\n";
    while (!is_null($module)) {
        $debug_msg .= 'change beacon state of ' . $module->get_serialNumber() . "\n";
        if($module->get_beacon() == Y_BEACON_ON) {
            $module->set_beacon(Y_BEACON_OFF);
        } else {
            $module->set_beacon(Y_BEACON_ON);
        }
        $module = $module->nextModule();
    }
    print($debug_msg);
    die();
}

?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Yoctopuce HTTP Callback</title>
</head>
<body>
<b>This example need to be run by a VirtualHub or a YoctoHub.</b><br/>
<ol>
    <li>Connect to the web interface of the VirtualHub or YoctoHub that will run this script.</li>
    <li>Click on the <em>configure</em> button of the VirtualHub or YoctoHub.</li>
    <li>Click on the <em>edit</em> button of "Callback URL" settings.</li>
    <li>Set the <em>type of Callback</em> to <b>Yocto-API Callback</b>.</li>
    <li>Set the <em>callback URL</em> to http://<b><?php print($_SERVER['SERVER_NAME'] . ':' . $_SERVER['SERVER_PORT'] . $_SERVER['SCRIPT_NAME']); ?></b>.</li>
    <li>Click on the <em>test</em> button.</li>
</ol>
</body>
</html>