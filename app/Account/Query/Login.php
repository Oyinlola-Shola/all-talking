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
        $this->LogDTO = $d;
        $this->Login = $m;
    }

    public function loginUser(){
        
    }
}