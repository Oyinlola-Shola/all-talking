<?php
namespace NewdichApp\Account\Command;

use OpenApi\Annotations as OA;
use PDO;
use PDOException;
use NewdichApp\DTO\AddFriendDTO;
use NewdichApp\Middleware\AddFriendMid;

/**
 *   @OA\Post(
 *      path="/add_friend",
 *      summary="This endpoint listen to adding friend",
 *      @OA\ResquestBody(
 *          required=true,
 *          @OA\JsonContent(
 *              required={'name_of_friend'},
 *              @OA\Property(property="name_of_friend", type="string", example="John Don")
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
class ContactList{
    private AddFriendDTO $dto;
    private AddFriendMid $mid;

    public function __construct(AddFriendDTO $d, AddFriendMid $m){
        $this->dto = $d;
        $this->mid = $m;
    } 

    public function addFriend(){
        $user_name = $this->mid->cleanData($this->dto->user_name);
        $user_name_to_add = $this->mid->cleanData($this->dto->user_name_to_add);
        try{
            include($_SERVER['DoCUMENT_ROOT'].'/Schema/index.php');
            $insert = $connector;
            $insert ->prepare("INSERT INTO Friends(user_name, user_name_to_add)VALUE(:user_name, :user_name_to_add)");
            $pdo = PDO::PARAM_STR;
            $insert->bindParam(":user_name", $user_name, $pdo);
            $insert->bindParam(":user_name_to_add", $user_name_to_add, $pdo);
            $insert->execute();
            if($insert){
                $sel = $insert; 
                $sel->prepare("SELECT * FROM Friends WHERE user_name_to_add=:user_name_to_add");
                $sel->bindParam(":user_name_to_add", $user_name_to_add, $pdo);
                $sel->execute();
                if($sel){
                    $feh=$sel;
                    $feh->fetchAll(PDO::FETCH_ASSOC);
                    $friends=$feh['user_name_to_add'];
                    echo json_encode(array("status"=>"success", "response"=>"$friends"), JSON_PRETTY_PRINT);
                    http_response_code(200);
                    exit();
                }
            }
            else{
                echo json_encode(array("status"=>"fail", "response"=>"something is wrong"), JSON_PRETTY_PRINT);
                http_response_code(400);
                exit();
            }
        }
        catch(Exception $error){
            echo json_encode(array("status"=>"fail", "response"=>"something went wrong with your code"), JSON_PRETTY_PRINT).$error->getMessage();
        }
    }
}
?>