<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of VtHelper
 * @author vas_tungtd2
 */
class VtHelper
{

  const MOBILE_SIMPLE = '9x';
  const MOBILE_GLOBAL = '849x';


  public static function generateSalt()
  {
    return md5(time());

  }


  public static function truncate($text, $length = 30, $truncateString = '...', $truncateLastspace = true, $escSpecialChars = false)
  {
    if (sfConfig::get('sf_escaping_method') == 'ESC_SPECIALCHARS') {
      $text = htmlspecialchars_decode($text, ENT_QUOTES);
    }

    if (is_array($text)) {
      throw new dmException('Can not truncate an array: ' . implode(', ', $text));
    }

    $text = (string)$text;

    if (extension_loaded('mbstring')) {
      $strlen = 'mb_strlen';
      $substr = 'mb_substr';
//hatt12 them dong nay de dem ky tu tieng viet
      $countStr = $strlen($text, 'utf-8');
      if ($countStr > $length) {
        $text = $substr($text, 0, $length, 'utf-8');

        if ($truncateLastspace) {
          $text = preg_replace('/\s+?(\S+)?$/', '', $text);
        }

        $text = $text . $truncateString;
      }
    } else {
      $strlen = 'strlen';
      $substr = 'substr';
      $countStr = $strlen($text);
      if ($countStr > $length) {
        $text = $substr($text, 0, $length);
        if ($truncateLastspace) {
          $text = preg_replace('/\s+?(\S+)?$/', '', $text);
        }

        $text = $text . $truncateString;
      }
    }
    if ($escSpecialChars) {
      return $text;
    } else {
      return htmlspecialchars($text, ENT_QUOTES, 'UTF-8');
    }
  }

  /**
   * deleteCacheKeyOfComponent ham xoa cache (Dependence)
   * @author tuanbm
   * @date 2013/01/24
   * @param module ~ Component
   * @param $partial ~ Can thuc hien xoa
   * @param key khoa cua cache ~ sf_cache_key, neu muon xoa tat cac khoa cua cache thi su dung *
   * @return string
   */
  public static function deleteCacheKeyOfComponent($module, $partial, $key)
  {
    $cacheKey = "@sf_cache_partial?module=" . $module . "&action=" . $partial . "&sf_cache_key=" . $key;
    return self::deleteCacheKey($cacheKey);
  }

  /**
   * deleteCacheKey ham xoa cache (Dependence)
   * @author tuanbm
   * @param key khoa cua cache ~ sf_cache_key, neu muon xoa tat cac khoa cua cache thi su dung *
   * @date 2013/01/24
   * @return string
   */
  public static function deleteCacheKey($cacheKey)
  {
    $cacheManager = sfContext::getInstance()->getViewCacheManager();
    if (isset($cacheManager)) {
//            $result = $cacheManager->remove('@sf_cache_partial?module=compVtAlbum&action=_albumHome&sf_cache_key=40cd750bba9870f18aada2478b24840a');    // Remove for all keys
      $result = $cacheManager->remove($cacheKey);
      return $result;
    }
    return false;
  }

  public static function decodeInput($string)
  {
    $string = VtHelper::replaceSpecialCharsFromWord($string);
    if (sfConfig::get('sf_escaping_method') == 'ESC_SPECIALCHARS')
      return htmlspecialchars_decode($string, ENT_QUOTES);
    return html_entity_decode($string, ENT_QUOTES, sfConfig::get('sf_charset'));
  }

  /**
   * preProcess query search backsplash (\) tat ca doan code search like trong PHP ma can tim ky tu dac biet deu phai goi ham nay
   * @author tuanbm
   * @modifier chuyennv2
   * @date 2012/06/27
   * @return string
   */
  public static function preProcessForSearchLike($param)
  {
    $param = addslashes($param);
    if (($param != '')) {
      $param = str_replace("%", "\\%", $param);
      $param = str_replace("_", "\\_", $param);
    }
    return self::decodeInput($param);
  }

  //tuanbm ghi log
  public static function getLogger()
  {
    $logger = new sfFileLogger(new sfEventDispatcher(), array('file' => sfConfig::get('sf_log_dir') . '/VtHelper.log'));
    return $logger;
  }

  /**
   * log message from anywhere
   * @author huynq28
   * @param type $module
   * @param type $mesage
   * @return type
   */
  public static function logMessage($module, $mesage)
  {
    sfContext::getInstance()->getEventDispatcher()->notify(new sfEvent($module, 'application.log', $mesage));
  }

  public static function checkCSRF(sfWebRequest $request)
  {
    $baseForm = new BaseForm();
    $baseForm->bind($request->getParameter('form'));
    if (!$baseForm->isValid()) {
      throw $baseForm->getErrorSchema();
    }
  }

  /**
   * @author ChuyenNV2
   * get a string with number character input
   * @static
   * @param $strInput
   * @param $maxString
   * @return string
   */
  public static function getStringMaxLength($strInput, $maxString)
  {
    //tuanbm su dung 1 ham duy nhat, fix loi tren ham getLimitString
    return self::getLimitString($strInput, $maxString);
  }

  public static function subString($str, $length = 22, $truncateString = '...', $truncateLastspace = true)
  {
    $str = self::replaceSpecialCharsFromWord($str);
    $str = (string)$str;
    if (extension_loaded('mbstring')) {
      $strlen = 'mb_strlen';
      $substr = 'mb_substr';
    } else {
      $strlen = 'strlen';
      $substr = 'substr';
    }

    if ($strlen($str) > $length) {
      if ($substr == 'mb_substr') {
        $str = $substr($str, 0, $length - $strlen($truncateString), 'UTF-8');
      } else {
        $str = $substr($str, 0, $length - $strlen($truncateString));
      }
      if ($truncateLastspace) {
        $str = preg_replace('/\s+?(\S+)?$/', '', $str);
      }
      $str = $str . $truncateString;
    }
    return $str;
  }

  /**
   * @author khanhnq16
   * @param type $str
   * @param type $len
   * @param type $charset
   * @return type
   */
  public static function subStringUnicode($str, $len, $charset = 'UTF-8')
  {
//        echo $str;die;
    $str = self::replaceSpecialCharsFromWord($str);
    $str = html_entity_decode($str, ENT_QUOTES, $charset);


//        if($len == 15 && strlen($str) > 25){echo $len."|".mb_strlen($str, $charset);die;}

//         if (extension_loaded('mbstring')) {echo "mb_strlen: ".mb_strlen("", $charset);die;};
    if (mb_strlen($str, $charset) > $len) {
      $arr = explode(' ', $str);
      $str = mb_substr($str, 0, $len, $charset);
      $arrRes = explode(' ', $str);
      $last = $arr[count($arrRes) - 1];
      unset($arr);
      if (strcasecmp($arrRes[count($arrRes) - 1], $last)) {
        unset($arrRes[count($arrRes) - 1]);
      }
      return implode(' ', $arrRes) . "...";
    }
    return $str;
  }

  /**
   * @modified by vos_khanhnq16
   * @param string $strInput
   * @param type $limit
   * @return type
   */
//  public static function getLimitString($strInput, $limit = 10)
//  {
//      //chuyennv2
//      if($strInput=='')
//	  return '';
//    //tuanbm2 them decode truoc khi substring
//    return vtSecurity::encodeOutput(VtHelper::subString(vtSecurity::decodeInput($strInput), $limit, '...', true));
//  }

  public static function replaceSpecialCharsFromWord($strInput)
  {
    $strInput = str_replace('“', '"', $strInput);
    $strInput = str_replace('”', '"', $strInput);
    return $strInput;
  }

