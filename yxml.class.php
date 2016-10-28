<?php

/*
 * Yandex search XML class
 * @author Vitaliy Krupin
 * @email dmf2@mail.ru
 * @url https://vkrupin.ru
 */

class yxml {

    private $user = '';
    private $key = '';
    private $cache = true;
    private $cache_dir = '';
    private $log_array = array();
    private $xml_result = '';


    public function __construct($user = '', $key = '', $cache = true, $cache_dir = '') {

        // Delete space
        $user = trim($user);
        $key = trim($key);
        $cache_dir = trim($cache_dir);

        $this->user = $user;
        $this->key = $key;
        $this->cache = $cache;

        // Cache
        if ($cache) {
            if (!empty($cache_dir)) {
                $this->cache_dir = $cache_dir;
                $this->addLog('Setup cache directory: "' . $this->cache_dir . '"');
            } else {
                // Cache directory
                $cache_root = __DIR__ . DIRECTORY_SEPARATOR . 'cache';

                // Create cache root directory if not exist
                if (!is_dir($cache_root)) {
                    mkdir($cache_root);
                    $this->addLog('Create cache root directory: "' . $cache_root . '"');
                } else {
                    $this->addLog('Cache root directory exist: "' . $cache_root . '"');
                }

                $this->cache_dir = $cache_root . DIRECTORY_SEPARATOR . date('Y-m-d');
                $this->addLog('Setup cache directory by default: "' . $this->cache_dir . '"');
            }

            // Create cache directory if not exist
            if (!is_dir($this->cache_dir)) {
                mkdir($this->cache_dir);
                $this->addLog('Create cache directory: "' . $this->cache_dir . '"');
            } else {
                $this->addLog('Cache directory exist: "' . $this->cache_dir . '"');
            }
        }

    }

    /*
     * Get XML search result
     */
    public function getResult($keyword = '', $geo = 213) {

        $this->addLog('Get XML search result');

        $keyword = trim($keyword);

        if (!empty($keyword)) {

            $this->addLog('Keyword: "' . $keyword . '"');

            $keyword = urlencode($keyword);
            $this->addLog('Encoded keyword: "' . $keyword . '"');

            if ($geo <= 0) {
                $this->addLog('GEO ID "' . $geo . '" is not correct');
                $geo = 213;
                $this->addLog('Set GEO ID by default: "' . $geo . '"');
            }

            $file = $this->cache_dir . DIRECTORY_SEPARATOR . date('Y-m-d_') . $geo . '_' . md5($keyword) . '.xml';

            if (file_exists($file) and $this->cache) {
                // Load cache
                $this->addLog('Loading from cache: "' . $file . '"');
                $res = file_get_contents($file);
                return $res;

            } else {
                // Get XML result

                $curl = curl_init();
                $this->addLog('CURL init');

                $xml_url = 'https://yandex.ru/search/xml?user=' . $this->user . '&key=' . $this->key . '&xml=1&groupby=attr%3Dd.mode%3Ddeep.groups-on-page%3D100&query=' . $keyword . '&lr=' . $geo;

                $this->addLog('XML URL: "' . $xml_url . '"');

                curl_setopt($curl, CURLOPT_URL, $xml_url);
                curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1);
                curl_setopt($curl, CURLOPT_HEADER, 0);
                curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
                curl_setopt($curl, CURLOPT_USERAGENT, 'Opera/9.80 (Windows NT 5.1; U; ru) Presto/2.7.62 Version/11.01');
                $res = curl_exec($curl);
                curl_close($curl);
                $this->addLog('CURL close');

                if (strpos($res, '<error code="') === false) {

                    // Save result to cache
                    if ($this->cache) {
                        file_put_contents($file, $res);
                        $this->xml_result = $res;
                        $this->addLog('Save XML result to cache: "' . $file . '"');
                    }

                    return $res;
                }

                // Save result to cache
                if ($this->cache) {

                    $file = $this->cache_dir . DIRECTORY_SEPARATOR . 'error_' . date('Y-m-d') . '_' . $geo . '_' . md5($keyword) . '.xml';
                    file_put_contents($file, $res);

                    $this->addLog('Save error to cache: "' . $file . '"');
                }

                $this->addLog('Errors on XML');
                return false;
            }

        }

        $this->addLog('Keyword is empty');
        return false;

    }


    /*
     * Get domain position on search result
     */
    public function position($domain = '', $xml_result = '') {
        $this->addLog('Search domain position in search results');

        $domain = trim($domain);
        $xml_result = trim($xml_result);

        if (!empty($domain)) {
            $this->addLog('Search domain: "' . $domain . '"');

            if (empty($xml_result)) {
                if (empty($this->xml_result)) {
                    $this->addLog('XML results are empty');
                    return false;
                }

                $xml_result = $this->xml_result;
            }

            $xml = simplexml_load_string($xml_result);

            $position_counter = 1;
            $domain_search = strtolower($domain);

            foreach ($xml->response->results->grouping->group as $group)
            {
                $domain = strtolower($group->doc->domain);
                if((strpos($domain, $domain_search)) or ($domain == $domain_search))
                {
                    $this->addLog('Domain found on #' . $position_counter . ' position');
                    return $position_counter;
                }
                $position_counter++;
            }

            $this->addLog('Domain not found in search results');
            return false;

        } else {
            $this->addLog('Domain name is empty');
        }

        return false;
    }



    /*
     * Add string to class log
     */
    private function addLog($string = '') {
        $string = trim($string);
        if (!empty($string)) {
            $this->log_array[] = $string;
            return true;
        }
        return false;
    }


    /*
     * Get class log
     */
    public function log() {
        $output = '';
        $counter = 0;

        foreach ($this->log_array as $log) {
            $counter++;
            $output .= '[' . $counter . '] ' . $log . PHP_EOL;
        }

        return $output;
    }

}