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

if(file_exists(dirname(__FILE__) . "/install.php"))require(dirname(__FILE__) . "/install.php");

require(dirname(__FILE__) . "/includes.php");

$pxp = new pxCLS_system();

echo $pxp->sHTMLHead		
		. '</head>'
		. '<frameset rows="64,*" onunload="this[0].destruct()">'
		. '<frame src="' . $pxp->sURL . '/menuHead.php?sShare=' . $pxp->sShare . '&amp;ref=' . $pxp->getRequestVar("ref") . '" name="frmHead" scrolling="no" noresize="noresize"/>'
		. '<frame src="' . $pxp->sURL . '/workspaces.php?sShare=' . $pxp->sShare . '&sPath=' . $pxp->sPath . '&bAllowSelection=' . $pxp->bAllowSelection . '" name="frmWorkspaces" frameborder="0" scrolling="no" noresize="noresize" />'
		. '</frameset></html>';

?>