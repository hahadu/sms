<?php


namespace Hahadu\Sms\Service\Aliyun;


use AlibabaCloud\Client\AlibabaCloud;
use AlibabaCloud\Client\Exception\ClientException;
use AlibabaCloud\Client\Exception\ServerException;

trait AliyunSmsRequest
{
    /******
     * 发送请求
     * @param string $action 请求类型
     * @param array $options 请求参数
     * @return array|string
     * @throws ClientException
     */
    public function request(string $action, array $options)
    {
        AlibabaCloud::accessKeyClient($this->access_key, $this->access_secret)
            ->regionId('cn-hangzhou')
            ->asDefaultClient();

        try {
            $result = AlibabaCloud::rpc()
                ->product('Dysmsapi')
                // ->scheme('https') // https | http
                ->version('2017-05-25')
                ->method('POST')
                ->host('dysmsapi.aliyuncs.com')
                ->action($action)
                ->options([
                    'query' => $options,
                ])
                ->request();
            return ($result->toArray());
        } catch (ClientException $e) {
            return $e->getErrorMessage() . PHP_EOL;
        } catch (ServerException $e) {
            return $e->getErrorMessage() . PHP_EOL;
        }
    }


}