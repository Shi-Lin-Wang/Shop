<?php
// 1. Autoload the SDK Package. This will include all the files and classes to your autoloader
require __DIR__  . '/vendor/autoload.php';
// 2. Provide your Secret Key. Replace the given one with your app clientId, and Secret
// https://developer.paypal.com/webapps/developer/applications/myapps
$paypal = new \PayPal\Rest\ApiContext(
    new \PayPal\Auth\OAuthTokenCredential(
        'AcJoLvUx_MsRVVPM_wWMj57uTmLuXG-UJuvC5bJAUTugcMXanphkDw8ag6amJZ2-xHmj-FJOMSqu_aYq',     // ClientID
        'EAnpXFJaws3xYVcz6plpoR46i1kNYOwr-qq58p7CEQHpBUmHZXA7U44Ki4QlVKOKxPJvI9KP2JXANggN'      // ClientSecret
    )
);
