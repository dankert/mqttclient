# MQTT Client

This is a MQTT client for PHP applications

## Installing a broker

Install a MQTT broker like Mosquitto

    sudo apt install mosquitto

### Sending some example messages with mosquitto

Send a message to a test topic

    mosquitto_pub 0 -r -m "ON" -t "test/switch"

And read it from the topic

    mosquitto_sub -C 1 -t "test/switch"

gives you the value "ON".

## Usage

### Open a connection to the MQTT broker

A very simple example would be

    $client = (new Mqtt())
        ->open()
        ->connect();

which connects to a local MQTT broker (on localhost) without authentication. 

But you may specify the host, clientId, user, password and logging:

    $client = (new Mqtt())
        ->setLog( function ($log) { echo "<pre>$log</pre>"; } )
        ->setClientId("test")
        ->open('mqtt://localhost')
        ->connect('<user>','<password>');

### Sending a value to a MQTT topic

        $client->publish( $topic, $value );

### Getting a value from the MQTT broker for a topic

        $value = $client->subscribe( $topic );

## Beware

- The client is only able to get retained messages. It cannot listen to upcoming mqtt event because of the request-based function of a PHP script.
- The client is always sending in QOS level 1
- Support for MQTT 3.1