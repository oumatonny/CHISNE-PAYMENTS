<?php
include 'configs.php';
if (isset($_GET['reference'])) {
  $referenceId = $_GET['reference'];
  if ($referenceId == '') {
    header("Location: index.php");
  } else {
    $curl = curl_init();
    curl_setopt_array($curl, array(
      CURLOPT_URL => "https://api.paystack.co/transaction/verify/$referenceId",
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => "",
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 30,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => "GET",
      CURLOPT_HTTPHEADER => array(
        "Authorization: Bearer $SecretKey",
        "Cache-Control: no-cache",
      ),
    ));

    $response = curl_exec($curl);
    $err = curl_error($curl);

    curl_close($curl);

    if ($err) {
      echo "cURL Error #:" . $err;
    } else {
      $data = json_decode($response);
      if ($data->status == true && $data->data->status == 'success') {
        // Redirect to success page with reference and amount
        $ref = urlencode($data->data->reference);
        $amount = urlencode($data->data->amount / 100);
        $email = urlencode($data->data->customer->email);
        header("Location: https://chisnepayment.chisne.co.ke/success.php?reference=$ref&amount=$amount&email=$email");
        exit();
      } else {
        // Redirect to failure page with message
        $msg = urlencode($data->message);
        header("Location: https://chisnepayment.chisne.co.ke/failure.php?message=$msg");
        exit();
      }
      
    }
  }
} else {
  header("Location: index.php");
}
