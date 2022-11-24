<?php

declare(strict_types=1);

namespace JD\JdUsercentricsConfigurator\Tests\Unit\Controller;

use PHPUnit\Framework\MockObject\MockObject;
use TYPO3\TestingFramework\Core\AccessibleObjectInterface;
use TYPO3\TestingFramework\Core\Unit\UnitTestCase;
use TYPO3Fluid\Fluid\View\ViewInterface;

/**
 * Test case
 */
class ConfigControllerTest extends UnitTestCase
{
    /**
     * @var \JD\JdUsercentricsConfigurator\Controller\ConfigController|MockObject|AccessibleObjectInterface
     */
    protected $subject;

    protected function setUp(): void
    {
        parent::setUp();
        $this->subject = $this->getMockBuilder($this->buildAccessibleProxy(\JD\JdUsercentricsConfigurator\Controller\ConfigController::class))
            ->onlyMethods(['redirect', 'forward', 'addFlashMessage'])
            ->disableOriginalConstructor()
            ->getMock();
    }

    protected function tearDown(): void
    {
        parent::tearDown();
    }

    /**
     * @test
     */
    public function listActionFetchesAllConfigsFromRepositoryAndAssignsThemToView(): void
    {
        $allConfigs = $this->getMockBuilder(\TYPO3\CMS\Extbase\Persistence\ObjectStorage::class)
            ->disableOriginalConstructor()
            ->getMock();

        $configRepository = $this->getMockBuilder(\JD\JdUsercentricsConfigurator\Domain\Repository\ConfigRepository::class)
            ->onlyMethods(['findAll'])
            ->disableOriginalConstructor()
            ->getMock();
        $configRepository->expects(self::once())->method('findAll')->will(self::returnValue($allConfigs));
        $this->subject->_set('configRepository', $configRepository);

        $view = $this->getMockBuilder(ViewInterface::class)->getMock();
        $view->expects(self::once())->method('assign')->with('configs', $allConfigs);
        $this->subject->_set('view', $view);

        $this->subject->listAction();
    }

    /**
     * @test
     */
    public function showActionAssignsTheGivenConfigToView(): void
    {
        $config = new \JD\JdUsercentricsConfigurator\Domain\Model\Config();

        $view = $this->getMockBuilder(ViewInterface::class)->getMock();
        $this->subject->_set('view', $view);
        $view->expects(self::once())->method('assign')->with('config', $config);

        $this->subject->showAction($config);
    }

    /**
     * @test
     */
    public function createActionAddsTheGivenConfigToConfigRepository(): void
    {
        $config = new \JD\JdUsercentricsConfigurator\Domain\Model\Config();

        $configRepository = $this->getMockBuilder(\JD\JdUsercentricsConfigurator\Domain\Repository\ConfigRepository::class)
            ->onlyMethods(['add'])
            ->disableOriginalConstructor()
            ->getMock();

        $configRepository->expects(self::once())->method('add')->with($config);
        $this->subject->_set('configRepository', $configRepository);

        $this->subject->createAction($config);
    }

    /**
     * @test
     */
    public function editActionAssignsTheGivenConfigToView(): void
    {
        $config = new \JD\JdUsercentricsConfigurator\Domain\Model\Config();

        $view = $this->getMockBuilder(ViewInterface::class)->getMock();
        $this->subject->_set('view', $view);
        $view->expects(self::once())->method('assign')->with('config', $config);

        $this->subject->editAction($config);
    }

    /**
     * @test
     */
    public function updateActionUpdatesTheGivenConfigInConfigRepository(): void
    {
        $config = new \JD\JdUsercentricsConfigurator\Domain\Model\Config();

        $configRepository = $this->getMockBuilder(\JD\JdUsercentricsConfigurator\Domain\Repository\ConfigRepository::class)
            ->onlyMethods(['update'])
            ->disableOriginalConstructor()
            ->getMock();

        $configRepository->expects(self::once())->method('update')->with($config);
        $this->subject->_set('configRepository', $configRepository);

        $this->subject->updateAction($config);
    }

    /**
     * @test
     */
    public function deleteActionRemovesTheGivenConfigFromConfigRepository(): void
    {
        $config = new \JD\JdUsercentricsConfigurator\Domain\Model\Config();

        $configRepository = $this->getMockBuilder(\JD\JdUsercentricsConfigurator\Domain\Repository\ConfigRepository::class)
            ->onlyMethods(['remove'])
            ->disableOriginalConstructor()
            ->getMock();

        $configRepository->expects(self::once())->method('remove')->with($config);
        $this->subject->_set('configRepository', $configRepository);

        $this->subject->deleteAction($config);
    }
}
