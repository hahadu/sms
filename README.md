# sms
聚合短信验证

* 已接入阿里云短信

#### 使用

```php 
use Hahadu\Sms\Client\SmsClient;
//实例化短信方法
//SmsClient支持4个参数
     * @param string $accessSecret Secret key
     * @param string $accessKey Secret key id
     * @param string $signName 短信签名
     * @param string $service 短信服务商 默认aliyun

$sms = New SmsClient('access_secret','access_key','测试签名','aliyun');

//发送短信
return $sms->send_sms('18888888888',['code'=>4545],'SMS_205*******'); //array
```
##### 查询短信发送记录
```php
    /*****
     * 查询发送记录
     * @param string|int $phone_number 查询手机号
     * @param string|int $current_page 查询页数
     * @param string|int $page_size 每页数量
     * @param mixed $send_date 查询时间
     */
return $sms->query_send_details($phone_number='18000000000',$page=1,$page_size=10,$send_date = "20210701");

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