  public static function getLimitString($strInput, $limit = 10)
  {
    $strInput = self::replaceSpecialCharsFromWord($strInput);

    //chuyennv2
    if ($strInput == '')
      return '';
    //tuanbm2 them decode truoc khi substring
    $str = vtSecurity::encodeOutput(VtHelper::subString(vtSecurity::decodeInput($strInput), $limit, '...', true));
    //    if($str==""){
    //      return vtSecurity::encodeOutput(VtHelper::subString(vtSecurity::decodeInput($strInput), $limit, '...', false));
    //    }
    //    if (!$str && $strInput) {
    //      $str = vtSecurity::encodeOutput(substr(vtSecurity::decodeInput($strInput), 0, $limit - 3), '...', true);
    //      //      $str = vtSecurity::encodeOutput(substr(vtSecurity::decodeInput($strInput), 0, $limit - 3) . '...');
    //    }


    return $str;
  }

  //truong hop $strInput ko bi encode boi symfony, return tu dong encode anti XSS
  public static function getLimitStringWithoutEncode($strInput, $limit = 10)
  {
    $strInput = self::replaceSpecialCharsFromWord($strInput);

//        $resultReturn = self::encodeOutput(VtHelper::subString($strInput, $limit, '...', true));
    return VtHelper::truncate($strInput, $limit, '...', true);
  }

  /*
   * @author tuanbm
   * Ham gui email toi nguoi dung
   * @static
   * @param: $to: Email toi nguoi nhan
   * @param $title: tieu de email
   * @param $body: noi dung email
   * $return (The number of sent emails)
   * 0: la khong co email nao duoc gui di
   * 1: la gui email thanh cong
   * -1: la co loi gui email
   */

  public static function SendEmail($to, $title, $body)
  {
    try {
      $mailer = sfContext::getInstance()->getMailer();
      $from = sfConfig::get('app_email_from');
      $message = $mailer->compose();
      $message->setSubject($title);
      $message->setTo($to);
      $message->setFrom($from);
      $message->setBody($body, 'text/html'); //text/plain
      //      $result = $mailer->composeAndSend($from, $to, $title, $body);
      $result = $mailer->send($message);
      return $result;
    } catch (exception $e) {
      //ghi log gui that bai
      return 0;
    }
  }

  public static function logInfo($objModule, $description)
  {
    try {
      $user = $objModule->getUser();
      $objectName = get_class($objModule);
      $actionName = $objModule->getActionName();
      $param = "";

      if ($actionName == "batch") {
        $actionName = $_POST['batch_action'];
        $ids = $_POST["ids"];
        $param = implode(",", $ids);
      }

      if ($user->getGuardUser() == null)
        $message = $objectName . "|" . $actionName . "|params:" . $param . "|" . $description;
      else
        $message = $objectName . "|" . $actionName . "|User:" . $user . "|params:" . $param . "|" . $description;

      //if (sfConfig::get('sf_logging_enabled')){
      //sfContext::getInstance()->getLogger()->notice($message);
      $objModule->logMessage($message, "notice");
      //}
    } catch (exception $e) {
      //      echo $e;
    }
  }

  /*
   * @author tuanbm
   * 2014/07/13
   * Ham get Image dung chung, de tra ve duong dan tuyet doi (Anh Goc)
   * @static
   * return: link day du ca http://server/media/....
   */

  public static function getUrlImagePath($imageName, $configDefaultImage = "app_url_media_default_image")
  {
    try {
      if (strlen($imageName) == 0) {
        return sfConfig::get($configDefaultImage);
      } else {
        $filename = sfConfig::get('sf_web_dir') . $imageName;
        if (is_file($filename)) {
          return sfConfig::get('sf_web_dir') . $imageName;
        } else {
          return sfConfig::get($configDefaultImage);
        }
      }
    } catch (Exception $e) {
      return sfConfig::get($configDefaultImage);
    }
  }

  /*
     * * Date: 2014/04/17
     * @author tuanbm
     * Ham get Image Thumbnail, de tra ve duong dan tuyet doi (Anh Thumbnail)
     * @static
     * return: link day du ca http://server/media/....
     * EX: $folderThumb="thumbnail",$width=150,$height=150,$configDefaultImage = "app_url_media_default_image"
     */

  public static function getImageThumbnail($imageName, $width, $height, $configDefaultImage = "app_url_media_default_image")
  {
    try {
      $folderThumbName = "uploads/thumbnails";
      //tuanbm: thu check xem Main Image co ton tai khong, neu ton tai thi generate ra anh thumbnail (Cai nay Do Keeng migrate ve)
      $full_path_file = sfConfig::get('sf_web_dir') . "/" . $folderThumbName . "/" . $imageName;
      $originalImage = sfConfig::get('sf_web_dir') . "/" . $imageName;
      if (is_file($originalImage)) {
        $file_name = basename($full_path_file);
        $folderThumb = str_replace($file_name, "", $full_path_file); //duong dan file
        if (!is_dir($folderThumb)) {
          @mkdir($folderThumb, 0744, true);
        }
        //neu ton tai $originalImage thi generate no ra anh thumbnail
        if ($height == 0) {
          $thumbnail = new sfThumbnail($width, $height, true, true, 60);
        } else {
          $thumbnail = new sfThumbnail($width, $height, false, true, 60);
        }

        $thumbnail->loadFile($originalImage);
        $thumbnail->save($full_path_file, 'image/jpeg');
        return sfConfig::get('app_url_media_images') . "/" . $folderThumbName . "/" . $imageName;
      }
      return sfConfig::get($configDefaultImage);
    } catch (Exception $ex) {
      return sfConfig::get($configDefaultImage);
    }
  }


  public static function getFullDirectoryImageFile($objectStr, $imageName, $configDefaultImage = "app_upload_media_images")
  {
    return sfConfig::get('app_url_media') . $imageName;
  }


  /**
   * @author hoangl
   * Ham loai bo tat ca cac the html
   * @static
   * @param       $str - Xau can loai bo tag
   * @param array $tags - Mang cac tag se strip, vi du: array('a', 'b')
   * @param bool $stripContent
   * @return mixed|string
   */
  public static function encodeOutput($string, $force = FALSE)
  {
    if (sfConfig::get('sf_escaping_strategy') == "1" && sfConfig::get('sf_escaping_method') == "ESC_SPECIALCHARS") {
      return self::strip_html_tags($string);
    }
    return $string;
  }

  /**
   * @author tuanbm2
   * Ham loai bo tat ca cac the html mac dinh loai bo array('script', 'iframe', 'noscript')
   * @static
   * @param       $str - Xau can loai bo tag
   * @param array $tags - Mang cac tag se strip, vi du: array('a', 'b')
   * @param bool $stripContent
   * @example: echo VtHelper::strip_html_default_tags($article->getBody())
   * @return mixed|string
   */
  public static function strip_html_default_tags($str)
  {
    return VtHelper::strip_html_tags($str, array('script', 'iframe', 'noscript'));
  }

  /**
   * @author tuanbm2
   * Ham loai bo tat ca cac the html mac dinh loai bo array('script', 'iframe', 'noscript')
   * @static
   * @param $str - Ham nay chi duoc dung doi voi  sf_escaping_strategy = 1 va sf_escaping_method=ESC_SPECIALCHARS
   * @return string
   */
  public static function strip_html_tags_and_decode($str)
  {
    //Ham nay chi duoc dung doi voi get du lieu hien thi sf_escaping_strategy = 1 va sf_escaping_method=ESC_SPECIALCHARS
    //tuyet doi ko dung de remove truoc khi save du lieu
    //do symfony tu dong encode HTML nen phai decode truoc khi remove Script
    $str = htmlspecialchars_decode($str); //co the dung ham $object->getSomething(ESC_RAW);//htmlspecialchars_decode($str, ENT_QUOTES);
    $str = VtHelper::strip_html_tags($str, array('script', 'iframe', 'noscript', 'embed'));
    return str_replace('<embed ', '', $str);
  }

