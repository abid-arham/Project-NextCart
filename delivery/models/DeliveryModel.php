<?php
class DeliveryModel {

    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    // Dashboard counts
    public function getPendingDispatchCount() {
        $result = $this->conn->query("
            SELECT COUNT(*) as total FROM orders
            WHERE status IN ('confirmed', 'processing')
            AND id NOT IN (SELECT order_id FROM delivery_assignments)
        ");
        return $result->fetch_assoc()['total'];
    }

    public function getActiveDeliveryCount() {
        $result = $this->conn->query("
            SELECT COUNT(*) as total FROM delivery_assignments
            WHERE status IN ('assigned', 'picked_up', 'in_transit')
        ");
        return $result->fetch_assoc()['total'];
    }

    public function getDeliveredTodayCount() {
        $result = $this->conn->query("
            SELECT COUNT(*) as total FROM delivery_assignments
            WHERE status = 'delivered'
            AND DATE(assigned_at) = CURDATE()
        ");
        return $result->fetch_assoc()['total'];
    }

    // Orders ready to dispatch
    public function getOrdersReadyForDispatch() {
        $result = $this->conn->query("
            SELECT o.id, o.shipping_address, o.total_amount, o.created_at, dz.zone_name
            FROM orders o
            LEFT JOIN delivery_zones dz ON o.zone_id = dz.id
            WHERE o.status IN ('confirmed', 'processing')
            AND o.id NOT IN (SELECT order_id FROM delivery_assignments)
        ");
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    // Assign agent to order
    public function assignAgent($order_id, $agent_id, $zone_name) {
        $stmt = $this->conn->prepare("
            INSERT INTO delivery_assignments (order_id, agent_id, status, delivery_zone)
            VALUES (?, ?, 'assigned', ?)
        ");
        $stmt->bind_param("iis", $order_id, $agent_id, $zone_name);
        $stmt->execute();

        $stmt2 = $this->conn->prepare("UPDATE orders SET status = 'shipped' WHERE id = ?");
        $stmt2->bind_param("i", $order_id);
        $stmt2->execute();
    }

    // Active deliveries
    public function getActiveDeliveries() {
        $result = $this->conn->query("
            SELECT da.id, da.order_id, da.status, da.assigned_at, da.delivery_zone,
                   u.name as agent_name
            FROM delivery_assignments da
            JOIN delivery_agents ag ON da.agent_id = ag.id
            JOIN users u ON ag.user_id = u.id
            WHERE da.status IN ('assigned', 'picked_up', 'in_transit')
        ");
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    // Update delivery status
    public function updateStatus($assign_id, $new_status, $fail_reason) {
        $stmt = $this->conn->prepare("
            UPDATE delivery_assignments SET status = ?, fail_reason = ? WHERE id = ?
        ");
        $stmt->bind_param("ssi", $new_status, $fail_reason, $assign_id);
        $stmt->execute();

        if ($new_status === 'delivered') {
            $result = $this->conn->query("SELECT order_id FROM delivery_assignments WHERE id = $assign_id");
            $row = $result->fetch_assoc();
            $this->conn->query("UPDATE orders SET status = 'delivered' WHERE id = " . $row['order_id']);
        }
    }

    // Delivery history
    public function getDeliveryHistory() {
        $result = $this->conn->query("
            SELECT da.id, da.order_id, da.status, da.assigned_at, da.delivery_zone,
                   da.fail_reason, u.name as agent_name
            FROM delivery_assignments da
            JOIN delivery_agents ag ON da.agent_id = ag.id
            JOIN users u ON ag.user_id = u.id
            WHERE da.status IN ('delivered', 'failed')
            ORDER BY da.assigned_at DESC
        ");
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    // Agent performance report
    public function getAgentReport() {
        $result = $this->conn->query("
            SELECT u.name,
                   COUNT(da.id) as total,
                   SUM(da.status = 'delivered') as delivered,
                   SUM(da.status = 'failed') as failed
            FROM delivery_assignments da
            JOIN delivery_agents ag ON da.agent_id = ag.id
            JOIN users u ON ag.user_id = u.id
            GROUP BY ag.id, u.name
        ");
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    // Zone performance report
    public function getZoneReport() {
        $result = $this->conn->query("
            SELECT delivery_zone,
                   COUNT(*) as total,
                   SUM(status = 'delivered') as delivered,
                   SUM(status = 'failed') as failed
            FROM delivery_assignments
            GROUP BY delivery_zone
        ");
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    // Daily summary
    public function getDailySummary() {
        $result = $this->conn->query("
            SELECT DATE(assigned_at) as date,
                   COUNT(*) as total,
                   SUM(status = 'delivered') as delivered,
                   SUM(status = 'failed') as failed,
                   SUM(status IN ('assigned', 'picked_up', 'in_transit')) as in_transit
            FROM delivery_assignments
            GROUP BY DATE(assigned_at)
            ORDER BY date DESC
            LIMIT 7
        ");
        return $result->fetch_all(MYSQLI_ASSOC);
    }
}
?>