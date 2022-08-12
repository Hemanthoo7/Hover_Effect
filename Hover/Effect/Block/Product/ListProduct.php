<?php
namespace Hover\Effect\Block\Product;
use Magento\Catalog\Model\Product;
use Magento\Catalog\Api\Data\ProductInterface;
use Magento\Catalog\Block\Product\AbstractProduct;
use Magento\Catalog\Block\Product\AwareInterface as ProductAwareInterface;
class ListProduct extends \Magento\Catalog\Block\Product\ListProduct implements ProductAwareInterface
{
    protected $_customerSession;
    protected $categoryFactory;
    private $product;
    public function __construct(
        \Magento\Catalog\Block\Product\Context $context,
        \Magento\Framework\Data\Helper\PostHelper $postDataHelper,
        \Magento\Catalog\Model\Layer\Resolver $layerResolver,
        \Magento\Catalog\Api\CategoryRepositoryInterface $categoryRepository,
        \Magento\Framework\Url\Helper\Data $urlHelper,
        \Magento\Customer\Model\Session $customerSession,
        \Magento\Catalog\Model\CategoryFactory $categoryFactory,
        array $data = []
    ) {
        $this->_customerSession = $customerSession;
        $this->categoryFactory = $categoryFactory;
        //   $this->_helper = $helper;
        parent::__construct(
            $context,
            $postDataHelper,
            $layerResolver,
            $categoryRepository,
            $urlHelper,
            $data
        );

    }
    public function setProduct(ProductInterface $product)
    {
        $this->product = $product;
        return $this;
    }
    public function getProduct()
    {
        if (is_null($this->product)) {
            $this->product = $this->registry->registry('product');
            if (!$this->product->getId()) {
                throw new LocalizedException(__('Failed to initialize product'));
            }
        }
        return $this->product;
    }
    public function getProductStatus()
    {
        return $this->getProduct()->getStatus();
    }
}
