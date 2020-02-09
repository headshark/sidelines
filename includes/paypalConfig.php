<?php
require_once("PayPal-PHP-SDK/autoload.php");

$apiContext = new \PayPal\Rest\ApiContext(
    new \PayPal\Auth\OAuthTokenCredential(
        'AazTGHDkf4cMqFDHhtTAaQ_o790sqRE_PqtQLPoN3-tCyCbbU8cfnuoUlUzGeUC1YhWxVquxTDJ-ZR2u',     // ClientID
        'ELe1Cc9AU9vdQD2d_djyXvsyAUwG6N-0aa16VwtvlAfevPxyXasRDe1owW73CzNxvVDj-R7Nq0fkf0uZ'      // ClientSecret
    )
);
?>
