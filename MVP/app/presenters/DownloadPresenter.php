<?php

use FileDownloader\DownloadResponse;
use FileDownloader\Tools;

/**
 * My Application
 *
 * @copyright  Copyright (c) 2009 John Doe
 * @package    MyApplication
 */



/**
 * Homepage presenter.
 *
 * @author     John Doe
 * @package    MyApplication
 */
class DownloadPresenter extends BasePresenter {

	function handleDownloadClassic() {
		$fileDownload = new DownloadResponse($this);
		$fileDownload->sourceFile = __FILE__;
		$fileDownload->speedLimit = 5*Tools::KILOBYTE;
		$fileDownload->download();
	}

	function handleDownloadFluent() {
		DownloadResponse::getInstance($this)
			->setSourceFile(__FILE__)
			->setSpeedLimit(5*Tools::KILOBYTE)
			->download();
	}

	function handleDownloadClassicSendResponse() {
		$fileDownload = new DownloadResponse($this);
		$fileDownload->sourceFile = __FILE__;
		$fileDownload->speedLimit = 5*Tools::KILOBYTE;
		$this->sendResponse($fileDownload);
	}

	function handleDownloadFluentSendResponse() {
		$this->sendResponse(
			DownloadResponse::getInstance($this)
			->setSourceFile(__FILE__)
			->setSpeedLimit(5*Tools::KILOBYTE)
		);
	}

}
