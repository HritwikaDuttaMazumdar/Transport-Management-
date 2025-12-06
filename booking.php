<?php
session_start();
if(!isset($_SESSION['aname'])){
  header('location:index.php');
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>Transport</title>
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <meta content="" name="keywords">
  <meta content="" name="description">

  <!-- Favicons -->
  <link href="img/favicon.png" rel="icon">
  <link href="img/apple-touch-icon.png" rel="apple-touch-icon">

  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,700,700i|Raleway:300,400,500,700,800|Montserrat:300,400,700" rel="stylesheet">

  <!-- Bootstrap CSS File -->
  <link href="lib/bootstrap/css/bootstrap.min.css" rel="stylesheet">

  <!-- Libraries CSS Files -->
  <link href="lib/font-awesome/css/font-awesome.min.css" rel="stylesheet">
  <link href="lib/animate/animate.min.css" rel="stylesheet">
  <link href="lib/ionicons/css/ionicons.min.css" rel="stylesheet">
  <link href="lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">
  <link href="lib/magnific-popup/magnific-popup.css" rel="stylesheet">
  <link href="lib/ionicons/css/ionicons.min.css" rel="stylesheet">

  <!-- Main Stylesheet File -->
  <link href="css/style.css" rel="stylesheet">

 
</head>

<body id="body">
<div id="booking" class="container">
    <div class="row">
      <div class="col-md-3"></div>
       <div class="col-md-6">
        <div class="card">
          <div class="card-header">
            <h3 class="text-center">Enter Bus  Detail</h3>
          </div>
          <div class="card-body bg-dark">
            <form>
             <div class="form-group">
                   <input type="text" class="form-input form-control" name="usn" id="bid" placeholder="Enter Bus Id"/>    
             </div>
            </form>
          </div>
          <div class="card-footer bg-dark">
            <div class="btn btn-danger booking">Submit</div>
          </div>
          
        </div>
         </div>
       </div>
        <div class="col-md-3"></div>
    </div>
  <div class="container-fluid mt-5" id="booked">
    <div class="card" >
      <h2 class="text-center ">Booking Bus Details </h2>
      <div class="card-header bg-info">
        <div class="row">
          <div class="col-md-2">
            <h3 class="text-center text-white">Bus Name</h3>
          </div>
          <div class="col-md-2">
            <h3 class="text-center text-white">Booked Seat </h3>
          </div>
          <div class="col-md-2">
            <h3 class="text-center text-white">Vacent Seat</h3>
          </div>
          <div class="col-md-2">
            <h3 class="text-center text-white">From</h3>
          </div>
          <div class="col-md-2">
            <h3 class="text-center text-white">To</h3>
          </div>
           <div class="col-md-2">
            <h3 class="text-center text-white">Journey Date</h3>
          </div>

        </div>
      </div>
      <div class="card-body bg-dark">
       <div id="bresult"></div>
      </div>
    </div>
  </div>
 

  
  <footer id="footer">
    <div class="container">
      <div class="copyright">
        &copy; Copyright <strong>Traveler</strong>. All Rights Reserved
      </div>
      <div class="credits">
       
        Designed by <a href="#">Bus Transport</a>
      </div>
    </div>
  </footer><!-- #footer -->

  <a href="#" class="back-to-top"><i class="fa fa-chevron-up"></i></a>

  <!-- JavaScript Libraries -->
  <script src="lib/jquery/jquery.min.js"></script>
  <script src="lib/jquery/jquery-migrate.min.js"></script>
  <script src="lib/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="lib/easing/easing.min.js"></script>
  <script src="lib/superfish/hoverIntent.js"></script>
  <script src="lib/superfish/superfish.min.js"></script>
  <script src="lib/wow/wow.min.js"></script>
  <script src="lib/owlcarousel/owl.carousel.min.js"></script>
  <script src="lib/magnific-popup/magnific-popup.min.js"></script>
  <script src="lib/sticky/sticky.js"></script>

  <!-- Contact Form JavaScript File -->
  <script src="contactform/contactform.js"></script>

  <!-- Template Main Javascript File -->
  <script src="js/main.js"></script>
  <script src="js/main1.js"></script>

  <script>
$(document).ready(function() {
  $(".booking").click(function() {
    const busId = $("#bid").val();

    if (busId.trim() === "") {
      alert("Please enter a Bus ID first.");
      return;
    }

    // Send POST request to your microservice
    fetch("http://localhost:8001/booking_service/booking_service.php", {
      method: "POST",
      headers: {
        "Content-Type": "application/json"
      },
      body: JSON.stringify({
        action: "get_bookings",   // This matches your PHP switch-case
        bus_id: busId
      })
    })
    .then(response => response.json())
    .then(data => {
      if (data.status === "success") {
        let html = "";
        data.data.forEach(bus => {
          html += `
            <div class="row text-white text-center mb-2">
              <div class="col-md-2">${bus.bus_name}</div>
              <div class="col-md-2">${bus.booked_seats}</div>
              <div class="col-md-2">${bus.vacant_seats}</div>
              <div class="col-md-2">${bus.source}</div>
              <div class="col-md-2">${bus.destination}</div>
              <div class="col-md-2">${bus.date}</div>
            </div>`;
        });
        $("#bresult").html(html);
      } else {
        alert(data.message);
      }
    })
    .catch(err => {
      console.error("Error:", err);
      alert("Could not reach the booking service. Make sure it’s running.");
    });
  });
});
</script>


</body>
</html> 
