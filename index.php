<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CISNE SOFTWARES - Payment Checkout</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
    <style>
        body {
            background: #f8f9fa;
        }
        .checkout-container {
            max-width: 500px;
            margin: 50px auto;
            background: #fff;
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0,0,0,0.1);
            padding: 30px;
        }
        .brand {
            font-size: 2rem;
            font-weight: bold;
            color: #0d6efd;
            text-align: center;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <div class="checkout-container">
        <div class="brand">CISNE SOFTWARES</div>
        <form id="paymentForm">
            <div class="mb-3">
                <label for="country" class="form-label">Country</label>
                <select class="form-select" id="country" onchange="updatePaymentOptions()" required>
                    <option value="NGN">Nigeria</option>
                    <option value="GHS">Ghana</option>
                    <option value="KES">Kenya</option>
                    <option value="USD">United States</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="mode" class="form-label">Mode of Payment</label>
                <select class="form-select" id="mode" required>
                    <option value="card">Card</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="amount" class="form-label">Amount</label>
                <input type="number" class="form-control" id="amount" min="1" required>
            </div>
            <div class="row mb-3">
                <div class="col">
                    <label for="firstname" class="form-label">First Name</label>
                    <input type="text" class="form-control" id="firstname" required>
                </div>
                <div class="col">
                    <label for="lastname" class="form-label">Last Name</label>
                    <input type="text" class="form-control" id="lastname" required>
                </div>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email address</label>
                <input type="email" class="form-control" id="email" required>
            </div>
            <div class="mb-3">
                <label for="phone" class="form-label">Phone Number</label>
                <input type="tel" class="form-control" id="phone" required>
            </div>
            <button type="submit" class="btn btn-primary w-100">Pay Now</button>
        </form>
    </div>

    <script src="https://js.paystack.co/v1/inline.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <?php include 'configs.php'; ?>
    <script type="text/javascript">
        const paymentForm = document.getElementById('paymentForm');
        paymentForm.addEventListener("submit", payWithPaystack, false);
        
        // Initialize payment options on page load
        document.addEventListener('DOMContentLoaded', function() {
            updatePaymentOptions();
            updateCurrencyLabel();
        });
        
        // Update payment options based on selected country
        function updatePaymentOptions() {
            const country = document.getElementById('country').value;
            const modeSelect = document.getElementById('mode');
            
            // Clear existing options
            modeSelect.innerHTML = '';
            
            // Always add Card option as it's available for all countries
            const cardOption = document.createElement('option');
            cardOption.value = 'card';
            cardOption.textContent = 'Card';
            modeSelect.appendChild(cardOption);
            
            // Add country-specific payment options
            if (country === 'KES') {
                // Kenya - add mobile money
                const mobileOption = document.createElement('option');
                mobileOption.value = 'mobile_money';
                mobileOption.textContent = 'Mobile Money (M-Pesa)';
                modeSelect.appendChild(mobileOption);
            } else if (country === 'NGN') {
                // Nigeria - add bank and USSD
                const bankOption = document.createElement('option');
                bankOption.value = 'bank';
                bankOption.textContent = 'Bank Transfer';
                modeSelect.appendChild(bankOption);
                
                const ussdOption = document.createElement('option');
                ussdOption.value = 'ussd';
                ussdOption.textContent = 'USSD';
                modeSelect.appendChild(ussdOption);
            } else if (country === 'GHS') {
                // Ghana - add mobile money
                const mobileOption = document.createElement('option');
                mobileOption.value = 'mobile_money';
                mobileOption.textContent = 'Mobile Money';
                modeSelect.appendChild(mobileOption);
            }
            
            // Update the amount label to show the currency
            updateCurrencyLabel();
        }
        
        // Update the amount label to show the selected currency
        function updateCurrencyLabel() {
            const country = document.getElementById('country').value;
            const amountLabel = document.querySelector('label[for="amount"]');
            
            let currencySymbol = '';
            switch(country) {
                case 'USD':
                    currencySymbol = '$';
                    break;
                case 'NGN':
                    currencySymbol = '₦';
                    break;
                case 'GHS':
                    currencySymbol = 'GH₵';
                    break;
                case 'KES':
                    currencySymbol = 'KSh';
                    break;
                default:
                    currencySymbol = '';
            }
            
            amountLabel.textContent = `Amount (${currencySymbol})`;
        }

        function payWithPaystack(e) {
            e.preventDefault();
            const country = document.getElementById('country').value;
            const mode = document.getElementById('mode').value;
            const amount = document.getElementById('amount').value;
            const firstname = document.getElementById('firstname').value;
            const lastname = document.getElementById('lastname').value;
            const email = document.getElementById('email').value;
            const phone = document.getElementById('phone').value;
            let currency = country;
            
            // Define available payment channels based on country
            let availableChannels = [];
            
            // Add the selected payment mode
            availableChannels.push(mode);
            
            let handler = PaystackPop.setup({
                key: '<?php echo $PublicKey; ?>',
                email: email,
                amount: amount * 100,
                currency: currency,
                ref: '' + Math.floor((Math.random() * 1000000000) + 1),
                firstname: firstname,
                lastname: lastname,
                phone: phone,
                channels: availableChannels,
                metadata: {
                    custom_fields: [
                        {
                            display_name: "Phone Number",
                            variable_name: "phone_number",
                            value: phone
                        },
                        {
                            display_name: "Payment Mode",
                            variable_name: "payment_mode",
                            value: mode
                        }
                    ]
                },
                onClose: function() {
                    window.location.href = "https://chisnepayment.chisne.co.ke/failure.php";
                },
                callback: function(response) {
                    window.location.href = "https://chisnepayment.chisne.co.ke/verify_transaction.php?reference=" + response.reference;
                }
            });
            handler.openIframe();
        }
    </script>
</body>
</html>