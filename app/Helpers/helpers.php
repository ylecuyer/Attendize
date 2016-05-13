<?php

if (!function_exists('get_supported_locales')) {
	
	function get_supported_locales() {
		
		return array(
			"en" => "English",
			"es" => "Spanish",
			"fr" => "French",
		);

	}

}

if (!function_exists('flag')) {
	
	function flag($locale) {
	
		$code = '';

		switch ($locale) {
			case "en":
				$code = "gb";
				break;
			default:
				$code = $locale;
		}		

		return '<span class="flag-icon flag-icon-'.$code.'"></span>';
	}	

}

if(!function_exists('money')) {
    /**
     * @param int $amount
     * @param string $currency_code
     * @param int $decimals
     * @param string $dec_point
     * @param string $thousands_sep
     *
     * @return string
     */
    function money($amount, $currency_code = '', $decimals = 2, $dec_point = '.', $thousands_sep = ',')
    {
        switch ($currency_code) {
            case 'USD':
            case 'AUD':
            case 'CAD':
                $currency_symbol = '$';
                break;
            case 'EUR':
                $currency_symbol = '€';
                break;
            case 'GBP':
                $currency_symbol = '£';
                break;

            default:
                $currency_symbol = '';
                break;
        }

        return $currency_symbol . number_format($amount, $decimals, $dec_point, $thousands_sep);
    }
}


