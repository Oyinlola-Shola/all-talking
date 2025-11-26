<?php
namespace NewdichApp\Account\Command;

use NewdichApp\DTO\RegDTO;
use NewdichApp\Middleware\RegMid;
use PDO;
use OpenApi\Annotations as OA;
use PDOException;

/**
 *  @OA\Post(1
 *      path="/registerapi",
 *      summary="This endpoint is used to register user",
 *      @OA\RequestBody(
 *          required=true,
 *          @OA\JsonContent(
 *              required={"full name", "email", "phone number", "password"},
 *              @OA\Property(property="full name", type="string", example="John Doen"),
 *              @OA\Property(property="email", type="string", example="johnDoen02@gmail.com),
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
class Register{
    private RegDTO $dto;
    private RegMid $mid;

    public function __construct(RegDTO $d , RegMid $m){
        $this->dto = $d;
        $this->mid = $m;
    }

    public function registerUser(){
        $full_name = $this->mid->cleanData($this->dto->full_name);
        $email = $this->mid->cleanData($this->dto->email);
        $phone_number = $this->mid->cleanData($this->dto->phone_number);
        $password = $this->mid->verfiyPwd($this->dto->password);
        $user_name = $this->mid->genUserName();
        include($_SERVER['DOCUMENT_ROOT'].'/Schema/index.php');
        try{
            global $connector;
            $checkNum = $connector;
            $checkNum ->prepare("SELECT * FROM UserData WHERE phone_number=:phone_numer");
            $checkNum ->bindParam(":phone_number", $phone_number, PDO::PARAM_STR);
            $checkNum ->execute();
            if($checkNum->rowCount() > 0){
                echo json_encode(array("status"=>"fail", "response"=>"number already exist, go and register"), JSON_PRETTY_PRINT);
                http_response_code(404);
                exit();
            }
            else{
                $insert=$connector;
                $insert->prepare("INSERT INTO UserData(phone_number, email, full_name, password, user_name)VALUE(:phone_number, :email, :full_name, :password, :user_name)");
                $insert->bindParam(":phone_number", $phone_number, PDO::PARAM_STR);
                $insert->bindParam(":email", $email, PDO::PARAM_STR);
                $insert->bindParam(":full_name", $full_name, PDO::PARAM_STR);
                $insert->bindParam(":password", $password, PDO::PARAM_STR);
                $insert->bindParam(":user_name", $user_name, PDO::PARAM_STR);
                $insert->execute();
                if($insert){
                    echo json_encode(array("status"=>"success", "response"=>"account created successfully"), JSON_PRETTY_PRINT);
                    http_response_code(200);
                    exit();
                }
            }
        }
        catch(Exception $error){
            echo json_encode(array("status"=>"fail", "response"=>"something went wrong with your code"), JSON_PRETTY_PRINT).$error->getMessage();
        }
    }
}
?>