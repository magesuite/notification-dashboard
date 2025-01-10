<?php

namespace MageSuite\NotificationDashboard\Test\Integration\Model\Schedule;

class JobsTest extends \PHPUnit\Framework\TestCase
{
    protected ?\MageSuite\NotificationDashboard\Model\Schedule\Jobs $scheduleJobs;

    protected function setUp(): void
    {
        $objectManager = \Magento\TestFramework\ObjectManager::getInstance();

        $this->scheduleJobs = $objectManager->get(\MageSuite\NotificationDashboard\Model\Schedule\Jobs::class);
    }

    /**
     * @magentoAppIsolation enabled
     * @magentoDbIsolation enabled
     * @magentoDataFixture MageSuite_NotificationDashboard::Test/Integration/_files/collector.php
     */
    public function testItReturnsCorrectJobs()
    {
        $jobs = $this->scheduleJobs->execute();

        $this->assertGreaterThanOrEqual(2, $jobs);
        $this->assertContains('30 */4 * * *', array_column($jobs, 'cron_expression'));
        $this->assertContains('0 * * * *', array_column($jobs, 'cron_expression'));
    }
}
