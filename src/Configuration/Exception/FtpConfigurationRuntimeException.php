<?php

namespace Lazzard\FtpClient\Configuration\Exception;

use Lazzard\FtpClient\Exception\FtpClientException;

/**
 * Class FtpConfigurationRuntimeException
 *
 * @since 1.0
 * @package Lazzard\FtpClient\FtpConfiguration\Exception
 * @author EL AMRANI CHAKIR <elamrani.sv.laza@gmail.com>
 */
class FtpConfigurationRuntimeException extends \RuntimeException implements FtpClientException
{
    public function __construct($message)
    {
        parent::__construct("[FtpClient FtpConfiguration Exception] : " . $message);
    }
}