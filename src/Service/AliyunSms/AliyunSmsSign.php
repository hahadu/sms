<?php


namespace Hahadu\Sms\Service\AliyunSms;

use AlibabaCloud\Client\Exception\ClientException;

trait AliyunSmsSign
{
    /*****
     * 查询短信签名
     * @param string $sign 签名名称
     * @return array|string
     * @throws ClientException
     */
    public function query_sms_sign(string $sign)
    {
        $options = [
            'SignName' => $sign,
        ];
        return $this->request('QuerySmsSign', $options);
    }

    /*****
     * 删除短信签名
     * <br/>
     * * 必须是本账号已申请的短信签名
     * @param string $sign 签名标识符
     */
    public function delete_sms_sign(string $sign)
    {
        $options = [
            'SignName' => $sign,
        ];
        return $this->request('DeleteSmsSign', $options);
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
     * @throws ClientException
     */
    public function create_sms_sign(string $sign_name, int $sign_source, $file_contents = null, $file_format = null, $remark = '')
    {
        $options = [
            'SignName' => $sign_name,
            'SignSource' => $sign_source,
            'Remark' => $remark,
            'SignFileList.' . $sign_source . '.FileSuffix' => $file_format,
            'SignFileList.' . $sign_source . '.FileContents' => $file_contents
        ];
        return $this->request('AddSmsSign', $options);
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
     * @throws ClientException
     */
    public function edit_sms_sign(string $sign_name, int $sign_source, $file_contents = null, $file_format = null, $remark = '')
    {
        $options = [
            'SignName' => $sign_name,
            'SignSource' => $sign_source,
            'Remark' => $remark,
            'SignFileList.1.FileSuffix' => $file_format,
            'SignFileList.1.FileContents' => $file_contents
        ];
        return $this->request('ModifySmsSign', $options);
    }


}