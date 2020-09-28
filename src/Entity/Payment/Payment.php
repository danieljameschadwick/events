<?php

declare(strict_types=1);

namespace App\Entity\Payment;

use App\DTO\PaymentDTO;
use Doctrine\ORM\Mapping as ORM;
use Fresh\DoctrineEnumBundle\Validator\Constraints as DoctrineAssert;
//use Payum\Core\Model\Payment as BasePayment;

/**
 * todo: May need to implement my own payment bundle that abstracts
 *  Payum to maintain a cleaner codebase
 *
 * @ORM\Table(
 *     schema="events",
 *     name="tblPayment"
 * )
 * @ORM\Entity
 */
//class Payment extends ArrayObject
class Payment
{
    /**
     * @ORM\Column(name="intPaymentId", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     *
     * @var integer $id
     */
    private $id;

    /**
     * @var string|null
     *
     * @ORM\Column(name="strReference", type="string", nullable=true)
     */
    private $reference;

    /**
     * todo: define what type of array
     *
     * @var array
     */
    private $details;

    /**
     * @var string
     *
     * @ORM\Column(name="strDescription", type="string", nullable=true)
     */
    private $description;

    /**
     * @var string
     *
     * @ORM\Column(name="strEmail", type="string", nullable=false)
     */
    private $clientEmail;

    /**
     * @var string
     *
     * @ORM\Column(name="strClientId", type="string", nullable=false)
     */
    private $clientId;

    /**
     * @var int
     *
     * @ORM\Column(name="intCentesimalAmount", type="integer", nullable=false)
     */
    private $totalAmount;

    /**
     * @var CurrencyCode
     *
     * @ORM\Column(name="strCurrencyCode", type="currencyCode", nullable=false)
     * @DoctrineAssert\Enum(entity="App\Entity\Payment\CurrencyCode")
     */
    private $currencyCode;

    /**
     * @param string $description
     * @param string $clientEmail
     * @param string $clientId
     * @param int $totalAmount
     * @param string $currencyCode
     * @param array $details
     * @param string|null $reference
     */
    private function __construct(
        string $description,
        string $clientEmail,
        string $clientId,
        int $totalAmount,
        string $currencyCode,
        array $details = [],
        ?string $reference = null
    )
    {
        $this->description = $description;
        $this->clientEmail = $clientEmail;
        $this->clientId = $clientId;
        $this->totalAmount = $totalAmount;
        $this->currencyCode = $currencyCode;
        $this->details = $details;
        $this->reference = $reference;
    }

    /**
     * @param string $description
     * @param string $clientId
     * @param string $clientEmail
     * @param int $totalAmount
     * @param string $currencyCode
     * @param array $details
     * @param string $reference
     *
     * @return Payment
     */
    public static function create(
        string $description,
        string $clientId,
        string $clientEmail,
        int $totalAmount,
        string $currencyCode,
        array $details = [],
        ?string $reference = null
    ): Payment
    {
        return new self(
            $description,
            $clientEmail,
            $clientId,
            $totalAmount,
            $currencyCode,
            $details,
            $reference
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
    public function getReference(): string
    {
        return $this->reference;
    }

    /**
     * @param string $reference
     */
    public function updateReference(string $reference): void
    {
        $this->reference = $reference;
    }

    /**
     * @return array
     */
    public function getDetails(): array
    {
        return $this->details;
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * @return string
     */
    public function getClientEmail(): string
    {
        return $this->clientEmail;
    }

    /**
     * @return string
     */
    public function getClientId(): string
    {
        return $this->clientId;
    }

    /**
     * @return int
     */
    public function getTotalAmount(): int
    {
        return $this->totalAmount;
    }

    /**
     * @return string
     */
    public function getCurrencyCode(): string
    {
        return $this->currencyCode;
    }
}