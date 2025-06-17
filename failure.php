<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Failed - CISNE SOFTWARES</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background: #fbe9e9; }
        .fail-container {
            max-width: 500px;
            margin: 60px auto;
            background: #fff;
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0,0,0,0.08);
            padding: 40px 30px;
            text-align: center;
        }
        .fail-icon {
            font-size: 4rem;
            color: #dc3545;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <div class="fail-container">
        <div class="fail-icon">&#10060;</div>
        <h2 class="mb-3">Payment Failed</h2>
        <p class="lead">Unfortunately, your payment could not be processed.</p>
        <hr>
        <div class="text-start">
            <p><strong>Reason:</strong> <span id="msg"></span></p>
        </div>
        <a href="index.php" class="btn btn-danger mt-3">Try Again</a>
    </div>
    <script>
        // Get params from URL
        const urlParams = new URLSearchParams(window.location.search);
        document.getElementById('msg').textContent = urlParams.get('message') || 'Unknown error.';
    </script>
</body>
</html>
