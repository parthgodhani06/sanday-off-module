<?php
namespace Brinkmarkt\Popup\Observer;

use Magento\Framework\App\RequestInterface;
use Magento\Framework\App\Response\Http;
use Magento\Framework\App\ViewInterface;
use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;
use Brinkmarkt\Popup\Helper\Data as HelperData;
class Redirect implements ObserverInterface
{
    protected $_helperData;
    protected $_response;
    protected $_view;
    protected $_request;

    public function __construct(
        HelperData $helperData,
        Http $response,
        ViewInterface $view,
        RequestInterface $request
    ) {
        $this->_helperData = $helperData;
        $this->_response = $response;
        $this->_view = $view;
        $this->_request = $request;
    }

    public function execute(Observer $observer)
    {
        $day = $this->_helperData->getCurrentWeekDay();
        if($day == "Sunday"){
            $this->_view->loadLayout(['default','popup_index_display'], true, true, false);
            $this->_response->setHttpResponseCode(503);
        }else{
            // $layout = $observer->getEvent()->getLayout();
            // $layout->getUpdate()->addHandle('sunday_cart_off');
            return true;
        }
        $this->_request->setDispatched(true);
        return true;
    }
}
