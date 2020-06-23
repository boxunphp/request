<?php
/**
 * This file is part of the Boxunsoft package.
 *
 * (c) Jordy <arno.zheng@gmail.com>
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code
 */

namespace All\Request;

use All\Instance\InstanceTrait;
use Symfony\Component\HttpFoundation\Request as HttpFoundationRequest;

/**
 * 请求类
 * 使用symfony/http-foundation
 */
class Request
{
    use InstanceTrait;
    use BagTrait;
    use MethodTrait;

    protected $requestId;
    protected $serverIp;
    private $req;

    public function __construct()
    {
        $this->req = HttpFoundationRequest::createFromGlobals();
    }

    public function getRequestUri()
    {
        return $this->req->getRequestUri();
    }

    public function getUri()
    {
        return $this->req->getUri();
    }

    /**
     * 请求ID
     *
     * @return string
     */
    public function getRequestId()
    {
        if (null === $this->requestId) {
            $this->requestId = md5(uniqid(gethostname(), true));
        }
        return $this->requestId;
    }

    /**
     * RAW请求内容
     *
     * @return string
     */
    public function getBody()
    {
        return $this->req->getContent();
    }

    public function getServerScheme()
    {
        return $this->req->getScheme();
    }

    public function getServerHost()
    {
        return $this->req->getHost();
    }

    public function getServerName()
    {
        return $this->server()->get('SERVER_NAME', '');
    }

    public function getServerPort()
    {
        return $this->req->getPort();
    }

    /**
     * 服务器IP
     *
     * @return string
     */
    public function getServerIp()
    {
        if (null !== $this->serverIp) {
            return $this->serverIp;
        }

        $this->serverIp = $this->server()->get('SERVER_ADDR');
        if (!$this->serverIp) {
            $this->serverIp = gethostbyname(gethostname());
        }

        return $this->serverIp;
    }

    public function getClientIp()
    {
        return $this->req->getClientIp();
    }

    public function getClientPort()
    {
        return $this->server()->get('REMOTE_PORT', '');
    }

    public function userAgent()
    {
        return $this->header()->get('HTTP_USER_AGENT');
    }

    public function referer()
    {
        return $this->header()->get('HTTP_REFERER');
    }

    public function isXmlHttpRequest()
    {
        return $this->req->isXmlHttpRequest();
    }
}