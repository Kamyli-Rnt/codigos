<?php
function mybr($data)
{
    $dataa = implode("/", array_reverse(explode("-", $data)));
    return $dataa;
}

function brmy($data)
{
    $datam = implode("-", array_reverse(explode("/", $data)));
    return $datam;
}
/*
aqui na parte verde tem exemplo de como usar...

// Aqui exemplo de uso o primeiro tem exemplo vindo do form oara o banco Mysql
$datab = "13/08/2023";
// Aqui vindo do banco para Tela, Form, etc
$datam = "2023-08-13";

echo "Data BR para Mysql:  " . mybr($datam) . "<br><bR>";

echo "Data Mysql para Br:  " . brmy($datab) . "<br><bR>";
*/