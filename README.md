# [esolutions](https://www.esolutions.co.zw/mobile-advertising/sms-gateway-sms-api)-laravel-notifications

> A laravel package for sending notifications via [esolutions](https://www.esolutions.co.zw/mobile-advertising/sms-gateway-sms-api) service.

Installation :traffic_light:
-------
Add the package to your composer.json

```
"require": {
    ... 
    "tjmugova/esolutions-sms-laravel": "{version}"
},
```

Or just run composer require

```bash
$ composer require tjmugova/esolutions-sms-laravel
```

### Configuration

Add your EsolutionsSMS username, Password,  API Url, and From  to your `.env`:

```dotenv
ESOLUTIONSSMS_API_URL=https://mobile.esolutions.co.zw/bmg # always required
ESOLUTIONS_SMS_API_ID=ZYX # always required
ESOLUTIONS_SMS_API_PASSWORD=ABCD # always required
ESOLUTIONS_SMS_FROM=1234 # always required
```

### Advanced configuration

Run `php artisan vendor:publish --provider="Tjmugova\EsolutionsSms\EsolutionsSmsProvider"`
```
/config/esolutions-sms.php
```

## Usage :white_check_mark:

For full documentation, please refer to [Laravel Notification Docs](https://laravel.com/docs/9.x/notifications)

### Sending Notification

To send notification you can use the Laravel Notification Facade and pass the mobile number as the first parameter

```
public function send () 
{
    Notification::send('263777777777', new LeadAddedNotification());
    Notification::send(['263777777777', '263777777777'], new LeadAddedNotification());
}
...

/**
 * Get the EsolutionsSms representation of the notification.
 *
 * @param  mixed  $notifiable
 * @return Tjmugova\EsolutionsSms\Messages\EsolutionsSmsMessage
 */
public function toEsolutionsSms($notifiable)
{
    return (new EsolutionsSmsMessage('This is a test message from Laravel'));
}
```

----
**`NOTE:`**

If you find any bugs or you have some ideas in mind that would make this better. Please don't hesitate to create a pull request.

If you find this package helpful, a simple star is very much appreciated.

----
**[MIT](LICENSE) LICENSE** <br>
