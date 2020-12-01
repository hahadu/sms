# sms
聚合短信验证

* 已接入阿里云短信

#### 使用

```php 
use Hahadu\Sms\Client\SmsClient;
$sms = New SmsClient('access_secret','access_key','阿里云');
return $sms->send_sms('18888888888',['code'=>4545],'SMS_205*******'); //array
```

#### 在thinkphp6中使用
* 创建thinkphp配置文件 sms.php
```php
config/sms.php
return [
    'service' => 'aliyun', //短信服务商
    'access_secret' => '', //secret
    'access_key' => '', //keyId
    'sign_name'  => '测试签名', //短信签名
    'template'   => SMS_20*******, //默认短信模板
];

```
* 控制器方法
```php
namespace app\index\controller;
use Hahadu\Sms\think\ThinkSmsClient;
class Index{
   return ThinkSmsClient::send_sms('18888888888',['code'=>4545],'SMS_205*******');
}
```