<?php declare(strict_types=1);

namespace Flavio\Bookmarks\Api\Data;

/**
 * Bookmark interface.
 * @api
 * @since 1.0.0
 */
interface BookmarkInterface
{
    const ID = 'id';
    const CUSTOMER_ID = 'customer_id';
    const URL = 'url';
    const PAGE_TITLE = 'page_title';
    const CUSTOMER_NAME = 'customer_name';

    /**
     * @return int
     */
    public function getId();

    /**
     * @return string
     */
    public function getPageTitle();

    /**
     * @param string $pageTitle
     * @return $this
     */
    public function setPageTitle($pageTitle);

    /**
     * @return string
     */
    public function getUrl();

    /**
     * @param string $url
     * @return $this
     */
    public function setUrl($url);

    /**
     * @return string
     */
    public function getCustomerName();

    /**
     * @param string $customerName
     * @return $this
     */
    public function setCustomerName($customerName);

    /**
     * @return int
     */
    public function getCustomerId();

    /**
     * @param int $customerId
     * @return $this
     */
    public function setCustomerId($customerId);

    /**
     * @param int $customerId
     * @return []
     */
    public function getBookmarksByCustomerId($customerId);

}
