<?php session_unset();?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Dashboard</title>
    <link href="~/../libs/fontawesome/css/font-awesome.css" rel="stylesheet" />    
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js"></script>
    
    <style type="text/css">
        
        .general-container{

            background-color: #eee;
            margin: 0px !important;
            padding: 20px 0px !important;
        }

        /* Column iformacion general */
        .informacion_general
        {
            font-family: Cambria, Cochin, Georgia, Times, 'Times New Roman', serif;
            font-size: 16px;
        }

        .informacion_general .titulo_area
        {
            text-align: center;
            font-size: 25px;
            font-weight: bold;
            margin-bottom: 10px;
        }

        .informacion_general img
        {
            height: 200px;
            margin: auto;
            display: block;
            margin-bottom: 20px;
        }

        .informacion_general .label_info
        {
            margin-top: 10px !important;
            color: white;
            display: block;
            padding: 2px 3px;
            background-color: gray;
        }
        .informacion_general .descripcion_sistema
        {
            display: block;
            padding: 3px;
            border-radius: 4px;
            border: 1px solid black;
            margin-top: 5px;
            box-shadow: 0px 0px 3px 1px gray;
            background-color: #f9f8cb;
        }


        /* Main content */
        .main_content
        {
            border: 2px solid #bbb;
            margin: 0px !important;
            border-radius: 5px;
            background-color: white;
        }

        .main_content .titulo_area
        {
            text-align: center;
            font-family: Cambria, Cochin, Georgia, Times, 'Times New Roman', serif;
            font-weight: bolder;
        }

        .main_content .btn_add_registro
        {
            background-color: #016e9f;
            color: #fff;
            text-align: right !important;
        }

        .main_content .form_search
        {
            margin-top: 15px !important;
            display: block !important;
            /*border: 1px solid red;*/
        }

        .form_search input, select
        {
            padding: 3px !important;
            border-radius: 4px;
            margin-right: 10px !important;
        }

        .main_content .btn_search
        {
            background-color: #016e9f;
            color: #fff;
            padding: 7px 20px !important;
            margin-top: -8px !important;
        }


        /* Auxliar content */
        .container_auxiliar
        {
            position: relative;
            font-family: Cambria, Cochin, Georgia, Times, 'Times New Roman', serif;
            height: 100vh;
        }

        .container_auxiliar h2
        {
            text-align: center;
            margin-top: 100px;
            font-size: 30px;
        }

        .container_auxiliar img
        {
            position: absolute;
            height: 400px;
            bottom: 0px;
        }

        .container_auxiliar .detalles_operacion
        {
            margin-top: 20px;
            padding: 4px;
            border-radius: 4px;
            border: 1px solid #aaa;
            box-shadow: 0px 0px 3px 1px #ccc;
        }



        .wrapper{
            width: 650px;
            margin: 0 auto;
        }
        .page-header h2{
            margin-top: 0;
        }
        table tr td:last-child a{
            margin-right: 15px;
        }
    </style>

    <script type="text/javascript">
        $(document).ready(function(){
            $('[data-toggle="tooltip"]').tooltip();   
        });
    </script>
</head>
<body>
    
    <div class="container-fluid p-0">
        <div class="row mt-3 general-container">
            <div class="col-3 informacion_general">
                <h3 class="titulo_area">Universidad Nacional del Altiplano Puno</h3>

                <img src="images/icon_una.png" alt="logo una puno">

                <strong class="label_info">Docente: </strong>
                <p>Fredy Aparicio Castillo Suaquita</p>

                <strong class="label_info">Integrantes: </strong>
                <ul class="lista_integrantes">
                    <li>Deyvis Mamani Lacuta</li>
                    <li>Honorio Menendez Sacaca</li>
                    <li>Carlos Virgilio Puraca Calapuja</li>
                </ul>

                <strong class="label_info">Informacion</strong>

                <p class="descripcion_sistema">
                    Sistema de Gestión de Bases de Datos Distribuidas, con las operaciones CRUD (Create, Read, Update, Delete), haciendo uso de una base de datos de gran tamaño, proporciona el tiempo de ejecución para la operación de busqueda.
                </p>
            </div>

            <div class="col-6 main_content">
                <div class="page-header clearfix mt-3">
                    <h2 class="titulo_area">CRUD - MOVIES</h2>
                </div>
                
                <a href="view/insert.php" class="btn btn_add_registro">Agregar registro</a>

                <form action="index.php?act=search" class="form_search" method="POST">
                    <label for="key_word"><strong>Keyword: </strong></label>
                    <input type="text" id="key_word" name="key_word" class="col-4" placeholder="ingrese el texto a buscar">
                    
                    <label for="servidores"><strong>Servidor: </strong></label>
                    <select name="servidores" id="servidores">
                        <?php
                            foreach($this->servidores as $servidor)
                            {
                                echo '<option value="'.$servidor[0].'">'.$servidor[0].'</option>';
                            }
                        ?>
                    </select>

                    <input type="submit" name="btn_search" class="btn btn_search" value="Buscar">
                </form>

                <hr>

                <?php
                    if($result->num_rows > 0){
                        echo "<table class='table table-bordered table-striped'>";
                            echo "<thead>";
                                echo "<tr>";
                                    echo "<th>#</th>";                                        
                                    echo "<th>Title</th>";
                                    echo "<th>Genres</th>";
                                    echo "<th>Release date</th>";
                                    echo "<th>Acción</th>";
                                echo "</tr>";
                            echo "</thead>";
                            echo "<tbody>";

                            // solo mostrar los 20 primeros registros
                            $max_records_show = 9;
                            while($row = mysqli_fetch_array($result) and $max_records_show > 0){
                                echo "<tr>";
                                    echo "<td>" . $row[0] . "</td>";                                        
                                    echo "<td>" . $row[1] . "</td>";
                                    echo "<td>" . $row[2] . "</td>";
                                    echo "<td>" . $row[3] . "</td>";
                                    echo "<td>";
                                    echo "<a href='index.php?act=update&id=". $row[0] ."' title='Update Record' data-toggle='tooltip'><i class='fa fa-edit'></i></a>";
                                    echo "<a href='index.php?act=delete&id=". $row[0] ."' title='Delete Record' data-toggle='tooltip'><i class='fa fa-trash'></i></a>";
                                    echo "</td>";
                                echo "</tr>";

                                $max_records_show = $max_records_show - 1;
                            }
                            echo "</tbody>";                            
                        echo "</table>";
                        // Free result set
                        mysqli_free_result($result);
                    } else{
                        echo "<p class='lead'><em>No records were found.</em></p>";
                    }
                ?>
            </div>

            <div class="col-3 container_auxiliar">
                <h2>Detalles operación</h2>
                
                <p class="detalles_operacion">
                    <?php
                        if (isset($tiempo_diferencia)) 
                        {
                            echo 'Tiempo respuesta: '.$tiempo_diferencia." seg.";
                        }
                        else 
                        {
                            echo "En esta area se muestan los detalles de la operacion de busqueda";
                        }
                    ?>
                </p>

                <img src="images/logo_topic.jpg" alt="">
            </div>
        </div>        
    </div>


    <script>    
        if(typeof window.history.pushState == 'function') {
            window.history.pushState({}, "Hide", '<?php echo $_SERVER['PHP_SELF'];?>');
        }
    </script>
</body>
</html>