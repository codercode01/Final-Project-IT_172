<!DOCTYPE html>
<html>
<head>
    <title>QR Code Card</title>
    <style>
        .card {
            width: 300px;
            height: 400px;
            padding: 20px;
            border: 1px solid #000;
        }

        .name {
            font-size: 24px;
            font-weight: bold;
            margin-bottom: 20px;
        }

        .qr-code {
            text-align: center;
        }

        .qr-code img {
            width: 300px;
            height: 300px;
        }
    </style>
</head>
<body>
    <div class="card">
        <div class="name">{{ $name }}</div>
        <div class="qr-code">
            <img src="data:image/png;base64,{{ $qrCode }}" alt="QR Code">
        </div>
    </div>
</body>
</html>
