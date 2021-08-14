<?php

class user {

    private $id = 0;
    private $name = null;
    private $email = null;
    private $password = null;

    public function setId(int $id) :void
    {
        $this -> id = $id;
    }

    public function getId() :int
    {
        return $this -> id;
    }

    public function setName(string $name) :void
    {
        $this -> name = $name;
    }

    public function getName() :string
    {
        return $this -> name;
    }

    public function setEmail(string $email) :void
    {
        $this -> email = $email;
    }

    public function getEmail() :string
    {
        return $this -> email;
    }

    public function setPassword(string $password) :void
    {
        $this -> password = $password;
    }

    public function getPassword() :string
    {
        return $this -> password;
    }


    private function connection() :\PDO {
        return new \PDO("mysql::host=localhost;dbname=user", "root","");
    }

    public function create() :array {
        
        $con = $this-> connection();
        $stmt = $con -> prepare("INSERT INTO user VALUE (NULL, :_name, :_email, :_password)");
        $stmt -> bindValue(":_name", $this->getName(), \PDO::PARAM_STR);
        $stmt -> bindValue(":_email", $this->getEmail(), \PDO::PARAM_STR);
        $stmt -> bindValue(":_password", $this->getPassword(), \PDO::PARAM_STR);
        
        if ($stmt->execute()) {
            $this->setId($con ->lastInsertId());
            return $this->read();
        }
        return[];
    
    }


    public function read() :array {
        //Para listar todos os usuários
        $con = $this-> connection();
        if ($this->getId()=== 0) {
        $stmt = $con -> prepare("SELECT * FROM user");
        if ($stmt->execute()) {
            return $stmt->fetchAll(\PDO::FETCH_ASSOC);
        }
    } else if ($this->getId() > 0) { //Listar apenas um usuário
        $stmt = $con -> prepare("SELECT * FROM user");
        $stmt ->bindValue(":_id",$this->getId(), \PDO::PARAM_INT);
        if ($stmt->execute()) {
            return $stmt->fetchAll(\PDO::FETCH_ASSOC);
        }
    }
        return[];
    
    }

    public function update() :array {
        
        $con = $this-> connection();
        $stmt = $con -> prepare("UPDATE user SET name = :_name, email = :_email, password = :_password WHERE id = :_id");
        $stmt -> bindValue(":_name", $this->getName(), \PDO::PARAM_STR);
        $stmt -> bindValue(":_email", $this->getEmail(), \PDO::PARAM_STR);
        $stmt -> bindValue(":_password", $this->getPassword(), \PDO::PARAM_STR);
        $stmt ->bindValue(":_id", $this->getId(), \PDO::PARAM_INT);
        if ($stmt->execute()) {
            return $this->read();
        }
        return[];
    }

    public function delete() :array {
        

        $con = $this-> connection();
        $stmt = $con -> prepare("DELETE FROM user WHERE id = :_id");
        $stmt ->bindValue(":_id", $this->getId(), \PDO::PARAM_INT);
        if ($stmt->execute()) {
           return $this->read();
        }
        return[];
    }

}