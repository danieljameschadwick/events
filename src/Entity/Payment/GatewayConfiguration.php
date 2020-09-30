<?php

declare(strict_types=1);

namespace App\Entity\Payment;

use Doctrine\ORM\Mapping as ORM;
use Payum\Core\Model\GatewayConfig as BaseGatewayConfiguration;

/**
 * @ORM\Table(schema="events.tblGatewayConfiguration")
 * @ORM\Entity()
 */
class GatewayConfiguration extends BaseGatewayConfiguration
{
    public const PAYPAL = 'PAYPAL';
    public const OFFLINE = 'OFFLINE';

    /**
     * @var array[]
     */
    public static $config = [
        GatewayConfiguration::OFFLINE => [
            'gatewayName' => 'offline',
            'factoryName' => '',
            'username' => '',
            'password' => '',
            'signature' => '',
            'sandbox' => true,
        ],
        GatewayConfiguration::PAYPAL => [
            'gatewayName' => '',
            'factoryName' => '',
            'username' => '',
            'password' => '',
            'signature' => '',
            'sandbox' => true,
        ],
    ];

    /**
     * @var integer
     *
     * @ORM\Id
     * @ORM\Column(name="intGatewayConfigurationId", type="integer")
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    protected $id;

    /**
     * @var string
     *
     * @ORM\Column(name="strHandle", type="string")
     */
    protected $handle;

    /**
     * @var string
     *
     * @ORM\Column(name="strGatewayName", type="string")
     */
    protected $gatewayName;

    /**
     * @var string
     *
     * @ORM\Column(name="strFactoryName", type="string")
     */
    protected $factoryName;

    /**
     * @var string
     *
     * @ORM\Column(name="strUsername", type="string")
     */
    protected $username;

    /**
     * @var string
     *
     * @ORM\Column(name="strPassword", type="string")
     */
    protected $password;

    /**
     * @var string
     *
     * @ORM\Column(name="strSignature", type="string")
     */
    protected $signature;

    /**
     * @var bool
     *
     * @ORM\Column(name="bolSandbox", type="boolean")
     */
    protected $sandbox = false;

    /**
     * GatewayConfiguration constructor.
     *
     * @param string $handle
     * @param string $gatewayName
     * @param string $factoryName
     * @param string $username
     * @param string $password
     * @param string $signature
     * @param bool $sandbox
     */
    public function __construct(
        string $handle,
        string $gatewayName,
        string $factoryName,
        string $username,
        string $password,
        string $signature,
        bool $sandbox = true
    )
    {
        parent::__construct();

        $this->handle = $handle;
        $this->gatewayName = $gatewayName;
        $this->factoryName = $factoryName;
        $this->username = $username;
        $this->password = $password;
        $this->signature = $signature;
        $this->sandbox = $sandbox;

        $this->setConfig(
            array_merge(
                $this->getConfig(),
                [
                    'username' => $this->getUsername(),
                    'password' => $this->getPassword(),
                    'signature' => $this->getSignature(),
                    'sandbox' => $this->isSandbox()
                ]
            )
        );
    }

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getHandle(): string
    {
        return $this->handle;
    }

    /**
     * @return string
     */
    public function getGatewayName(): string
    {
        return $this->gatewayName;
    }

    /**
     * @return string
     */
    public function getFactoryName(): string
    {
        return $this->factoryName;
    }

    /**
     * @return string
     */
    public function getUsername(): string
    {
        return $this->username;
    }

    /**
     * @return string
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    /**
     * @return string
     */
    public function getSignature(): string
    {
        return $this->signature;
    }

    /**
     * @return bool
     */
    public function isSandbox(): bool
    {
        return $this->sandbox;
    }

    /**
     * @return array[]
     */
    public function getConfig(): array
    {
        return self::$config;
    }
}