<?php
namespace Brinkmarkt\Popup\Observer;

use Magento\Config\Model\ResourceModel\Config;

class DisableOutput implements \Magento\Framework\Event\ObserverInterface
{

const VENDOR_CONFIG = 'brinkmarkt_popup/general/enable';
protected $_config;
protected $_scopeConfig;
protected $storeManager;

public function  __construct(
    Config $_config,
    \Magento\Framework\App\Config\ScopeConfigInterface $_scopeConfig,
    \Magento\Store\Model\StoreManagerInterface $storeManager,
    \Magento\Framework\App\RequestInterface $request
){
    $this->_config = $_config;
    $this->_scopeConfig = $_scopeConfig;
    $this->storeManager = $storeManager;
    $this->request = $request;
}

public function execute(\Magento\Framework\Event\Observer $observer)
{
    $disable = false;
    $scopeType = \Magento\Framework\App\Config\ScopeConfigInterface::SCOPE_TYPE_DEFAULT;
    $scopeCode = 0;

    if($this->request->getParam(\Magento\Store\Model\ScopeInterface::SCOPE_STORE))
    {
        $scopeType = ScopeInterface::SCOPE_STORE;
        $scopeCode = $this->storeManager->getStore($this->request->getParam(\Magento\Store\Model\ScopeInterface::SCOPE_STORE))->getCode();
    }elseif($this->request->getParam(\Magento\Store\Model\ScopeInterface::SCOPE_WEBSITE))
    {
        $scopeType = ScopeInterface::SCOPE_WEBSITE;
        $scopeCode = $this->storeManager->getWebsite($this->request->getParam(\Magento\Store\Model\ScopeInterface::SCOPE_WEBSITE))->getCode();
    }
    else
    {
        $scopeType = \Magento\Framework\App\Config\ScopeConfigInterface::SCOPE_TYPE_DEFAULT;
        $scopeCode = 0;
    }

    $moduleConfig= $this->_scopeConfig->getValue(self::VENDOR_CONFIG, $scopeType);

    if((int)$moduleConfig == 0){
        $disable = true;
    }

    $outputPath = "advanced/modules_disable_output/Brinkmarkt_Popup";

    $this->_config->saveConfig($outputPath,$disable, 'default',$scopeCode);
    }
}
