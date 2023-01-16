<?php

namespace LaravelFCM\Request;

abstract class BaseRequest
{
    /**
     * @internal
     *
     * @var \GuzzleHttp\ClientInterface
     */
    protected $client;

    /**
     * @internal
     *
     * @var string
     */
    protected $serverKey;

    /**
     * @internal
     *
     * @var string
     */
    protected $senderId;

    /**
     * BaseRequest constructor.
     */
    public function __construct()
    {
        $config = app('config')->get('fcm.http', []);
        $this->serverKey = $config['server_key'];
        $this->senderId = $config['sender_id'];
    }

    /**
     * Build the header for the request.
     *
     * @return array<string,string>
     */
    protected function buildRequestHeader()
    {
        return [
            'Authorization' => 'key=' . $this->serverKey,
            'Content-Type' => 'application/json',
            'project_id' => $this->senderId,
        ];
    }

    /**
     * Build the body of the request.
     *
     * @return mixed
     */
    abstract protected function buildBody();

    /**
     * Return the request in array form.
     *
     * @return array
     */
    public function build()
    {
        return [
            'headers' => $this->buildRequestHeader(),
            'json' => $this->buildBody(),
        ];
    }
}
