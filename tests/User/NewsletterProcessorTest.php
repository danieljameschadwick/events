<?php

declare(strict_types=1);

namespace App\Tests\User;

use App\DTO\NewsletterDTO;
use App\Entity\User\Newsletter;
use App\Repository\NewsletterRepository;
use App\User\NewsletterProcessor;
use Doctrine\ORM\EntityManager;
use PHPUnit\Framework\MockObject\MockBuilder;
use PHPUnit\Framework\MockObject\MockObject;
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
     * @var EntityManager|MockObject
     */
    private $entityManager;

    /**
     * @var Security|MockObject
     */
    private $security;

    /**
     * @var FlashBag|MockObject
     */
    private $flashBag;

    /**
     * @var NewsletterDTO
     */
    private $newsletterDTO;

    public function setUp(): void
    {
        $this->entityManager = $this->createMock(EntityManager::class);
        $this->security = $this->createMock(Security::class);
        $this->flashBag = $this->createMock(FlashBag::class);

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

        $this->entityManager
            ->method('getRepository')
            ->willReturn($repository);

        $this->testClass = new NewsletterProcessor(
            $this->entityManager,
            $this->security,
            $this->flashBag
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

        self::assertEquals($this->newsletterDTO->getEmail(), $newsletter->getEmail());
        self::assertTrue($newsletter->isSubscribed());
    }
}