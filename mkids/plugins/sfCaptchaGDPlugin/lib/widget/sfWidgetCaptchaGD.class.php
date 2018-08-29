<?php
	class sfWidgetCaptchaGD extends sfWidgetForm
	{
		protected function configure($options = array(), $attributes = array()) {

		}

		public function render($name, $value = null, $attributes = array(), $errors = array()) {


			sfContext::getInstance()->getConfiguration()->loadHelpers('Asset','Url','I18n');

			$img_src = sfContext::getInstance()->getRouting()->generate("sf_captchagd").'?sid='.md5(time());


			$html =$this->renderTag('input', array_merge(
				array('type' => 'text', 'name' => $name, 'value' => $value,'style'=> 'width:120px'),
				$attributes)) .
				"<a href='' onClick='return false' title='".__("Reload image")."'>
        <img src='$img_src' onClick='this.src=\"$img_src?r=\" + Math.random() + \"&amp;reload=1\"' border='0' class='captcha' />
      </a>";

			return $html;

		}



	}
