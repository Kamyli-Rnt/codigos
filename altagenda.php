<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link href="https://fonts.googleapis.com/css2?family=Josefin+Sans&display=swap" rel="stylesheet">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body {
            font-family: 'Josefin Sans', sans-serif;
            background-color: #efc6dead;
            margin: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .main-cadastro {
            background-color: aliceblue;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 20px;
            padding: 20px;
            width: 400px;
            text-align: center;
            font-family: 'Josefin Sans', sans-serif;

        }

        .card-cadastro {
            margin-top: 20px;
            font-family: 'Josefin Sans', sans-serif;

        }

        .textfield {
            margin-bottom: 15px;
            text-align: left;
            font-family: 'Josefin Sans', sans-serif;
            color: purple;
        }

        label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
            font-family: 'Josefin Sans', sans-serif;
        }

        select,
        input {
            width: 100%;
            padding: 8px;
            box-sizing: border-box;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 12px;
            font-size: 14px;
            font-family: 'Josefin Sans', sans-serif;

        }

        button {
            padding: 10px;
            font-size: 16px;
            cursor: pointer;
            border: none;
            border-radius: 10px;
            font-family: 'Josefin Sans', sans-serif;
        }

        .btn-1 {
            background-color: purple;
            color: #fff;
            margin-right: 10px;
            font-family: 'Josefin Sans', sans-serif;
            transition: background-color 0.4s, transform 0.4s;

        }

        .btn-2 {
            background-color: purple;
            color: #fff;
            font-family: 'Josefin Sans', sans-serif;
            transition: background-color 0.4s, transform 0.4s;

        }

        .btn-1:hover{
            text-decoration: none;
            color: aliceblue;
            background-color: green;
            transform: scale(1.1);
            font-family: 'Josefin Sans', sans-serif;
        }

        .btn-2:hover{
            text-decoration: none;
            color: aliceblue;
            background-color: red;
            transform: scale(1.1);
            font-family: 'Josefin Sans', sans-serif;
        }

        h1{
            color: purple;
        }

    </style>
</head>
<body>

<form method="post">
    <div class="main-cadastro">
        <div class="Cadastro">
            <div class="card-cadastro">
                <h1> Editar Agendamento</h1>

                <div class="textfield">
                    <label for="clientes">Cliente:</label>
                    <select id="id_clie" name="id_clie">
                        <?php
                        foreach ($dados_clientes as $dc) {
                            $selected = ($dc['cod_cli'] == $id_clie) ? "selected" : "";
                            echo "<option value='{$dc['cod_cli']}' $selected>{$dc['nome_cli']}</option>";
                        }
                        ?>
                    </select>
                </div>

                <div class="textfield">
                    <label for="funcionario">Funcionário:</label>
                    <select id="fk_id_func" name="fk_id_func">
                        <?php
                        foreach ($dados_funcionarios as $d) {
                            $selected = ($d['cod_func'] == $fk_id_func) ? "selected" : "";
                            echo "<option value='{$d['cod_func']}' $selected>{$d['nome_func']}</option>";
                        }
                        ?>
                    </select>
                </div>

                <div class="textfield">
                    <label for="servicos">Serviço:</label>
                    <select id="fk_id_serv" name="fk_id_serv">
                        <?php
                        foreach ($dados_servicos as $ds) {
                            $selected = ($ds['cod_serv'] == $fk_id_serv) ? "selected" : "";
                            echo "<option value='{$ds['cod_serv']}' $selected>{$ds['nome_serv']}</option>";
                        }
                        ?>
                    </select>
                </div>

                <div class="textfield">
                    <label for="data">Data de agendamento:</label>
                    <input type="date" name="data" id="data" value="<?php echo $data ?>">
                </div>
                <div class="textfield">
                    <label for="horario">Horario de agendamento:</label>
                    <input type="time" name="horario" id="horario" value="<?php echo $horario ?>">
                </div>

                <input type="hidden" name="id_agenda" value="<?php echo $id ?>">
                <button class="btn-1" name="update">Alterar</button>
                <button class="btn-2" name="btncancelar">Cancelar</button>
            </div>
        </div>
    </div>
</form>

</body>
</html>
