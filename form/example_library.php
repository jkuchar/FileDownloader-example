<?php

use FileDownloader\Downloader\AdvancedDownloader;
use FileDownloader\FileDownload;
use FileDownloader\IDownloader;
use Nette\Diagnostics\Debugger;
use Nette\Environment;
use Nette\Templating\Helpers;

/**
 * Generates random file
 * @param string $location
 * @param int $size in kb
 */
function generateFile($location,$size) {
	$fp = fopen($location,"wb");
	$toWrite = "";
	for($y=0;$y<1024;$y++) { // One kb of content
		$toWrite .= chr(rand(0,255));
	}
	for($i=0;$i<$size;$i++) {
		FWrite($fp,$toWrite);
	}
	fclose($fp);
}

function log_write($data,FileDownload $file,IDownloader $downloader) {
	$cache = Environment::getCache("FileDownloader/log");
	$log = array();
	$tid = (string)$file->getTransferId();
	if(!IsSet($cache["registry"])) $cache["registry"] = array();
	$reg = $cache["registry"];
	$reg[$tid] = true;
	$cache["registry"] = $reg;
	if(IsSet($cache[$tid])) $log = $cache[$tid];

	Debugger::fireLog("Data: ".$data."; ".$downloader->end);

	
	
	$data = $data.": ".Helpers::bytes($file->transferredBytes)." <->; ";
	if($downloader instanceof AdvancedDownloader and $downloader->isInitialized()) {
		$data .= "position: ".Helpers::bytes($downloader->position)."; ";
		//$data .= "length: ".Helpers::bytes($downloader->length)."; ";
		$data .= "http-range: ".Helpers::bytes($downloader->start)."-".Helpers::bytes($downloader->end)."; ";
		$data .= "progress (con: ".round($file->transferredBytes/$downloader->end*100)."% X ";
		$data .= "file: ".round($downloader->position/$file->sourceFileSize*100)."%)";
	}
	$log[] = $data;
	$cache[$tid] = $log;
}

function onBeforeDownloaderStarts($file,IDownloader $downloader) {
	log_write(__FUNCTION__,$file,$downloader);
}

function onBeforeOutputStarts($file,IDownloader $downloader) {
	log_write(__FUNCTION__,$file,$downloader);
}

function onStatusChange(FileDownload $file,IDownloader $downloader) {
	log_write(__FUNCTION__,$file,$downloader);
}

function onComplete($file,IDownloader $downloader) {
	log_write(__FUNCTION__,$file,$downloader);
}

function onConnectionLost($file,IDownloader $downloader) {
	log_write(__FUNCTION__,$file,$downloader);
}

function onNewTransferStart($file,IDownloader $downloader) {
	log_write(__FUNCTION__,$file,$downloader);
}

function onAbort($file,IDownloader $downloader) {
	log_write(__FUNCTION__,$file,$downloader);
}

function onTransferContinue($file,IDownloader $downloader) {
	log_write(__FUNCTION__,$file,$downloader);
}