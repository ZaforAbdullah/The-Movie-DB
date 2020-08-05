<?php
require 'response.php';

class RequestHandler{

    private $method;
    private $query;
    private $response;

    public function __construct()
    {
        if ($_SERVER["REQUEST_METHOD"] == "POST" && $_REQUEST['submit']){
            $this->method = true;
            $this->query = $_POST['query'];
        }else{
            $this->method = false;
        }
        $this->response = new Response();
    }

    public function handleRequest()
    {
        if($this->method && !empty($this->query)){
            $this->response->search($this->query);
        }else{
            $this->response->returnError("resource not found", 404);
        }
    }
}