<?php
/*
	Section: Content Copyright
	Author: {wm}digital
	Author URI: http://slipperysource.com
	Description: Allows you to place a customizable copyright statement within your template that auto-updates the year.
	Class Name: wmContentCopyright
	Filter: Component
	Loading: active,templates,main,sb_1,sb_2,sb_wrap, footer, footermore
*/

/**
 * Post Author Section
 *
 * @author William Mincy
 */
class wmContentCopyright extends PageLinesSection {
	const version = '1.0.0';
	
	// Options Panel
	function section_opts(){
		$options = array();
		$options[] = array(
				'key' => 'WMCopyrightefaults',
				'type' => 'multi',
				'title' => __('Copyright display options','wmContentCopyright'),
				'opts' => array(
						array(
								'key' => 'WMCopyright_Symbol',
								'type' => 'check',
								'title' => __('Display copyright symbol'),
								'label' => __('Display copyright symbol'),
								'default' => false
							), 
						array(
								'key' => 'WMCopyright_Title',
								'type' => 'text',
								'title' => __('Copyright ower','wmContentCopyright'),
								'label' => __('Copyright ower','wmContentCopyright')
							),
						array(
								'key' => 'WMCopyright_Text',
								'type' => 'check',
								'title' => __('Display copyright text'),
								'label' => __('Display copyright text'),
								'default' => true
							),
						array (
								'key' => 'WMCopyright_AllRightsReserved', 
								'type' => 'check', 
								'title' => __('Show "All Rights Reserved" statement','wmContentCopyright'),
								'label' => __('Show "All Rights Reserved" statement','wmContentCopyright'),
								'default' => true
							),
						array(
								'key' => 'WMCopyright_BeginningYear',
								'type' => 'text', 
								'title' => __('Copyright beginning year','wmContentCopyright'),
								'label' => __('Copyright beginning year','wmContentCopyright')
							),
						array(
								'key' => 'WMCopyright_MultipleYears',
								'type' => 'check', 
								'title' => __('Show multiple years','wmContentCopyright'),
								'label' => __('Show multiple years','wmContentCopyright'),
								'ref' => __('Checking this will show the year over time to be the start year up through the currnet year (i.e. 2010 - 2013) as opposed to the currene year (2013)','wmContentCopyright'),
								'default' => false
							)
					)
			);
		return $options;
	}
	
	// Content Display
	function section_template() {
		echo '<span class="wmContentCopyright">';
		_e('Copyright ','wmContentCopyright');
		if(ploption('WMCopyright_Symbol', $this->oset)) {
			echo ' <span class="wmContentCopyrightSymbol">&copy;</span> ';
		}
		$startyear = (ploption('WMCopyright_BeginningYear',$this->oset)) ? ploption('WMCopyright_BeginningYear',$this->oset) : (int)date("Y");
		$thisyear = date("Y");
		echo ' '.$startyear.' ';
		if(ploption('WMCopyright_MultipleYears',$this->oset) && $startyear<$thisyear) {
			echo '- '.$thisyear.' ';
		}
		if(ploption('WMCopyright_Title', $this->oset)) { 
			echo ploption('WMCopyright_Title', $this->oset);
		}
		if(ploption('WMCopyright_AllRightsReserved',$this->oset)) {
			echo '<span class="wmContentCopyrightOwner">';
			_e(' &middot; All Rights Reserved','wmContentCopyright');
			echo '</span>';
		}
		echo '</span>';
	}
}
?>