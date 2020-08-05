<?php

include_once ('moviecontroller.php');

class Response {
    private $moviecontroller;

    public function __construct() {
        $this->moviecontroller = new MovieController();
    }

    function returnError($error,$code){
        http_response_code($code);
        $res = json_encode(array("data"=>"","error"=>$error));
        die($res);
    }

    function returnData($data,$code){
        http_response_code($code);
        $res = "<table style='width:100%'>
        <tr>
          <th><center>Id</center></th>
          <th><center>Image</center></th>
          <th style='width:250px'><center>Title</center></th>
          <th><center>Description</center></th>
          <th>URL</th>
        </tr>";
        foreach ($data as $result){
            $res .= "<tr>
            <td><center>" . $result['id'] . "</center></td>
            <td><center><img src=". $result['location'] . " style='width:200px;height:300px;'></center></td>
            <td style='width:250px'><center>" . $result['title'] . "</center></td>
            <td><center>" . $result['description'] . "</center></td>
            <td><a href=" . $result['url'] . " target='_blank'>". $result['url'] ."</a></td>
          </tr>";
        }
        $result = 
        $res .= "</table>";
        die($res);
    }

    public function getAll($resource) {
        $results= array();

        $stmt = $this->moviecontroller->getAll();
        
        if($stmt){
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $result= array();
                foreach ($row as $key=>$value) {
                    $result[$key] = $value;
                }
                $results[]=$result;
            }
            $this->returnData($results,200);
        }else
            $this->returnError("the query returned empty result",406);
    }

    public function search($query) {
        $results= array();

        $stmt = $this->moviecontroller->search($query);
        
        if($stmt){
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $result= array();
                foreach ($row as $key=>$value) {
                    $result[$key] = $value;
                }
                $results[]=$result;
            }
            $this->returnData($results,200);
        }else
            $this->returnError("the query returned empty result",406);
    }

    public function get($resource, $id){

        $result = $this->moviecontroller->get($id);

        if($result){
            $results = $result;
            $this->returnData($results,200);
        }else{
            $this->returnError("item doesn't exist",404);
        }
    }

    public function delete($resource, $id){

        $result = $this->moviecontroller->get($id);
        if(!$result)
            $this->returnError("item doesn't exist",400);
        else{
            $result=$this->moviecontroller->delete($id);
            $this->queryResponse($result);
        }
    }

    public function update($resource, $id,$parameters){

        $result = $this->moviecontroller->get($id);
        if(!$result)
            $this->returnError("resource not found",404);
        else{
            $result=$this->moviecontroller->update($id,$parameters);
            $this->queryResponse($result);
        }
    }

    public function create($resource, $parameters){

        $result=$this->moviecontroller->create($parameters);

        $this->queryResponse($result);
    }

    private function queryResponse($res)
    {
        if ($res)
            $this->returnData("success", 201);
        else
            $this->returnError("something went wrong", 406);
    }
}