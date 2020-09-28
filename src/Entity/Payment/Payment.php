<?php

declare(strict_types=1);

namespace App\Entity\Payment;

use App\DTO\PaymentDTO;
use Doctrine\ORM\Mapping as ORM;
use Payum\Core\Model\ArrayObject;

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
     * @var string
     *
     * @ORM\Column(name="strReference", type="string")
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
     * @ORM\Column(name="strDescription", type="string")
     */
    private $description;

    /**
     * @var string
     *
     * @ORM\Column(name="strEmail", type="string")
     */
    private $clientEmail;

    /**
     * @var string
     *
     * @ORM\Column(name="strClientId", type="string")
     */
    private $clientId;

    /**
     * @var int
     *
     * @ORM\Column(name="intCentesimalAmount", type="integer")
     */
    private $totalAmount;

    /**
     * todo: Convert to an object/use base object
     *
     * @var string
     *
     * @ORM\Column(name="strCurrencyCode", type="string")
     */
    private $currencyCode;

    /**
     * @param string $reference
     * @param string $description
     * @param string $clientEmail
     * @param string $clientId
     * @param int $totalAmount
     * @param string $currencyCode
     * @param array $details
     */
    private function __construct(
        string $reference,
        string $description,
        string $clientEmail,
        string $clientId,
        int $totalAmount,
        string $currencyCode,
        array $details
    )
    {
        $this->reference = $reference;
        $this->description = $description;
        $this->clientEmail = $clientEmail;
        $this->clientId = $clientId;
        $this->totalAmount = $totalAmount;
        $this->currencyCode = $currencyCode;
        $this->details = $details;
    }

    /**
     * @param string $reference
     * @param string $description
     * @param string $clientId
     * @param string $clientEmail
     * @param int $totalAmount
     * @param string $currencyCode
     * @param array $details
     *
     * @return Payment
     */
    public static function create(
        string $reference,
        string $description,
        string $clientId,
        string $clientEmail,
        int $totalAmount,
        string $currencyCode,
        array $details
    ): Payment
    {
        return new self(
            $reference,
            $description,
            $clientEmail,
            $clientId,
            $totalAmount,
            $currencyCode,
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
    public function getReference(): string
    {
        return $this->reference;
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