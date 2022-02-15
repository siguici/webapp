<?php namespace Ske\Util\Http;

class Client {
    public function __construct() {
        $this->init();
    }

    public function init() {
        $this->curl = curl_init();
        curl_setopt($this->curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($this->curl, CURLOPT_HEADER, true);
        curl_setopt($this->curl, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($this->curl, CURLOPT_AUTOREFERER, true);
        curl_setopt($this->curl, CURLOPT_CONNECTTIMEOUT, 120);
        curl_setopt($this->curl, CURLOPT_TIMEOUT, 120);
        curl_setopt($this->curl, CURLOPT_MAXREDIRS, 10);
        curl_setopt($this->curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($this->curl, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($this->curl, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/33.0.1750.154 Safari/537.36');
    }

    public function get($url) {
        curl_setopt($this->curl, CURLOPT_URL, $url);
        curl_setopt($this->curl, CURLOPT_CUSTOMREQUEST, 'GET');
        return $this->exec();
    }

    public function post($url, $data) {
        curl_setopt($this->curl, CURLOPT_URL, $url);
        curl_setopt($this->curl, CURLOPT_CUSTOMREQUEST, 'POST');
        curl_setopt($this->curl, CURLOPT_POSTFIELDS, $data);
        return $this->exec();
    }

    public function put($url, $data) {
        curl_setopt($this->curl, CURLOPT_URL, $url);
        curl_setopt($this->curl, CURLOPT_CUSTOMREQUEST, 'PUT');
        curl_setopt($this->curl, CURLOPT_POSTFIELDS, $data);
        return $this->exec();
    }

    public function delete($url, $data) {
        curl_setopt($this->curl, CURLOPT_URL, $url);
        curl_setopt($this->curl, CURLOPT_CUSTOMREQUEST, 'DELETE');
        curl_setopt($this->curl, CURLOPT_POSTFIELDS, $data);
        return $this->exec();
    }

    public function patch($url, $data) {
        curl_setopt($this->curl, CURLOPT_URL, $url);
        curl_setopt($this->curl, CURLOPT_CUSTOMREQUEST, 'PATCH');
        curl_setopt($this->curl, CURLOPT_POSTFIELDS, $data);
        return $this->exec();
    }

    public function head($url) {
        curl_setopt($this->curl, CURLOPT_URL, $url);
        curl_setopt($this->curl, CURLOPT_CUSTOMREQUEST, 'HEAD');
        return $this->exec();
    }

    public function options($url) {
        curl_setopt($this->curl, CURLOPT_URL, $url);
        curl_setopt($this->curl, CURLOPT_CUSTOMREQUEST, 'OPTIONS');
        return $this->exec();
    }

    public function exec() {
        $response = curl_exec($this->curl);
        $headerSize = curl_getinfo($this->curl, CURLINFO_HEADER_SIZE);
        $code = curl_getinfo($ch, CURLINFO_HTTP_CODE)
        $header = substr($response, 0, $headerSize);
        $body = substr($response, $headerSize);
        return new Response($code, $header, $body);
    }

    public function open(strin $url, string $method, array $headers = [], array $data = []) {
        $headers = array_merge($headers, [
            'Accept: application/json',
            'Content-Type: application/json'
        ]);
        $data = json_encode($data);
        curl_setopt($this->curl, CURLOPT_URL, $url);
        curl_setopt($this->curl, CURLOPT_CUSTOMREQUEST, $method);
        curl_setopt($this->curl, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($this->curl, CURLOPT_POSTFIELDS, $data);
        return $this->exec();
    }

    public function send(Request $request) {
        curl_setopt($this->curl, CURLOPT_URL, $request->url);
        curl_setopt($this->curl, CURLOPT_CUSTOMREQUEST, $request->method);
        curl_setopt($this->curl, CURLOPT_HTTPHEADER, $request->headers);
        curl_setopt($this->curl, CURLOPT_POSTFIELDS, $request->data);
        return $this->exec();
    }

    public function close() {
        curl_close($this->curl);
    }

    public function __destruct() {
        $this->close();
    }
}