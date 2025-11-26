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
        
    }
}
?>