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

var ROW_HIGHLIGHT_COLOR = "#ddeeff"

oCMenu = new makeCM("oCMenu")

oCMenu.frames = 0

oCMenu.openOnClick = 1
oCMenu.closeOnClick = 1

//Menu properties
oCMenu.pxBetween = 0
oCMenu.fromLeft = 0
oCMenu.fromTop = 0
oCMenu.rows = 1
oCMenu.menuPlacement = "left"
                                                             
oCMenu.offlineRoot = ""
oCMenu.onlineRoot = ""
oCMenu.resizeCheck = 1
oCMenu.wait = 2222
oCMenu.fillImg = "cm_fill.gif"
oCMenu.zIndex = 2000

//Background bar properties
oCMenu.useBar = 0
oCMenu.barWidth = "100%"
oCMenu.barHeight = "menu"
oCMenu.barClass = "clBar"
oCMenu.barX = 0
oCMenu.barY = 0
oCMenu.barBorderX = 0
oCMenu.barBorderY = 0
oCMenu.barBorderClass = ""

//Level properties - ALL properties have to be spesified in level 0
oCMenu.level[0] = new cm_makeLevel() //Add this for each new level
oCMenu.level[0].width = 140
oCMenu.level[0].height = 20
oCMenu.level[0].regClass = "clLevel0"
oCMenu.level[0].overClass = "clLevel0over"
oCMenu.level[0].borderX = 0
oCMenu.level[0].borderY = 3
oCMenu.level[0].borderClass = "clLevel0border"
oCMenu.level[0].offsetX = 2
oCMenu.level[0].offsetY = 4
oCMenu.level[0].rows = 0
oCMenu.level[0].arrow = 0
oCMenu.level[0].arrowWidth = 0
oCMenu.level[0].arrowHeight = 0
  oCMenu.level[0].align = "bottom"

//EXAMPLE SUB LEVEL[1] PROPERTIES - You have to specify the properties you want different from LEVEL[0] - If you want all items to look the same just remove this
oCMenu.level[1] = new cm_makeLevel() //Add this for each new level (adding one to the number)
oCMenu.level[1].width = 190
oCMenu.level[1].height = 23
oCMenu.level[1].regClass = "clLevel1"
oCMenu.level[1].overClass = "clLevel1over"
oCMenu.level[0].borderX = 1
oCMenu.level[1].borderY = 1
oCMenu.level[1].align = "right"
oCMenu.level[1].offsetX = -(oCMenu.level[0].width-2)/2
oCMenu.level[1].offsetY = -20
oCMenu.level[1].borderClass = "clLevel1border"

oCMenu.level[1].arrow = "menu_arrow.gif"
oCMenu.level[1].arrowWidth = 6
oCMenu.level[1].arrowHeight = 11

//EXAMPLE SUB LEVEL[2] PROPERTIES - You have to spesify the properties you want different from LEVEL[1] OR LEVEL[0] - If you want all items to look the same just remove this
oCMenu.level[2] = new cm_makeLevel() //Add this for each new level (adding one to the number)
oCMenu.level[2].width = 200
oCMenu.level[2].height = 23
oCMenu.level[2].offsetX = -(oCMenu.level[1].width-2)/2+20
oCMenu.level[2].offsetY = -20
oCMenu.level[2].regClass = "clLevel2"
oCMenu.level[2].overClass = "clLevel2over"
oCMenu.level[2].borderClass = "clLevel2border"