<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Success - CISNE SOFTWARES</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background: #e9fbe5; }
        .success-container {
            max-width: 500px;
            margin: 60px auto;
            background: #fff;
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0,0,0,0.08);
            padding: 40px 30px;
            text-align: center;
        }
        .success-icon {
            font-size: 4rem;
            color: #28a745;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <div class="success-container">
        <div class="success-icon">&#10004;</div>
        <h2 class="mb-3">Payment Successful!</h2>
        <p class="lead">Thank you for your payment.</p>
        <hr>
        <div class="text-start">
            <p><strong>Reference:</strong> <span id="ref"></span></p>
            <p><strong>Amount Paid:</strong> <span id="amt"></span></p>
            <p><strong>Email:</strong> <span id="eml"></span></p>
        </div>
        <a href="index.php" class="btn btn-success mt-3">Make Another Payment</a>
    </div>
    <script>
        // Get params from URL
        const urlParams = new URLSearchParams(window.location.search);
        document.getElementById('ref').textContent = urlParams.get('reference') || '-';
        document.getElementById('amt').textContent = urlParams.get('amount') ? (urlParams.get('amount') + ' (in local currency)') : '-';
        document.getElementById('eml').textContent = urlParams.get('email') || '-';
    </script>
</body>
</html>
