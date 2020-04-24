<?php


namespace Lazzard\FtpClient\Connection;

use Lazzard\FtpClient\Exception\ConnectionException;
use Lazzard\FtpClient\FtpWrapper;

class FtpConnection implements ConnectionInterface
{
    /** @var FtpWrapper */
    protected $wrapper;

    /** @var resource */
    protected $stream;

    /** @var string */
    protected $host;

    /** @var string */
    protected $username;

    /* @var string */
    protected $password;

    /** @var int */
    protected $port;

    /** @var int */
    protected $timeout;

    /**
     * FtpConnection constructor.
     *
     * @param string $host
     * @param string $username
     * @param string $password
     * @param int    $port
     * @param int    $timeout
     */
    public function __construct($host, $username, $password, $port = 21, $timeout = 90)
    {
        $this->host     = $host;
        $this->username = $username;
        $this->password = $password;
        $this->port     = $port;
        $this->timeout  = $timeout;

        $this->wrapper = new FtpWrapper($this);
    }

    /**
     * @return bool|resource
     *
     * @throws ConnectionException
     */
    protected function _connect()
    {
        if ( ! ($connection = $this->wrapper->connect($this->getHost(), $this->getPort(),
            $this->getTimeout()))) {
            throw new ConnectionException("Connection failed to remote server.");
        }

        $this->wrapper->setConnection($this);

        return $connection;
    }

    /**
     * @return bool
     */
    protected function _login()
    {
        return $this->wrapper->login(
            $this->getUsername(),
            $this->getPassword()
        );
    }

    /**
     * @inheritDoc
     */
    public function open()
    {
        if ( ! ($this->stream = $this->_connect())) {
            throw new ConnectionException("Failed to connect to FTP server.");
        }

        if ( ! ($this->_login())) {
            throw new ConnectionException("Could not logging into the FTP server.");
        }

        return true;
    }

    /**
     * @inheritDoc
     */
    public function close()
    {
        if ( ! $this->wrapper->close()) {
            throw new ConnectionException("Failed to closing FTP connection.");
        }

        return true;
    }

    /**
     * {@inheritDoc}
     *
     * @throws ConnectionException
     */
    public function getStream()
    {
        if ( ! is_resource($this->stream)) {
            throw new ConnectionException("Invalid FTP stream resource, try to reconnect to the server.");
        }

        return $this->stream;
    }

    /**
     * @param resource $stream
     */
    public function setStream($stream)
    {
        $this->stream = $stream;
    }

    /**
     * @inheritDoc
     */
    public function getHost()
    {
        return $this->host;
    }

    /**
     * @inheritDoc
     */
    public function setHost($host)
    {
        $this->host = $host;
    }

    /**
     * @inheritDoc
     */
    public function getPort()
    {
        return $this->port;
    }

    /**
     * @inheritDoc
     */
    public function setPort($port)
    {
        $this->port = $port;
    }

    /**
     * @inheritDoc
     */
    public function getTimeout()
    {
        return $this->timeout;
    }

    /**
     * @inheritDoc
     */
    public function setTimeout($timeout)
    {
        $this->timeout = $timeout;
    }

    /**
     * @return string
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * @param string $username
     */
    public function setUsername($username)
    {
        $this->username = $username;
    }

    /**
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->password = $password;
    }

}