  /**
   * @author hoangl
   * Ham loai bo tat ca cac the html
   * @static
   * @param       $str - Xau can loai bo tag
   * @param array $tags - Mang cac tag se strip, vi du: array('a', 'b')
   * @param bool $stripContent
   * @example: <?php echo VtHelper::strip_html_tags($article->getBody(), array('script', 'iframe', 'noscript'))?>
   * @return mixed|string
   */
  public static function strip_html_tags($str, $tags = array(), $stripContent = false)
  {
    if (empty($tags)) {
      $tags = array("br/", "hr/", "!--...--", '!doctype', 'a', 'abbr', 'address', 'area', 'article', 'aside', 'audio', 'b', 'base', 'bb', 'bdo', 'blockquote', 'body', 'br', 'button', 'canvas', 'caption', 'cite', 'code', 'col', 'colgroup', 'command', 'datagrid', 'datalist', 'dd', 'del', 'details', 'dfn', 'div', 'dl', 'dt', 'em', 'embed', 'eventsource', 'fieldset', 'figcaption', 'figure', 'footer', 'form', 'h1', 'h2', 'h3', 'h4', 'h5', 'h6', 'head', 'header', 'hgroup', 'hr', 'html', 'i', 'iframe', 'img', 'input', 'ins', 'kbd', 'keygen', 'label', 'legend', 'li', 'link', 'mark', 'map', 'menu', 'meta', 'meter', 'nav', 'noscript', 'object', 'ol', 'optgroup', 'option', 'output', 'p', 'param', 'pre', 'progress', 'q', 'ruby', 'rp', 'rt', 'samp', 'script', 'section', 'select', 'small', 'source', 'span', 'strong', 'style', 'sub', 'summary', 'sup', 'table', 'tbody', 'td', 'textarea', 'tfoot', 'th', 'thead', 'time', 'title', 'tr', 'ul', 'var', 'video', 'wbr');
    }
    $content = '';
    if (!is_array($tags)) {
      $tags = (strpos($str, '>') !== false ? explode('>', str_replace('<', '', $tags)) : array($tags));
      if (end($tags) == '')
        array_pop($tags);
    }
    foreach ($tags as $tag) {
      if ($stripContent)
        $content = '(.+</' . $tag . '(>|\s[^>]*>)|)';
      $str = preg_replace('#</?' . $tag . '(>|\s[^>]*>)' . $content . '#is', '', $str);
    }

    $str = trim($str, ' ');

    return $str;
  }

  /*
   * duynt10
   */

  public static function strip_html_tags_p($str, $tags = array(), $stripContent = false)
  {
    if (empty($tags)) {
      $tags = array("br/", "hr/", "!--...--", '!doctype', 'a', 'abbr', 'address', 'area', 'article', 'aside', 'audio', 'b', 'base', 'bb', 'bdo', 'blockquote', 'body', 'br', 'button', 'canvas', 'caption', 'cite', 'code', 'col', 'colgroup', 'command', 'datagrid', 'datalist', 'dd', 'del', 'details', 'dfn', 'div', 'dl', 'dt', 'em', 'embed', 'eventsource', 'fieldset', 'figcaption', 'figure', 'footer', 'form', 'h1', 'h2', 'h3', 'h4', 'h5', 'h6', 'head', 'header', 'hgroup', 'hr', 'html', 'i', 'iframe', 'img', 'input', 'ins', 'kbd', 'keygen', 'label', 'legend', 'li', 'link', 'mark', 'map', 'menu', 'meta', 'meter', 'nav', 'noscript', 'object', 'ol', 'optgroup', 'option', 'output', 'param', 'pre', 'progress', 'q', 'ruby', 'rp', 'rt', 'samp', 'script', 'section', 'select', 'small', 'source', 'span', 'strong', 'style', 'sub', 'summary', 'sup', 'table', 'tbody', 'td', 'textarea', 'tfoot', 'th', 'thead', 'time', 'title', 'tr', 'ul', 'var', 'video', 'wbr');
    }
    $content = '';
    if (!is_array($tags)) {
      $tags = (strpos($str, '>') !== false ? explode('>', str_replace('<', '', $tags)) : array($tags));
      if (end($tags) == '')
        array_pop($tags);
    }
    foreach ($tags as $tag) {
      if ($stripContent)
        $content = '(.+</' . $tag . '(>|\s[^>]*>)|)';
      $str = preg_replace('#</?' . $tag . '(>|\s[^>]*>)' . $content . '#is', '', $str);
    }

    $str = trim($str, ' ');

    return $str;
  }

  public static function strip_html_tags_no_script($str)
  {
    $str = VtHelper::strip_html_tags($str, array('script', 'iframe'));
    return $str;
  }

  /**
   * @author: ChuyenNV2
   * @param type $credentialModule
   * @return type
   */
  public static function isAdmin($credentialModule = '')
  {
    $isAdmin = (sfContext::getInstance()->getUser()->getGuardUser()->hasPermission('admin') == 1) ? true : false;
    $isAdminSong = (sfContext::getInstance()->getUser()->getGuardUser()->hasPermission($credentialModule) == 1) ? true : false;
    return ($isAdmin || $isAdminSong);
  }


  //tuanbm
  public static function createTokenCsrf()
  {
    //    echo $_SERVER['SERVER_NAME']; die();
    $domain = $_SERVER['SERVER_NAME'];
    sfContext::getInstance()->getResponse()->setCookie('sToken', uniqid(), NULL, "/", $domain
//            sfConfig::get("app_main_domain", "localhost")
    );
  }

  //tuanbm
  //ham su dung de generate ra the Embed Flash player(Su dung cho backend)
  public static function generateEmbedJwplayer($url, $width = "300", $height = "24")
  {
    return '<embed id="player" height="' . $height . '" width="' . $width . '"
           flashvars="file=' . $url . '&controlbar=top" wmode="transparent" allowfullscreen="true"
           allowscriptaccess="always" bgcolor="undefined"
           src="/js/player/player.swf" name="player" type="application/x-shockwave-flash">';
  }

  public static function generateEmbedJwplayerArticle($sPlayerId, $url, $width = "300", $height = "30", $image_path = "")
  {
    //tam thoi ko dung code nay, ly do code nay ko chay duoc tren IE8
    return "<input class='jwplayerArticle' type='hidden' value='" . $url . "," . $width . "," . $height . "," . $sPlayerId . "," . $image_path . "' />
     <div id='" . $sPlayerId . "' name='' ></div>";
  }

  public static function generateEmbedJwplayerFrontend($url, $width = "716", $height = "56")
  {
    //tam thoi ko dung code nay, ly do code nay ko chay duoc tren IE8, su dung: generateEmbedJwplayerArticle
    return '<object id="songPlayer" height="' . $height . '" width="' . $width . '" type="application/x-shockwave-flash" data="/js/player5.swf" style="visibility: visible;">'
    . '<param name="allowscriptaccess" value="always">'
    . '<param name="allowfullscreen" value="true">'
    . '<param name="seamlesstabbing" value="true">'
    . '<param name="wmode" value="opaque">'
    . '<param name="flashvars" value="id=songPlayer&name=songPlayer&file=' . $url . '&repeat=none&skin=/js/songPlayer.zip">'
    . '</object>';
  }

