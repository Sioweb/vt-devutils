<?php

namespace Vt\Oxid\DevCore\Core;

use OxidEsales\Eshop\Core\Base;
use OxidEsales\Eshop\Core\Config;
use OxidEsales\Eshop\Core\Registry;

class DevUtils extends Base
{

    public function success($content, $time = false)
    {
        header('Content-Type: application/json; charset=UTF-8');
        if ($time) {
            header('Last-Modified: ' . date('r', $time));
        }

        echo json_encode($content);
        exit;
    }

    public function error($content)
    {
        header('HTTP/1.1 500 It didnt work... ');
        header('Content-Type: application/json; charset=UTF-8');
        die(json_encode(array('error' => $content)));
    }

    public function clearTmp($output = false)
    {
        $pattern = Registry::get(Config::class)->getConfigParam("sCompileDir") . "/*.txt";
        $i = 0;
        $fs = 0;
        foreach (glob($pattern) as $item) {
            if (is_file($item)) {
                $fs += filesize($item);
                unlink($item);
                $i++;
            }
        }
        $fs = number_format($fs / 1024 / 1024, 2);

        if (!$output) {
            return "$i files ( $fs MB )  deleted";
        }

        echo "$i files ( $fs MB )  deleted";
        exit;
    }

    public function clearTpl($output = false)
    {
        $pattern = Registry::get(Config::class)->getConfigParam("sCompileDir") . "smarty/*.php";
        $i = 0;
        $fs = 0;
        foreach (glob($pattern) as $item) {
            if (is_file($item)) {
                $fs += filesize($item);
                unlink($item);
                $i++;
            }
        }
        $fs = number_format($fs / 1024 / 1024, 2);

        if (!$output) {
            return "$i files ( $fs MB )  deleted";
        }

        echo "$i files ( $fs MB )  deleted";
        exit;
    }

    public function updateViews($output = false)
    {
        if (Registry::getSession()->getVariable("malladmin")) {
            $oMetaData = oxNew('oxDbMetaDataHandler');
            $ret = $oMetaData->updateViews();

            if (!$output) {
                return $ret;
            }

            echo $ret;
            exit;
        }
    }

}
