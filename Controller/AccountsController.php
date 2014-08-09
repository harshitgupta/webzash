<?php
/**
 * The MIT License (MIT)
 *
 * Webzash - Easy to use web based double entry accounting software
 *
 * Copyright (c) 2014 Prashant Shah <pshah.mumbai@gmail.com>
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
 */

App::uses('WebzashAppController', 'Webzash.Controller');
App::uses('AccountList', 'Webzash.Lib');

/**
 * Webzash Plugin Accounts Controller
 *
 * @package Webzash
 * @subpackage Webzash.controllers
 */
class AccountsController extends WebzashAppController {

/**
 * This controller does not use a model
 *
 * @var array
 */
	public $uses = array();

/**
 * index method
 *
 * @return void
 */
	public function index() {
		return $this->redirect(array('action' => 'show'));
	}

/**
 * show method
 *
 * @return void
 */
	public function show() {
		/* TODO : Switch to loadModel() */
		App::import("Webzash.Model", "Ledger");
		$this->Ledger = new Ledger();

		$this->set('actionlinks', array(
			array('controller' => 'groups', 'action' => 'add', 'title' => 'Add Group'),
			array('controller' => 'ledgers', 'action' => 'add', 'title' => 'Add Ledger')
		));
		$accountlist = new AccountList();
		$accountlist->start(0);
		$this->set('accountlist', $accountlist);

		$opdiff = $this->Ledger->getOpeningDiff();
		if (calculate($opdiff['opdiff_balance'], 0, '==')) {
			/* Nothing to do */
		} else {
			$this->Session->setFlash(__d('webzash', 'There is a difference in opening balance of ') . toCurrency($opdiff['opdiff_balance_dc'], $opdiff['opdiff_balance']), 'error');
		}

		return;
	}

}
