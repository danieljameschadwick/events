<?php

declare(strict_types=1);

namespace App\Tests\User;

use App\DTO\NewsletterDTO;
use App\Entity\User\Newsletter;
use App\Repository\NewsletterRepository;
use App\User\NewsletterProcessor;
use Doctrine\ORM\EntityManager;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Session\Flash\FlashBag;
use Symfony\Component\Security\Core\Security;

/**
 * Class NewsletterProcessorTest
 * @package App\Tests\User
 *
 * @property NewsletterProcessor $testClass
 */
class NewsletterProcessorTest extends TestCase
{
    /**
     * @var NewsletterProcessor
     */
    private $testClass;

    /**
     * @var NewsletterDTO
     */
    private $newsletterDTO;

    public function setUp(): void
    {
        $entityManager = $this->createMock(EntityManager::class);
        $security = $this->createMock(Security::class);
        $flashBag = $this->createMock(FlashBag::class);

        $this->newsletterDTO = NewsletterDTO::create(
            'daniel@chadwk.com',
            false
        );

        $newsletter = Newsletter::createFromDTO($this->newsletterDTO);

        $repository = $this->getMockBuilder(NewsletterRepository::class)
            ->disableOriginalConstructor()
            ->getMock();

        $repository
            ->method('getOneByEmail')
            ->willReturn($newsletter);

        $entityManager
            ->method('getRepository')
            ->willReturn($repository);

        $this->testClass = new NewsletterProcessor(
            $entityManager,
            $security,
            $flashBag
        );
    }

    public function testNewsletterDTONotSet(): void
    {
        $this->expectErrorMessage('NewsletterDTO is not set.');
        $this->testClass->subscribe();
    }

    public function testSubscribe(): void
    {
        $this->testClass->setNewsletterDTO($this->newsletterDTO);
        $this->testClass->subscribe();

        $newsletter = $this->testClass->getNewsletter();

        self::assertNull($newsletter->getId());
        self::assertEquals($this->newsletterDTO->getEmail(), $newsletter->getEmail());
        self::assertTrue($newsletter->isSubscribed());
    }
}