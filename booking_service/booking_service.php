<?php
header("Content-Type: application/json");
include('../db_connect.php'); // Connect to main DB

$data = json_decode(file_get_contents("php://input"), true);

if (!isset($data['action'])) {
    echo json_encode(["status" => "error", "message" => "No action specified"]);
    exit;
}

$action = $data['action'];

switch ($action) {

    //  BOOK TICKET
    case "book_ticket":
        $user_id = $data['user_id'];
        $bus_id = $data['bus_id'];
        $seats = $data['seats'];
        $date = $data['date'];
        $pname = isset($data['pname']) ? $data['pname'] : 'Unknown';

        // Insert into ticket table
        $query = "INSERT INTO ticket (bus_id, uid, seat_no, no_seat, ticket_status, jdate, booking_date, pname)
                  VALUES ('$bus_id', '$user_id', '1', '$seats', 'Confirm', '$date', CURDATE(), '$pname')";

        if (mysqli_query($con, $query)) {
            echo json_encode(["status" => "success", "message" => "Ticket booked successfully"]);
        } else {
            echo json_encode(["status" => "error", "message" => "Booking failed", "error" => mysqli_error($con)]);
        }
        break;

    //  GET BOOKINGS BY BUS
    case "get_bookings":
        $bus_id = $data['bus_id'];

        $result = mysqli_query($con, "SELECT * FROM ticket WHERE bus_id = '$bus_id'");

        $rows = [];
        while ($r = mysqli_fetch_assoc($result)) {
            $rows[] = $r;
        }

        echo json_encode(["status" => "success", "data" => $rows]);
        break;

    default:
        echo json_encode(["status" => "error", "message" => "Invalid action"]);
}
?>
