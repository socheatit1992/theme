<?php
class html {
    static public $categoriesOptions = array();
    static public $productsOptions = array();
    static public function block($name, $params= array('attrs' => '', 'value' => '')){
		$params['value'] = isset($params['value']) ? $params['value'] : '';
        return '<p class="toe_'. self::nameToClassId($name). '">'. $params['value']. '</p>';
    }
    static public function nameToClassId($name) {
        return str_replace(array('[', ']'), '', $name);
    }
    static public function textarea($name, $params = array('attrs' => '', 'value' => '', 'rows' => 3, 'cols' => 50)) {
        $params['rows'] = isset($params['rows']) ? $params['rows'] : 3;
        $params['cols'] = isset($params['cols']) ? $params['cols'] : 50;
		$params['value'] = isset($params['value']) ? $params['value'] : '';
		$params['attrs'] = isset($params['attrs']) ? $params['attrs'] : '';
        return '<textarea name="'.$name.'" '.$params['attrs'].' rows="'.$params['rows'].'" cols="'.$params['cols'].'">'.
                $params['value'].
                '</textarea>';
    }
    static public function input($name, $params = array('attrs' => '', 'type' => 'text', 'value' => '')) {
		$params['type'] = isset($params['type']) ? $params['type'] : '';
		$params['value'] = isset($params['value']) ? $params['value'] : '';
		$params['attrs'] = isset($params['attrs']) ? $params['attrs'] : '';
        return '<input type="'.$params['type'].'" name="'.$name.'" value="'.$params['value'].'" '.$params['attrs'].' />';
    }
    static public function text($name, $params = array('attrs' => '', 'value' => '')) {
        $params['type'] = 'text';
        return self::input($name, $params);
    }
	static public function reset($name, $params = array('attrs' => '', 'value' => '')) {
        $params['type'] = 'reset';
        return self::input($name, $params);
    }
    static public function password($name, $params = array('attrs' => '', 'value' => '')) {
        $params['type'] = 'password';
        return self::input($name, $params);
    }
    static public function hidden($name, $params = array('attrs' => '', 'value' => '')) {
        $params['type'] = 'hidden';
        return self::input($name, $params);
    }
    static public function checkbox($name, $params = array('attrs' => '', 'value' => '', 'checked' => '')) {
		$params['checked'] = isset($params['checked']) ? $params['checked'] : '';
		$params['value'] = isset($params['value']) ? $params['value'] : 1;
		$params['attrs'] = isset($params['attrs']) ? $params['attrs'] : '';
        $params['type'] = 'checkbox';
        if($params['checked'])
            $params['checked'] = 'checked';
        $params['attrs'] .= ' '.$params['checked'];
        return self::input($name, $params);
    }
    static public function checkboxlist($name, $params = array('options' => array(), 'attrs' => '', 'checked' => '', 'delim' => '<br />', 'usetable' => 5), $delim = '<br />') {
		$params['options'] = isset($params['options']) ? $params['options'] : '';
		$params['delim'] = isset($params['delim']) ? $params['delim'] : $delim;
		$params['usetable'] = isset($params['usetable']) ? $params['usetable'] : '';
		$params['attrs'] = isset($params['attrs']) ? $params['attrs'] : '';
        $out = '';
        if(!strpos($name, '[]')) {
            $name .= '[]';
        }
        $i = 0;
        if($params['options']) {
            if(!isset($params['delim']))
                $params['delim'] = $delim;
            if($params['usetable']) $out .= '<table><tr>';
			if(isset($params['value'])) {
				if(!is_array($params['value']))
					$params['value'] = array($params['value']);
				foreach($params['options'] as $j => $v) {
					$params['options'][$j]['checked'] = (isset($v['checked']) && $v['checked']) ? $v['checked'] : in_array($v['id'], $params['value']);
				}
			}
            foreach($params['options'] as $v) {
                if($params['usetable']) {
                    if($i != 0 && $i%$params['usetable'] == 0) $out .= '</tr><tr>';
                    $out .= '<td>';
                }
                $out .= self::checkbox($name, array(
                    'attrs' => $params['attrs'],
                    'value' => $v['id'],
                    'checked' => $v['checked']
                ));
                $out .= '&nbsp;'. $v['text']. $params['delim'];
                if($params['usetable']) $out .= '</td>';
                $i++;
            }
            if($params['usetable']) $out .= '</tr></table>';
        }
        return $out;
    } 
    static public function datepicker($name, $params = array('attrs' => '', 'value' => '')) {
        if(isset($params['id']) && !empty($params['id']))
            $id = $params['id'];
        else
            $id = self::nameToClassId($name);
        return self::input($name, array(
                'attrs' => 'id="'.$id.'" '.$params['attrs'],
                'type' => 'text',
                'value' => $params['value']
        )).'<script type="text/javascript">
            // <!--
                jQuery(document).ready(function(){
                    jQuery("#'.$id.'").datepicker({dateFormat: "'.S_DATE_FORMAT_JS.'", 
                        changeYear: true,
                        yearRange: "1905:'.(date('Y')+5).'"});
                });
            // -->
        </script>';
    }
    static public function submit($name, $params = array('attrs' => '', 'value' => '')) {
        $params['type'] = 'submit';
        return self::input($name, $params);
    }
	static public function inputImage($name, $params = array('attrs' => '', 'value' => '', 'src' => '')) {
		$params['type'] = 'image';
		if(!isset($params['attrs']))
			$params['attrs'] = '';
		$params['attrs'] .= ' src="'. $params['src']. '"';
        return self::input($name, $params);
	}
    static public function img($src, $usePlugPath = 1, $params = array('width' => '', 'height' => '', 'attrs' => '')) {
        if($usePlugPath) $src = S_IMG_PATH. $src;
        return '<img src="'.$src.'" '.($params['width']?'width="'.$params['width'].'"':'').' '.($params['height']?'height="'.$params['height'].'"':'').' '.$params['attrs'].' />';
    }
    static public function selectbox($name, $params = array('attrs' => '', 'options' => array(), 'value' => '')) {
		$params['attrs'] = isset($params['attrs']) ? $params['attrs'] : '';
		$params['value'] = isset($params['value']) ? $params['value'] : '';
        $out = '';
        $out .= '<select name="'.$name.'" '.$params['attrs'].'>';
        if(!empty($params['options'])) {
            foreach($params['options'] as $k => $v) {
                $selected = ($k == $params['value'] ? 'selected="true"' : '');
                $out .= '<option value="'.$k.'" '.$selected.'>'.$v.'</option>';
            }
        }
        $out .= '</select>';
        return $out;
    }
    static public function selectlist($name, $params = array('attrs'=>'', 'size'=> 5, 'options' => array(), 'value' => '')) {
		$params['size'] = isset($params['size']) ? $params['size'] : '';
		$params['attrs'] = isset($params['attrs']) ? $params['attrs'] : '';
		$params['value'] = isset($params['value']) ? $params['value'] : array();
		$params['multiple'] = isset($params['multiple']) ? $params['multiple'] : true;
        $out = '';
        if(!strpos($name, '[]')) 
            $name .= '[]';
        if (!isset($params['size']) || !is_numeric($params['size']) || $params['size'] == '') {
            $params['size'] = 5;
        }
        $out .= '<select '. ($params['multiple'] ? 'multiple="multiple" ' : ''). 'size="'.$params['size'].'" name="'.$name.'" '.$params['attrs'].'>';
        if(!empty($params['options'])) {
            foreach($params['options'] as $k => $v) {
                $selected = (is_array($params['value']) && in_array($k, $params['value']) ? 'selected="true"' : '');
                $out .= '<option value="'.$k.'" '.$selected.'>'.$v.'</option>';
            }
        }
        $out .= '</select>';
        return $out; 
    }
    static public function ajaxfile($name, $params = array('url' => '', 'value' => '', 'fid' => '', 'buttonName' => '')) {
        $out = '';
        $out .= self::button(array('value' => lang::_( empty($params['buttonName']) ? 'Upload' :  $params['buttonName'] ), 'attrs' => 'id="toeUploadbut_'.$name.'"'));
        $display = (empty($params['value']) ? 'style="display: none;"' : '');
        if($params['preview'])
            $out .= self::img($params['value'], 0, array('attrs' => 'id="prev_'.$name.'" '.$display.' class="previewpicture"'));
        $out .= '<span class="delete_option" id="delete_'.$name.'" '.$display.'></span>';
        $out .= '<script type="text/javascript">// <!--
                jQuery(document).ready(function(){
                    new AjaxUpload("#toeUploadbut_'.$name.'", { 
                        action: "'.$params['url'].'", 
                        name: "'. $name. '" '. 
                        (empty($params['data']) ? '' : ',  data: '. $params['data']. '').
                        (empty($params['autoSubmit']) ? '' : ',  autoSubmit: "'. $params['autoSubmit']. '"').
                        (empty($params['responseType']) ? '' : ',  responseType: "'. $params['responseType']. '"').
                        (empty($params['onChange']) ? '' : ',  onChange: '. $params['onChange']. '').
                        (empty($params['onSubmit']) ? '' : ',  onSubmit: '. $params['onSubmit']. '').
                        (empty($params['onComplete']) ? '' : ',  onComplete: '. $params['onComplete']. '').
                    '});
                });
            // --></script>';
        return $out;
    }
    static public function button($params = array('attrs' => '', 'value' => '')) {
        return '<button '.$params['attrs'].'>'.$params['value'].'</button>';
    }
    static public function inputButton($params = array('attrs' => '', 'value' => '')) {
		if(!is_array($params))
			$params = array();
		$params['type'] = 'button';
        return self::input('', $params);
    }
    static public function radiobuttons($name, $params = array('attrs' => '', 'options' => array(), 'value' => '', '')) {
		$params['value'] = isset($params['value']) ? $params['value'] : '';
		$params['options'] = isset($params['options']) ? $params['options'] : array();
		$params['attrs'] = isset($params['attrs']) ? $params['attrs'] : '';
        $out = '';
        foreach($params['options'] as $key => $val) {
            $checked =($key == $params['value']) ? 'checked' : '';
            $out .= self::input($name, array('attrs' => $params['attrs'].' '.$checked, 'type' => 'radio', 'value' => $key)).' '.$val.'<br />';
        }
        return $out;
    }
    static public function radiobutton($name, $params = array('attrs' => '', 'value' => '', 'checked' => '')) {
        $params['type'] = 'radio';
		$params['checked'] = isset($params['checked']) ? $params['checked'] : false;
		$params['attrs'] = isset($params['attrs']) ? $params['attrs'] : '';
        if($params['checked'])
            $params['attrs'] .= ' checked';
        return self::input($name, $params);
    }
    static public function nonajaxautocompleate($name, $params = array('attrs' => '', 'options' => array())) {
        if(empty($params['options'])) return false;
        $out = '';
        $jsArray = array();
        $oneItem = '<div id="%%ID%%"><div class="ac_list_item"><input type="hidden" name="'.$name.'[]" value="%%ID%%" />%%VAL%%</div><div class="close" onclick="removeAcOpt(%%ID%%)"></div><div class="br"></div></div>';
        $tID = $name. '_ac';
        $out .= self::text($tID. '_ac', array('attrs' => 'id="'.$tID.'"'));
        $out .= '<div id="'.$name.'_wraper">';
        foreach($params['options'] as $opt) {
            $jsArray[$opt['id']] = $opt['text'];
            if(isset($opt['checked']) && $opt['checked'] == 'checked') {
                $out .= str_replace(array('%%ID%%', '%%VAL%%'), array($opt['id'], $opt['text']), $oneItem);
            }
        }
        $out .= '</div>';
        $out .= '<script type="text/javascript">
                var ac_values_'.$name.' = '.json_encode(array_values($jsArray)).';
                var ac_keys_'.$name.' = '.json_encode(array_keys($jsArray)).';
                jQuery(document).ready(function(){
                    jQuery("#'.$tID.'").autocomplete(ac_values_'.$name.', {
                        autoFill: false,
                        mustMatch: false,
                        matchContains: false
                    }).result(function(a, b, c){
                        var keyID = jQuery.inArray(c, ac_values_'.$name.');
                        if(keyID != -1) {
                            addAcOpt(ac_keys_'.$name.'[keyID], c, "'.$name.'");
                        }
                    });
                });
        </script>';
        return $out;
    }
    static public function formStart($name, $params = array('action' => '', 'method' => 'GET', 'attrs' => '', 'hideMethodInside' => false)) {
        $params['attrs'] = isset($params['attrs']) ? $params['attrs'] : '';
        $params['action'] = isset($params['action']) ? $params['action'] : '';
        $params['method'] = isset($params['method']) ? $params['method'] : 'GET';
		$params['hideMethodInside'] = isset($params['hideMethodInside']) ? $params['hideMethodInside'] : false;
        if($params['hideMethodInside']) {
            return '<form name="'. $name. '" action="'. $params['action']. '" method="'. $params['method']. '" '. $params['attrs']. '>'. 
                self::hidden('method', array('value' => $params['method']));
        } else {
            return '<form name="'. $name. '" action="'. $params['action']. '" method="'. $params['method']. '" '. $params['attrs']. '>';
        }
    }
    static public function formEnd() {
        return '</form>';
    }
    static public function statesInput($name, $params = array('value' => '', 'attrs' => '', 'notSelected' => true, 'id' => '', 'selectHtml' => '')) {
        if(empty($params['selectHtml']) || !method_exists('html', $params['selectHtml']))
            return false;
        
        $params['notSelected'] = isset($params['notSelected']) ? $params['notSelected'] : true;
        $states = fieldAdapter::getStates($params['notSelected']);
        
        foreach($states as $sid => $s) {
            $params['options'][$sid] = $s['name'];
        }
        $idSelect = '';
        $idText = '';
        $id = '';
        if(!empty($params['id'])) {
            $id = $params['id'];
        } else {
            $id = self::nameToClassId($name);
        }
		$params['attrs'] = isset($params['attrs']) ? $params['attrs'] : '';
        $paramsText = $paramsSelect = $params;
        $paramsText['attrs'] .= 'id = "'. $id. '_text"';
        $paramsSelect['attrs'] .= 'id = "'. $id. '_select"';
        $res = '';
        $res .= self::$params['selectHtml']($name, $paramsSelect);
        $res .= self::text($name, $paramsText);
        if(empty($params['doNotAddJs'])) {
            $res .= '<script type="text/javascript">
                // <!--
                if(!toeStates.length)
                    toeStates = '. utils::jsonEncode($states). ';
                toeStatesObjects["'. $id. '"] = new toeStatesSelect("'. $id. '");
                // -->
            </script>';
        }
        return $res;
    }
    static public function statesList($name, $params = array('value' => '', 'attrs' => '', 'notSelected' => true, 'id' => '')) {
        $params['selectHtml'] = 'selectbox';
        return self::statesInput($name, $params);
    }
    static public function statesListMultiple($name, $params = array('value' => '', 'attrs' => '', 'notSelected' => true, 'id' => '')) {
        if(!empty($params['value'])) {
            if(is_string($params['value'])) {
                if(strpos($params['value'], ','))
                    $params['value'] = array_map('trim', explode(',', $params['value']));
                else
                    $params['value'] = array(trim($params['value']));
            }
        }
        $params['selectHtml'] = 'selectlist';
        return self::statesInput($name, $params);
    }
    static public function countryList($name, $params = array('value' => '', 'attrs' => '', 'notSelected' => true)) {
        $params['notSelected'] = isset($params['notSelected']) ? $params['notSelected'] : true;
		$params['attrs'] = isset($params['attrs']) ? $params['attrs'] : '';
        $params['options'] = fieldAdapter::getCountries($params['notSelected']);
        $params['attrs'] .= ' type="country"';
        return self::selectbox($name, $params);
    }
    static public function countryListMultiple($name, $params = array('value' => '', 'attrs' => '', 'notSelected' => true)) {
		$params['value'] = isset($params['value']) ? $params['value'] : '';
		$params['attrs'] = isset($params['attrs']) ? $params['attrs'] : '';
        if(!empty($params['value'])) {
            if(is_string($params['value'])) {
                if(strpos($params['value'], ','))
                    $params['value'] = array_map('trim', explode(',', $params['value']));
                else
                    $params['value'] = array(trim($params['value']));
            }
        }
        $params['notSelected'] = isset($params['notSelected']) ? $params['notSelected'] : true;
        $params['options'] = fieldAdapter::getCountries($params['notSelected']);
        $params['attrs'] .= ' type="country"';
        return self::selectlist($name, $params);
    }
    static public function textFieldsDynamicTable($name, $params = array('value' => '', 'attrs' => '', 'options' => array())) {
        $res = '';
		$params['value'] = isset($params['value']) ? $params['value'] : array();
        if(!isset($params['options']) || empty($params['options']))
            $params['options'] = array(0 => array('label' => ''));
        if(!empty($params['options'])) {
            $pattern = array();
            foreach($params['options'] as $key => $p) {
                $pattern[$key] = html::text($name. '[]['. $key. ']');
            }
            $countOptions = count($params['options']);
            $remove = '<a href="#" onclick="toeRemoveTextFieldsDynamicTable(this); return false;">remove</a>';
            $add = '<a href="#" onclick="toeAddTextFieldsDynamicTable(this, '. $countOptions. '); return false;">add</a>';
            
            $res = '<div class="toeTextFieldsDynamicTable">';
            if(empty($params['value']))
                $params['value'] = array();
            elseif(!is_array($params['value'])) {
                $params['value'] = utils::jsonDecode($params['value']);
                //$params['value'] = $params['value'][0];
            }
            $i = 0;
            do {
                $res .= '<div class="toeTextFieldDynamicRow">';
                foreach($params['options'] as $key => $p) {
                    switch($countOptions) {
                        case 1:
                            if(isset($params['value'][$i])) 
                                $value = is_array($params['value'][$i]) ? $params['value'][$i][$key] : $params['value'][$i];
                            else
                                $value = '';
                            break;
                        case 2:
                        default:
                            $value = isset($params['value'][$i][$key]) ? $params['value'][$i][$key] : '';
                            break;
                    }
                    $paramsForText = array(
                        'value' => $value,
                    );
                    $res .= lang::_($p['label']). html::text($name. '['. $i. ']['. $key. ']', $paramsForText);
                }
                $res .= $remove. '</div>';
                $i++;
            } while($i < count($params['value']));
            $res .= $add;
            $res .= '</div>';
        }
        return $res;
    }
    static public function categorySelectlist($name, $params = array('attrs'=>'', 'size'=> 5, 'value' => '')) {
        self::_loadCategoriesOptions();
        if(self::$categoriesOptions) {
			$params['attrs'] = isset($params['attrs']) ? $params['attrs'] : '';
			$selectBoxId = self::extractIdFromString($params['attrs']);
			if(empty($selectBoxId)) {
				$selectBoxId = 'toeProdCats_'. mt_rand(1, 99999);
				$params['attrs'] .= ' id="'. $selectBoxId. '"';
			}
			$buttonId = $selectBoxId. '_clear_button';
			$params['options'] = array();
			if(isset($params['select_all']))
				$params['options'][0] = lang::_('Select All');
			foreach(self::$categoriesOptions as $cid => $cname) {
				$params['options'][ $cid ] = $cname;
			}
            $out = self::selectlist($name, $params);
			$out .= '<br />';
			$out .= self::button(array('value' => lang::_('Deselect All'), 'attrs' => 'id="'. $buttonId. '" class="button"'));
			$out .= '<script type="text/javascript">//<!--'. S_EOL;
            $out .= 'jQuery("#'. $buttonId. '").click(function(){
						jQuery("#'. $selectBoxId. '").find("option").removeAttr("selected");
						return false;
					});'. S_EOL;
			if(isset($params['select_all'])) {
				$out .= 'jQuery("#'. $selectBoxId. '").find("option[value=0]").click(function(){
							jQuery("#'. $selectBoxId. '").find("option").attr("selected", 1);
							return false;
						});'. S_EOL;
				if(isset($params['value']) && is_array($params['value']) && $params['value'][0]) {	// All is selected
					$out .= 'jQuery("#'. $selectBoxId. '").find("option[value=0]").trigger("click");'. S_EOL;
				}
			}
			$out .= '--></script>';
			return $out;
        }
        return false;
    }
    static public function categorySelectbox($name, $params = array('attrs'=>'', 'size'=> 5, 'value' => '')) {
        self::_loadCategoriesOptions();
        if(!empty(self::$categoriesOptions)) {
            $params['options'] = self::$categoriesOptions;
            return self::selectbox($name, $params);
        }
        return false;
    }
	static public function extractIdFromString($str) {
		preg_match('/id\s*=\s*"(?P<ID>.+)"/i', $str, $matches);
		if(!empty($matches) && isset($matches['ID']))
			return $matches['ID'];
		return false;
	}
    static public function productsSelectlist($name, $params = array('attrs'=>'', 'size'=> 5, 'value' => '')) {
        self::_loadProductsOptions();
        if(!empty(self::$productsOptions)) {
			$params['attrs'] = isset($params['attrs']) ? $params['attrs'] : '';
			$selectBoxId = self::extractIdFromString($params['attrs']);
			if(empty($selectBoxId)) {
				$selectBoxId = 'toeProds_'. mt_rand(1, 99999);
				$params['attrs'] .= ' id="'. $selectBoxId. '"';
			}
			$buttonId = $selectBoxId. '_clear_button';
			$params['options'] = array();
			if(isset($params['select_all']))
				$params['options'][0] = lang::_('Select All');
			foreach(self::$productsOptions as $pid => $pname) {
				$params['options'][ $pid ] = $pname;
			}
			$out = self::selectlist($name, $params);
			$out .= '<br />';
			$out .= self::button(array('value' => lang::_('Deselect All'), 'attrs' => 'id="'. $buttonId. '" class="button"'));
			$out .= '<script type="text/javascript">//<!--'. S_EOL;
            $out .= 'jQuery("#'. $buttonId. '").click(function(){
						jQuery("#'. $selectBoxId. '").find("option").removeAttr("selected");
						return false;
					});'. S_EOL;
			if(isset($params['select_all'])) {
				$out .= 'jQuery("#'. $selectBoxId. '").find("option[value=0]").click(function(){
							jQuery("#'. $selectBoxId. '").find("option").attr("selected", 1);
							return false;
						});'. S_EOL;
				if(isset($params['value']) && is_array($params['value']) && $params['value'][0]) {	// All is selected
					$out .= 'jQuery("#'. $selectBoxId. '").find("option[value=0]").trigger("click");'. S_EOL;
				}
			}
			$out .= '--></script>';
			return $out;
        }
        return false;
    }
    static public function productsSelectbox($name, $params = array('attrs'=>'', 'size'=> 5, 'value' => '')) {
        self::_loadProductsOptions();
        if(!empty(self::$productsOptions)) {
            $params['options'] = self::$productsOptions;
            return self::selectbox($name, $params);
        }
        return false;
    }
    static protected function _loadCategoriesOptions() {
        if(empty(self::$categoriesOptions)) {
            $categories = frame::_()->getModule('products')->getCategories();
            if(!empty($categories)) {
                foreach($categories as $c) {
                    self::$categoriesOptions[$c->term_taxonomy_id] = $c->cat_name;
                }
            }
        }
    }
    static protected function _loadProductsOptions() {
        if(empty(self::$productsOptions)) {
            $products = frame::_()->getModule('products')->getModel()->get(array('getFields' => 'post.ID, post.post_title', 'activeOnly' => 1));
            if(!empty($products)) {
                foreach($products as $p) {
                    self::$productsOptions[$p['ID']] = $p['post_title'];
                }
            }
        }
    }
    static public function slider($name, $params = array('value' => 0, 'min' => 0, 'max' => 0, 'step' => 1, 'slide' => '')) {
        $id = self::nameToClassId($name);
        $paramsStr = '';
        if(empty($params['slide']) && $params['slide'] !== false) { //Can be set to false to ignore function onSlide event binding
            $params['slide'] = 'toeSliderMove';
        }
        if(!empty($params)) {
            $paramsArr = array();
            foreach($params as $k => $v) {
                $value = (is_numeric($v) || in_array($k, array('slide'))) ? $v : '"'. $v. '"';
                $paramsArr[] = $k. ': '. $value;
            }
            $paramsStr = implode(', ', $paramsArr);
        }
        $res = '<div id="toeSliderDisplay_'. $id. '">'. (empty($params['value']) ? '' : $params['value']). '</div>';
        $res .= '<div id="'. $id. '"></div>';
        $params['attrs'] = 'id="toeSliderInput_'. $id. '"';
        $res .= self::hidden($name, $params);
        $res .= '<script type="text/javascript"><!-- 
            jQuery(function(){ 
                jQuery("#'. $id. '").slider({'. $paramsStr. '}); 
            }); 
            --></script>';
        return $res;
    }
	static public function capcha() {
		return recapcha::_()->getHtml();
	}
	static public function textIncDec($name, $params = array('value' => '', 'attrs' => '', 'options' => array(), 'onclick' => '', 'id' => '')) {
		if(!isset($params['attrs']))
			$params['attrs'] = '';
		$textId = (isset($params['id']) && !empty($params['id'])) ? $params['id'] : 'toeTextIncDec_'. mt_rand(9, 9999);
		$params['attrs'] .= ' id="'. $textId. '"';
		$textField = self::text($name, $params);
		$onClickInc = 'toeTextIncDec(\''. $textId. '\', 1); return false;';
		$onClickDec = 'toeTextIncDec(\''. $textId. '\', -1); return false;';
		if(isset($params['onclick']) && !empty($params['onclick'])) {
			$onClickInc = $params['onclick']. ' '. $onClickInc;
			$onClickDec = $params['onclick']. ' '. $onClickDec;
		}
		$textField .= '<div class="toeUpdateQtyButtonsWrapper"><div class="toeIncDecButton toeIncButton '. $textId. '" onclick="'. $onClickInc. '">+</div>'
				. '<div class="toeIncDecButton toeDecButton '. $textId. '" onclick="'. $onClickDec. '">-</div></div>';
		return $textField;
	}
	/**
	 * Didn't make it to work
	 */
	/*static public function colorpicker($name, $params = array('attrs' => '', 'value' => '')) {
		$id =  self::nameToClassId($name). '_'. mt_rand(9, 9999);
		if(!isset($params['attrs']))
			$params['attrs'] = '';
		$params['attrs'] .= ' class="colorpicker" id="'. $id. '" ';
		$res = self::text($name, $params);
		$res .= '<script type="text/javascript"><!-- 
            jQuery(document).ready(function(){ 
				
				jQuery("#colorpicker").farbtastic("#'. $id. '").prepend("<span class=\'ui-icon ui-icon-check\'></span>");
                jQuery("#'. $id. '").each(function(){
					jQuery.farbtastic("#colorpicker").linkTo(jQuery(this));
				});
				jQuery("#'. $id. '").focus(function() {
					jQuery("#colorpicker").hide();
					jQuery.farbtastic("#colorpicker").linkTo(jQuery(this));
					jQuery("#colorpicker").attr(\'old-color\', jQuery.farbtastic("#colorpicker").color);
					var offset = jQuery(this).offset();
					jQuery("#colorpicker").css(\'left\', offset.left - 68).css(\'top\', offset.top + 20).fadeIn(400);
				});
				jQuery("#'. $id. '").click(function(){
					jQuery("#colorpicker").attr("old-color", jQuery.farbtastic("#colorpicker").color);
					jQuery("#colorpicker").show();
				});
				jQuery("#'. $id. '").keydown(function(event) {
					// Esc.
					if (event.keyCode == 27) {scCancelColorPicker()}
					// Enter.
					if (event.keyCode == 13) {
					  jQuery("#colorpicker .ui-icon-check").click();
					  event.preventDefault();
					}
					// Space.
					if (event.keyCode == 32) {jQuery("#colorpicker").show();}
				});
            }); 
            --></script>';
		return $res;
	}*/
}
?>