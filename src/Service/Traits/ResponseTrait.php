<?php

namespace Hahadu\Sms\Service\Traits;

trait ResponseTrait
{
    /**
     * 成功返回通用结构
     * @param mixed $data 返回的数据
     * @param string $message 成功消息
     * @return array
     */
    public function success($data = null, string $message = 'success'): array
    {
        return [
            'code' => 200,
            'request_id'=>null,
            'message' => $message,
            'data' => $data
        ];
    }

    /**
     * 错误返回通用结构
     * @param int $code 错误码
     * @param string $message 错误消息
     * @param mixed $data 错误数据（可选）
     * @return array
     */
    public function error(int $code, string $message='error', $data = null): array
    {
        return [
            'code' => $code,
            'request_id' => null,
            'message' => $message,
            'data' => $data
        ];
    }
}