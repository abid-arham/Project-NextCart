<?php
class ZoneModel {

    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function getAllZones() {
        $result = $this->conn->query("SELECT * FROM delivery_zones");
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function addZone($zone_name, $delivery_fee, $estimated_days) {
        $stmt = $this->conn->prepare("
            INSERT INTO delivery_zones (zone_name, delivery_fee, estimated_days)
            VALUES (?, ?, ?)
        ");
        $stmt->bind_param("sdi", $zone_name, $delivery_fee, $estimated_days);
        $stmt->execute();
    }

    public function deleteZone($zone_id) {
        $stmt = $this->conn->prepare("DELETE FROM delivery_zones WHERE id = ?");
        $stmt->bind_param("i", $zone_id);
        $stmt->execute();
    }
}
?>