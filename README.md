# sms

聚合短信验证

* 已接入阿里云短信
 require php >7.2
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
```

##### 发送短信

```php
//发送短信
    /****
     * @param int|string $phone
     * @param array $smsParam 短信内容
     * @param string $template 短信模板
    */
return $sms->send_sms('18888888888',$smsParam=['code'=>4545],$template='SMS_205*******'); //array
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

##### 查询短信模板

```php
    /*****
     * 查询短信模板
     * @param string $template 短信模板code
     * @return array|string
     */
return $sms->query_sms_template($template);
```

##### 修改短信模板

````php
    /*****
     * 修改申请失败的短信模板
     * @param int $type 短信类型。其中：<br/>
     * 0：验证码。<br/>
     * 1：短信通知。<br/>
     * 2：推广短信。<br/>
     * 3：国际/港澳台消息<br/>
     * @param string $template_name 模板名称
     * @param string $template_content 模板内容
     * @param string $remark 短信模板申请说明
     * @param null $template_code 短信模板id
     * @param null $sign 模板签名ID
     * @return array|string
     */
return $sms->edit_sms_template($type, $template_name, $template_content, $remark, $template_code , $sign );
````

##### 添加短信模板

```php
    /*****
     * 创建短信模板
     * @param int $type 短信类型。其中：<br/>
     * 0：验证码。<br/>
     * 1：短信通知。<br/>
     * 2：推广短信。<br/>
     * 3：国际/港澳台消息<br/>
     * @param string $template_name 模板名称
     * @param string $template_content 模板内容
     * @param string $remark 短信模板申请说明
     * @param null $sign 模板签名ID
     * @return array|string
     */
    $sms->create_sms_template($type, $template_name, $template_content, $remark, $sign = null);

```

##### 删除短信模板

```php
    /*****
     * 删除短信模板
     * @param string $template_code 短信模板标识符
     * @return array|string
     */
   $sms->delete_sms_template(string $template_code);
```

#### 在thinkphp6中使用

##### 创建thinkphp配置文件 sms.php

```php
config/sms.php
return [
    'default' => 'aliyun', //默认短信服务商
    'service' =>[
        'aliyun'=>[ //短信服务配置
            'access_secret' => 'ztmTzCvpGr****KbceSfXibBS', //secret
            'access_key' => 'LTAI4GCA****DKTbFkYMPD',
            'sign_name'  => '阿里云', //短信签名
            'template'   => 'SMS_205****6', //默认短信模板
        ],
    ],
];
```

配置好参数后直接调用方法即可

##### 控制器方法

```php
namespace app\index\controller;
use Hahadu\Sms\think\ThinkSmsClient;
class Index{
   
   //发送短信
   dump(ThinkSmsClient::init()->send_sms('18888888888',['code'=>4545],'SMS_205*******'));
   //查询短信发送记录
   dump(ThinkSmsClient::init()->query_send_details('18000000000',1,10,"20210701"));
}
```

### 项目
[@hahadu主页](http://github.com/hahadu)
