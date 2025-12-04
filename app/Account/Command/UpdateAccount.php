<?php
namespace Talking\NewdichApp\Account\Command;

use Talking\NewdichApp\DTO\UpdateAccountDTO;
use Talking\NewdichApp\Middleware\UpdateAccountMid;
use PDO;
use PDOException;
use OpenApi\Annotations as OA;

/**
 *  @OA\Post(
 *      path="/updateAccount",
 *      summary="This endpoint listen to updating account",
 *      @OA\RequestBody(
 *          required=true,
 *          @OA\JsonContent(  
 *              required={"full name", "phone number", "email", "password"},
 *              @OA\Property(property="full name", type="string", example="Don John"),
 *              @OA\Property(property="phone number", type="string", example="+2747847237"),
 *              @OA\Property(property="email", type="string", example="donjohn@gmail.com"),
 *              @OA\Property(property="password", type="string", example="3sd8ejk372")
 *          )
 *      ),
 *      @OA\Response(
 *          response=200,
 *          description="success"
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

class UpdateAccount{
    private UpdateAccountDTO $dto;
    private UpdateAccountMid $mid;

    public function __construct(UpdateAccountDTO $d, UpdateAccountMid $m){
       $this->dto=$d;
       $this->mid=$m;
    }

    public function updateAccount(){
        $full_name = $this->mid->cleanData($this->dto->full_name);
        $email = $this->mid->cleanData($this->dto->email);
        $pass_word = $this->mid->cleanData($this->dto->password);
        $phone_number = $this->mid->cleanData($this->dto->phone_number);
        try{
            include($_SERVER['DOCUMENT_ROOT'].'/Schema/index.php');
            $upd = $connector;
            $upd->prepare("UPDATE UserData SET full_name=':full_name', _password=':_password', phone_number=':phone_number' WHERE email=':email'");
            $upd->bindParam(":full_name", $full_name, PDO::PARAM_STR);
            $upd->bindParam(":_password", $pass_word, PDO::PARAM_STR);
            $upd->bindParam(":phone_number", $phone_number, PDO::PARAM_STR);
            $upd->bindParam(":email", $email, PDO::PARAM_STR);
            $upd->execute();
            if($upd){
                $sel=$upd;
                $sel->bindParam("SELECT * FROM UserData WHERE email=:email");
                $sel->execute();
                if($sel->rowCount() > 0){
                    $feh=$sel;
                    $feh->fetchAll(PDO::FETCH_ASSOC);
                    $phoneFech=$feh['phone_number'];
                    $full_nameFeh=$feh['full_name'];
                    $pass_wordFeh=$feh['_password'];
                    $emailFech=$feh['email'];
                    $hold=array("phone number"=>"$phoneFech", "full name"=>"$full_nameFeh", "password"=>"$pass_wordFeh", "email"=>"$emailFech");
                    echo json_encode(array("status"=>"success", "response"=>"$hold"), JSON_PRETTY_PRINT);
                    http_response_code(200);
                    exit();
                }
            }
            else{
                echo json_encode(array("status"=>"failed","response"=>"updating failed"), JSON_PRETTY_PRINT);
                http_response_code(400);
                exit();
            }
        }
        catch(PDOException $error){
            echo json_encode(array("status"=>"failed", "response"=>"something went wrong your code"), JSON_PRETTY_PRINT).$error->getMessage();
            http_response_code(400);
            exit();
        }
    }
}