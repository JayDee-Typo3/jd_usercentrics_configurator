<?php

declare(strict_types=1);

namespace JD\JdUsercentricsConfigurator\Tests\Unit\Domain\Model;

use PHPUnit\Framework\MockObject\MockObject;
use TYPO3\TestingFramework\Core\AccessibleObjectInterface;
use TYPO3\TestingFramework\Core\Unit\UnitTestCase;

/**
 * Test case
 */
class ConfigTest extends UnitTestCase
{
    /**
     * @var \JD\JdUsercentricsConfigurator\Domain\Model\Config|MockObject|AccessibleObjectInterface
     */
    protected $subject;

    protected function setUp(): void
    {
        parent::setUp();

        $this->subject = $this->getAccessibleMock(
            \JD\JdUsercentricsConfigurator\Domain\Model\Config::class,
            ['dummy']
        );
    }

    protected function tearDown(): void
    {
        parent::tearDown();
    }

    /**
     * @test
     */
    public function getSettingsIdReturnsInitialValueForString(): void
    {
        self::assertSame(
            '',
            $this->subject->getSettingsId()
        );
    }

    /**
     * @test
     */
    public function setSettingsIdForStringSetsSettingsId(): void
    {
        $this->subject->setSettingsId('Conceived at T3CON10');

        self::assertEquals('Conceived at T3CON10', $this->subject->_get('settingsId'));
    }

    /**
     * @test
     */
    public function getActivateReturnsInitialValueForBool(): void
    {
        self::assertFalse($this->subject->getActivate());
    }

    /**
     * @test
     */
    public function setActivateForBoolSetsActivate(): void
    {
        $this->subject->setActivate(true);

        self::assertEquals(true, $this->subject->_get('activate'));
    }

    /**
     * @test
     */
    public function getUseFooterLinkReturnsInitialValueForBool(): void
    {
        self::assertFalse($this->subject->getUseFooterLink());
    }

    /**
     * @test
     */
    public function setUseFooterLinkForBoolSetsUseFooterLink(): void
    {
        $this->subject->setUseFooterLink(true);

        self::assertEquals(true, $this->subject->_get('useFooterLink'));
    }

    /**
     * @test
     */
    public function getUseGtmReturnsInitialValueForBool(): void
    {
        self::assertFalse($this->subject->getUseGtm());
    }

    /**
     * @test
     */
    public function setUseGtmForBoolSetsUseGtm(): void
    {
        $this->subject->setUseGtm(true);

        self::assertEquals(true, $this->subject->_get('useGtm'));
    }

    /**
     * @test
     */
    public function getBlockOnlyReturnsInitialValueForString(): void
    {
        self::assertSame(
            '',
            $this->subject->getBlockOnly()
        );
    }

    /**
     * @test
     */
    public function setBlockOnlyForStringSetsBlockOnly(): void
    {
        $this->subject->setBlockOnly('Conceived at T3CON10');

        self::assertEquals('Conceived at T3CON10', $this->subject->_get('blockOnly'));
    }

    /**
     * @test
     */
    public function getBlockElementsReturnsInitialValueForString(): void
    {
        self::assertSame(
            '',
            $this->subject->getBlockElements()
        );
    }

    /**
     * @test
     */
    public function setBlockElementsForStringSetsBlockElements(): void
    {
        $this->subject->setBlockElements('Conceived at T3CON10');

        self::assertEquals('Conceived at T3CON10', $this->subject->_get('blockElements'));
    }
}
