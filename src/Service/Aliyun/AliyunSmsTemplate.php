<?php


namespace Hahadu\Sms\Service\Aliyun;


trait AliyunSmsTemplate
{
    /*****
     * 查询短信模板
     * @param string $template 短信模板code
     * @return array|string
     */
    public function query_sms_template(string $template)
    {
        $options = [
            'TemplateCode' => $template,
        ];
        return $this->request('QuerySmsTemplate', $options);
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
     * @param null $sign
     * @return array|string
     */
    public function edit_sms_template($type, $template_name, $template_content, $remark, $template_code = null, $sign = null)
    {
        $options = [
            'TemplateType' => $type, //短信类型。其中：0：验证码。1：短信通知。2：推广短信。3：国际/港澳台消息
            'TemplateName' => $template_name,//'订单创建',
            'TemplateContent' => $template_content,//"您有订单创建成功，订单号为：${order_id}，请注意查收！",
            'Remark' => $remark,//'当前的短信模板应用于双11大促推广营销',
            'TemplateCode' => $template_code,
        ];
        return $this->request('ModifySmsTemplate', $options);
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
     * @param null $sign
     * @return array|string
     */
    public function create_sms_template($type, $template_name, $template_content, $remark, $sign = null)
    {
        $options = [
            'TemplateType' => $type, //短信类型。其中：0：验证码。1：短信通知。2：推广短信。3：国际/港澳台消息
            'TemplateName' => $template_name,//'订单创建',
            'TemplateContent' => $template_content,//"您有订单创建成功，订单号为：${order_id}，请注意查收！",
            'Remark' => $remark,//'当前的短信模板应用于双11大促推广营销'
        ];
        return $this->request('AddSmsTemplate', $options);
    }

    /*****
     * 删除短信模板
     * @param string $template_code
     * @return array|string
     */
    public function delete_sms_template(string $template_code)
    {
        $options = [
            'TemplateCode' => $template_code
        ];
        return $this->request('DeleteSmsTemplate', $options);
    }

}