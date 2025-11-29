<?php
namespace NewdichApp\Account\Command;

use OpenApi\Annotations as OA;
use PDO;
use PDOException;
use NewdichApp\DTO\DeleteProfileDTO;
use NewdichApp\Middleware\DeleteProfileMid;

/**
 *   @OA\Post(
 *      path="/deleteProfile",
 *      summary="This endpoint listen to deleting of profile",
 *      @OA\ResquestBody(
 *          required=true,
 *          @OA\JsonContent(
 *              required={"file", "phone number"},
 *              @OA\Property(property="file", type="string", example="7347948943.png"),
 *              @OA\Property(property="phone number", type="string", example="+7247565274")
 *          )
 *      ),
 *      @oA\Response(
 *          response=200,
 *          description="success"
 *      ),
 *      @OA\Response(
 *          response=400,
 *          description="bad resquest"
 *      ),
 *      @OA\Response(
 *          response=500,
 *          description="internal server error"
 *      )
 *  )
 */

class DeleteProfile{
    private DeleteProfileDTO $dto;
    private DeleteProfileMid $mid;

    public function __construct(DeleteProfileDTO $d, DeleteProfileMid $m){
        $this->dto=$d;
        $this->mid=$m;
    }

    public function deleteProfile(){
        $file = $this->mid->cleanData($this->dto->file);
        $phone_number = $this->mid->cleanData($this->dto->phone_number);
        try{
            include($_SERVER['DOCUMENT_ROOT'].'/Schema/index.php');
            $del=$connector;
            $del->prepare("DELETE profile_picture FROM UserData WHERE phone_number=:phone_number");
            $del->bindParam(":phone_number", $phone_number, PDO::PARAM_STR);
            $del->execute();
            if($del){
                $hold ='';
                echo json_encode(array("status"=>"success", "response"=>"$hold"), JSON_PRETTY_PRINT);
                http_response_code(200);
                exit();
            }
            else{
                echo json_encode(array("status"=>"failed", "response"=>"failed to delete profile"), JSON_PRETTY_PRINT);
                http_response_code(400);
                exit();
            }
        }
        catch(PDOException $error){
            echo json_encode(array("status"=>"failed", "response"=>"something went wrong your code"), JSON_PRETTY_PRINT);
            http_response_code(400);
            exit();
        }
    }
}
?>