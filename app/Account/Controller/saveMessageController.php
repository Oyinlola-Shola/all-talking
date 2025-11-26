<?php
    namespace NewdichApp\Account\Controller;

    use NewdichApp\DTO\SaveMesDTO;
    use NewdichApp\Middleware\SaveMessageMid;
    $getComingData = json_decode(file_get_contents("php:input"), true);

    $dto = new SaveMesDTO($getComingData);
    $mid = new SaveMessageMid();

    $acc = new SaveMessage($dto, $mid);
?>