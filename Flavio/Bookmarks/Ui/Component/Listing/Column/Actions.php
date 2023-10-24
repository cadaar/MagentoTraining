<?php declare(strict_types=1);

namespace Flavio\Bookmarks\Ui\Component\Listing\Column;

use Magento\Framework\UrlInterface;
use Magento\Framework\View\Element\UiComponent\ContextInterface;
use Magento\Framework\View\Element\UiComponentFactory;
use Magento\Ui\Component\Listing\Columns\Column;

class Actions extends Column
{
    /** @var UrlInterface */
    protected $urlBuilder;

    public function __construct(
        ContextInterface $context,
        UiComponentFactory $uiComponentFactory,
        UrlInterface $urlBuilder,
        array $components = [],
        array $data = [])
    {
        $this->urlBuilder = $urlBuilder;
        parent::__construct($context, $uiComponentFactory, $components, $data);
    }

    public function prepareDataSource(array $dataSource): array
    {
        if (!isset($dataSource['data']['items'])) {
            return $dataSource;
        }

        foreach ($dataSource['data']['items'] as & $item) {
            if (!isset($item['id'])) {
                continue;
            }

            $item[$this->getData('name')] = [
                'view' => [
                    'href' => $this->urlBuilder->getUrl('bookmarks/AllBookmarks/view', [
                        'id' => $item['id']
                    ]),
                    'label' => __('View')
                ],
//                'delete' => [
//                    'href' => $this->urlBuilder->getUrl('minerva/faq/delete', [
//                        'id' => $item['id']
//                    ]),
//                    'label' => __('Delete'),
//                    'confirm' => [
//                        'title' => __('Delete Question'),
//                        'message' => __('Are you sure you want to delete «%1» question record?', $this['question'])
//                    ]
//                ],
            ];
        }

        return $dataSource;
    }

}
