<?php

/*
 * This file is part of the symfony package.
 * (c) Fabien Potencier <fabien.potencier@symfony-project.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * sfValidatorString validates a string. It also converts the input value to a string.
 *
 * @package    symfony
 * @subpackage validator
 * @author     Fabien Potencier <fabien.potencier@symfony-project.com>
 * @version    SVN: $Id: sfValidatorString.class.php 12641 2008-11-04 18:22:00Z fabien $
 */
class sfValidatorBase64Image extends sfValidatorString {

    /**
     * Configures the current validator.
     *
     * Available options:
     *
     *  * max_length: The maximum length of the string
     *  * min_length: The minimum length of the string
     *
     * Available error codes:
     *
     *  * max_length
     *  * min_length
     *
     * @param array $options   An array of options
     * @param array $messages  An array of error messages
     *
     * @see sfValidatorBase
     */
    protected function configure($options = array(), $messages = array()) {
      $this->addMessage('max_size', 'File is too large (maximum is %max_size% bytes).');
      $this->addMessage('mime_types', 'Invalid mime type (%mime_type%).');
      $this->addOption('max_size');
      $this->addOption('mime_types');
    }

    /**
     * @param mixed $value
     * @return string
     * @throws sfValidatorError
     */
    protected function doClean($value) {
        $clean = (string) trim($value);

        $size = strlen($value);
        if ($this->hasOption('max_size') && $this->getOption('max_size') < (int) $size)
        {
          throw new sfValidatorError($this, 'max_size', array('max_size' => $this->getOption('max_size'), 'size' => (int) $value['size']));
        }

        if ($value && $this->hasOption('mime_types'))
        {
          $imgArr = explode(',', $value);
          $info = getimagesizefromstring(base64_decode($imgArr[1]));
          $mimeType = $info['mime'];
          $mimeTypes = $this->getOption('mime_types');
          if (!in_array($mimeType, array_map('strtolower', $mimeTypes)))
          {
            throw new sfValidatorError($this, 'mime_types', array('mime_types' => $mimeTypes, 'mime_type' => $mimeType));
          }
        }

        return $clean;
    }

}
