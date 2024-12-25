<html lang="en">
<body>

<h1>MQTT Client</h1>

<?php

use mqtt\Mqtt;
$topic = 'test/switch';

header("Content-Type: text/html");

error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);

require('./autoload.php');


try {
    $client = (new Mqtt())
        ->setLog( function ($log) { echo "<pre>$log</pre>"; } )
        ->setClientId("test")
        ->open()
        ->connect();

    $value = @$_POST['value'];
    if   ( $value ) {
        $client->publish( $topic, $value );
        echo "Value '".htmlentities($value)."' saved. <a href=\"\">Read the value</a>";
    } else {
        $value = $client->subscribe( $topic );
        echo "Actual Value: ".$value;
    }

    $client->disconnect();
}
catch(Exception $exception) {
    error_log( $exception->getMessage().":".$exception->getTraceAsString());
    echo "Error: <b>".$exception->getMessage()."</b>";
}

?>

<hr>
<form action="" method="post">
    <input name="value" type="text" /><br />
    <input type="submit" value="Save value" />
</form>

</body></html>