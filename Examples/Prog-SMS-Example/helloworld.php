<HTML>
<HEAD>
    <TITLE>Hello World</TITLE>
</HEAD>
<BODY>
<FORM method='get'>
<?php
include('../../php8/yocto_api.php');
include('../../php8/yocto_messagebox.php');

function smsCallback($mbox, $sms)
{
    print("<br>\n");
    printf("New message dated %s:<br>\n", $sms->get_timestamp());
    printf("&nbsp; from %s<br>\n", $sms->get_sender());
    printf("&nbsp;  \"%s\"<br>\n", $sms->get_textData());
    print("<br>\n");
    $sms->deleteFromSIM();
}

$address = '127.0.0.1';

// Setup the API to use the VirtualHub on local machine,
if(YAPI::RegisterHub($address, $errmsg) != YAPI::SUCCESS) {
    die("Cannot contact $address");
}

$mbox = YMessageBox::FirstMessageBox();
if($mbox === null)
    die("No GSM module found on $address (check USB cable)\n");

// list messages found on the device
print("Messages found on the SIM Card:<br>\n");
print("<br>\n");
$messages = $mbox->get_messages();
if(sizeof($messages) == 0) {
    print("* No messages found<br>\n");
} else {
    foreach($messages as $sms) {
        printf("- dated %s:<br>\n", $sms->get_timestamp());
        printf("&nbsp; from %s<br>\n", $sms->get_sender());
        printf("&nbsp;  \"%s\"<br>\n", $sms->get_textData());
        print("<br>\n");
    }
}
print("<br>\n");

// register a callback to receive any new message
$mbox->registerSmsCallback('smsCallback');

// offer to send a new message
if(!isset($_GET["smsDest"]) || !isset($_GET["smsText"])) {
    print("To test sending SMS, provide message recipient and text, then submit.<br>\n");
    print("Recipient number: <input name='smsDest' placeholder='+xxxxxxxxxx'><br>\n");
    print("Message content: <input name='smsText' placeholder='Say something'><br>\n");
    print("<input type='submit'><br>\n");
} else {
    printf("Sending SMS to %s<br>\n", $_GET["smsDest"]);
    // if that call fails, make sure that your SIM operator
    // allows you to send SMS given your current contract
    $mbox->sendTextMessage($_GET["smsDest"], $_GET["smsText"]);
    printf("Waiting 1 sec to receive messages...<br>\n");
    YAPI::Sleep(1000);
    printf("Done.<br>\n");
}
YAPI::FreeAPI();
?>

</FORM>
</BODY>
</HTML>
