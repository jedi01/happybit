<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
<?php 
require('./includes/config.inc.php');
$bid_ratio = $SETTINGS['bid_ratio'];
?>
<script type="text/javascript">

  var current_str = '';
  var current = '0';
  var arrOffers = '';
  var content = '';
  var http = getHTTPObject();
  
  function isArray(obj) {
    return obj.constructor == Array;
  }
  
  function openoffer(ourl) {
    ourl = ourl.replace('http://adscendmedia.com/', '');
    newwindow = window.open("http://adscendmedia.com/"+ourl, '_blank');
    if (window.focus) {newwindow.focus();}
  }
  
  function filterOffers(rule, selected){
    rule = rule.replace(/\|/g, "\""); // replace all | with "
    rule = rule.replace(/\#/g, "\|"); // replace # with |
    content = '';
    var trclass = '';
    var offersmatching = 0;
    if (isArray(arrOffers)){
      content += '<div id="offernav">';
      content += '<a href="http://" onClick="javascript:filterOffers(\'(offer[14]>=65)##(offer[15]==1)\',\'featured\'); return false;"'; if(selected=='featured'){content+=' class=selCat';} content += '>Featured Offers</a><br />';
      content += '<a href="http://" onClick="javascript:filterOffers(\'offer[2]==0\',\'free\'); return false;"'; if(selected=='free'){content+=' class=selCat';} content += '>Free Offers</a><br />';
      content += '<a href="http://" onClick="javascript:filterOffers(\'offer[7]==|cell|\',\'cell\'); return false;"'; if(selected=='cell'){content+=' class=selCat';} content += '>Cellphone Offers</a><br />';
      content += '<a href="http://" onClick="javascript:filterOffers(\'offer[7]==|trial|\',\'trial\'); return false;"'; if(selected=='trial'){content+=' class=selCat';} content += '>Trial Offers</a><br />';
      content += '<a href="http://" onClick="javascript:filterOffers(\'offer[11]==1\',\'completed\'); return false;"'; if(selected=='completed'){content+=' class=selCat';} content += '>Completed Offers</a><br />';
      content += '<a href="http://" onClick="javascript:filterOffers(\'\',\'all\'); return false;"'; if(selected=='all'){content+=' class=selCat';} content += '>All Offers</a>';
      content += '</div>';
      content += '<div id="gw_offers">';
      content += '<table class="offertbl">';
      var numoffers = arrOffers.length;
      for(var i=0; i<numoffers; i++) {
      	var offer = arrOffers[i];
        if ( (rule!='') && (!eval('('+rule+')')) ) { // applied rule evaluates false
          //alert('rule:'+rule+'is false.\r\n'+offer);    //debug
          continue;
        }
        offersmatching++;
        if (i % 2 == 0){trclass='even';}else{trclass='odd';}
        if (offer[11] != 1){ // not completed
          content += '<tr class="'+trclass+'"><td>';
            content += '';
          content += '</td><td>';
            content += '<a href="http://" onClick="javascript:openoffer(\''+offer[12]+'\'); return false;" class="gw_offer">'+offer[1]+'</a><br />';
            content += offer[5]+'<br /><br />';
          content += '</td><td valign="middle" align="center"><b>'+Math.floor(offer[3]*<? echo $bid_ratio; ?>)+'</b><br />Bids</td></tr>';
        }else{ // completed
          content += '<tr class="'+trclass+'"><td>';
            content += '';
          content += '</td><td class="completed_offer">';
            content += offer[1]+'<br />';
            content += offer[5]+'<br /><br />';
          content += '</td><td valign="middle" align="center" class="completed_points"><b>Bids</b><br /><b>credited!</b></td></tr>';
        }
      } // end For
      if (offersmatching == 0){ content += '<td class="odd"><td>No offers are available in this category.</td></tr>'; }
      content += '</table>';
    }else{ // not an array
      content = '<div id="offernav">&nbsp;</div>';
      content += '<div id="gw_offers">';
      content += arrOffers;
    }
    content += '</div>';
    content += '<div style="clear:both;">&nbsp;</div>';
    if (rslt != '') { document.getElementById('gw_content').innerHTML = content; }
  }
	
	function doauth() {
		setTimeout("doauth();", 10000);
		http.open("GET", "api_ajax.php?sid=<?=$_GET['sid'];?>&ip=<?=$_GET['ip'];?>"+current_str, true);
		http.onreadystatechange = handleHttpResponse;
		http.send(null);
	}
	
	function handleHttpResponse() {
		if (http.readyState == 4) {
      if (http.responseText != '') {
        rslt = http.responseText;
        rsltArr = rslt.split('||');
        current = rsltArr[0];
        needed = rsltArr[1];
        rslt = rsltArr[2];
        current_str = "&current=" + current
        // document.getElementById('gw_progress').innerHTML = current+' of '+needed+' ';
        // parse returned json into array (or string if an error was returned)
        arrOffers = eval('(' + rslt + ')');
        filterOffers('(offer[14]>=65)##(offer[15]==1)','featured');
			}
			// http.onreadystatechange = function(){};
      // http.abort();
		}
	}
	
	function getHTTPObject() {
		var xmlhttp;
		/*@cc_on
		@if (@_jscript_version >= 5)
			try {
				xmlhttp = new ActiveXObject("Msxml2.XMLHTTP");
			} catch (e) {
				try {
					xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
				} catch (E) {
					xmlhttp = false;
				}
			}
		@else
		xmlhttp = false;
		@end @*/
		if (!xmlhttp && typeof XMLHttpRequest != 'undefined') {
			try {
				xmlhttp = new XMLHttpRequest();
			} catch (e) {
				xmlhttp = false;
			}
		}
		return xmlhttp;
	}
	
</script>


<style>

  a {text-decoration:none; color:#cd0505;}
  a:hover {text-decoration:underline; color:#cd0505;}
  
  body {
    font-family:Arial;
    font-size:12px;
    margin:0px;
    margin-top:30px;
    padding:0px;
    background-color:#FFFFFF;
    color:#000000;
  }
  .paragraphs {
    width:500px;
    margin-left:auto;
    margin-right:auto;
    text-align:left;
  }
  #gw_content {
    width:660px;
    margin-left:auto;
    margin-right:auto;
    padding:15px;
    padding-bottom:20px;
  }
  #gw_progress {
    width:855px;
    margin-left:auto;
    margin-right:auto;
    padding:15px;
    padding-bottom:0px;
    text-align: right;
    font-weight:bold;
  }
  #offernav {
    width:135px;
    text-align:left;
    padding-left:0px;
    padding-top:0px;
    padding-right:5px;
    padding-bottom:0px;
    line-height:200%;
    float:left;
    font-size:13px;
  }
  .selCat {
    font-weight:bold;
  }
  #gw_offers {
    text-align:left;
    padding:0px;
    border-style:solid; border-width:1px; border-color:#B0B0B0;
    height:300px;
    overflow:auto;
  }
  .gw_offer {
    font-weight:bold;
  }
  .completed_offer {
    color:#444444;
  }
  .completed_points {
    color:#cd0505;
  }
  table.offertbl {width:500px; border-collapse:collapse;}
  table.offertbl td {border-bottom:1px solid #D7DFE3; padding:7px;}
  table tr.even {background-color:#FFFFFF;}
  table tr.odd {background-color:#FAFCFE;}
</style>



</head>
<body onload="doauth();">
<div align="center">
<span style="color:#2E2E2E;">
Complete a free offer below to earn bids and win auctions!<br><br>
<b>Once you complete an offer, close this box and refresh the page to see your updated bid balance.</b>
</span>
</div>
   	<div id="gw_content">
		<img src="http://adscendmedia.com/gwi/wheel-throb.gif">
  </div>
  
</body>
</html>