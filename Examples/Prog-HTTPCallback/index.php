<?php
  
    // this is needed for the unserialize to work properly.
    include("config.php");

    $all_swi = LoadVirtualSwitches();

    if(isset($_POST['action']) && $_POST['action']=='new'){
        $name       = $_POST['nameSwitch'];
        $off_relay    = array();
        $on_relay   = array();
        foreach ($_POST as $key => $value) {
            if( $value=='stateOn' || $value=='stateOff' || $value=='pulse'){
                $parts=explode('_', $key);
                if(sizeof($parts)!=3)
                    continue;
                $hwid=$parts[0].'.'.$parts[1];
                if($parts[2]=='on'){
                    $on_relay[$hwid]=$value;
                }else if($parts[2]=='off'){
                    $off_relay[$hwid]=$value;
                }
            }
        }
        $all_swi[$name] = new VirtualSwitch($name,$on_relay,$off_relay);
        SaveVirtualSwitches($all_swi);
    }

    if(isset($_GET['action']) && $_GET['action']=='delete'){
        $name  = $_GET['name'];
        if(isset($all_swi[$name])) {
            unset($all_swi[$name]);
            SaveVirtualSwitches($all_swi);
        }
    }
    if(isset($_GET['name']) && isset($_GET['state'])){
        $name  = $_GET['name'];
        $state = $_GET['state'];
        if(isset($all_swi[$name])){
            $all_swi[$name]->setState($state);
            SaveVirtualSwitches($all_swi);
        }
    }
?>
<!DOCTYPE html> 
<html>

<head>
    <meta charset="utf-8">
    <title>Yocto-Relay HTTP Callback</title> 
    <meta name="viewport" content="width=device-width, initial-scale=1"> 
    <link rel="stylesheet" href="http://code.jquery.com/mobile/1.2.0/jquery.mobile-1.2.0.min.css" />
    <script src="http://code.jquery.com/jquery-1.8.2.min.js"></script>
    <script src="http://code.jquery.com/mobile/1.2.0/jquery.mobile-1.2.0.min.js"></script>

</head> 



<body> 

<!-- Start of first page: #main -->
<div data-role="page" id="main">

    <div data-role="header">
        <h1>All Virtual Switches</h1>
    </div><!-- /header -->

    <div data-role="content">   
    <ul data-role="listview" data-inset="true" >
<?php
  foreach ($all_swi as $name => $swi) {
    Print("<li>");
    Print('<a href="detail.php?name='.$name.'" data-transition="slidedown">'.$name.'</a></td><td style="width: 15em;">');
    $state = $swi->getState();
    Print('</li>');
  } 
?>
    </ul>
    </div><!-- /content -->
    <div data-role="footer" class="ui-bar"  data-position="fixed">
        <a href="new.php" data-role="button" data-icon="plus" data-transition="slidedown">new Virtual Switch</a>
    </div>
</div><!-- /page main -->


</body>
</html>