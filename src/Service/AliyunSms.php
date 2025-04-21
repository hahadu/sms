<?php


namespace Hahadu\Sms\Service;

use AlibabaCloud\Client\Exception\ClientException;
use Hahadu\Sms\Client\SmsServiceInterface;
use Hahadu\Sms\Service\AliyunSms\AliyunSmsRequest;
use Hahadu\Sms\Service\AliyunSms\AliyunSmsSign;
use Hahadu\Sms\Service\AliyunSms\AliyunSmsTemplate;
use Hahadu\Sms\Service\Traits\ResponseTrait;


class AliyunSms implements SmsServiceInterface
{
    use AliyunSmsSign;
    use AliyunSmsRequest;
    use AliyunSmsTemplate;
    use ResponseTrait;
    /*****
     * @var $access_key string
     */
    protected $access_key;
    /*****
     * @var $access_secret string
     */
    protected $access_secret;
    /*****
     * 签名名称
     * @var $sign_name string
     */
    protected $sign_name;
    /*****
     * 短信模板
     * @var $sms_template object json
     */
    protected $sms_template;

    /*****
     * 构造函数
     * @param string $accessSecret Secret key
     * @param string $accessKey Secret key id
     * @param string $signName 短信签名
     */
    public function __construct(string $accessSecret, string $accessKey, string $signName)
    {
        $this->access_key = $accessKey;
        $this->access_secret = $accessSecret;
        $this->sign_name = $signName;
    }

    /******
     * 设置默认短信模板
     * @param null $template 短信模板
     */
    public function set_template($template = NULL)
    {
        $this->sms_template = $template;
        return $this;
    }

    /*****
     * 发送短信方法
     * @param int|string $phone 接收方手机号
     * @param array $smsParam 短信内容
     * @param string $template 短信模板
     * @throws ClientException
     */
    public function send_sms($phone, $smsParam, $template = NULL)
    {
        if (null !== $template) $this->sms_template = $template;

        $options = [
            'PhoneNumbers' => $phone,
            'SignName' => $this->sign_name,
            'TemplateCode' => $this->sms_template,
            'TemplateParam' => json_encode($smsParam,JSON_UNESCAPED_UNICODE),
        ];
        $result = $this->request('SendSms', $options);
        if($result['Code'] == 'OK'){
            return $this->success($result['BizId'],$result['Message']);
        }
        return $this->error(0,$result['Message'],$result['Code']);
    }

    /*****
     * 查询发送记录
     * @param string|int $phone_number
     * @param int $current_page
     * @param int $page_size
     * @param null $send_date
     * @return array|string
     * @throws ClientException
     */
    public function query_send_details($phone_number, $current_page = 1, $page_size = 50, $send_date = null)
    {
        if (null == $send_date) {
            $send_date = date("Ymd");
        }
        $options = [
            'CurrentPage' => $current_page,
            'PageSize' => $page_size,
            'PhoneNumber' => $phone_number,
            'SendDate' => $send_date
        ];
        $result = $this->request('QuerySendDetails', $options);
        if($result['Code'] == 'OK'){
            return $this->success(['list'=>$result['SmsSendDetailDTOs']],$result['Message']);
        }
        return $this->error(0,$result['Message'],$result['Code']);
    }



}