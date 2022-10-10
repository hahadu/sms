<?php

namespace Hahadu\Sms\Service;

use Qiniu\Auth;
use Qiniu\Sms\Sms;
use Hahadu\Sms\Client\SmsServiceInterface;
class QiniuSms implements SmsServiceInterface
{
    protected $accessKey;
    protected $accessSecret;
    protected $signName;
    protected $smsClient;

    public function __construct(string $accessSecret, string $accessKey, string $signName)
    {
        $this->accessKey = $accessKey;
        $this->accessSecret = $accessSecret;
        $this->signName = $signName;

        $this->smsClient = new Sms(new Auth($this->accessKey, $this->accessSecret));
    }

    /**
     * 设置默认短信模板
     * @param null|string $template 默认短信模板
     * @return mixed
     */
    public function set_template($template = NULL)
    {
        $this->template = $template;
        return $this;
    }

    /**
     * 发送短信方法
     * @param int|string|array $phone ,可以是单个手机号，也可以是多个手机号的数组
     * @param array $smsParam 短信内容
     * @param string $template 短信模板
     */
    public function send_sms($phone, $smsParam, $template = NULL)
    {
        if(!is_array($phone)){
            $phone = [$phone];
        }
        return $this->smsClient->sendMessage($template, $phone, $smsParam);
    }

    /**
     * 查询发送记录
     * @param string|int $phone_number 查询手机号
     * @param string|int $current_page 查询页数
     * @param string|int $page_size 每页数量 默认10条 每页最大200条
     * @param mixed $send_date 查询时间 ['start' => 1599976580, 'end' => 1599977229]
     */
    public function query_send_details($phone_number, $current_page = 1, $page_size = 10, array $send_date = null)
    {
        if(empty($send_date)){
            $send_date = [
                'start' => time() - 86400,
                'end' => time(),
            ];
        }
        [$ret, $err] = $this->smsClient->querySendSms(null,null,$phone_number,null,null,null,$send_date['start'],$send_date['end'],$current_page,$page_size );
        return $this->response($ret, $err);

    }

    /**
     * 查询短信签名
     * @param string|null $audit_status 签名标识符 <br/> 阿里云为签名名称，七牛云为签名ID
     * @param int $page
     * @param int $page_size
     * @return mixed
     */
    public function query_sms_sign(string $audit_status=null,$page = 1, $page_size = 20)
    {
        [$ret, $err] = $this->smsClient->querySignature($audit_status,$page,$page_size );
        return $this->response($ret, $err);
    }

    /**
     * 删除短信签名
     * <br/>
     * * 必须是本账号已申请的短信签名
     * @param string $sign_id 签名标识符
     */
    public function delete_sms_sign(string $sign_id)
    {
        [$ret, $err] = $this->smsClient->deleteSignature($sign_id);
        return $this->response($ret, $err);
    }

    /**
     * @param string $sign_name
     * @param int $sign_source 签名来源。取值：<br/>
     * 0：enterprises_and_institutions 企事业单位的全称或简称。<br/>
     * 1：website 工信部备案网站的全称或简称。<br/>
     * 2：app App应用的全称或简称。<br/>
     * 3：public_number_or_small_program 公众号或小程序的全称或简称。<br/>
     * 4：store_name 电商平台店铺名的全称或简称。<br/>
     * 5：trade_name 商标名的全称或简称。<br/>
     * @param string $file_contents 签名资质证明文件，base64编码
     * @param null|string $file_format 资质证明文件格式
     * @param string $remark 签名申请说明
     * @return array|string
     */
    public function create_sms_sign(string $sign_name, int $sign_source, $file_contents = null, $file_format = null, $remark = '')
    {
        [$ret, $err] = $this->smsClient->createSignature($sign_name, $sign_source,$file_contents);
        return $this->response($ret, $err);

    }

    /**
     * @param string $sign_name
     * @param int $sign_source 签名来源。取值：<br/>
     * 0：enterprises_and_institutions 企事业单位的全称或简称。<br/>
     * 1：website 工信部备案网站的全称或简称。<br/>
     * 2：app App应用的全称或简称。<br/>
     * 3：public_number_or_small_program 公众号或小程序的全称或简称。<br/>
     * 4：store_name 电商平台店铺名的全称或简称。<br/>
     * 5：trade_name 商标名的全称或简称。<br/>
     * @param string $file_contents 签名资质证明文件，base64编码
     * @param null|string $file_format 资质证明文件格式
     * @param string $sign_id 模板id
     * @return array|string
     */
    public function edit_sms_sign(string $sign_name, int $sign_source, $file_contents = null, $sign_id = null, $file_format = null)
    {
        [$ret, $err] = $this->smsClient->updateSignature($sign_id,$sign_name, $sign_source,$file_contents);
        return $this->response($ret, $err);
    }

    /**
     * 查询短信模板
     * @param string $template 短信模板code
     * @return array|string
     */
    public function query_sms_template(string $template,$page = 1, $page_size = 20)
    {
        [$ret, $err] = $this->smsClient->queryTemplate($template,$page,$page_size);
        return $this->response($ret, $err);
    }

    /**
     * 修改申请失败的短信模板
     * @param int $type 短信类型。其中：<br/>
     *  0：验证码。<br/>
     *  1：短信通知。<br/>
     *  2：推广短信。<br/>
     *  3：国际/港澳台消息<br/>
     * @param string $template_name 模板名称
     * @param string $template_content 模板内容
     * @param string $remark 短信模板申请说明
     * @param null $template_code 短信模板id
     * @param null $sign 模板签名ID
     * @return array|string
     */
    public function edit_sms_template($type, $template_name, $template_content, $remark, $template_code = null, $sign = null)
    {
        [$ret, $err] = $this->smsClient->updateTemplate($template_code,$template_name,$template_content,$remark,$sign);
        return $this->response($ret, $err);
    }

    /**
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
    public function create_sms_template($type, $template_name, $template_content, $remark, $sign = null)
    {
        [$ret, $err] = $this->smsClient->createTemplate($template_name,$template_content,$type,$remark,$sign);
        return $this->response($ret, $err);
    }

    /**
     * 删除短信模板
     * @param string $template_code 短信模板标识符
     * @return array|string
     */
    public function delete_sms_template(string $template_code)
    {
        [$ret, $err] = $this->smsClient->deleteTemplate($template_code);
        return $this->response($ret, $err);
    }

    private function response($ret, $err)
    {
        if ($err !== null) {
            throw new \RuntimeException($err);
        }
        return $ret;
    }
}