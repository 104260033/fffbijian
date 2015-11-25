<?php
/**
 * Created by PhpStorm.
 * User: ff
 * Date: 15/11/25
 * Time: 下午5:11
 */

namespace tools\scanner;


class Scanner
{
    protected $urls = array();
    protected $httpClient;

    public function __construct(array $urls)
    {
        $this->urls = $urls;
        $this->client = new GuzzleHttp\Client();
    }

    public function getInvalidUrls()
    {
        foreach ($this->urls as $url) {
            $code = $this->getHttpStatusCode($url);
            try{
                $statusCode = $code;
            }catch (\Exception $e){
                $statusCode = 500;
            }

            if($statusCode >= 400){
                array_push($invalidUrls,[
                    'url' => $url,
                    'code' => $statusCode,
                ]);
            }
        }

        return $invalidUrls;
    }

    public function getHttpStatusCode($url)
    {
        $httpResponse = $this->httpClient->request('GET',$url);
        return $httpResponse->getStatusCode();
    }
}