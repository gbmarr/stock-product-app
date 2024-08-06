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

    private function isTableEmpty($table){
        $sql = "SELECT COUNT(*) FROM $table";
        $isCharge = $this->database->prepare($sql);
        $isCharge->execute();
        return $isCharge->fetchColumn() == 0;
    }

    private function insertData(){
        try {
            $this->database->exec(
                "INSERT INTO `categories` (`name`) VALUES
                ('Sin categoría asignada'),
                ('Electrónica'),
                ('Ropa'),
                ('Hogar');");
            $this->database->exec(
                "INSERT INTO `products` (`name`, `description`, `idcategory`, `stock`, `price`, `imgproduct`) VALUES
                ('Televisor', 'Televisor LED de 42 pulgadas', 2, TRUE, 200, 'https://th.bing.com/th/id/OIP.3Tdr8z2sWnjazwobaV_qigHaGR?w=222&h=188&c=7&r=0&o=5&dpr=1.3&pid=1.7'),
                ('Camiseta', 'Camiseta de algodón 100%', 3, TRUE, 30.00, 'https://www.cienporcientofutbol.cl/cdn/shop/files/Camiseta_Local_Seleccion_Argenti_3_840x840.jpg?v=1711568681'),
                ('Sofá', 'Sofá de 3 plazas color gris', 4, TRUE, 500.10, 'https://i5.walmartimages.com/seo/3-Seater-Sofa-Couch-Modern-Linen-Tufed-Upholstered-2-Pillows-Armrest-Design-Wooden-Tapered-Legs-Accent-Arm-Sofas-Living-Room-Bedroom-Office-Grey_04ec8f14-062d-44d0-9aed-9dac7be853b9.5e2b287cd25bd91421fd9bb39412dbc8.jpeg'),
                ('Auriculares', 'Auriculares con cancelación de ruido', 2, TRUE, 1500, 'https://www.sevenelectronics.com.ar/images/000000mls-s389ne02151s389-negro1.png');
            ");
            $this->database->exec(
                "INSERT INTO `users` (`name`, `surname`, `email`, `pass`, `admin`) VALUES
                ('Admin', 'User', 'webadmin@admin.com', 'admin', TRUE),
                ('UserComun', 'Apellido', 'user@comun.com', 'user', FALSE);"
            );
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }

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