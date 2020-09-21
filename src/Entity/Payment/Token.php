<?php

declare(strict_types=1);

namespace App\Entity\Payment;

use Doctrine\ORM\Mapping as ORM;
use Payum\Core\Model\Token as BaseToken;

/**
 * Will be split out /eventually/ to a payment microservice.
 *
 * @ORM\Table(
 *     schema="events",
 *     name="tblToken"
 * )
 * @ORM\Entity
 */
class Token extends BaseToken
{

}