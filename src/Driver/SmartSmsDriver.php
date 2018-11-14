<?php
/**
 * Created by PhpStorm.
 * User: moeen
 * Date: 11/11/18
 * Time: 3:11 PM
 */

namespace SmartSms\Driver;


use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Response;
use SmartSms\Exceptions\SmartSmsException;

class SmartSmsDriver extends Driver
{
    protected $config;
    protected $client;

    public function __construct($config)
    {
        $this->config = (object)$config;
        $this->client = new Client();
    }

    public function send()
    {
        $numbers = implode(';', $this->recipients);
        $response = $this->client->request('GET', $this->config->url, [
            'query' => [
                'username' => $this->config->username,
                'password' => $this->config->password,
                'senderid' => $this->config->senderid,
                'type' => $this->config->type,
                'to' => $numbers,
                'text' => $this->message,
            ],
        ]);
        $data = $this->getResponseData($response);

        return (object) $data;
    }

    /**
     * @param Response $response
     * @return array
     * @throws SmartSmsException
     */
    protected function getResponseData(Response $response): array
    {
        $data = \json_decode((string)$response->getBody(), true);
        if (!isset($data['data']['status'])) {
            throw new SmartSmsException('The smart sms api has changed');
        }

        $status_code = $response->getStatusCode();
        $status = \mb_strtolower($data['data']['status']) === 'success';

        if ($status_code !== 200 || !$status) {
            if (!empty($data['errors'])) {
                throw new SmartSmsException(\json_encode($this->parseErrors($data['errors'])));
            }
            throw new SmartSmsException('Something went worng while sending sms');
        }

        return \array_merge($data['data'], ['status' => true]);
    }

    /**
     * @param array $errors
     * @return array
     */
    protected function parseErrors(array $errors): array
    {
        return \array_map(function ($error) {
            return $error['title'];
        }, $errors);
    }
}