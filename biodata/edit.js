

function mypkt(posisi,mana)
{
	var ini=posisi.options[posisi.selectedIndex].value;
	
	if (mana=="cpns")
	{
		document.cpnspnsform.pktcpns.value=pktnya(ini)
	}
	else if (mana=="pns")
	{
		document.pns.pktpns.value=pktnya(ini)
	}
	else if (mana=="pkt")
	{
		document.pktform.pktpkt.value=pktnya(ini)
	}
}


function pktnya(ini)
{
	switch(ini)
	{
		  case "11": { var pkt_nya="JURU MUDA";break;}
		  case "12": { var pkt_nya="JURU MUDA TK I";break;}
		  case "13": { var pkt_nya="JURU";break;}
		  case "14": { var pkt_nya="JURU TK I";break;}
		  case "21": { var pkt_nya="PENGATUR MUDA";break;}
		  case "22": { var pkt_nya="PENGATUR MUDA TK I";break;}
		  case "23": { var pkt_nya="PENGATUR";break;}
		  case "24": { var pkt_nya="PENGATUR TK I";break;}
		  case "31": { var pkt_nya="PENATA MUDA";break;}
		  case "32": { var pkt_nya="PENATA MUDA TK I";break;}
		  case "33": { var pkt_nya="PENATA";break;}
		  case "34": { var pkt_nya="PENATA TK I";break;}
		  case "41": { var pkt_nya="PEMBINA";break;}
		  case "42": { var pkt_nya="PEMBINA TK I";break;}
		  case "43": { var pkt_nya="PEMBINA UTAMA MUDA";break;}
		  case "44": { var pkt_nya="PEMBINA UTAMA MADYA";break;}
		  case "45": { var pkt_nya="PEMBINA UTAMA";break;}
		  
		
	}
	return pkt_nya
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

function goJab(kemana,posini)
{
	var I_01=document.jabatan.I_01.options[document.jabatan.I_01.selectedIndex].value
	var I_02=document.jabatan.I_02.value;
	var TGSKJAB=document.jabatan.TGSKJAB.value;
	var BLSKJAB=document.jabatan.BLSKJAB.value;
	var THSKJAB=document.jabatan.THSKJAB.value;
	var TGTMTJAB=document.jabatan.TGTMTJAB.value;
	var BLTMTJAB=document.jabatan.BLTMTJAB.value;
	var THTMTJAB=document.jabatan.THTMTJAB.value;
	
	var I_06=document.jabatan.I_06.value;
	window.location=kemana+'&I_01='+I_01+'&I_02='+I_02+'&TGSKJAB='+TGSKJAB+'&BLSKJAB='+BLSKJAB+'&THSKJAB='+THSKJAB+'&TGTMTJAB='+TGTMTJAB+'&BLTMTJAB='+BLTMTJAB+'&THTMTJAB='+THTMTJAB+'&I_06='+I_06+posini
}

function oW(myLink,windowName)
  {
  if(! window.focus)return;
  var myWin=window.open("",windowName,"height=550,width=600,dependent=yes,resizable=yes,scrollbars=yes,menubar=yes");
  myWin.focus();
  myLink.target=windowName;
  }

function doHapuspkt(lok,modi,thpos) {
	var mylok=lok
	
  	for(var i=0;i<document.rpangkat.elements.length;i++)
  	{
  		if (document.rpangkat.elements[i].type== "checkbox" )
  		{
  			if (document.rpangkat.elements[i].checked)
  			{
  			mylok+=mylok+"&"+document.rpangkat.elements[i].name+"="+document.rpangkat.elements[i].value;
  			
  			}
  			
  			
  		}
  	}
  	window.location=mylok+"&no="+document.rpangkat.no.value+'&modi='+modi+thpos;
  	
  }
  
function doHapusjab(lok,modi,thpos) {
	var mylok=lok
	
  	for(var i=0;i<document.rjab.elements.length;i++)
  	{
  		if (document.rjab.elements[i].type== "checkbox" )
  		{
  			if (document.rjab.elements[i].checked)
  			{
  			mylok+=mylok+"&"+document.rjab.elements[i].name+"="+document.rjab.elements[i].value;
  			
  			}
  			
  			
  		}
  	}
  	window.location=mylok+"&no="+document.rjab.no.value+'&modi='+modi+thpos;
  	
  }

function doHapusjasa(lok,modi,thpos) {
	var mylok=lok
	
  	for(var i=0;i<document.rtj.elements.length;i++)
  	{
  		if (document.rtj.elements[i].type== "checkbox" )
  		{
  			if (document.rtj.elements[i].checked)
  			{
  			mylok+=mylok+"&"+document.rtj.elements[i].name+"="+document.rtj.elements[i].value;
  			
  			}
  			
  			
  		}
  	}
  	window.location=mylok+"&no="+document.rtj.no.value+'&modi='+modi+thpos;
  	
  }
  
  
function doHapustg(lok,modi,thpos) {
	var mylok=lok
	
  	for(var i=0;i<document.rtg.elements.length;i++)
  	{
  		if (document.rtg.elements[i].type== "checkbox" )
  		{
  			if (document.rtg.elements[i].checked)
  			{
  			mylok+=mylok+"&"+document.rtg.elements[i].name+"="+document.rtg.elements[i].value;
  			
  			}
  			
  			
  		}
  	}
  	window.location=mylok+"&no="+document.rtg.no.value+'&modi='+modi+thpos;
  	
  }
  
function doHapusbhs(lok,modi,thpos) {
	var mylok=lok
	
  	for(var i=0;i<document.bhs.elements.length;i++)
  	{
  		if (document.bhs.elements[i].type== "checkbox" )
  		{
  			if (document.bhs.elements[i].checked)
  			{
  			mylok+=mylok+"&"+document.bhs.elements[i].name+"="+document.bhs.elements[i].value;
  			
  			}
  			
  			
  		}
  	}
  	window.location=mylok+"&no="+document.bhs.no.value+'&modi='+modi+thpos;
  	
  }
function doHapusrdu(lok,modi,thpos) {
	var mylok=lok
	
  	for(var i=0;i<document.rumum.elements.length;i++)
  	{
  		if (document.rumum.elements[i].type== "checkbox" )
  		{
  			if (document.rumum.elements[i].checked)
  			{
  			mylok+=mylok+"&"+document.rumum.elements[i].name+"="+document.rumum.elements[i].value;
  			
  			}
  			
  			
  		}
  	}
  	window.location=mylok+"&no="+document.rumum.no.value+'&modi='+modi;
  	
  }
function doHapusstru(lok,modi,thpos) {
	var mylok=lok
	
  	for(var i=0;i<document.rstru.elements.length;i++)
  	{
  		if (document.rstru.elements[i].type== "checkbox" )
  		{
  			if (document.rstru.elements[i].checked)
  			{
  			mylok+=mylok+"&"+document.rstru.elements[i].name+"="+document.rstru.elements[i].value;
  			
  			}
  			
  			
  		}
  	}
  	window.location=mylok+"&no="+document.rstru.no.value+'&modi='+modi+thpos;
  	
  }  
function doHapusfung(lok,modi,thpos) {
	var mylok=lok
	
  	for(var i=0;i<document.rfung.elements.length;i++)
  	{
  		if (document.rfung.elements[i].type== "checkbox" )
  		{
  			if (document.rfung.elements[i].checked)
  			{
  			mylok+=mylok+"&"+document.rfung.elements[i].name+"="+document.rfung.elements[i].value;
  			
  			}
  			
  			
  		}
  	}
  	window.location=mylok+"&no="+document.rfung.no.value+'&modi='+modi+thpos;
  	
  }  
function doHapustekn(lok,modi,thpos) {
	var mylok=lok
	
  	for(var i=0;i<document.rtekn.elements.length;i++)
  	{
  		if (document.rtekn.elements[i].type== "checkbox" )
  		{
  			if (document.rtekn.elements[i].checked)
  			{
  			mylok+=mylok+"&"+document.rtekn.elements[i].name+"="+document.rtekn.elements[i].value;
  			
  			}
  			
  			
  		}
  	}
  	window.location=mylok+"&no="+document.rtekn.no.value+'&modi='+modi+thpos;
  	
  }  
function doHapustar(lok,modi,thpos) {
	var mylok=lok
	
  	for(var i=0;i<document.rptar.elements.length;i++)
  	{
  		if (document.rptar.elements[i].type== "checkbox" )
  		{
  			if (document.rptar.elements[i].checked)
  			{
  			mylok+=mylok+"&"+document.rptar.elements[i].name+"="+document.rptar.elements[i].value;
  			
  			}
  			
  			
  		}
  	}
  	window.location=mylok+"&no="+document.rptar.no.value+thpos;
  	
  }
  
function doHapussemi(lok,modi,thpos) {
	var mylok=lok
	
  	for(var i=0;i<document.rsemi.elements.length;i++)
  	{
  		if (document.rsemi.elements[i].type== "checkbox" )
  		{
  			if (document.rsemi.elements[i].checked)
  			{
  			mylok+=mylok+"&"+document.rsemi.elements[i].name+"="+document.rsemi.elements[i].value;
  			
  			}
  		}
  	}
  	window.location=mylok+"&no="+document.rsemi.no.value+thpos;
  	
}
    
function doHapuskurs(lok,modi,thpos) {
	var mylok=lok
	
  	for(var i=0;i<document.rkursus.elements.length;i++)
  	{
  		if (document.rkursus.elements[i].type== "checkbox" )
  		{
  			if (document.rkursus.elements[i].checked)
  			{
  			mylok+=mylok+"&"+document.rkursus.elements[i].name+"="+document.rkursus.elements[i].value;
  			
  			}
  		}
  	}
  	window.location=mylok+"&no="+document.rkursus.no.value+thpos;
  	
  }


function doHapusanak(lok,modi,thpos) {
	var mylok=lok
	
  	for(var i=0;i<document.ranak.elements.length;i++)
  	{
  		if (document.ranak.elements[i].type== "checkbox" )
  		{
  			if (document.ranak.elements[i].checked)
  			{
  			mylok+=mylok+"&"+document.ranak.elements[i].name+"="+document.ranak.elements[i].value;
  			
  			}
  			
  			
  		}
  	}
  	window.location=mylok+"&no="+document.ranak.no.value+'&modi='+modi+thpos;
  	
  }
  
  
function tmtgaji()
{
var tgtmtbaru=document.pkt.TGPKT.value
var bltmtbaru=document.pkt.BLPKT.value
var thtmtbaru=document.pkt.THPKT.value
var mytgl=new Date(thtmtbaru,bltmtbaru,tgtmtbaru)


var mymskj=document.pkt.F_04B.value;
if (mymskj.substring(0,1)=="0") { mymskj=mymskj.substring(1,2); }
var mykurang=0
var mytahun=0
var mybulan=0
var mytanggal=mytgl.getDate()
var mygol=document.pkt.F_03.options[document.pkt.F_03.selectedIndex].value
var mymkerja1=parseInt(document.pkt.F_04A.value)
var thegol=parseInt(mygol.substring(0,1))

if ((thegol==3) || (thegol==4))
{
if (mymkerja1%2==0)
   {
   mykurang=24-(12+parseInt(mymskj))
   mytahun +=parseInt(mytgl.getFullYear())
   mytahun +=1
   mybulan=parseInt(mytgl.getMonth())+mykurang
   
   }
   else 
   {
   mykurang=12-parseInt(mymskj)
   mytahun=parseInt(mytgl.getFullYear())
   mybulan=parseInt(mytgl.getMonth())+mykurang
   
   }
}
else
{
if (mymkerja1%2!=0)
   {
   mykurang=24-(12+parseInt(mymskj))
   mytahun+=parseInt(mytgl.getFullYear())
   mytahun+=1
   mybulan=parseInt(mytgl.getMonth())+mykurang
   
   }
   else 
   {
   mykurang=12-parseInt(mymskj)
   mytahun=parseInt(mytgl.getFullYear())
   mybulan=parseInt(mytgl.getMonth())+mykurang
   }


}   
   
var tglgj=new Date(mytahun,mybulan,mytanggal)
var hasiltanggal,hasilbulan=""
var hasilbln=0
if (mybulan==12) { hasilbln=parseInt(mybulan) } else { hasilbln=parseInt(tglgj.getMonth()) }

if (mytanggal < 10 ) { hasiltanggal='0'+mytanggal } else { hasiltanggal=mytanggal }
if (hasilbln < 10 ) { hasilbulan='0'+hasilbln } else { hasilbulan=hasilbln }

document.pkt.TGGAJI.value=hasiltanggal
document.pkt.BLGAJI.value=hasilbulan
document.pkt.THGAJI.value=tglgj.getFullYear()
}

function gajinya()
{
	var gol=document.pkt.F_03.options[document.pkt.F_03.selectedIndex].value
	
	
	var mker=document.pkt.F_04A.value
	
	var pkt11=new Array()
 	{ 
 	pkt11[0]="500000";
	pkt11[1]="500000";
	pkt11[2]="512500";
	pkt11[3]="512500";
	pkt11[4]="525300";
	pkt11[5]="525300";
	pkt11[6]="538400";
	pkt11[7]="538400";
	pkt11[8]="551900";
	pkt11[9]="551900";
	pkt11[10]="565700";
	pkt11[11]="565700";
	pkt11[12]="579800";
	pkt11[13]="579800";
	pkt11[14]="594300";
	pkt11[15]="594300";
	pkt11[16]="609200";
	pkt11[17]="609200";
	pkt11[18]="624400";
	pkt11[19]="624400";
	pkt11[20]="640000";
	pkt11[21]="640000";
	pkt11[22]="656000";
	pkt11[23]="656000";
	pkt11[24]="672400";
	pkt11[25]="672400";
	pkt11[26]="689300";
	pkt11[27]="689300";
	}
	var pkt12=new Array()
	{ 
	pkt12[3]="537600";
	pkt12[4]="537600";
	pkt12[5]="551100";
	pkt12[6]="551100";
	pkt12[7]="564900";
	pkt12[8]="564900";
	pkt12[9]="579000";
	pkt12[10]="579000";
	pkt12[11]="593500";
	pkt12[12]="593500";
	pkt12[13]="606300";
	pkt12[14]="606300";
	pkt12[15]="623500";
	pkt12[16]="623500";
	pkt12[17]="639100";
	pkt12[18]="639100";
	pkt12[19]="655100";
	pkt12[20]="655100";
	pkt12[21]="671400";
	pkt12[22]="671400";
	pkt12[23]="688200";
	pkt12[24]="688200";
	pkt12[25]="705400";
	pkt12[26]="705400";
	pkt12[27]="723100";
	pkt12[28]="723100";
	}
	var pkt13=new Array()
 	{ 
	pkt13[3]="557100";
	pkt13[4]="557100";
	pkt13[5]="571000";
	pkt13[6]="571000";
	pkt13[7]="585300";
	pkt13[8]="585300";
	pkt13[9]="599900";
	pkt13[10]="599900";
	pkt13[11]="614900";
	pkt13[12]="614900";
	pkt13[13]="630300";
	pkt13[14]="630300";
	pkt13[15]="646000";
	pkt13[16]="646000";
	pkt13[17]="662200";
	pkt13[18]="662200";
	pkt13[19]="678700";
	pkt13[20]="678700";
	pkt13[21]="695700";
	pkt13[22]="695700";
	pkt13[23]="713100";
	pkt13[24]="713100";
	pkt13[25]="730900";
	pkt13[26]="730900";
	pkt13[27]="749200";
	pkt13[28]="749200";
	}
	var pkt14=new Array()
	{ 
	pkt14[3]="577200";
	pkt14[4]="577200";
	pkt14[5]="591600";
	pkt14[6]="591600";
	pkt14[7]="606400";
	pkt14[8]="606400";
	pkt14[9]="621500";
	pkt14[10]="621500";
	pkt14[11]="637100";
	pkt14[12]="637100";
	pkt14[13]="653000";
	pkt14[14]="653000";
	pkt14[15]="669300";
	pkt14[16]="669300";
	pkt14[17]="686100";
	pkt14[18]="686100";
	pkt14[19]="703200";
	pkt14[20]="703200";
	pkt14[21]="720800";
	pkt14[22]="720800";
	pkt14[23]="738800";
	pkt14[24]="738800";
	pkt14[25]="757300";
	pkt14[26]="757300";
	pkt14[27]="776200";
	pkt14[28]="776200";
	}
	var pkt21=new Array()
	 { 
	 pkt21[0]="620600";
	pkt21[1]="628400";
	pkt21[2]="628400";
	pkt21[3]="644100";
	pkt21[4]="644100";
	pkt21[5]="660200";
	pkt21[6]="660200";
	pkt21[7]="676700";
	pkt21[8]="676700";
	pkt21[9]="693600";
	pkt21[10]="693600";
	pkt21[11]="710900";
	pkt21[12]="710900";
	pkt21[13]="728700";
	pkt21[14]="728700";
	pkt21[15]="746900";
	pkt21[16]="746900";
	pkt21[17]="765600";
	pkt21[18]="765600";
	pkt21[19]="784800";
	pkt21[20]="784800";
	pkt21[21]="804400";
	pkt21[22]="804400";
	pkt21[23]="824500";
	pkt21[24]="824500";
	pkt21[25]="845100";
	pkt21[26]="845100";
	pkt21[27]="866200";
	pkt21[28]="866200";
	pkt21[29]="887900";
	pkt21[30]="887900";
	pkt21[31]="910100";
	pkt21[32]="910100";
	pkt21[33]="932800";
	}
	var pkt22=new Array()
	 { 
	 pkt22[3]="667300";
	pkt22[4]="667300";
	pkt22[5]="684000";
	pkt22[6]="684000";
	pkt22[7]="701100";
	pkt22[8]="701100";
	pkt22[9]="718600";
	pkt22[10]="718600";
	pkt22[11]="736600";
	pkt22[12]="736600";
	pkt22[13]="755000";
	pkt22[14]="755000";
	pkt22[15]="773900";
	pkt22[16]="773900";
	pkt22[17]="793300";
	pkt22[18]="793300";
	pkt22[19]="813100";
	pkt22[20]="813100";
	pkt22[21]="833400";
	pkt22[22]="833400";
	pkt22[23]="854200";
	pkt22[24]="854200";
	pkt22[25]="875600";
	pkt22[26]="875600";
	pkt22[27]="897500";
	pkt22[28]="897500";
	pkt22[29]="919900";
	pkt22[30]="919900";
	pkt22[31]="942900";
	pkt22[32]="942900";
	pkt22[33]="966500";
	}
	var pkt23=new Array()
	 { 
	 pkt23[3]="691400";
	pkt23[4]="691400";
	pkt23[5]="708700";
	pkt23[6]="708700";
	pkt23[7]="726400";
	pkt23[8]="726400";
	pkt23[9]="744600";
	pkt23[10]="744600";
	pkt23[11]="763200";
	pkt23[12]="763200";
	pkt23[13]="782300";
	pkt23[14]="782300";
	pkt23[15]="801800";
	pkt23[16]="801800";
	pkt23[17]="821900";
	pkt23[18]="821900";
	pkt23[19]="842400";
	pkt23[20]="842400";
	pkt23[21]="863500";
	pkt23[22]="863500";
	pkt23[23]="885100";
	pkt23[24]="885100";
	pkt23[25]="907200";
	pkt23[26]="907200";
	pkt23[27]="929900";
	pkt23[28]="929900";
	pkt23[29]="953100";
	pkt23[30]="953100";
	pkt23[31]="977000";
	pkt23[32]="977000";
	pkt23[33]="1001400";
	}
	var pkt24=new Array()
	 { 
	 pkt24[3]="716400";
	pkt24[4]="716400";
	pkt24[5]="734300";
	pkt24[6]="734300";
	pkt24[7]="752700";
	pkt24[8]="752700";
	pkt24[9]="771500";
	pkt24[10]="771500";
	pkt24[11]="790800";
	pkt24[12]="790800";
	pkt24[13]="810500";
	pkt24[14]="810500";
	pkt24[15]="830800";
	pkt24[16]="830800";
	pkt24[17]="851600";
	pkt24[18]="851600";
	pkt24[19]="872900";
	pkt24[20]="872900";
	pkt24[21]="894700";
	pkt24[22]="894700";
	pkt24[23]="917000";
	pkt24[24]="917000";
	pkt24[25]="940000";
	pkt24[26]="940000";
	pkt24[27]="963500";
	pkt24[28]="963500";
	pkt24[29]="987600";
	pkt24[30]="987600";
	pkt24[31]="1012200";
	pkt24[32]="1012200";
	pkt24[33]="1037600";
	}
	var pkt31=new Array()
	 { 
	 pkt31[0]="760800";
	pkt31[1]="760800";
	pkt31[2]="779800";
	pkt31[3]="779800";
	pkt31[4]="799300";
	pkt31[5]="799300";
	pkt31[6]="819300";
	pkt31[7]="819300";
	pkt31[8]="839800";
	pkt31[9]="839800";
	pkt31[10]="860800";
	pkt31[11]="860800";
	pkt31[12]="882300";
	pkt31[13]="882300";
	pkt31[14]="904400";
	pkt31[15]="904400";
	pkt31[16]="927000";
	pkt31[17]="927000";
	pkt31[18]="950200";
	pkt31[19]="950200";
	pkt31[20]="973900";
	pkt31[21]="973900";
	pkt31[22]="998300";
	pkt31[23]="998300";
	pkt31[24]="1023200";
	pkt31[25]="1023200";
	pkt31[26]="1048800";
	pkt31[27]="1048800";
	pkt31[28]="1075000";
	pkt31[29]="1075000";
	pkt31[30]="1101900";
	pkt31[31]="1101900";
	pkt31[32]="1129400";
	}
	var pkt32=new Array()
	 { 
	 pkt32[0]="788300";
	pkt32[1]="788300";
	pkt32[2]="808000";
	pkt32[3]="808000";
	pkt32[4]="828200";
	pkt32[5]="828200";
	pkt32[6]="848900";
	pkt32[7]="848900";
	pkt32[8]="870100";
	pkt32[9]="870100";
	pkt32[10]="891900";
	pkt32[11]="891900";
	pkt32[12]="914200";
	pkt32[13]="914200";
	pkt32[14]="937000";
	pkt32[15]="937000";
	pkt32[16]="960500";
	pkt32[17]="960500";
	pkt32[18]="984500";
	pkt32[19]="984500";
	pkt32[20]="1000100";
	pkt32[21]="1000100";
	pkt32[22]="1034300";
	pkt32[23]="1034300";
	pkt32[24]="1060200";
	pkt32[25]="1060200";
	pkt32[26]="1086700";
	pkt32[27]="1086700";
	pkt32[28]="1113800";
	pkt32[29]="1113800";
	pkt32[30]="1141700";
	pkt32[31]="1141700";
	pkt32[32]="1170200";
	}
	var pkt33=new Array()
	 { 
	 pkt33[0]="816700";
	pkt33[1]="816700";
	pkt33[2]="837200";
	pkt33[3]="837200";
	pkt33[4]="858100";
	pkt33[5]="858100";
	pkt33[6]="879500";
	pkt33[7]="879500";
	pkt33[8]="901500";
	pkt33[9]="901500";
	pkt33[10]="924100";
	pkt33[11]="924100";
	pkt33[12]="947200";
	pkt33[13]="947200";
	pkt33[14]="970900";
	pkt33[15]="970900";
	pkt33[16]="995100";
	pkt33[17]="995100";
	pkt33[18]="1020000";
	pkt33[19]="1020000";
	pkt33[20]="1045500";
	pkt33[21]="1045500";
	pkt33[22]="1071600";
	pkt33[23]="1071600";
	pkt33[24]="1098400";
	pkt33[25]="1098400";
	pkt33[26]="1125900";
	pkt33[27]="1125900";
	pkt33[28]="1154000";
	pkt33[29]="1154000";
	pkt33[30]="1182900";
	pkt33[31]="1182900";
	pkt33[32]="1212500";
	}
	var pkt34=new Array()
	 { 
	 pkt34[0]="846200";
	pkt34[1]="846200";
	pkt34[2]="867400";
	pkt34[3]="867400";
	pkt34[4]="809100";
	pkt34[5]="809100";
	pkt34[6]="911300";
	pkt34[7]="911300";
	pkt34[8]="934100";
	pkt34[9]="934100";
	pkt34[10]="957400";
	pkt34[11]="957400";
	pkt34[12]="981400";
	pkt34[13]="981400";
	pkt34[14]="1005900";
	pkt34[15]="1005900";
	pkt34[16]="1031100";
	pkt34[17]="1031100";
	pkt34[18]="1056800";
	pkt34[19]="1056800";
	pkt34[20]="1083300";
	pkt34[21]="1083300";
	pkt34[22]="1110300";
	pkt34[23]="1110300";
	pkt34[24]="1138100";
	pkt34[25]="1138100";
	pkt34[26]="1166500";
	pkt34[27]="1166500";
	pkt34[28]="1195700";
	pkt34[29]="1195700";
	pkt34[30]="1225600";
	pkt34[31]="1225600";
	pkt34[32]="1256200";
	}
	var pkt41=new Array()
	 { 
	 pkt41[0]="876800";
	pkt41[1]="876830";
	pkt41[2]="898700";
	pkt41[3]="898700";
	pkt41[4]="921200";
	pkt41[5]="921200";
	pkt41[6]="944200";
	pkt41[7]="944200";
	pkt41[8]="967800";
	pkt41[9]="967800";
	pkt41[10]="992000";
	pkt41[11]="992000";
	pkt41[12]="1016800";
	pkt41[13]="1016800";
	pkt41[14]="1042200";
	pkt41[15]="1042200";
	pkt41[16]="1068300";
	pkt41[17]="1068300";
	pkt41[18]="1095000";
	pkt41[19]="1095000";
	pkt41[20]="1122400";
	pkt41[21]="1122400";
	pkt41[22]="1150400";
	pkt41[23]="1150400";
	pkt41[24]="1179200";
	pkt41[25]="1179200";
	pkt41[26]="1208700";
	pkt41[27]="1208700";
	pkt41[28]="1238900";
	pkt41[29]="1238900";
	pkt41[30]="1269900";
	pkt41[31]="1269900";
	pkt41[32]="1301600";
	}
	var pkt42=new Array()
	 { 
	 pkt42[0]="908400";
	pkt42[1]="908400";
	pkt42[2]="931200";
	pkt42[3]="931200";
	pkt42[4]="954400";
	pkt42[5]="954400";
	pkt42[6]="978300";
	pkt42[7]="978300";
	pkt42[8]="1002800";
	pkt42[9]="1002800";
	pkt42[10]="1027800";
	pkt42[11]="1027800";
	pkt42[12]="1053600";
	pkt42[13]="1053600";
	pkt42[14]="1079900";
	pkt42[15]="1079900";
	pkt42[16]="1106900";
	pkt42[17]="1106900";
	pkt42[18]="1134500";
	pkt42[19]="1134500";
	pkt42[20]="1162900";
	pkt42[21]="1162900";
	pkt42[22]="1192000";
	pkt42[23]="1192000";
	pkt42[24]="1221800";
	pkt42[25]="1221800";
	pkt42[26]="1252300";
	pkt42[27]="1252300";
	pkt42[28]="1283600";
	pkt42[29]="1283600";
	pkt42[30]="1315700";
	pkt42[31]="1315700";
	pkt42[32]="1348600";
	}
	var pkt43=new Array()
	 { 
	 pkt43[0]="941200";
	pkt43[1]="941200";
	pkt43[2]="964800";
	pkt43[3]="964800";
	pkt43[4]="988900";
	pkt43[5]="988900";
	pkt43[6]="1013600";
	pkt43[7]="1013600";
	pkt43[8]="1039000";
	pkt43[9]="1039000";
	pkt43[10]="1064900";
	pkt43[11]="1064900";
	pkt43[12]="1091600";
	pkt43[13]="1091600";
	pkt43[14]="1118800";
	pkt43[15]="1118800";
	pkt43[16]="1146800";
	pkt43[17]="1146800";
	pkt43[18]="1175500";
	pkt43[19]="1175500";
	pkt43[20]="1204900";
	pkt43[21]="1204900";
	pkt43[22]="1235000";
	pkt43[23]="1235000";
	pkt43[24]="1265900";
	pkt43[25]="1265900";
	pkt43[26]="1297600";
	pkt43[27]="1297600";
	pkt43[28]="1330000";
	pkt43[29]="1330000";
	pkt43[30]="1363200";
	pkt43[31]="1363200";
	pkt43[32]="1397300";
	}
	var pkt44=new Array()
	 { 
	 pkt44[0]="976200";
	pkt44[1]="976200";
	pkt44[2]="999600";
	pkt44[3]="999600";
	pkt44[4]="1024600";
	pkt44[5]="1024600";
	pkt44[6]="1050200";
	pkt44[7]="1050200";
	pkt44[8]="1076500";
	pkt44[9]="1076500";
	pkt44[10]="1103400";
	pkt44[11]="1103400";
	pkt44[12]="1131000";
	pkt44[13]="1131000";
	pkt44[14]="1159200";
	pkt44[15]="1159200";
	pkt44[16]="1188200";
	pkt44[17]="1188200";
	pkt44[18]="1217900";
	pkt44[19]="1217900";
	pkt44[20]="1248400";
	pkt44[21]="1248400";
	pkt44[22]="1279600";
	pkt44[23]="1279600";
	pkt44[24]="1311600";
	pkt44[25]="1311600";
	pkt44[26]="1344400";
	pkt44[27]="1344400";
	pkt44[28]="1378000";
	pkt44[29]="1378000";
	pkt44[30]="1412400";
	pkt44[31]="1412400";
	pkt44[32]="1447700";
	}
	var pkt45=new Array()
	 { 
	 pkt45[0]="1010400";
	pkt45[1]="1010400";
	pkt45[2]="1035700";
	pkt45[3]="1035700";
	pkt45[4]="1061600";
	pkt45[5]="1061600";
	pkt45[6]="1088100";
	pkt45[7]="1088100";
	pkt45[8]="1115300";
	pkt45[9]="1115300";
	pkt45[10]="1143200";
	pkt45[11]="1143200";
	pkt45[12]="1171800";
	pkt45[13]="1171800";
	pkt45[14]="1201100";
	pkt45[15]="1201100";
	pkt45[16]="1231100";
	pkt45[17]="1231100";
	pkt45[18]="1261900";
	pkt45[19]="1261900";
	pkt45[20]="1293400";
	pkt45[21]="1293400";
	pkt45[22]="1325800";
	pkt45[23]="1325800";
	pkt45[24]="1358900";
	pkt45[25]="1358900";
	pkt45[26]="1392900";
	pkt45[27]="1392900";
	pkt45[28]="1427700";
	pkt45[29]="1427700";
	pkt45[30]="1463400";
	pkt45[31]="1463400";
	pkt45[32]="1500000";
	}


switch(parseInt(gol))
	{
		case 11:pktA=pkt11[parseInt(mker)];break;
		case 12:pktA=pkt12[parseInt(mker)];break;
		case 13:pktA=pkt13[parseInt(mker)];break;
		case 14:pktA=pkt14[parseInt(mker)];break;
		case 21:pktA=pkt21[parseInt(mker)];break;
		case 22:pktA=pkt22[parseInt(mker)];break;
		case 23:pktA=pkt23[parseInt(mker)];break;
		case 24:pktA=pkt24[parseInt(mker)];break;
		case 31:pktA=pkt31[parseInt(mker)];break;
		case 32:pktA=pkt32[parseInt(mker)];break;
		case 33:pktA=pkt33[parseInt(mker)];break;
		case 34:pktA=pkt34[parseInt(mker)];break;
		case 41:pktA=pkt41[parseInt(mker)];break;
		case 42:pktA=pkt42[parseInt(mker)];break;
		case 43:pktA=pkt43[parseInt(mker)];break;
		case 44:pktA=pkt44[parseInt(mker)];break;
		case 45:pktA=pkt45[parseInt(mker)];break;
	}
	document.pkt.G_03.value=pktA;
}

