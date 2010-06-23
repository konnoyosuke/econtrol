<?php
/**
* econtrol Helper: 
*
* Licensed under The MIT License
* Redistributions of files must retain the above copyright notice.
*
* @copyright Copyright 2010, Yosuke Konno. (http://ban-systems.com)
* @link http://ban-systems.com
* @package econtrol
* @subpackage econtrol
* @version 0.01
* @license MIT License (http://www.opensource.org/licenses/mit-license.php)
*
*
* =====Usage=====
*  controller:
*  	var $helpers = array('Econtrol');
*
*  view:
*   <?php echo 	$this->Econtrol->handleEnter();?>
*   <?php echo 	$this->Econtrol->submitEnter("#voucheradd","#ProductName");?>
*   <?php echo 	$this->Econtrol->submitEnter("#itemsadd","#ProductName");?>
*  
*  JsHelper:
*  echo $js->submit('Save', array('id'=>'voucheradd', 'update'=>'#voucher','url' => '/vouchers/add'));
*  echo $js->writebuffer(array('inline'=>false));
*
* ===============
*
*/

class EcontrolHelper extends AppHelper {

	var $helpers = array('Html', 'Form', 'Javascript');
	
	function handleEnter() {
		
		$s  = "function handleEnter (field, event) {". PHP_EOL;  
	    $s .= "var keyCode = event.keyCode ? event.keyCode : event.which ? event.which : event.charCode; ". PHP_EOL;
	    $s .= "     if (keyCode == 13) {". PHP_EOL;  
		$s .= "		var i;". PHP_EOL;  
	    $s .= "         for (i = 0; i < field.form.elements.length; i++)". PHP_EOL;  
	    $s .= "             if (field == field.form.elements[i])". PHP_EOL;  
	    $s .= "                 break;". PHP_EOL;
	    $s .= "         i = (i + 1) % field.form.elements.length;". PHP_EOL;  
	    $s .= "         field.form.elements[i].focus();". PHP_EOL;
	    $s .= "         return false;". PHP_EOL;  
	    $s .= "     } ". PHP_EOL;  
	    $s .= "     else ". PHP_EOL; 
	    $s .= "       return true; ". PHP_EOL; 
	 	$s .= "}". PHP_EOL;

		$this->Javascript->cacheEvents(false,true);
		$this->Javascript->codeBlock($s, array('inline'=>false));
	
	}

	function submitEnter($submit=null, $next=null) {
		
		$s  = '$(document).ready(function (){'. PHP_EOL;
		$s .= '$("'.$submit.'").click( function () { $("'.$next.'").focus(); });'. PHP_EOL;
		$s .= '});'. PHP_EOL;
		
		$this->Javascript->codeBlock($s, array('inline'=>false));
	}

	function end() {
		$this->Javascript->blockEnd();
		$this->Javascript->writeEvents(false);		
	}

	function input($name=null, $options=array()) {
		
		$options = array_merge($options, array("onkeypress"=>"return handleEnter(this, event)"));
		return $this->Form->input($name, $options);

	}

	
	
}