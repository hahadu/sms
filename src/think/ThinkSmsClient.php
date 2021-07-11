<?php


namespace Hahadu\Sms\think;
use AlibabaCloud\Client\Exception\ClientException;
use Hahadu\Sms\Client\SmsClient;

class ThinkSmsClient
{
    protected static $sms;
    public function __construct(){
        self::$sms = New SmsClient(config('sms.access_secret'),config('sms.access_key'),config('sms.sign_name'),config('sms.service'));
        self::$sms->set_template(config('sms.template'));
    }
    public static function init(){
        new self();
    }

    /*****
     * 发送短信方法
     * @param int|string $phone
     * @param array $smsParam 短信内容
     * @param string $template 短信模板
     * @throws ClientException
     */

    public static function send_sms($phone,$smsParam,$template=NULL){
        self::init();
        return self::$sms->send_sms($phone,$smsParam,$template);
    }

    public static function query_send_details($phone_number, $current_page = 1, $page_size = 10, $send_date=null){
        self::init();
        return self::$sms->query_send_details($phone_number,$current_page,$page_size,$send_date);
    }

    /******
     * 设置默认短信模板
     * @param null|string $template 默认短信模板
     * @return mixed
     */
    public static function set_template($template = NULL)
    {
        self::init();
    }

    /*****
     * 查询短信签名
     * @param string $sign 签名标识符 <br/> 阿里云为签名名称，七牛云为签名ID
     *
     */
    public static function query_sms_sign(string $sign)
    {
        self::init();
        return self::$sms->query_sms_sign($sign);
    }

    /*****
     * 删除短信签名
     * <br/>
     * * 必须是本账号已申请的短信签名
     * @param string $sign 签名标识符
     */
    public static function delete_sms_sign(string $sign)
    {
        self::init();
        return self::$sms->delete_sms_sign($sign);
    }

    /*****
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
    public static function create_sms_sign(string $sign_name, int $sign_source, $file_contents = null, $file_format = null, $remark = '')
    {
        self::init();
        return self::$sms->create_sms_sign($sign_name,$sign_source,$file_contents,$file_format,$remark);
    }

    /*****
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
    public static function edit_sms_sign(string $sign_name, int $sign_source, $file_contents = null, $file_format = null, $remark = '')
    {
        self::init();
        return self::$sms->edit_sms_sign($sign_name,$sign_source,$file_contents,$file_format,$remark);
    }

    /*****
     * 查询短信模板
     * @param string $template 短信模板code
     * @return array|string
     */
    public static function query_sms_template(string $template)
    {
        self::init();
        return self::$sms->query_sms_template($template);
    }

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
    public static function edit_sms_template($type, $template_name, $template_content, $remark, $template_code = null, $sign = null)
    {
        self::init();
        return self::$sms->edit_sms_template($type,$template_name,$template_content,$remark,$template_code,$sign);
    }

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
    public static function create_sms_template($type, $template_name, $template_content, $remark, $sign = null)
    {
        self::init();
        return self::$sms->create_sms_template($type,$template_name,$template_content,$remark,$sign);
    }

    /*****
     * 删除短信模板
     * @param string $template_code 短信模板标识符
     * @return array|string
     */
    public static function delete_sms_template(string $template_code)
    {
        self::init();
        return self::$sms->delete_sms_template($template_code);
    }
}