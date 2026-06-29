<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Payment Completed</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
</head>

<body class="bg-light">

<div class="container">

    <div class="row justify-content-center align-items-center min-vh-100">

        <div class="col-lg-6">

            <div class="card border-0 shadow-lg rounded-4">

                <div class="card-body text-center p-5">

                    <div class="mb-4">

                        <div class="bg-success bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center"
                            style="width:120px;height:120px;">

                            <i class="fas fa-check text-success"
                               style="font-size:55px;"></i>

                        </div>

                    </div>

                    <h2 class="fw-bold text-success mb-3">
                        Payment Submitted
                    </h2>

                    <p class="text-secondary fs-5">

                        Your payment has been submitted successfully.

                    </p>

                    <p class="text-muted">

                        We are waiting for confirmation from Paymob.

                        Once the payment is confirmed, your appointment will be updated automatically.

                    </p>

                    <hr class="my-4">

                    <a href="{{ route('medical-records.index') }}"
                       class="btn btn-success btn-lg px-5 rounded-pill">

                        <i class="fa-solid fa-notes-medical me-2"></i>

                        Go to Medical Records

                    </a>

                </div>

            </div>

        </div>

    </div>

</div>

</body>

</html>