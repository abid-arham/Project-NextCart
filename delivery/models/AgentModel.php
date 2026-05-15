<?php
class AgentModel {

    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function getAllAgents() {
        $result = $this->conn->query("
            SELECT da.id, da.vehicle_type, da.phone, da.is_active, u.name
            FROM delivery_agents da
            JOIN users u ON da.user_id = u.id
        ");
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function addAgent($name, $phone, $vehicle_type) {
        $email = 'agent_' . time() . '@nextcart.com';
        $pass_hash = password_hash('agent123', PASSWORD_DEFAULT);

        $stmt = $this->conn->prepare("
            INSERT INTO users (name, email, password_hash, phone, role, is_active)
            VALUES (?, ?, ?, ?, 'delivery_agent', 1)
        ");
        $stmt->bind_param("ssss", $name, $email, $pass_hash, $phone);
        $stmt->execute();
        $user_id = $this->conn->insert_id;

        $stmt2 = $this->conn->prepare("
            INSERT INTO delivery_agents (user_id, vehicle_type, phone, is_active)
            VALUES (?, ?, ?, 1)
        ");
        $stmt2->bind_param("iss", $user_id, $vehicle_type, $phone);
        $stmt2->execute();
    }

    public function toggleStatus($agent_id) {
        $stmt = $this->conn->prepare("SELECT is_active FROM delivery_agents WHERE id = ?");
        $stmt->bind_param("i", $agent_id);
        $stmt->execute();
        $row = $stmt->get_result()->fetch_assoc();
        $new_status = $row['is_active'] ? 0 : 1;

        $stmt2 = $this->conn->prepare("UPDATE delivery_agents SET is_active = ? WHERE id = ?");
        $stmt2->bind_param("ii", $new_status, $agent_id);
        $stmt2->execute();
    }

    public function getActiveAgents() {
        $result = $this->conn->query("
            SELECT da.id, da.vehicle_type, u.name
            FROM delivery_agents da
            JOIN users u ON da.user_id = u.id
            WHERE da.is_active = 1
        ");
        return $result->fetch_all(MYSQLI_ASSOC);
    }
}
?>