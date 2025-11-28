<?php
namespace NewdichApp\Account\Command;

use NewdichApp\DTO\SendMessageDTO;
use NewdichApp\Middleware\SendMessageMid;
use PDO;
use PDOException;
use OpenApi\Annotations as OA;

/**
 *  @OA\Post(
 *      path="/SendMessage",
 *      summary="This endpoint is used to send message to user",
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

class SendMes{
    private SendMessageDTO $dto;
    private SendMessageMid $mid;

    public function __construct(SendMessageDTO $d, SendMessageMid $m){
        $this->dto = $d;
        $this->mid = $m;
    }

    public function message(){
        $re_phone_number = $this->mid->cleanData($this->dto->receiver_Phone_number);
        $se_phone_number = $this->mid->cleanData($this->dto->sender_phone_number);
        $message = $this->mid->cleanData($this->dto->message);
        try{
             include($_SERVER["DOCUMENT_ROOT"].'/Schema/index.php');
             $insert = $connector;
             $insert->prepare("INSERT INTO Save_message(re_phone_number, se_phone_number, _message)VALUE(:re_phone_number, :se_phone_number, :_message)");
             $insert->bindParam(":re_phone_number", $re_phone_number, PDO::PARAM_STR);
             $insert->bindParam(":se_phone_number", $se_phone_number, PDO::PARAM_STR);
             $insert->bindParam(":_message", $message, PDO::PARAM_STR);
             $insert->execute();
             if($insert){
               $sel=$insert;
               $sel->prepare("SELECT * FROM Save_message WHERE _message=:_message");
               $sel->bindParam(":_message", $message, PDO::PARAM_STR);
               $sel->execute();
               if($sel){
                $feh = $sel;
                $feh->fetchAll(PDO::FETCH_ASSOC);
                $mess = $feh['_messade'];
                $re_phone = $feh['re_phone_number'];
                $se_phone = $feh['se_phone_number'];
                $hold = array('message'=>"$mess", "sender"=>"$se_phone", "receiver"=>"$re_phone");
                echo json_encode(array("status"=>"success","response"=>"$hold"), JSON_PRETTY_PRINT);
                http_response_code(200);
                exit();
               }
             }
             else{
                json_encode(array("status"=>"fail", "response"=>"something went wrong with your code"), JSON_PRETTY_PRINT);
                http_response_code(400);
                exit();
             }
        }
         catch(PDOException){
                echo json_encode(array("status"=>"fail", "response"=>"something went wrong with your code"), JSON_PRETTY_PRINT).$error->getMessage();
         }       
    }
}
?>