function newImage(arg) {
	if (document.images) {
		rslt = new Image();
		rslt.src = arg;
		return rslt;
	}
}

function changeImages() {
	if (document.images && (preloadFlag === true)) {
		for (var i=0; i<changeImages.arguments.length; i+=2) {
			document[changeImages.arguments[i]].src = changeImages.arguments[i+1];
		}
	}
}

var preloadFlag = false;
function preloadImages() {
	if (document.images) {
		headerfip_13_over = newImage("images/headerfip_13-over.gif");
		headerfip_14_over = newImage("images/headerfip_14-over.gif");
		headerfip_15_over = newImage("images/headerfip_15-over.gif");
		headerfip_16_over = newImage("images/headerfip_16-over.gif");
		preloadFlag = true;
	}
}

function setPointer(theRow, thePointerColor)
{
    if (thePointerColor === '' || typeof(theRow.style) === 'undefined') {
        return false;
    }
    if (typeof(document.getElementsByTagName) !== 'undefined') {
        var theCells = theRow.getElementsByTagName('td');
    }
    else if (typeof(theRow.cells) !== 'undefined') {
        var theCells = theRow.cells;
    }
    else {
        return false;
    }

    var rowCellsCnt  = theCells.length;
    for (var c = 0; c < rowCellsCnt; c++) {
        theCells[c].style.backgroundColor = thePointerColor;
    }

    return true;
} 

function gantiP(posisi,kode1,kodenya,pos1)
{
  var kodeini=posisi.value
  window.location=kodenya+'&'+kode1+'='+kodeini+'#'+pos1
}
function ganti(posisi,kode1,kodenya)
{
  var kodeini=posisi.value
  window.location=kodenya+'&'+kode1+'='+kodeini
}

function oW(myLink,windowName)
  {
  if(! window.focus)return;
  var myWin=window.open("",windowName,"height=550,width=600,dependent=yes,resizable=yes,scrollbars=yes,menubar=yes");
  myWin.focus();
  myLink.target=windowName;
  }


function MM_openBrWindow(theURL,winName,features) { 
  window.open(theURL,winName,features);
}
