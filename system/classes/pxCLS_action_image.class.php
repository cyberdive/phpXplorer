<?php
/***************************************************************
*  Copyright notice
*
*  (c) 2003-2005 Tobias Bender (tobias@phpxplorer.org)
*  All rights reserved
*
*  This script is part of the phpXplorer project. The phpXplorer project is
*  free software; you can redistribute it and/or modify
*  it under the terms of the GNU General Public License as published by
*  the Free Software Foundation; either version 2 of the License, or
*  (at your option) any later version.
*
*  The GNU General Public License can be found at
*  http://www.gnu.org/copyleft/gpl.html.
*  A copy is found in the textfile GPL.txt distributed with these scripts.
*
*  This script is distributed in the hope that it will be useful,
*  but WITHOUT ANY WARRANTY; without even the implied warranty of
*  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
*  GNU General Public License for more details.
*
*  This copyright notice MUST APPEAR in all copies of the script!
***************************************************************/
/**
	* @package phpXplorer
*/

require_once($pxp->sDir . "/classes/pxCLS_action.class.php");

class pxCLS_action_image extends pxCLS_action{

	var $iResize;
	var $bForceDirect;
	var $iX;
	var $iY;
	
	var $oImageIn;
	var $oImageOut;
	
	var $sThumbFilePath;
	var $sThumbFileURL;
	
	var $bGD2;

	function pxCLS_action_image(){

		parent::pxCLS_action();
	}


	function init(){

		global $pxp;

		if($pxp->oShare->bCheckThumbnailPermission){

    	$oFile = checkFile($pxp->sFilename, PXP_prmLevel_open, false, true);

    	if(!$oFile->bOpen){
    		$imError = ImageCreate(100,100);
    		$background_color = ImageColorAllocate ($imError, 255, 255, 255);
    		ImageString($imError, 1, 5, 5, "Access denied", ImageColorAllocate ($imError, 0, 53, 102));
    		ImagePNG($imError);
    		exit;
    	}
    }
	}


	function resizeCheck(){
	
		return ($this->iX > $this->iY) ? ($this->iX > $this->iResize) : ($this->iY > $this->iResize);
	}


	function outputFile($sFile){
	
		global $pxp;

  	if($this->bForceDirect){

  		header("Content-type: image/" . strtolower($pxp->sExtension));
  		readfile($sFile);

  	}else{

  		header("Location: " . $pxp->encodeURIParts(str_replace($pxp->oShare->sDir, $pxp->oShare->sURL, $sFile)));
  		exit;
  	}
	}
	
	
	function createCacheDirectory(){

		global $pxp;

		if(!is_dir($pxp->sWorkingDirectory . "/data.pxp/thumbs.pxTBNd/$this->iResize")){
			if(!is_dir($pxp->sWorkingDirectory . "/data.pxp/thumbs.pxTBNd")){

				if(!is_dir($pxp->sWorkingDirectory . "/data.pxp"))
					$pxp->oStorage->mkdir($pxp->sWorkingDirectory . "/data.pxp");

				$pxp->oStorage->mkdir($pxp->sWorkingDirectory . "/data.pxp/thumbs.pxTBNd");
			}
			$pxp->oStorage->mkdir($pxp->sWorkingDirectory . "/data.pxp/thumbs.pxTBNd/$this->iResize");
		}
	}


	function outputThumbnail(){

		global $pxp;
		
		if($pxp->oShare->iImageLibrary == 0){
		
			$this->outputFile($this->sThumbFilePath);

			if(!$pxp->oShare->bCacheThumbnails)
				$pxp->oStorage->unlink($this->sThumbFilePath);

		}else{

			if($pxp->oShare->bCacheThumbnails){
				$this->createCacheDirectory();

	  		switch(strtoupper($pxp->sExtension)){
	  			case 'JPG' : imageJPEG($this->oImageOut, $this->sThumbFilePath, $pxp->oShare->iThumbnailQuality); break;
	  			case 'JPEG' : imageJPEG($this->oImageOut, $this->sThumbFilePath, $pxp->oShare->iThumbnailQuality); break;
	  			case 'GIF' : imageGIF($this->oImageOut, $this->sThumbFilePath); break;
	  			case 'PNG' : imagePNG($this->oImageOut, $this->sThumbFilePath); break;
	   		}
			}

			if($this->bForceDirect  or  !$pxp->oShare->bCacheThumbnails){

 				switch(strtoupper($pxp->sExtension)){
 					case 'JPG' : imageJPEG($this->oImageOut, null, $pxp->oShare->iThumbnailQuality); break;
 					case 'JPEG' : imageJPEG($this->oImageOut, null, $pxp->oShare->iThumbnailQuality); break;
 					case 'GIF' : imageGIF($this->oImageOut); break;
 					case 'PNG' : imagePNG($this->oImageOut); break;
 	  		}
			}else{

	  		header("Location: " . $pxp->encodeURIParts($this->sThumbFileURL));
			}
			
			if(isset($this->oImageIn)){
				imagedestroy($this->oImageIn);
				imagedestroy($this->oImageOut);
			}
		}
	}


