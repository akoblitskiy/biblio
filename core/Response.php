<?php
namespace Core;

class Response {
    protected $headers = [];
    protected $content;

    /**
     * @return array
     */
    public function getHeaders()
    {
        return $this->headers;
    }

    /**
     * @param string $header
     */
    public function setHeader($header)
    {
        $this->headers[] = $header;
    }

    /**
     * @return mixed
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * @param mixed $content
     */
    public function setContent($content)
    {
        $this->content = $content;
    }

    public function sendHeaders()
    {
        foreach ($this->headers as $header) {
            header($header);
        }
    }

    public static function redirect($url)
    {
        $response = new self();
        $response->setHeader('Location: ' . $url);
        $response->sendHeaders();
    }
}