  //tuanbm ham xu ly convert cac ky tu dac biet @#|
  public static function replaceSpecialCharacterForXml($value)
  {
    //chu y: bat buoc phai tuan theo thu tu convert #, @ |
    //    $value = str_replace("#","&#35;",$value);
    //    $value = str_replace("@","&#64;",$value);
    //    $value = str_replace("|","&#124;",$value);
    //Su dung Ma Mo Rong ASCII de thay the ® ¶ ©
    return $value;
  }

  //tuanbm format date
  //format: 'd/m/Y' default
  //format: 'd/m/Y hh:mm'
  public static function formatDateTime($datetime, $pattern = "d/m/Y")
  {
    return date($pattern, strtotime($datetime));
  }

  public static function generateLinkIms($ims_id, $ims_name)
  {
    if ($ims_id > 0) {
      return "http://sangtao.imuzik.com.vn/ringtone/nhac-chuong-" . removeSignClass::removeSign($ims_name) . '/' . $ims_id;
    }
    return "";
  }

  //huynq28 format number
  //format: 'x.yyy.zzz' default
  public static function formatNumber($number, $delimiter = ",")
  {
    return number_format($number, 0, $delimiter, $delimiter);
  }

  public static function generateString($length = 8)
  {

    $string = "";
    $possible = "2346789bcdfghjkmnpqrtvwxyzBCDFGHJKLMNPQRTVWXYZ";

    $maxlength = strlen($possible);

    if ($length > $maxlength) {
      $length = $maxlength;
    }
    // set up a counter for how many characters are in
    $i = 0;
    // add random characters until $length is reached
    while ($i < $length) {
      // pick a random character from the possible ones
      $char = substr($possible, mt_rand(0, $maxlength - 1), 1);
      // have we already used this character?
      if (!strstr($string, $char)) {
        // no, so it's OK to add it onto the end of whatever we've already got...
        $string .= $char;

        $i++;
      }
    }
    return $string;
  }

  /**
   * Lay ra danh sach id tu lucene theo dieu kien, co tra lai phan trang
   * @author HoangL
   * @param $preQuery
   * @param $typeIndex
   * @param $pageNo
   * @param $pageSize
   * @return array|null
   */


  /**
   * Lay ra danh sach id tu lucene theo dieu kien, co tra lai phan trang
   * @author HoangL
   * @modify KhanhNQ16
   * @param $preQuery
   * @param $typeIndex
   * @param $pageNo
   * @param $pageSize
   * @return array|null
   */


  /**
   * Lay link anh thumbnail<br />
   * Vi du su dung:<br />
   * <img src="<?php VtHelper::getThumbUrl('/medias/2011/06/15/abc.jpg', 90, 60); ?>" />
   * @param string $source /medias/2011/06/15/abc.jpg (nam trong thu muc web!)
   * @param int $width
   * @param int $height
   * @return string /medias/2011/06/15/thumbs/abc_90_60.jpg
   */
//    public static function getThumbUrl($source, $width = null, $height = null, $type = '') {
//        $defaultImage = sfConfig::get('app_url_media_default_image');
//        $source = self::getUrlImagePath($type, $source);
//        if ($width == null && $height == null)
//            return (file_exists(sfConfig::get('sf_web_dir') . $source)) ? $source : $defaultImage;
//        if (empty($source)) {
//            return $defaultImage;
//        }
//
//        $mediasDir = sfConfig::get('sf_web_dir');
//
//        $fullPath = $mediasDir . $source;
//        $pos = strrpos($source, '/');
//        if ($pos !== false) {
//            $filename = substr($source, $pos + 1);
//
//            $app = sfContext::getInstance()->getConfiguration()->getApplication();
//            if ($app == 'front') {
//                $dir = '/cache' . '/f_' . substr($source, 1, $pos);
//            } else if ($app == 'mobile') {
//                $dir = '/cache' . '/m_' . substr($source, 1, $pos);
//            } else if ($app == 'admin') {
//                $dir = '/cache' . '/a_' . substr($source, 1, $pos);
//            }
//        } else {
//            return $defaultImage;
//        }
//
//        $pos = strrpos($filename, '.');
//        if ($pos !== false) {
//            $basename = substr($filename, 0, $pos);
//            $extension = substr($filename, $pos + 1);
//        } else {
//            return $defaultImage;
//            #return false;
//        }
//
//        if ($width == null) {
//            $thumbName = $basename . '_auto_' . $height . '.' . $extension;
//        } else if ($height == null) {
//            $thumbName = $basename . '_' . $width . '_auto.' . $extension;
//        } else {
//            $thumbName = $basename . '_' . $width . '_' . $height . '.' . $extension;
//        }
//
//        $fullThumbPath = $mediasDir . $dir . $thumbName;
//
//        # Neu thumbnail da ton tai roi thi khong can generate
//        if (file_exists($fullThumbPath)) {
//            return $dir . $thumbName;
//        }
//
//        # Neu thumbnail chua ton tai thi su dung plugin de tao ra
//        $scale = ($width != null && $height != null) ? false : true;
//        $thumbnail = new sfThumbnail($width, $height, $scale, true, 100);
//        if (!is_file($fullPath)) {
//            return $defaultImage;
//        }
//        $thumbnail->loadFile($fullPath);
//
//        if (!is_dir($mediasDir . $dir))
//            mkdir($mediasDir . $dir, 0777, true);
//
//        $thumbnail->save($fullThumbPath, 'image/jpeg');
//        return (file_exists(sfConfig::get('sf_web_dir') . $dir . $thumbName)) ? $dir . $thumbName : $defaultImage;
//    }


  public static function getThumbUrl($source, $width = null, $height = null, $type = '')
  {

//    switch ($type) {
//      case 'app':
//        $defaultImage = sfConfig::get('app_url_media_default_image');
//        break;
//      default:
    $defaultImage = sfConfig::get('app_url_media_default_image');
//    }

    $mediasDir = sfConfig::get('sf_web_dir');

    if ($width == null && $height == null)
      return (file_exists($mediasDir . $source)) ? $source : $defaultImage;
    if (empty($source)) {
      return $defaultImage;
    }

    $fullPath = $mediasDir . $source;
    $pos = strrpos($source, '/');
    if ($pos !== false) {
      $filename = substr($source, $pos + 1);

      $app = sfContext::getInstance()->getConfiguration()->getApplication();
      switch ($app) {
        default:
          $dir = '/cache/' . substr($source, 1, $pos);
      }
    } else {
      return $defaultImage;
#return false;
    }

    $pos = strrpos($filename, '.');
    if ($pos !== false) {
      $basename = substr($filename, 0, $pos);
      $extension = substr($filename, $pos + 1);
      if (strtolower($extension) == 'bmp') {
        $fullPath = VtBmpImageConvert::ImageCreateFromBmp($mediasDir . $source);
        $extension = 'jpg';
      }
    } else {
      return $defaultImage;
#return false;
    }

    if ($width == null) {
      $thumbName = $basename . '_auto_' . $height . '.' . $extension;
    } else if ($height == null) {
      $thumbName = $basename . '_' . $width . '_auto.' . $extension;
    } else {
      $thumbName = $basename . '_' . $width . '_' . $height . '.' . $extension;
    }

    $fullThumbPath = $mediasDir . $dir . $thumbName;
# Neu thumbnail da ton tai roi thi khong can generate
    if (file_exists($fullThumbPath)) {
      return $dir . $thumbName;
    }

# Neu thumbnail chua ton tai thi su dung plugin de tao ra
    $scale = ($width != null && $height != null) ? false : true;
    $thumbnail = new sfThumbnail($width, $height, $scale, true, 100);
    if (!is_file($fullPath)) {
      return $defaultImage;
    }
    $thumbnail->loadFile($fullPath);

    if (!is_dir($mediasDir . $dir))
      mkdir($mediasDir . $dir, 0777, true);
    $thumbnail->save($fullThumbPath, 'image/jpeg');
    return (file_exists($mediasDir . $dir . $thumbName)) ? $dir . $thumbName : $defaultImage;
  }

