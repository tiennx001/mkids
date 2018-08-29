<?php

/**
 * Phục vụ cho việc gọi các restfull server
 * @author NghiaLD <nghiald@viettel.com>
 * @created_at: 4/16/14 11:08 AM
 */
class RestfullUtils
{

  const METHOD_POST = "POST"; // method post
  const METHOD_GET = "GET"; //method get
  const METHOD_PUT = "PUT"; //method put
  const METHOD_DELETE = "DELETE"; //method delete

  private $curl; //object cUrl phục vụ cho việc gọi rest full client

  /**
   * Khởi tạo REST Full
   * @param type $url - url truy xuất http://example.com/api
   * @param type $method - method POST,GET,PUT,DELETE
   * @param type $params - tham số truyền trong REST Full
   * <br/> Sử dụng định dạng: <pre/>
   * array (
   *      "param"=>"value",
   * );
   * @param type $authenticate - sử dụng trong trường hợp xác thực khi truy xuất vào REST Full,
   * <br/> sử dụng định dạng:
   * <pre/><b>(String)</b> "username:password";
   * @throws RestfullErrorException
   * @author NghiaLD <nghiald@viettel.com>
   * @created_at: 4/16/14 1:30 PM
   */

  public function __construct($url, $method, $params = false, $authenticate = false, $verifyHost = true)
  {
    $ch = curl_init();
    switch ($method) {
      case RestfullUtils::METHOD_GET:
        if ($params) {
          $url = sprintf("%s?%s", $url, http_build_query($params));
        }
        break;
      case RestfullUtils::METHOD_POST:
        curl_setopt($ch, CURLOPT_POST, true);
        if ($params) {
          curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
        }
        break;
      case RestfullUtils::METHOD_PUT:
        curl_setopt($ch, CURLOPT_PUT, true);
        if ($params) {
          curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($params));
        }
        break;
      case RestfullUtils::METHOD_DELETE:
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, RestfullUtils::METHOD_DELETE);
        if ($params) {
          curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
        }
        break;
      default:
        throw new RestfullErrorException(RestfullErrorCode::getMessage(RestfullErrorCode::METHOD_INVALID), RestfullErrorCode::METHOD_INVALID);
    }
    // Optional Authentication:
    if ($authenticate) {
      curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
      curl_setopt($ch, CURLOPT_USERPWD, $authenticate);
    }
    if (!$verifyHost) {
      curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
    }
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $this->curl = $ch;
  }

  /**
   * Thực hiện gọi tới REST Full
   * @return: dữ liệu trả về dưới dạng JSON
   * @throws RestfullErrorException
   * @author NghiaLD <nghiald@viettel.com>
   * @created_at: 4/16/14 1:47 PM
   */
  public function callService($assoc = false)
  {
    $response = curl_exec($this->curl);
    if ($response === false) {
      $error = curl_error($this->curl);
      curl_close($this->curl);
      VtHelper::writeLogValue("Error occured during curl exec.[Info]:" . var_export($error, true));
      return false;
    }
    curl_close($this->curl);

    return json_decode($response, $assoc);
  }

  /**
   * Thực hiện gọi tới REST Full
   * @return: dữ liệu trả về dưới dạng JSON
   * @throws RestfullErrorException
   * @author NghiaLD <nghiald@viettel.com>
   * @created_at: 4/16/14 1:47 PM
   */
  public function callHTTPRequest()
  {
    $response = curl_exec($this->curl);
    if ($response === false) {
      $error = curl_error($this->curl);
      curl_close($this->curl);
      VtHelper::writeLogValue("Error occured during curl exec.[Info]:" . var_export($error, true));
      return false;
    }
    curl_close($this->curl);

    return $response;
  }

}

