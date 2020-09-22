<?php

declare(strict_types=1);

namespace App\Entity\Payment;

use Doctrine\ORM\Mapping as ORM;
use Payum\Core\Model\Payment as BasePayment;

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
class Payment extends BasePayment
{
    /**
     * @ORM\Column(name="intPaymentId", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     *
     * @var integer $id
     */
    protected $id;

    /**
     * @var string
     *
     * @ORM\Column(name="strReference", type="string")
     */
    protected $number;

    /**
     * @var string
     *
     * @ORM\Column(name="strDescription", type="string")
     */
    protected $description;

    /**
     * @var string
     *
     * @ORM\Column(name="strEmail", type="string")
     */
    protected $clientEmail;

    /**
     * @var string
     *
     * @ORM\Column(name="strClientId", type="string")
     */
    protected $clientId;

    /**
     * @var int
     *
     * @ORM\Column(name="intCentesimalAmount", type="integer")
     */
    protected $totalAmount;

    /**
     * todo: Convert to an object/use base object
     *
     * @var string
     *
     * @ORM\Column(name="strClientId", type="string")
     */
    protected $currencyCode;

    /**
     * todo: define what type of array
     *
     * @var array
     */
    protected $details;

    /**
     * @return self
     */
    public static function create(): self
    {
        $instance = new self();

        $instance->setNumber(uniqid('', true));
        $instance->setCurrencyCode('EUR');
        $instance->setTotalAmount(123); // 1.23 EUR
        $instance->setDescription('A description');
        $instance->setClientId('anId');
        $instance->setClientEmail('foo@example.com');

        return $instance;
    }
}