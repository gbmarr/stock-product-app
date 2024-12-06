<?php
require_once './config/configapp.php';

class Model{
    protected $database;

    function __construct(){
        try {
            $this->deploy();

            $data = "mysql:host=".SQL_HOST.";dbname=".SQL_DBNAME.";charset=utf8";
            $this->database = new PDO($data, SQL_USER, SQL_PASS);

            $this->database->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    /*
    Metodo de despliegue de la DB utilizando ejecucion de archivo
    SQL almacenado en la carpeta DATA.*/
    private function deploy(){
        try {
            $pdo = new PDO("mysql:host=".SQL_HOST."", SQL_USER, SQL_PASS);

            $sql = file_get_contents('data/database.sql');

            $pdo->exec($sql);

            $this->database = new PDO("mysql:host=".SQL_HOST.";dbname=".SQL_DBNAME."", SQL_USER, SQL_PASS);
            if($this->isTableEmpty('categories') && $this->isTableEmpty('products') && $this->isTableEmpty('users')){
                $this->insertData();
            }
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    /*
    Metodo que verifica si la cantidad de registros en una tabla determinada
    pasada como parámetro es igual a cero, es decir, si se encuentra vacía.*/
    private function isTableEmpty($table){
        $sql = "SELECT COUNT(*) FROM $table";
        $isCharge = $this->database->prepare($sql);
        $isCharge->execute();
        return $isCharge->fetchColumn() == 0;
    }

    /*
    Método de inserción de registros en las diferentes tablas de la base de datos.*/
    private function insertData(){
        try {
            $this->database->exec(
                "INSERT INTO `categories` (`catname`, `catimage`) VALUES
                ('Sin categoría asignada', 'images/imagenPorDefault.jpg'),
                ('Electrónica', 'images/imagenPorDefault.jpg'),
                ('Ropa', 'images/imagenPorDefault.jpg'),
                ('Hogar', 'images/imagenPorDefault.jpg');");

            $this->database->exec(
                "INSERT INTO `products` (`prodname`, `description`, `idcategory`, `stock`, `price`, `imgproduct`) VALUES
                ('Televisor', 'Televisor LED de 42 pulgadas', 2, TRUE, 200, 'images/img-tv.jpeg'),
                ('Camiseta', 'Camiseta de algodón 100%', 3, TRUE, 30.00, 'images/camiseta.jpeg'),
                ('Sofá', 'Sofá de 3 plazas color gris', 4, TRUE, 500.10, 'images/sofa.jpeg'),
                ('Auriculares', 'Auriculares con cancelación de ruido', 2, TRUE, 1500, 'images/auriculares.jpeg');
            ");

            $stmt = $this->database->prepare(
                "INSERT INTO `users` (`name`, `surname`, `email`, `pass`, `token`, `admin`) VALUES
                ('Admin', 'User', 'admin@admin.com', :adminpass, :admintoken, TRUE),
                ('UserComun', 'Apellido', 'user@comun.com', :userpass, :usertoken, FALSE);"
            );
            $stmt->execute([
                ':adminpass' => '$2y$10$xHn/k/qTE8tGr1iSSe3X0OOUbkSnYGTLp7BAuIKFUAb9teWs/Ybxi',
                ':userpass' => '$2y$10$hP1MFvzm7SpV6CbZX7GQDekSTWD0GyVtR0eN2icxbLHNM.QfQ0U4a',
                ':admintoken' => '646fc0d751c58050fb1d81ee8f455420',
                ':usertoken' => '80da7e7ce496db405ee6b67d87bf648d'
            ]);
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }

    
    /*
    Metodo de ejecucion de consultas SQL que recibe dos parametros:
    consulta y parametros de reemplazo en la consulta que aparecen (?). */
    function executeQuery($query, $params = []){
        try {
            $action = $this->database->prepare($query);
            $action->execute($params);
            return $action;
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }
}