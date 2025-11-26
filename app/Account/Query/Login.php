<?php
namespace NewdichApp\Account\Query;

use NewdichApp\DTO\LogDTO;
use NewdichApp\Middleware\LogMid;
use PDO;
use PDOException;
use OpenApi\Annotations as OA;

/**
 *  @OA\Post(
 *      path="/loginapi",
 *      summary="This endpoint is used to login user",
 *      @OA\RequestBody(
 *          required=true,
 *          @OA\JsonContent(
 *              required={"phone number", "password"},
 *              @OA\Property(property="phone number", type="string", example="+329029290424"),
 *              @OA\Property(property="password", type="string", example="doen12345")
 *          )
 *      ),
 *      @OA\Response(
 *          response=200,
 *          description="successful"
 *      ),
 *      @OA\Response(
 *          response=400,
 *          description="bad request"
 *      ),
 *      @OA\Response(
 *          response=500,
 *          description="internal server error"
 *      )
 *  )
 */

class Login{
    private LogDTO $dto;
    private LogMid $mid;

    public function __construct(Login $d, LogMid $m){
        $this->dto = $d;
        $this->mid = $m;
    }

    public function loginUser(){
        $phone_number = $this->mid->cleanData($this->dto->$phone_number);
        $passwaord  = $this->mid->cleanData($this->dto->$passwaord);

        include($_SERVER['DOCUMENT_ROOT'].'/Schema/index.php');
        try{
            global $connector;
            $checkNumber=$connector;
            $checkNumber->prepare("SELECT * FROM LoginTable WHERE phone_number=:phone_number and pwd=:pwd");
            $checkNumber->bindParam(":phone_number", $phone_number, PDO::PARAM_STR);
             $checkPwd->bindParam(":pwd", $passwaord, PDO::PARAM_STR);
            $checkNumber->execute();
            if($checkNumber->rowCount() > 0){
                $checkNumber=$feh;
                $feh->fetch(PDO::FETCH_ASSOC);
                $chkPwd = $feh['password'];
                if($chkPwd == $passwaord){
                    echo json_encode(array("status"=>"success", "response"=>"can be authorized in"), JSON_PRETTY_PRINT);
                    http_response_code(200);
                    exit();
                }
                else{
                    echo json_encode(array("status"=>"fail", "response"=>"incorrect password"), JSON_PRETTY_PRINT);
                    http_response_code(400);
                    exit();
                }
            }
            else{
                echo json_encode(array("status"=>"fail", "response"=>"phone number not found please go and register"), JSON_PRETTY_PRINT);
                http_response_code(400);
                exit();
            }
        }
         catch(Exception $error){
            echo json_encode(array("status"=>"fail", "response"=>"something went wrong with your code"), JSON_PRETTY_PRINT).$error->getMessage();
        }
    }
}