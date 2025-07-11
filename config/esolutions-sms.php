<?php
return [
    /*
   |--------------------------------------------------------------------------
   | API Credentials
   |--------------------------------------------------------------------------
   |
   | The following configuration options contain your API credentials, which
   | may be accessed from your bluedot dashboard. These credentials may be
   | used to authenticate with the bluedot API so you may send messages.
   |
   */
    'api_url' => env("ESOLUTIONS_SMS_API_URL","https://mobile.esolutions.co.zw/bmg"),
    'username' => env("ESOLUTIONS_SMS_USERNAME","esolutions"),
    'password' => env("ESOLUTIONS_SMS_PASSWORD","esolutions"),
    /*
   |--------------------------------------------------------------------------
   | SMS "From" Number/ sender id
   |--------------------------------------------------------------------------
   |
   | This configuration option defines the phone number that will be used as
   | the "from" number for all outgoing text messages. You should provide
   | the number you have already reserved within your bluedot dashboard.
   |
   */
    'sms_from' => env("ESOLUTIONS_SMS_FROM"),
];