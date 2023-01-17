<?php

/**
 *
 * Copyright (c) Ratepay GmbH
 *
 *For the full copyright and license information, please view the LICENSE
 *file that was distributed with this source code.
 */

namespace pi\ratepay\Application\Controller\Admin;

use pi\ratepay\Application\Model\Logs;

class LogList extends AdminListBase
{
    /**
     * Current class template name.
     * @var string
     */
    protected $_sThisTemplate = 'pi_ratepay_log_list.tpl';

    /**
     * Name of chosen object class (default null).
     *
     * @var string
     */
    protected $_sListClass = Logs::class;


    /**
     * Sets default list sorting field and executes parent method parent::Init().
     *
     * @return null
     */
    public function init() {
        $oConfig = $this->getConfig();
        $this->_sDefSort = "DATE";
        $sSortCol = $oConfig->getRequestParameter('sort');

        if (!$sSortCol || $sSortCol == $this->_sDefSort) {
            $this->_blDesc = false;
        }

        parent::init();
    }
}