  /**
   * Ham tra ve duong dan theo ngay thang nam hoac theo duong dan truyen vao
   * @author NamDT5
   * @created on 29/09/2012
   * @param string $path
   * @param boolean $byDate
   * @return mixed
   */
  public static function generatePath($path = '', $byDate = true)
  {
    if ($byDate) {
      if ($path)
        $folder = $path . '/' . date('Y') . '/' . date('m') . '/' . date('d') . "/";
      else
        $folder = date('Y') . '/' . date('m') . '/' . date('d') . "/";
    } else {
      $folder = $path . '/';
    }
    $fullDir = sfConfig::get('sf_web_dir') . $folder;
    if (!is_dir($fullDir)) {
      @mkdir($fullDir, 0777, true);
    }
    return $folder;
  }

  /**
   * @author vos_khanhnq16
   * @return string
   */
  public static function generateHashPath()
  {
    $mash = 255;
    $hashCode = crc32(uniqid()); //md5(serialize($fileName));
    $firstDir = $hashCode & $mash;
    $firstDir = vsprintf("%02x", $firstDir);
    $secondDir = ($hashCode >> 8) & $mash;
    $secondDir = vsprintf("%02x", $secondDir);
    $thirdDir = ($hashCode >> 4) & $mash;
    $thirdDir = vsprintf("%02x", $thirdDir);
    return $firstDir . "/" . $secondDir . "/" . $thirdDir;
  }

  public static function generateFileUploadPath()
  {
    $mash = 255;
    $fileName = uniqid();
    $hashCode = crc32($fileName); //md5(serialize($fileName));
    $firstDir = $hashCode & $mash;
    $firstDir = vsprintf("%02x", $firstDir);
    $secondDir = ($hashCode >> 8) & $mash;
    $secondDir = vsprintf("%02x", $secondDir);
    $thirdDir = ($hashCode >> 4) & $mash;
    $thirdDir = vsprintf("%02x", $thirdDir);
    return $firstDir . DIRECTORY_SEPARATOR . $secondDir . DIRECTORY_SEPARATOR . $thirdDir . DIRECTORY_SEPARATOR . $fileName;
  }

  public static function createFileUpload($file, $tempFile, $fileMode = 0666, $create = true, $dirMode = 0777)
  {
    // get our directory path from the destination filename
    $directory = dirname($file);

    if (!is_readable($directory)) {
      if ($create && !@mkdir($directory, $dirMode, true)) {
        // failed to create the directory
        throw new Exception(sprintf('Failed to create file upload directory "%s".', $directory));
      }

      // chmod the directory since it doesn't seem to work on recursive paths
      chmod($directory, $dirMode);
    }

    if (!is_dir($directory)) {
      // the directory path exists but it's not a directory
      throw new Exception(sprintf('File upload path "%s" exists, but is not a directory.', $directory));
    }

    if (!is_writable($directory)) {
      // the directory isn't writable
      throw new Exception(sprintf('File upload path "%s" is not writable.', $directory));
    }

    // copy the temp file to the destination file
    copy($tempFile, $file);

    // chmod our file
    chmod($file, $fileMode);
  }

  public static function formatDurationTime($duration, $delimiter = ':')
  {
    $seconds = $duration % 60;
    $minutes = floor($duration / 60);
    $hours = floor($duration / 3600);
    $seconds = str_pad($seconds, 2, "0", STR_PAD_LEFT);
    $minutes = str_pad($minutes, 2, "0", STR_PAD_LEFT) . $delimiter;
    if ($hours > 0) {
      $hours = str_pad($hours, 2, "0", STR_PAD_LEFT) . $delimiter;
    } else {
      $hours = '';
    }
    return "$hours$minutes$seconds";
  }

  /**
   * replace apostrophe
   * @param type $inputString
   * @return string
   */
  public static function replaceApostrophe($inputString)
  {
    if (!$inputString)
      return "";
    $replaced_string = array('\'', '"');
    $output_str = str_replace($replaced_string, "\'", vtSecurity::decodeInput($inputString));
    return vtSecurity::encodeOutput($output_str);
//    return str_replace('"', '\\\"', $inputString);
  }

  /**
   * Replace het cac ky tu dac biet
   * @param $str
   * @return mixed
   */
  public static function replaceSpecialChar($str)
  {
    $specialChar = array(
      unichr(160), //'\xA0',     // space
      # '\x60',     //
      # '\xB4',     //
      unichr(8216), // '\x2018',   // left single quotation mark
      unichr(8217), // '\x2019',   // right single quotation mark
      unichr(8220), // '\x201C',   // left double quotation mark
      unichr(8221), // '\x201D'    // right double quotation mark
      unichr(130), // baseline single quote
      unichr(145), // left single quote
      unichr(146), // right single quote)
      unichr(147), // right single quote)
      unichr(148), // right single quote)
    );
    $specialCharReplace = array(
      ' ', // space
      # '\x60',     //
      # '\xB4',     //
      "'", // left single quotation mark
      "'", // right single quotation mark
      '"', // left double quotation mark
      '"', // right double quotation mark
      ',', // baseline single quote
      "'", // 145
      "'", // 146
      '"', // 147
      '"', // 148
    );
    return str_replace($specialChar, $specialCharReplace, $str);
  }

  /**
   * author: thongnq1
   * han thuc hien kiem tra xem so thue bao co phai cua viettel khong
   */
  public static function checkViettelPhoneNumber($phoneNumber)
  {
    if (preg_match(sfConfig::get('app_viettel_phone_expression'), $phoneNumber)) {
      return true;
    }
    return false;
  }

