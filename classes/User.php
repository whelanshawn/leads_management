<?php
class User
{

    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    public function getByEmail($email)
    {
        $statement = $this->pdo->prepare("
            SELECT * FROM users 
            WHERE email = :email AND deleted = false
        ");

        $statement->execute(['email' => $email]);
        return $statement->fetch(PDO::FETCH_ASSOC);
    }

    public function create($name, $email, $password, $role = 'role3')
    {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $statement = $this->pdo->prepare("
            INSERT INTO users(name, email, password, role)
            VALUES(:name, :email, :password, :role)
        ");
        return $statement->execute([
            'name' => $name,
            'email' => $email,
            'password' => $hashedPassword,
            'role' => $role
        ]);
    }

    public function getAll($page = 1, $search = '')
    {
        $limit = 10;
        $offset = ($page - 1) * $limit;
        $sql = "SELECT * FROM users WHERE deleted = false";
        if ($search) {
            $sql .= " AND (name ILIKE :search OR email ILIKE :search)";
        }
        $sql .= " ORDER BY id ASC LIMIT :limit OFFSET :offset";
        $statement = $this->pdo->prepare($sql);
        if ($search) {
            $statement->bindValue(':search', "%$search%");
        }
        $statement->bindValue(':limit', $limit, PDO::PARAM_INT);
        $statement->bindValue(':offset', $offset, PDO::PARAM_INT);
        $statement->execute();
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

    public function delete($id)
    {
        $statement = $this->pdo->prepare("
            UPDATE users 
            SET deleted = true 
            WHERE id = :id
        ");
        return $statement->execute(['id' => $id]);
    }
}
?>