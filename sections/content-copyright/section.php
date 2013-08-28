<?php
/*
	Section: Content Copyright
	Author: William Mincy
	Author URI: http://slipperysource.com
	Description: Allows you to place a customizable copyright statement within your template that auto-updates the year.
	Class Name: wmContentCopyright
	Filter: Component
	Loading: active,templates,main,sb_1,sb_2,sb_wrap,footer,footermore
	V3: true
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
				'help' => __('<p>Styling the output on the page is possible by way of the provided CSS class names applied to the elements. By default we do not apply any CSS rules and inherit form the site\'s overall CSS rules.
								<dl>
									<dt><em>wmContentCopyright</em></dt>
										<dd>This class is applied to the wrapper <code>span</code> for the entire section. It is recommended that this be styled first since all other classes will inherit from it.</dd>
									<dt><em>wmContentCopyrightSymbol</em></dt>
										<dd>This class is applied to the wrapper <code>span</code> for the copyright symbol itself, allowing it to be individually targeted.</dd>
									<dt><em>wmContentCopyrightOwner</em></dt>
										<dd>This class is applied to the wrapper <code>span</code> for the copyright owner text, and wraps any <code>HTML</code> or text that may be used.</dd>
								</dl>
								</p>','wmContentCopyright'),
				'opts' => array(
						array(
								'key' => 'WMCopyright_Symbol',
								'type' => 'check',
								'title' => __('Display copyright symbol','wmContentCopyright'),
								'label' => __('Display copyright symbol','wmContentCopyright'),
								'default' => false
							), 
						array(
								'key' => 'WMCopyright_Title',
								'type' => 'text',
								'title' => __('Copyright owner','wmContentCopyright'),
								'label' => __('Copyright owner','wmContentCopyright')
							),
						array(
								'key' => 'WMCopyright_Text',
								'type' => 'check',
								'title' => __('Display copyright text','wmContentCopyright'),
								'label' => __('Display copyright text','wmContentCopyright'),
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
								'key' => 'WMCopyright_Roman',
								'type' => 'check',
								'title' => __('Show as Roman numerals','wmContentCopyright'),
								'label' => __('Show as Roman numerals','wmContentCopyright'),
								'default' => false
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
								'ref' => __('Checking this will show the year over time to be the start year up through the current year (i.e. 2010 - 2013) as opposed to the current year (2013)','wmContentCopyright'),
								'default' => false
							)
					)
			);
		return $options;
	}
	
	function toRoman($num, $uppercase = true)
    {
        $conv = array(10 => array('X', 'C', 'M'), 
        			5 => array('V', 'L', 'D'),
        			1 => array('I', 'X', 'C')
        		);
        $roman = '';

        if ($num < 0) {
            return '';
        }

        $num = (int) $num;
        $digit = (int) ($num / 1000);
        $num -= $digit * 1000;

        while ($digit > 0) {
            $roman .= 'M';
            $digit--;
        }

        for ($i = 2; $i >= 0; $i--) {
            $power = pow(10, $i);
            $digit = (int) ($num / $power);
            $num -= $digit * $power;

            if (($digit == 9) || ($digit == 4)) {
                $roman .= $conv[1][$i] . $conv[$digit+1][$i];
            } else {
                if ($digit >= 5) {
                    $roman .= $conv[5][$i];
                    $digit -= 5;
                }

                while ($digit > 0) {
                    $roman .= $conv[1][$i];
                    $digit--;
                }
            }
        }

        $roman = str_replace(str_repeat('M', 1000), 'AFS', $roman);
        $roman = str_replace(str_repeat('M', 900), 'CAFS', $roman);
        $roman = str_replace(str_repeat('M', 500), 'D', $roman);
        $roman = str_replace(str_repeat('M', 400), 'CD', $roman);
        $roman = str_replace(str_repeat('M', 100), 'C', $roman);
        $roman = str_replace(str_repeat('M', 90), 'XC', $roman);
        $roman = str_replace(str_repeat('M', 50), 'L', $roman);
        $roman = str_replace(str_repeat('M', 40), 'XL', $roman);
        $roman = str_replace(str_repeat('M', 10), 'X', $roman);
        $roman = str_replace(str_repeat('M', 5), 'V', $roman);
        $roman = str_replace(str_repeat('M', 4), 'MV', $roman);

        $roman = str_replace('AFS', 'M', $roman);

        if ($uppercase == false) {
            $roman = strtolower($roman);
        }

       return $roman;

    }

	
	// Content Display
	function section_template() {
		echo '<span class="wmContentCopyright">';
		if(ploption('WMCopyright_Text', $this->oset)) {
			_e('Copyright ','wmContentCopyright');
		}
		if(ploption('WMCopyright_Symbol', $this->oset)) {
			echo ' <span class="wmContentCopyrightSymbol">&copy;</span> ';
		}
		$startyear = (ploption('WMCopyright_BeginningYear',$this->oset)) ? ploption('WMCopyright_BeginningYear',$this->oset) : (int)date("Y");
		$thisyear = date("Y");
		echo ' '.((ploption('WMCopyright_Roman', $this->oset)) ? $this->toRoman($startyear) : $startyear).' ';
		if(ploption('WMCopyright_MultipleYears',$this->oset) && $startyear<$thisyear) {
			echo '- '.((ploption('WMCopyright_Roman', $this->oset)) ? $this->toRoman($thisyear) : $thisyear).' ';
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