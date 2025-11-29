<?php
namespace Talking\NewdichApp\Account\Command;

use OpenApi\Annotations as OA;
use PDO;
use PDOException;
use Talking\NewdichApp\DTO\UploadStatusDTO;
use Talking\NewdichApp\Middleware\UploadStatusMid;

/**
 *  @OA\Post(
 *      path="/uploadStatus",
 *      summary="This endpoint is use for uploading status",
 *      @OA\ResquestBody(
 *          required=true,
 *          @OA\JsonContent(
 *              required={"user_name", "file", "description"},
 *              @OA\Property(property="user_name", type="string", example="donmoen"),
 *              @OA\Property(property="file", type="string", example="2394384238324.png"),
 *              @OA\Property(property="description", type="string", example="Thank you Jesus")
 *          )
 *      ),
 *      @OA\Response(
 *          response="200",
 *          description="success"
 *      ),
 *      @OA\Response(
 *          response="400",
 *          description="bad request"
 *      ),
 *      @OA\Response(
 *          response="500",
 *          description="internal server error"
 *      )
 *  )
 */

class UploadStatus{
    private UploadStatusDTO $dto;
    private UploadStatusMid $mid;

    public function __construct(UploadStatusDTO $d, UploadStatusMid $m){
        $this->dto=$d;
        $this->mid=$m;
    }

    public function uploadStatus(){
        $user_name = $this->mid->cleanData($this->dto->user_name);
        $file = $this->mid->cleanData($this->dto->file);
        $des = $this->mid->cleanData($this->dto->description);

    try{
        $sizeAllowed = 50*1024*1024;
        $fileName = $file['name'];
        $fileSize = $file['size'];
        $fileType = $file['type'];
        $basename = basename($fileName);
        $ext = pathinfo($basename, PATHINFO_EXTENSION);
        $tolower = strtolower($ext);
        $oldfile = $file['tmp_name'];
        $time = strtotime(date('y|d|m h:s:i'));
        $hashTime = crc32($time);
        $dot = '.';
        $newFile = $basename.$hashTime.$dot.$tolower;
        if(move_uploaded_file($oldfile, $newFile)){
            echo json_encode(array("status"=>"panding", "response"=>"file under verification"), JSON_PRETTY_PRINT);
            http_response_code(200);
            if($fileType!=="png" || $fileType!=="jpg" || $fileType!=="peng" || $fileType!=="mp3"){
                echo json_encode(array("status"=>"failed", "response"=>"file format not supported or accepted"), JSON_PRETTY_PRINT);
                http_response_code(400);
                exit();
            }
            elseif($fileSize > $sizeAllowed){
                echo json_encode(array("status"=>"failed", "response"=>"file to big"), JSON_PRETTY_PRINT);
                http_response_code(400);
                exit();
            }
            else{
                include($_SERVER["DOCUMENT_ROOT"].'/Schema/index.php');
                    $insert = $connector;
                    $insert->prepare("INSERT INTO _Status(user_name, file, description)VALUE(:user_name, :file, :description)");
                    $pdo = PDO::PARAM_STR;
                    $insert->bindParam(":user_name", $user_name, $pdo);
                    $insert->bindParam(":file", $fileName, $pdo);
                    $insert->bindParam(":description", $des, $pdo);
                    $insert->execute();
                    if($insert){
                       $sel=$insert;
                       $sel->prepare("SELECT * FROM Status WHERE user_name=:user_name");
                       $sel->bindParam(":user_name", $user_name, $pdo);
                       if($sel->rowCount() > 0){
                            $feh = $sel;
                            $feh->fetchAll(PDO::FETCH_ASSOC);
                            $userNameStored = $feh['user_name'];
                            $FileStored = $feh['file'];
                            $desStored = $feh['description'];
                            $hold = array("user name"=>"$userNameStored", "File"=>"$FileStored", "description"=>"$desStored");
                            echo json_encode(array("status"=>"success", "response"=>"$hold"), JSON_PRETTY_PRINT);
                            http_response_code(200);
                            exit();
                       }
                       else{
                        echo json_encode(array("status"=>"failed", "response"=>"file name not found"), JSON_PRETTY_PRINT);
                        http_response_code(400);
                        exit();
                       }
                    }
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