<?php 

class Mahasiswa_model
{
    private $table = 'mahasiswa',
            $db;

    public function __construct()
    {
        // isikan variable db serta intansiasi ke class Database
        $this->db = new Database;
    }
    
    

    public function getAllMahasiswa()
    {
        // buat query nya, tampung dalam method query()
        $this->db->query('SELECT * FROM ' . $this->table);
        // kembalikan hasil kepada method reseltSet()
        return $this->db->resultSet();
    }

    public function getMahasiswaById($id)
    {
        // mengambil id dari db
        $this->db->query('SELECT * FROM ' . $this->table . ' WHERE id=:id');
        // tampung id yang telah diambil
        $this->db->bind('id', $id);
        return $this->db->single();
    }

    public function tambahDataMahasiswa($data)
    {
        $query = "INSERT INTO " . $this->table . 
                    " VALUES (null, :nama, :nim, :email, :jurusan)";

        $this->db->query($query);
        $this->db->bind('nama', $data['nama']);
        $this->db->bind('nim', $data['nim']);
        $this->db->bind('email', $data['email']);
        $this->db->bind('jurusan', $data['jurusan']);

        $this->db->execute();

        return $this->db->rowCount();
    }

    public function hapusDataMahasiswa($id)
    {
        $query = "DELETE FROM " . $this->table . " WHERE id =:id";
        $this->db->query($query);
        $this->db->bind('id', $id);

        $this->db->execute();

        return $this->db->rowCount();
    }

    public function ubahDataMahasiswa($data)
    {
        $query = "UPDATE " . $this->table . 
                    " SET 
                    nama =:nama,
                    nim =:nim,
                    email =:email,
                    jurusan =:jurusan 
                    WHERE id=:id";

        $this->db->query($query);
        $this->db->bind('nama', $data['nama']);
        $this->db->bind('nim', $data['nim']);
        $this->db->bind('email', $data['email']);
        $this->db->bind('jurusan', $data['jurusan']);
        $this->db->bind('id', $data['id']);

        $this->db->execute();

        return $this->db->rowCount();
    }

    public function cariDataMahasiswa()
    {
        $keyword = $_POST['keyword'];
        $query = "SELECT * FROM " . $this->table . " WHERE nama LIKE :keyword";

        $this->db->query($query);
        $this->db->bind('keyword', "%$keyword%");
        return $this->db->resultSet();
    }
}