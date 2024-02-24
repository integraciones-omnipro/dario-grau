<?php
declare(strict_types=1);

namespace Omnipro\QuickProductPositioning\Block\Adminhtml\FeaturedProduct\Edit\Buttons;

use Magento\Backend\Block\Widget\Context;
use Magento\Framework\AuthorizationInterface;
use Magento\Framework\Exception\NoSuchEntityException;
use Omnipro\QuickProductPositioning\Api\FeaturedProductRepositoryInterface;

class Generic
{
    protected AuthorizationInterface $authorization;
    protected Context $context;
    protected FeaturedProductRepositoryInterface $repository;

    public function __construct(
        Context $context,
        FeaturedProductRepositoryInterface $repository
    ) {
        $this->context = $context;
        $this->repository = $repository;
        $this->authorization = $context->getAuthorization();
    }

    public function getEntityId()
    {
        try {
            return $this->repository->getById(
                $this->context->getRequest()->getParam('id')
            )->getId();
        } catch (NoSuchEntityException $e) {
            return null;
        }
    }

    /**
     * Generate url by route and parameters
     * @param   string $route
     * @param array $params
     * @return  string
     */
    public function getUrl(string $route = '', array $params = []): string
    {
        return $this->context->getUrlBuilder()->getUrl($route, $params);
    }
}