  public static function datapost($URLServer, $postdata)
  {
    $agent = "Mozilla/5.0";
    $cURL_Session = curl_init();
    curl_setopt($cURL_Session, CURLOPT_URL, $URLServer);
    curl_setopt($cURL_Session, CURLOPT_USERAGENT, $agent);
    curl_setopt($cURL_Session, CURLOPT_POST, 1);
    curl_setopt($cURL_Session, CURLOPT_POSTFIELDS, $postdata);
    curl_setopt($cURL_Session, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($cURL_Session, CURLOPT_FOLLOWLOCATION, 1);
    $result = curl_exec($cURL_Session);
    return $result;
  }

  //loilv4
  public static function getUrlBannerPath($objectStr, $fileName)
  {
    if (strlen($fileName) == 0) {
      return "";
    } else {
      return VtHelper::getUrlImagePathThumb($objectStr, $fileName);
    }
  }

  /**
   * @author loilv4
   * Ham loai bo tat ca cac the html mac dinh loai bo array('script', 'iframe', 'noscript') va loai bo ca the 'p'
   */
  public static function strip_html_tags_and_decode_p($str)
  {
    //Ham nay chi duoc dung doi voi get du lieu hien thi sf_escaping_strategy = 1 va sf_escaping_method=ESC_SPECIALCHARS
    //tuyet doi ko dung de remove truoc khi save du lieu
    //do symfony tu dong encode HTML nen phai decode truoc khi remove Script
    $str = htmlspecialchars_decode($str); //co the dung ham $object->getSomething(ESC_RAW);//htmlspecialchars_decode($str, ENT_QUOTES);
    $str = VtHelper::strip_html_tags($str, array('script', 'iframe', 'noscript', 'embed', 'p', 'br'));
    return str_replace('<embed ', '', $str);
  }

  /*
   * duynt10
   * remove all tag <p> , <li>,....
   * use for song lyric
   */

  public static function strip_html_tags_and_decode_songlyric($str)
  {
    //Ham nay chi duoc dung doi voi get du lieu hien thi sf_escaping_strategy = 1 va sf_escaping_method=ESC_SPECIALCHARS
    //tuyet doi ko dung de remove truoc khi save du lieu
    //do symfony tu dong encode HTML nen phai decode truoc khi remove Script
    $str = htmlspecialchars_decode($str); //co the dung ham $object->getSomething(ESC_RAW);//htmlspecialchars_decode($str, ENT_QUOTES);
    $str = VtHelper::strip_html_tags($str, array('script', 'iframe', 'noscript', 'embed', 'p', 'li', 'ul', "br/", "hr/", "!--...--", '!doctype', 'a', 'abbr', 'address', 'area', 'article', 'aside', 'audio', 'b', 'base', 'bb', 'bdo', 'blockquote', 'body', 'br', 'button', 'canvas', 'caption', 'cite', 'code', 'col', 'colgroup', 'command', 'datagrid', 'datalist', 'dd', 'del', 'details', 'dfn', 'div', 'dl', 'dt', 'em', 'embed', 'eventsource', 'fieldset', 'figcaption', 'figure', 'footer', 'form', 'h1', 'h2', 'h3', 'h4', 'h5', 'h6',
      'head', 'header', 'hgroup', 'hr', 'html', 'i', 'iframe', 'img', 'input', 'ins', 'kbd', 'keygen', 'label', 'legend', 'li', 'link', 'mark', 'map', 'menu', 'meta', 'meter', 'nav', 'noscript', 'object', 'ol', 'optgroup', 'option', 'output', 'p', 'param', 'pre', 'progress', 'q', 'ruby', 'rp', 'rt', 'samp', 'script', 'section', 'select', 'small', 'source', 'span', 'strong', 'style', 'sub', 'summary', 'sup', 'table', 'tbody', 'td', 'textarea', 'tfoot', 'th', 'thead', 'time',
      'title', 'tr', 'ul', 'var', 'video', 'wbr'));
    return str_replace('<embed ', '', $str);
  }

  /*
   * loilv4
   * chuyen cac ky tu tieng viet co dau sang khong
   * use for song lyric
   */

  public static function removeSign($str)
  {
    $hasSign = array(
      'à', 'á', 'ạ', 'ả', 'ã', 'â', 'ầ', 'ấ', 'ậ', 'ẩ', 'ẫ', 'ă', 'ằ', 'ắ', 'ặ', 'ẳ', 'ẵ', '&agrave;', '&aacute;', '&acirc;', '&atilde;',
      'è', 'é', 'ẹ', 'ẻ', 'ẽ', 'ê', 'ề', 'ế', 'ệ', 'ể', 'ễ', '&egrave;', '&eacute;', '&ecirc;',
      'ì', 'í', 'ị', 'ỉ', 'ĩ', '&igrave;', '&iacute;', '&icirc;',
      'ò', 'ó', 'ọ', 'ỏ', 'õ', 'ô', 'ồ', 'ố', 'ộ', 'ổ', 'ỗ', 'ơ', 'ờ', 'ớ', 'ợ', 'ở', 'ỡ', '&ograve;', '&oacute;', '&ocirc;', '&otilde;',
      'ù', 'ú', 'ụ', 'ủ', 'ũ', 'ư', 'ừ', 'ứ', 'ự', 'ử', 'ữ', '&ugrave;', '&uacute;',
      'ỳ', 'ý', 'ỵ', 'ỷ', 'ỹ', '&yacute;',
      'đ', '&eth;',
      'À', 'Á', 'Ạ', 'Ả', 'Ã', 'Â', 'Ầ', 'Ấ', 'Ậ', 'Ẩ', 'Ẫ', 'Ă', 'Ằ', 'Ắ', 'Ặ', 'Ẳ', 'Ẵ', '&Agrave;', '&Aacute;', '&Acirc;', '&Atilde;',
      'È', 'É', 'Ẹ', 'Ẻ', 'Ẽ', 'Ê', 'Ề', 'Ế', 'Ệ', 'Ể', 'Ễ', '&Egrave;', '&Eacute;', '&Ecirc;',
      'Ì', 'Í', 'Ị', 'Ỉ', 'Ĩ', '&Igrave;', '&Iacute;', '&Icirc;',
      'Ò', 'Ó', 'Ọ', 'Ỏ', 'Õ', 'Ô', 'Ồ', 'Ố', 'Ộ', 'Ổ', 'Ỗ', 'Ơ', 'Ờ', 'Ớ', 'Ợ', 'Ở', 'Ỡ', '&Ograve;', '&Oacute;', '&Ocirc;', '&Otilde;',
      'Ù', 'Ú', 'Ụ', 'Ủ', 'Ũ', 'Ư', 'Ừ', 'Ứ', 'Ự', 'Ử', 'Ữ', '&Ugrave;', '&Uacute;',
      'Ỳ', 'Ý', 'Ỵ', 'Ỷ', 'Ỹ', '&Yacute;',
      'Đ', '&ETH;',
    );
    $noSign = array(
      'a', 'a', 'a', 'a', 'a', 'a', 'a', 'a', 'a', 'a', 'a', 'a', 'a', 'a', 'a', 'a', 'a', 'a', 'a', 'a', 'a',
      'e', 'e', 'e', 'e', 'e', 'e', 'e', 'e', 'e', 'e', 'e', 'e', 'e', 'e',
      'i', 'i', 'i', 'i', 'i', 'i', 'i', 'i',
      'o', 'o', 'o', 'o', 'o', 'o', 'o', 'o', 'o', 'o', 'o', 'o', 'o', 'o', 'o', 'o', 'o', 'o', 'o', 'o', 'o',
      'u', 'u', 'u', 'u', 'u', 'u', 'u', 'u', 'u', 'u', 'u', 'u', 'u',
      'y', 'y', 'y', 'y', 'y', 'y',
      'd', 'd',
      'A', 'A', 'A', 'A', 'A', 'A', 'A', 'A', 'A', 'A', 'A', 'A', 'A', 'A', 'A', 'A', 'A', 'A', 'A', 'A', 'A',
      'E', 'E', 'E', 'E', 'E', 'E', 'E', 'E', 'E', 'E', 'E', 'E', 'E', 'E',
      'I', 'I', 'I', 'I', 'I', 'I', 'I', 'I',
      'O', 'O', 'O', 'O', 'O', 'O', 'O', 'O', 'O', 'O', 'O', 'O', 'O', 'O', 'O', 'O', 'O', 'O', 'O', 'O', 'O',
      'U', 'U', 'U', 'U', 'U', 'U', 'U', 'U', 'U', 'U', 'U', 'U', 'U',
      'Y', 'Y', 'Y', 'Y', 'Y', 'Y',
      'D', 'D'
    );

    $str = str_replace($hasSign, $noSign, $str);
    return $str;
  }

  /**
   * Check datetime
   * @author HoangL
   * @param $dateTime
   * @return bool
   */
  public static function checkDateTime($dateTime)
  {
    if (preg_match("/^(\d{2})-(\d{2})-(\d{4}) ([01][0-9]|2[0-3]):([0-5][0-9]):([0-5][0-9])$/", $dateTime, $matches)) {
      if (count($matches) >= 6 && checkdate($matches[2], $matches[1], $matches[3])) {
        return true;
      }
    }
    return false;
  }

  /**
   * Kiem tra moi gia tri mang $childArray co thuoc mang $parentArray ko?
   * @param $childArray
   * @param $parentArray
   * @return bool
   */
  public static function checkChildArray($childArray, $parentArray)
  {
    foreach ($childArray as $child) {
      if (!in_array($child, $parentArray)) {
        return false;
      }
    }
    return true;
  }

  /**
   * giup filter tim kiem cac ky tu dac biet %,_..
   * @author vos_khanhnq16
   * @date 24/01/2013
   * @param $string
   * @return mixed
   */
  public static function filterSpecialCharacter($string)
  {
    return self::preProcessForSearchLike($string);
//        if(($string != '')){
//            $string = str_replace("%","\\%",$string);
//            $string = str_replace("_","\\_",$string);
////            die($string);
//        }
//        return $string;
  }

  /**
   * Ham xu ly generate ra cau truc duong dan file dua vao ten file
   * @param $uniqueFileName
   * @return string
   */
  public static function generateStructurePath($uniqueFileName)
  {
    //$uiq = uniqid(1,true);
    //$fileName = hash('sha1',$uiq);
    $mash = 255;
    $hashCode = crc32($uniqueFileName); //md5(serialize($fileName));
    $firstDir = $hashCode & $mash;
    $firstDir = vsprintf("%02x", $firstDir);
    $secondDir = ($hashCode >> 8) & $mash;
    $secondDir = vsprintf("%02x", $secondDir);
    $thirdDir = ($hashCode >> 4) & $mash;
    $thirdDir = vsprintf("%02x", $thirdDir);
    return $firstDir . "/" . $secondDir . "/" . $thirdDir;
  }

  //ma hoa mat khau
  public static function encryptPassword($username, $password)
  {
    $toLowerUsername = strtolower($username);
    $passwordVal = $toLowerUsername . $password;
    return base64_encode(sha1(mb_convert_encoding($passwordVal, 'utf-16le', 'ascii'), true));
  }

  /**
   * @author huynq28-120928
   * @return string
   */
  public static function randomPassword()
  {
    $alphabet = "abcdefghijklmnopqrstuwxyzABCDEFGHIJKLMNOPQRSTUWXYZ0123456789";
    $pass = array(); //remember to declare $pass as an array
    for ($i = 0; $i < 8; $i++) {
      $n = rand(0, strlen($alphabet) - 1); //use strlen instead of count
      $pass[$i] = $alphabet[$n];
    }
    return implode($pass); //turn the array into a string
  }

  /*     * ***** Ham get sdt neu dung tu dt   **** */

  /**
   * Tra ve IP cua thiet bi truy cap
   * @author NamDT5
   * @created on Mar 26, 2012
   * @return string
   */
  public static function getDeviceIp()
  {
    if (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
      $mobileIp = $_SERVER['HTTP_X_FORWARDED_FOR'];
    } else {
      $mobileIp = $_SERVER['REMOTE_ADDR'];
    }

    return trim($mobileIp);
  }

  /**
   * Ham kiem tra Ip co nam trong dai V-internet cua viettel khong
   * @author NamDT5
   * @created on 17/01/2013
   * @param $ip
   * @return bool
   */
  public static function isV_wapIp($ip)
  {
    $vInternetRange = sfConfig::get('app_ip_pool_v_wap');
    if (!empty($vInternetRange)) {
      foreach ($vInternetRange as $range) {
        $netArr = explode("/", $range);
        if (self::ipInNetwork($ip, $netArr[0], $netArr[1])) {
          return true;
        }
      }
    }
    return false;
  }

  /**
   * Ham kiem tra IP co nam trong dai IP cho phep khong
   * Tham khao: http://php.net/manual/en/function.ip2long.php
   * @author NamDT5
   * @created on 17/01/2013
   * @param $ip
   * @param $netAddr
   * @param $netMask
   * @return bool
   */
  public static function ipInNetwork($ip, $netAddr, $netMask)
  {
    if ($netMask <= 0) {
      return false;
    }
    $ipBinaryString = sprintf("%032b", ip2long($ip));
    $netBinaryString = sprintf("%032b", ip2long($netAddr));
    return (substr_compare($ipBinaryString, $netBinaryString, 0, $netMask) === 0);
  }

  /**
   * Ham kiem tra Ip co nam trong dai V-internet cua viettel khong
   * @author NamDT5
   * @created on 17/01/2013
   * @param $ip
   * @return bool
   */
  public static function isV_internetIp($ip)
  {
    $vInternetRange = sfConfig::get('app_ip_pool_v_internet');
    if (!empty($vInternetRange)) {
      foreach ($vInternetRange as $range) {
        $netArr = explode("/", $range);
        if (self::ipInNetwork($ip, $netArr[0], $netArr[1])) {
          return true;
        }
      }
    }
    return false;
  }


  public static final function convertMsisdn($msisdn, $type)
  {
    if ($msisdn != "") {
      switch ($type) {
        case self::MOBILE_GLOBAL:
          if ($msisdn[0] == '0')
            return '84' . substr($msisdn, 1);
          else if ($msisdn[0] . $msisdn[1] != '84')
            return '84' . $msisdn;
          else
            return $msisdn;
          break;
        case self::MOBILE_SIMPLE:
          if ($msisdn[0] == '0')
            return substr($msisdn, 1);
          else if ($msisdn[0] . $msisdn[1] == '84')
            return substr($msisdn, 2);
          else
            return $msisdn;
          break;
        default:
          if ($msisdn[0] == '0')
            return '84' . substr($msisdn, 1);
          else if ($msisdn[0] . $msisdn[1] != '84')
            return '84' . $msisdn;
          else
            return $msisdn;
          break;
      }
    }
  }

  /**
   * get msisdn
   */
  public static function getMsisdn()
  {

    $ip = self::getDeviceIp();
    if (!$ip) {
      return 'unknown';
    }

    if (self::isV_wapIp($ip)) {
      return (isset($_SERVER['HTTP_MSISDN']) && $_SERVER['HTTP_MSISDN'] != 'unknown') ? self::getMobileNumber($_SERVER['HTTP_MSISDN'], self::MOBILE_GLOBAL) : 'unknown';
    } elseif (self::isV_internetIp($ip)) {
      // Neu nam trong dai v-internet --> goi radius
      $param = array(
        'username' => sfConfig::get('app_radius_username'),
        'password' => sfConfig::get('app_radius_password'),
        'ip' => $ip
      );

      $options = array('connect_timeout' => sfConfig::get('app_radius_connect_timeout', 5), 'timeout' => sfConfig::get('app_radius_timeout', 5));
      try {
        $client = new SoapClient(sfConfig::get('app_radius_wsdl'), $options);

        $result = $client->__soapCall('getMSISDN', array($param));

        if (is_object($result)) {
          if ($result->return->code == 0) {
            return ($result->return->desc != 'unknown') ? self::convertMsisdn($result->return->desc, self::MOBILE_GLOBAL) : $result->return->desc;
          } else {
            sfContext::getInstance()->getLogger()->log(date('Y-m-d H:i:s') . ' GET MSISDN: ' . $ip . ' -> ' . $result->return->desc . '\n');
            return 'unknown';
          }
        } else {
          sfContext::getInstance()->getLogger()->log(date('Y-m-d H:i:s') . ' GET MSISDN: ' . $ip . ' -> response no object!');
          return 'unknown';
        }
      } catch (Exception $e) {
        if (sfConfig::get('sf_environment') == 'dev') {
          echo 'Error ' . $e->getCode() . ': ' . $e->getMessage();
        }
        return 'unknown';
      }
    }
    // Neu khong thuoc cac dai cua viettel --> khong xu ly
    return 'unknown';
  }

  public static function endsWith($haystack, $needle)
  {
    $length = strlen($needle);
    if ($length == 0) {
      return true;
    }
    return (substr($haystack, -$length) === $needle);
  }

  /**
   * @description : Chuyen doi cac ky tu dac biet trong cau truy van sql
   * loai bo cac ky tu \,%,_
   * @param type $str
   * @param type $trim trim string hoac khong
   * @author : nghiald <nghiald@viettel.com.vn>
   * @created_at : 11/6/13 4:31 PM
   * @return : public
   *
   */
  /**
   * Chuyen doi cac ky tu dac biet trong cau truy van sql loai bo cac ky tu \,%,_
   * @author anhbhv
   * @created at 22/09/2014
   * @param $str
   * @param bool $trim
   * @return string
   */
  public static function translateQuery($str, $trim = true)
  {
    if ($str == null || $str == '')
      return $str;
    $str = $trim ? trim($str) : $str;
    $str = addcslashes($str, "\\%_");
    return $str;
  }

  public static function getClientIP()
  {
    if (isset($_SERVER['HTTP_CLIENT_IP'])) {
      $ipaddress = $_SERVER['HTTP_CLIENT_IP'];
    } else if (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
      $ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
    } else if (isset($_SERVER['HTTP_X_FORWARDED'])) {
      $ipaddress = $_SERVER['HTTP_X_FORWARDED'];
    } else if (isset($_SERVER['HTTP_FORWARDED_FOR'])) {
      $ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
    } else if (isset($_SERVER['HTTP_FORWARDED'])) {
      $ipaddress = $_SERVER['HTTP_FORWARDED'];
    } else if (isset($_SERVER['REMOTE_ADDR'])) {
      $ipaddress = $_SERVER['REMOTE_ADDR'];
    } else {
      $ipaddress = 'UNKNOWN';
    }
    return $ipaddress;
  }

  public static function writeLogValue($content, $fileName = 'default.log')
  {
    $fileName = $fileName . "." . date("Y-m-d");
    $logger = new sfFileLogger(new sfEventDispatcher(), array('file' => sfConfig::get('sf_log_dir') . '/' . $fileName));
    $logger->log($content, sfFileLogger::INFO);
  }

  /**
   * Ham kiem tra 2 khoang thoi gian co bi trung nhau khong
   * @author anhbhv
   * @created on 16/10/2014
   * @param $start_one
   * @param $end_one
   * @param $start_two
   * @param $end_two
   * @return int
   */
  public static function datesOverlap($start_one, $end_one, $start_two, $end_two)
  {
    $start_one = new DateTime($start_one);
    $end_one = new DateTime($end_one);
    $start_two = new DateTime($start_two);
    $end_two = new DateTime($end_two);
    if ($start_one <= $end_two && $end_one >= $start_two) { //If the dates overlap
      return min($end_one, $end_two)->diff(max($start_two, $start_one))->days + 1; //return how many days overlap
    }

    return 0; //Return 0 if there is no overlap
  }

  public static function numberClean($num)
  {

    //remove zeros from end of number ie. 140.00000 becomes 140.
    $clean = rtrim($num, '0');
    //remove decimal point if an integer ie. 140. becomes 140
    $clean = rtrim($clean, '.');

    return $clean;
  }

  public static function getDayByDate($date, $format = 'd/m/Y H:i:s')
  {
    date_default_timezone_set('Asia/Ho_Chi_Minh');
    $weekday = date("l", strtotime($date));
    $weekday = strtolower($weekday);
    switch ($weekday) {
      case 'monday':
        $weekday = 'Thứ hai';
        break;
      case 'tuesday':
        $weekday = 'Thứ ba';
        break;
      case 'wednesday':
        $weekday = 'Thứ tư';
        break;
      case 'thursday':
        $weekday = 'Thứ năm';
        break;
      case 'friday':
        $weekday = 'Thứ sáu';
        break;
      case 'saturday':
        $weekday = 'Thứ bảy';
        break;
      default:
        $weekday = 'Chủ nhật';
        break;
    }
    return $weekday . ', Ngày ' . date($format, strtotime($date));
  }

  /**
   * Hàm dấu số điện thoại
   * @param $phone
   * @param $start
   * @param $length
   * @param string $char
   * @return string
   */
  public static function hidePhonenumber($phone, $length, $char = '*')
  {
    $pl = strlen($phone); // phone length
    $masked = str_pad(substr($phone, 0, -$length), $pl, $char, STR_PAD_RIGHT);
    return $masked;
  }

  /**
   * Ham lay thong tin luot share, like, comment... theo url truyen vao
   * @param $url
   * @return mixed
   */
  public static function facebookCount($url){
    // Query in FQL
    $fql  = "SELECT total_count, share_count, like_count, comment_count, click_count ";
    $fql .= " FROM link_stat WHERE url = '".$url."'";
    $fqlURL = "https://api.facebook.com/method/fql.query?format=json&query=" . urlencode($fql);
    // Facebook Response is in JSON
    $response = file_get_contents($fqlURL);
    VtHelper::writeLogValue('url: '.$fqlURL.' | facebook: '.$response);
    return json_decode($response);
  }

  public static function generateCode($length = 8){
    return $length ? substr(md5(uniqid(mt_rand(), true)) , 0, $length) : md5(uniqid(mt_rand(), true));
  }

  /**
   * getRandomWeightedElement()
   * Utility function for getting random values with weighting.
   * Pass in an associative array, such as array('A'=>5, 'B'=>45, 'C'=>50)
   * An array like this means that "A" has a 5% chance of being selected, "B" 45%, and "C" 50%.
   * The return value is the array key, A, B, or C in this case.  Note that the values assigned
   * do not have to be percentages.  The values are simply relative to each other.  If one value
   * weight was 2, and the other weight of 1, the value with the weight of 2 has about a 66%
   * chance of being selected.  Also note that weights should be integers.
   *
   * @param array $weightedValues
   */
  public static function getRandomWeightedElement(array $weightedValues) {
    $rand = mt_rand(1, (int) array_sum($weightedValues));

    foreach ($weightedValues as $key => $value) {
      $rand -= $value;
      if ($rand <= 0) {
        return $key;
      }
    }
  }
}

//@tungtd2
// function to call post webservice QTAN

/**
 * Chuyen doi ky tu ASCII ve dang chuan UNICODE
 * @author HoangL
 * @param        $unicode
 * @param string $encoding
 * @return string
 */
function unichr($unicode, $encoding = 'UTF-8')
{
  return mb_convert_encoding("&#{$unicode};", $encoding, 'HTML-ENTITIES');
}

/**
 * Tra ve ma ASCII
 * @param        $string
 * @param string $encoding
 * @return mixed
 */
function uniord($string, $encoding = 'UTF-8')
{
  $entity = mb_encode_numericentity($string, array(0x0, 0xffff, 0, 0xffff), $encoding);
  return preg_replace('`^&#([0-9]+);.*$`', '\\1', $entity);
}


