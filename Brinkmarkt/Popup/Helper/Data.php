<?php

namespace Brinkmarkt\Popup\Helper;
use \Magento\Framework\App\Helper\AbstractHelper;

class Data extends AbstractHelper
{

	public function __construct(
        \Magento\Framework\Stdlib\DateTime\DateTime $date
    ) {
        $this->date = $date;
    }

   public function getCurrentWeekDay()
   {
       return date("l");
   }
   
	public function getCurrentTime()
   {
   		date_default_timezone_set('Europe/Amsterdam');
   		$date = $this->date->gmtDate();
        return $date;
   }
}