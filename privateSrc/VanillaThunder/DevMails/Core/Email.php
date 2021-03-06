<?php

/**
 * vt dev utilities - mails
 * The MIT License (MIT)
 *
 * Copyright (C) 2015  Marat Bedoev
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 *
 * Version:    0.9
 * Author:     Marat Bedoev <oxid@marat.ws>
 */

namespace Vt\Oxid\DevMails\Core;

use OxidEsales\Eshop\Core\Registry;
use OxidEsales\Eshop\Core\SeoEncoder;

class Email extends Email_parent
{
    private $_blDebug = false;

    public function setDebug($blDebug = true)
    {
        $this->_blDebug = $blDebug;
    }

    public function isDebug()
    {
        return $this->_blDebug;
    }

    public function send()
    {
        if ($this->isDebug()) {
            $encoder = Registry::get(SeoEncoder::class);
            $sFile = $this->getSubject();
            $sFile = $encoder->encodeString($sFile, true, 0);
            $sFile = preg_replace("/[^A-Za-z0-9" . preg_quote('-', '/') . " \t\/]+/", '', $sFile);
            $sFile = preg_replace("/[^A-Za-z0-9" . preg_quote('-', '/') . "\/]+/", '_', $sFile);
            if (is_file(Registry::getConfig()->getLogsDir() . $sFile . '.html')) {
                unlink(Registry::getConfig()->getLogsDir() . $sFile . '.html');
            }

            Registry::getUtils()->writeToLog(preg_replace("/\r|\n/", "", $this->getBody()), $sFile . '.html');
            return $this;
        }
        return parent::send();
    }

    public function sendForgotPwdEmail($sEmailAddress, $sSubject = null)
    {
        Registry::getUtils()->writeToLog($sEmailAddress . " haz forgot pwd!", 'pwd.log');
        $ret = parent::sendForgotPwdEmail($sEmailAddress, $sSubject);
        Registry::getUtils()->writeToLog($sEmailAddress . " haz forgot pwd!!!!", 'pwd.log');
        return ($this->isDebug()) ? $this : $ret;
    }
}
