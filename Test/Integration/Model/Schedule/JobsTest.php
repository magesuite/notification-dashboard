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

        $this->assertCount(2, $jobs);
        $this->assertEquals('30 */4 * * *', $jobs[0]['cron_expression']);
        $this->assertEquals('0 * * * *', $jobs[1]['cron_expression']);

    }
}
