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

Add your Bluedot API ID, API Password,  API Url, and From Number to your `.env`:

```dotenv
BLUEDOTSMS_API_URL=https://mobile.esolutions.co.zw/bmg # always required
BLUEDOTSMS_API_ID=ZYX # always required
BLUEDOTSMS_API_PASSWORD=ABCD # always required
BLUEDOTSMS_SMS_FROM=1234 # always required
```

### Advanced configuration

Run `php artisan vendor:publish --provider="Tjmugova\BluedotSms\BluedotSmsProvider"`
```
/config/bluedot-sms.php
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
```

### Formatting Viber Notification
If a notification supports being sent as a Bluedot message, you should define a toBluedotSms method on the notification class. This method will receive a $notifiable entity and should return an Snp\Notifications\Rml\Messages\ViberMessage instance. Let's take a look at a basic toRMLViber example:

```

use Tjmugova\BluedotSms\Messages\ViberMessage;
...

/**
 * Get the BluedotSms representation of the notification.
 *
 * @param  mixed  $notifiable
 * @return Tjmugova\BluedotSms\Messages\BluedotSmsMessage
 */
public function toBluedotSms($notifiable)
{
    return (new BluedotSmsMessage('This is a test message from Laravel'));
}
```

----
**`NOTE:`**

If you find any bugs or you have some ideas in mind that would make this better. Please don't hesitate to create a pull request.

If you find this package helpful, a simple star is very much appreciated.

----
**[MIT](LICENSE) LICENSE** <br>
