<?php
class Lead
{

    private $pdo;
    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    public function create($name, $description, $userId)
    {
        $statement = $this->pdo->prepare("
            INSERT INTO leads(name, description, created_by, assigned_to)
            VALUES(:name, :description, :userId, :userId)
        ");
        return $statement->execute([
            'name' => $name,
            'description' => $description,
            'userId' => $userId
        ]);
    }

    public function update($id, $name, $description)
    {
        $statement = $this->pdo->prepare("
        UPDATE leads 
        SET 
        name = :name
        ,description = :description
        WHERE id = :id
    ");

        return $statement->execute([
            'id' => $id,
            'name' => $name,
            'description' => $description
        ]);
    }

    public function complete($id)
    {
        $statement = $this->pdo->prepare("
            UPDATE leads 
            SET status = 'completed'
            ,updated_at = NOW()
            WHERE id = :id
        ");
        return $statement->execute(['id' => $id]);
    }

    public function singleLead($id)
    {
        $sql = "SELECT * FROM leads WHERE id = :id";
        $statement = $this->pdo->prepare($sql);
        $statement->execute(['id' => $id]);
        return $statement->fetch(PDO::FETCH_ASSOC);
    }

    public function getAll($page, $searchName, $dateFrom, $dateTo)
    {
        $limit = 10;
        $offset = ($page - 1) * $limit;
        // $sql = "SELECT * FROM leads WHERE deleted = false";
        $sql = "SELECT l.*, u.name AS assigned
                FROM leads l
                LEFT JOIN users u ON l.assigned_to = u.id
                WHERE l.deleted = false";

        // filter by name
        if ($searchName) {
            $sql .= " AND name ILIKE :searchName";
        }
        // filter by date
        if ($dateFrom) {
            $dateFromObj = new DateTime($dateFrom);
            $dateFromObj->setTime(0, 0, 0);
            $dateFrom = $dateFromObj->format('Y-m-d H:i:s');
            $sql .= " AND created_at >= :dateFrom";
        }
        if ($dateTo) {
            $dateToObj = new DateTime($dateTo);
            $dateToObj->setTime(23, 59, 59);
            $dateTo = $dateToObj->format('Y-m-d H:i:s');
            $sql .= " AND created_at <= :dateTo";
        }
        $sql .= " ORDER BY id DESC LIMIT :limit OFFSET :offset";
        $statement = $this->pdo->prepare($sql);
        if ($searchName) {
            $statement->bindValue(':searchName', "%$searchName%");
        }
        if ($dateFrom) {
            $statement->bindValue(':dateFrom', $dateFrom);
        }
        if ($dateTo) {
            $statement->bindValue(':dateTo', $dateTo);
        }
        $statement->bindValue(':limit', $limit, PDO::PARAM_INT);
        $statement->bindValue(':offset', $offset, PDO::PARAM_INT);
        $statement->execute();
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getById($id)
    {
        $statement = $this->pdo->prepare("
            SELECT * FROM leads WHERE id = :id AND deleted = false
        ");
        $statement->execute(['id' => $id]);
        return $statement->fetch(PDO::FETCH_ASSOC);
    }

    public function delete($id)
    {
        $statement = $this->pdo->prepare("
            UPDATE leads 
            SET deleted = true 
            WHERE id = :id
        ");
        return $statement->execute(['id' => $id]);
    }
}
?>