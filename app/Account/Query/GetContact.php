<?php
namespace NewdichApp\Account\Query;

use OpenApi\Annotations as OA;
use NewdichApp\DTO\GetContactDTO;
use NewdichApp\Middleware\GetContactMid;

use PDO;
use PDOException;
/**
 *  @OA\Get(
 *      path="/getContactapi",
 *      summary="This endpoint is used for getting contact",
 *      description="This endpoint returns all the available user name",
 *      tags={"user name"},
 *      @OA\Parameter(
 *          name="user name",
 *          in="query",
 *          required=true,
 *          @OA\Schema(type="string"),
 *          example="johndon",
 *          description="The user name searching for"
 *      ),
 *      @OA\Response(
 *          response=200,
 *          description="success"
 *      ),
 *      @OA\Response(   
 *          response=400,
 *          description="bad request, missing parametr"
 *      ),
 *      @OA\Response(
 *          response=500,
 *          description="Internal server error"
 *      )
 *  )
 */

class GetContact{
    private GetContactDTO $dto;
    private GetContactMid $mid;

    public function __construct(GetContactDTO $d, GetContactMid $m){
        $this->dto = $d;
        $this->mid = $m;
    }

    public function getContact(){
        $username = $this->mid->cleanData($this->dto->user_name);
        try{
            include($_SERVER['DOCUMENT_ROOT'].'/Schema/index.php');
            $connector;
            $checkUserName = $connector;
            $checkUserName->prepare("SELECT * FROM UserData WHERE user_name LIKE :user_name");
            $ch= "%$username%";
            $checkUserName->bindParam(":user_name", $ch);
            $checkUserName->execute();
            if($checkUserName->rowCount() > 0){
                $checkUserName=$fch;
                $fch->fetchAll(PDO::FETCH_ASSOC);
                $fetchUserName = $fch['user_name'];
                $fetchPhone = $fch['phone_number'];
                $hold = array('user_name'=>"$fetchUserName", 'phone_number'=>"$fetchPhone");
                echo json_encode(array("status"=>"success", "response"=>"$hold"), JSON_PRETTY_PRINT);
                http_response_code(200);
                exit();
            }
            else{
                echo json_encode(array("status"=>"fail", "reponse"=>"user name not found"), JSON_PRETTY_PRINT);
                http_response_code(400);
                exit();
            }
        }
        catch(Exeception $error){
            echo json_encode(array("status"=>"fail", "response"=>"something went wrong with your code"), JSON_PRETTY_PRINT).$error->getMessage();
        }
    }
}
?>