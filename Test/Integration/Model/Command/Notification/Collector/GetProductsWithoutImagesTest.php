<?php /** @noinspection ObjectManagerInspection */

namespace MageSuite\NotificationDashboard\Test\Integration\Model\Command\Notification\Collector;

use Magento\TestFramework\Fixture\AppArea;
use Magento\TestFramework\Fixture\AppIsolation;
use Magento\TestFramework\Fixture\DataFixture;
use Magento\TestFramework\Fixture\DataFixtureStorage;
use Magento\TestFramework\Fixture\DataFixtureStorageManager;
use Magento\TestFramework\Fixture\DbIsolation;
use MageSuite\NotificationDashboard\Test\Fixture\Collector as CollectorFixture;
use MageSuite\NotificationDashboard\Model\Command\Notification\Collector\GetProductsWithoutImages;
use MageSuite\NotificationDashboard\Model\Source\Severity;

#[AppArea('frontend')]
#[AppIsolation(true)]
#[DbIsolation(true)]
class GetProductsWithoutImagesTest extends \PHPUnit\Framework\TestCase
{
    protected ?\Magento\Framework\App\ObjectManager $objectManager;
    protected ?GetProductsWithoutImages $getProductsWithoutImages;
    protected ?\MageSuite\NotificationDashboard\Api\NotificationRepositoryInterface $notificationRepository;
    protected ?DataFixtureStorage $fixtures;

    public function setUp(): void
    {
        $this->objectManager = \Magento\TestFramework\ObjectManager::getInstance();
        $this->getProductsWithoutImages = $this->objectManager->get(GetProductsWithoutImages::class);
        $this->notificationRepository = $this->objectManager->get(\MageSuite\NotificationDashboard\Api\NotificationRepositoryInterface::class);
        $this->fixtures = $this->objectManager->get(DataFixtureStorageManager::class)->getStorage();
    }

    #[DataFixture(CollectorFixture::class, as: 'collector')]
    #[DataFixture('Magento/Catalog/_files/products_list.php')]
    public function testItAddsNotificationCorrectly()
    {
        $productsWithoutImagesSkua = [
            'simple-156',
            'simple-249',
            'wrong-simple'
        ];
        $collectors = $this->fixtures->get('collector')->getData('collectors');
        $collector = array_shift($collectors);

        $configurationFormat = '{"type_ids":%s,"excluded_skus":"%s"}';

        $collector->setSeverity(Severity::SEVERITY_MAJOR);
        $collector->setConfiguration(sprintf($configurationFormat, '["simple","bundle"]', implode(',', $productsWithoutImagesSkua)));

        $this->getProductsWithoutImages->setCollector($collector);
        $this->getProductsWithoutImages->setConfiguration($collector);

        $this->getProductsWithoutImages->execute();

        $notifications = $this->notificationRepository->getList()->getItems();
        $this->assertCount(0, $notifications);

        $collector->setConfiguration(sprintf($configurationFormat, '["simple","bundle"]', 'simple-156'));
        $this->getProductsWithoutImages->setCollector($collector);
        $this->getProductsWithoutImages->setConfiguration($collector);

        $this->getProductsWithoutImages->execute();

        $notifications = $this->notificationRepository->getList()->getItems();
        $this->assertCount(1, $notifications);

        $notification = current($notifications);

        $this->assertEquals($collector->getId(), $notification->getCollectorId());
        $this->assertEquals('Missing product images', $notification->getTitle());
        $messages[] = sprintf('Product with sku %s (type simple) has no images', $productsWithoutImagesSkua[1]);
        $messages[] = sprintf('Product with sku %s (type simple) has no images', $productsWithoutImagesSkua[2]);
        $this->assertEquals(implode("<br>", $messages), $notification->getMessage());
        $this->assertEquals(Severity::SEVERITY_MAJOR, $notification->getSeverity());
    }

    #[DataFixture(CollectorFixture::class, as: 'collector')]
    #[DataFixture('Magento/Catalog/_files/products_list.php')]
    public function testItDoesNotReportSimpleProductsWhenOnlyConfigurableIsSelected()
    {
        $collector = current($this->fixtures->get('collector')->getData('collectors'));

        $configurationFormat = '{"type_ids":%s,"excluded_skus":"%s"}';

        $collector->setSeverity(Severity::SEVERITY_MAJOR);
        $collector->setConfiguration(sprintf($configurationFormat, '["configurable"]', ''));

        $this->getProductsWithoutImages->setCollector($collector);
        $this->getProductsWithoutImages->setConfiguration($collector);

        $this->getProductsWithoutImages->execute();

        $notifications = $this->notificationRepository->getList()->getItems();
        $this->assertCount(0, $notifications);
    }
}
