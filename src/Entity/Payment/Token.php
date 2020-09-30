<?php

declare(strict_types=1);

namespace App\Entity\Payment;

use Doctrine\ORM\Mapping as ORM;
use Payum\Core\Security\TokenInterface;

/**
 * todo: refactor to remove dependency on TokenInterface
 *
 * @ORM\Table(
 *     schema="events",
 *     name="tblToken"
 * )
 * @ORM\Entity()
 */
//class Token extends BaseToken
class Token implements TokenInterface
{
    /**
     * @var int
     *
     * @ORM\Id
     * @ORM\Column(name="intTokenId", type="integer")
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="strGatewayName", type="string")
     */
    private $gatewayName;

    /**
     * @var string|null
     *
     * @ORM\Column(name="strHash", type="string", nullable=true)
     */
    private $hash;

    /**
     * @var array
     */
    private $details;

    /**
     * @var string|null
     *
     * @ORM\Column(name="strTargetUrl", type="string", nullable=true)
     */
    private $targetUrl;

    /**
     * @var string|null
     *
     * @ORM\Column(name="strAfterUrl", type="string", nullable=true)
     */
    private $afterUrl;

    /**
     * Token constructor.
     *
     * @param string $gatewayName
     * @param string|null $afterUrl
     * @param string|null $targetUrl
     * @param array $details
     */
    public function __construct(
        string $gatewayName = 'offline',
        string $afterUrl = null,
        string $targetUrl = null,
        array $details = []
    )
    {
        $this->gatewayName = $gatewayName;
        $this->afterUrl = $afterUrl;
        $this->targetUrl = $targetUrl;
        $this->details = $details;
    }

    /**
     * @param string $gatewayName
     * @param string|null $afterUrl
     * @param string|null $targetUrl
     * @param array $details
     *
     * @return Token
     */
    public static function create(
        string $gatewayName,
        string $afterUrl = null,
        string $targetUrl = null,
        array $details = []
    ): Token
    {
        return new self(
            $gatewayName,
            $afterUrl,
            $targetUrl,
            $details
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
    public function getGatewayName(): string
    {
        return $this->gatewayName;
    }

    /**
     * @param string $gatewayName
     */
    public function setGatewayName($gatewayName)
    {
        $this->gatewayName = $gatewayName;
    }

    /**
     * @return array
     */
    public function getDetails(): array
    {
        return $this->details;
    }

    /**
     * @param array $details
     */
    public function setDetails($details)
    {
        $this->details = $details;
    }

    /**
     * @return string|null
     */
    public function getHash(): ?string
    {
        return $this->hash;
    }

    /**
     * @param string $hash
     */
    public function setHash($hash)
    {
        $this->hash = $hash;
    }

    /**
     * @return string|null
     */
    public function getTargetUrl()
    {
        return $this->targetUrl;
    }

    /**
     * @param string $targetUrl
     */
    public function setTargetUrl($targetUrl)
    {
        $this->targetUrl = $targetUrl;
    }

    /**
     * @return string|null
     */
    public function getAfterUrl()
    {
        return $this->afterUrl;
    }

    /**
     * @param string $afterUrl
     */
    public function setAfterUrl($afterUrl)
    {
        $this->afterUrl = $afterUrl;
    }
}