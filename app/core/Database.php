<?php 

class Database 
{
    private $host = DB_HOST,
            $user = DB_USER,
            $pass = DB_PASS,
            $name = DB_NAME;

    private $dbh,
            $stmt;

    public function __construct()
    {
        //data source name
        $dsn = 'mysql:host=' . $this->host . ';dbname=' . $this->name;

        // untuk optimasi database
        $option = 
        [
            PDO::ATTR_PERSISTENT => true, // membuat koneksi tejaga
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION // menampilkan mode error
        ];

        try {
            $this->dbh = new PDO($dsn, $this->user, $this->pass, $option); //user dan pw
        } catch (PDOException $e) {
            die($e->getMessage()); //matikan dan tampilkan pesan error
        }
    }

    // membuat query generik untuk database wrapper agar dapat digunakan untuk apapun (INSERT, UPDATE, DELETE)
    public function query($query)
    {
        $this->stmt = $this->dbh->prepare($query);
    }

    // membuat binding data sebagai parameter query generik (WHERE, SET, INTO)
    public function bind($param, $value, $type = null)
    {
        if ( is_null($type) )
        {
            switch (true) {
                case is_int($value):
                    $type = PDO::PARAM_INT;
                    break;
                case is_bool($value):
                    $type = PDO::PARAM_BOOL;
                    break;
                case is_null($value):
                    $type = PDO::PARAM_NULL;
                    break;
                
                default:
                    $type = PDO::PARAM_STR;
            }
        }
        $this->stmt->bindValue($param, $value, $type);
    }

    // execute statement nya
    public function execute()
    {
        $this->stmt->execute();
    }

    // tampilkan hasilnya SEMUA DATA
    public function resultSet()
    {
        $this->execute();
        return $this->stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // tampilkan hasilnya hanya SATU DATA
    public function single()
    {
        $this->stmt->execute();
        return $this->stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function rowCount()
    {
        return $this->stmt->rowCount();
    }
}

