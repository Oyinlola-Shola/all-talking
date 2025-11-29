<?php
namespace NewdichApp\Account\Command;

use OpenApi\Annotations as OA;
use PDO;
use PDOException;
use NewdichApp\DTO\EditProfileDTO;
use NewdichApp\Middleware\EditProfileMid;

/**
 *   @OA\Post(
 *      path="/UploadProfile",
 *      summary="This endpoint listen to uploading and editting of profile",
 *      @OA\ResquestBody(
 *          required=true,
 *          @OA\JsonContent(
 *              required={"file"},
 *              @OA\Property(property="file", type="string", example="840558585843.png")
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

class EditProfile{
    private EditProfileDTO $dto;
    private EditProfileMid $mid;
    
    public function __construct(EditProfileDTO $d, EditProfileMid $m){
        $this->dto=$d;
        $this->mid=$m;
    }

    public function editProfile(){
        $file = $this->mid->cleanData($this->dto->file);
        $phone_number = $this->mid->cleanData($this->dto->phone_number);
        try{
            $fileName = $file['name'];
            $fileSize = $file['size'];
            $fileType = $file['type'];
            $basename =basename($fileName);
            $ext = pathinfo($basename, PATHINFO_EXTENSION);
            $tolower =strtolower($ext);
            $oldfile =$file['tmp_name'];
            $time =strtotime(date("y|d|m h:s:i"));
            $hashTime = crc32($time);
            $dot ='.';
            $newFile =$basename.$hashTime.$dot.$tolower;
            if(move_uploaded_file($oldfile, $newFile)){
               // echo json_encode(array("status"=>"panding", "response"=>"file under verification"), JSON_PRETTY_PRINT);
               // http_response_code(200);
               /* if($fileType!=="png" || $fileType!=="jpg" || $fileType!=="peng" || $fileType!=="mp3"){
                    echo json_encode(array("status"=>"failed", "response"=>"file format not supported or accepted"), JSON_PRETTY_PRINT);
                    http_response_code(400);
                    exit();
                } */
              /*  elseif($fileSize > $sizeAllowed){
                    echo json_encode(array("status"=>"failed", "response"=>"file to big"), JSON_PRETTY_PRINT);
                    http_response_code(400);
                    exit();
                } */
                
                    include($_SERVER['DOCUMENT_ROOT'].'/Schema/index.php');
                    $upd = $connector;
                    $upd ->prepare("UPDATE UserData SET profile_picture=':profile_picture' WHERE phone_number=':phone_number'");
                    $upd ->bindParam(":profile_picture", $fileName, PDO::PARAM_STR);
                    $upd ->bindParam(":phone_number", $phone_number, PDO::PARAM_STR);
                    $upd ->execute();
                    if($upd){
                       //echo json_encode(array("status"=>"success", "response"=>"upload successful"), JSON_PRETTY_PRINT);
                       //http_response_code(200);
                       $sel=$upd;
                       $sel->prepare("SELECT * FROM UserData WHERE phone_number=:phone_number");
                       $sel->bindParam(":phone_number", $phone_number, POD::PARAM_STR);
                       $sel->execute();
                       if($sel->rowCount() > 0){
                        $feh=$sel;
                        $fel->fetchAll(PDO::FETCH_ASSOC);
                            $profile=$feh['profile_picture'];
                            echo json_encode(array("status"=>"success", "response"=>"$profile"), JSON_PRETTY_PRINT);
                            http_response_code(200);
                            exit();
                       }
                    }
                    else{
                        echo json_encode(array("status"=>"failed", "reponse"=>"uploading failed"), JSON_PRETTY_PRINT);
                        http_response_code(400);
                        exit();
                    }
                }
            }
        catch(PDOException $error){
            echo json_encode(array("status"=>"failed", "response"=>"something went your code"), JSON_PRETTY_PRINT).$error->getMessage();
            http_response_code(400);
            exit();    
        }
        
    }
} 
?>