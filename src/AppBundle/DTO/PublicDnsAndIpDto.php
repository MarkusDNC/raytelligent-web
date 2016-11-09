<?php
/**
 * Created by PhpStorm.
 * User: lundgren
 * Date: 2016-11-09
 * Time: 13:09
 */

namespace AppBundle\DTO;


class PublicDnsAndIpDto
{

    /**
     * @var string
     */
    private $dns;

    /**
     * @var string
     */
    private $ip;

    /**
     * @return string
     */
    public function getDns()
    {
        return $this->dns;
    }

    /**
     * @param string $dns
     * @return PublicDnsAndIpDto
     */
    public function setDns($dns)
    {
        $this->dns = $dns;

        return $this;
    }

    /**
     * @return string
     */
    public function getIp()
    {
        return $this->ip;
    }

    /**
     * @param string $ip
     * @return PublicDnsAndIpDto
     */
    public function setIp($ip)
    {
        $this->ip = $ip;

        return $this;
    }


}