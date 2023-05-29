<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel = "icon" href ="/img/Logo.png" type = "image/x-icon">
    <title>BJMP</title>
    <script src="https://unpkg.com/axios/dist/axios.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="/css/Login.css">
    <script src="https://rawgit.com/schmich/instascan-builds/master/instascan.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/vue/2.1.10/vue.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/webrtc-adapter/3.3.3/adapter.min.js"></script>
    

    
</head>
<body>
<header>
    <h1>Bureau of Jail Management and Penology</h1>
  </header>
  <div class="container">
    <div class="row justify-content-center">
    
    <div class="col-md-6">
        <div class="card" style="margin-top: 50px;">
          <div class="card-header" style="font-size: 30px;">BJMP INFORMATION</div>
          <div class="card-body">
          <img src="/img/National.png" alt="AC" " class="card-img-top" style="width: 180px;">
          <img src="/img/logo.png" alt="AC" " class="card-img-top" style="width: 180px;">
          <img src="/img/Region1.png" alt="AC" " class="card-img-top" style="width: 180px;">
          <br>
          <br>
          <br>
          <h3 style="font-size: 20px; text-align:justify;">The BJMP is one of the pillars of the Criminal Justice System, focused on jail management and penology. It oversees city, district, and municipal jails, aiming to rehabilitate offenders through livelihood projects, education, recreation, and spiritual activities.</h3>
          <br>
          
          <h4>Note:</h4>
          <p><em>Wait for scan confirmation before proceeding. If an <strong>"ERROR"</strong> appears consult the reception officer</em></p>
          </div>
        </div>
      </div>
      <div class="col-md-6">
        <div class="card" style="margin-top: 50px;">
          <div class="card-header" style="font-size: 30px;">SCAN QR CODE</div>
          <div class="card-body">
            <div class="scanner-container">
              <video id="preview" width="100%"></video>
            </div>
          </div>
        </div>
      </div>
      
    </div>
  </div>
  <div id="popup" style="display: none; position: fixed; top: 50%; left: 50%; transform: translate(-50%, -50%); background-color: #fff; padding: 20px; border: 1px solid #ccc; box-shadow: 0 0 10px rgba(0, 0, 0, 0.3); width: 30%; height: 30%; text-align: center; font-size: 60px;padding-top: 50px;">
    Scanned
</div>



<script>
  function speak(message) {
  const speech = new SpeechSynthesisUtterance(message);
  speechSynthesis.speak(speech);
  }
    let scanner = new Instascan.Scanner({ video: document.getElementById('preview') });

    scanner.addListener('scan', function (content) {
       
        // Store the scanned data in the database
        axios.post('/qr-code-scans', {
            visitor: content,
            time_in: new Date(),
            date: new Date().toISOString().slice(0, 10)
        })
        .then(function (response) {
            // Handle success if necessary
            showPopup('SCANNED!');
            speak('Scanned successfully!');
        })
        .catch(function (error) {
            // Handle error if necessary
            showPopup('ERROR!');
            speak('Error! Please Consult Reception Officer!');
        });
    });

    function showPopup(message) {
        const popup = document.getElementById('popup');
        popup.innerText = message;
        popup.style.display = 'block';
        setTimeout(function () {
            popup.style.display = 'none';
        }, 3000); // Hide the pop-up after 2 seconds
    }

    Instascan.Camera.getCameras().then(function (cameras) {
        if (cameras.length > 0) {
            scanner.start(cameras[0]);
        } else {
            console.error('No cameras found.');
        }
    }).catch(function (error) {
        console.error(error);
    });
</script>

        
</body>
</html>