	function handleRequest(){

		global $pxp;

		if(function_exists("gd_info")){
			$gdInfo = gd_info();
			$this->bGD2 = strpos($gdInfo['GD Version'], "2.") !== false ? true : false;
		}else{
			$this->bGD2 = false;
		}

		$this->iResize = $pxp->getRequestVar("iResize");

		$this->bForceDirect = isset($pxp->_GET["forceDirect"]);

    $this->sThumbFilePath = $pxp->sWorkingDirectory . "/data.pxp/thumbs.pxTBNd/$this->iResize/" . $pxp->sFilename;		
    $this->sThumbFileURL = str_replace($pxp->oShare->sDir, $pxp->oShare->sURL, $pxp->sWorkingDirectory) . "/data.pxp/thumbs.pxTBNd/$this->iResize/" . $pxp->sFilename;		

		if(
			!file_exists($this->sThumbFilePath)
				or
			filemtime($pxp->sWorkingDirectory . "/" . $pxp->sFilename) > filemtime($this->sThumbFilePath)
				or
			!$pxp->oShare->bCacheThumbnails
		){
		
			if(isset($this->iResize)){
			
				$this->iResize = (int)$this->iResize;

   		  $aSize = getImageSize($pxp->sWorkingDirectory . "/" . $pxp->sFilename);

				$this->iX = $aSize[0];
				$this->iY = $aSize[1];
				
				if($this->resizeCheck()){
					
					$this->resize();

					$this->outputThumbnail();
					
				}else{ // no resize

					$this->outputFile($pxp->sWorkingDirectory . "/" . $pxp->sFilename);
				}
			}else{

				$this->outputFile($pxp->sWorkingDirectory . "/" . $pxp->sFilename);
			}

		}else{

			# output

			$this->outputFile($this->sThumbFilePath);
		}		
	}

	function resize(){

		global $pxp;

		if($pxp->oShare->iImageLibrary == 0){

			$this->createCacheDirectory();

			copy($pxp->sWorkingDirectory . "/" . $pxp->sFilename, $this->sThumbFilePath);
			system('mogrify -resize ' . $this->iResize . 'x' . $this->iResize . ' -quality ' . $pxp->oShare->iThumbnailQuality . ' "' . $this->sThumbFilePath . '"');

		}else{

			switch(strtoupper($pxp->sExtension)){
				case 'JPG':
					$this->oImageIn = imagecreatefromjpeg($pxp->sWorkingDirectory . "/" . $pxp->sFilename);
				break;
				case 'JPEG':
					$this->oImageIn = imagecreatefromjpeg($pxp->sWorkingDirectory . "/" . $pxp->sFilename);
				break;
				case 'GIF':
					$this->oImageIn = imagecreatefromgif($pxp->sWorkingDirectory . "/" . $pxp->sFilename);
				break;
				case 'PNG':
					$this->oImageIn = imagecreatefrompng($pxp->sWorkingDirectory . "/" . $pxp->sFilename);
				break;
			}

			if($this->iX > $this->iY){ // horizontal

				$iNewY = $this->iY * ($this->iResize / $this->iX);

				if($this->bGD2){
					$this->oImageOut = ImageCreateTrueColor($this->iResize, $iNewY);
				}else{
					$this->oImageOut = ImageCreate($this->iResize, $iNewY);
				}

				if($this->bGD2){
					imagecopyresampled($this->oImageOut, $this->oImageIn, 0, 0, 0, 0, $this->iResize, $iNewY, $this->iX, $this->iY);
				}else{
					imagecopyresized($this->oImageOut, $this->oImageIn, 0, 0, 0, 0, $this->iResize, $iNewY, $this->iX, $this->iY);
				}

			}else{ // vertical

				$iNewX = $this->iX * ($this->iResize / $this->iY); // - 0.4;
				
				if($this->bGD2){
					$this->oImageOut = ImageCreateTrueColor($iNewX, $this->iResize);
				}else{
					$this->oImageOut = ImageCreate($iNewX, $this->iResize);
				}
				
				if($this->bGD2){
					imagecopyresampled($this->oImageOut, $this->oImageIn, 0, 0, 0, 0, $iNewX, $this->iResize, $this->iX, $this->iY);
				}else{
					imagecopyresized($this->oImageOut, $this->oImageIn, 0, 0, 0, 0, $iNewX, $this->iResize, $this->iX, $this->iY);
				}
			}
		}
	}

}

?>
