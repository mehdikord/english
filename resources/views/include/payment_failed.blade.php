<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Attivaa -  Payment failed</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css">
    <style>
        .bg-color{
            background-color: #FAFAFA !important;
        }
    </style>
</head>
<body>

<div class="container">
    <div class="row mt-5 justify-content-center">
        <div class="col-md-6 mt-5">

            <div class="card bg-color">
                <div class="card-body">
                    <div class="mt-2 img-fluid text-center">
                        <img src="{{asset('assets/images/default/payment-failed.png')}}" width="130" alt="">
                    </div>
                    <h4 class="mt-3 text-center text-danger">
                        Payment failed
                    </h4>
                    <div class="mt-4 text-center">
                        Dear user, your payment was failed
                        <br>
                        <br>
                        error  : <span class="text-danger">{{ request('error')}}</span>
                    </div>

                    <div class="text-center mt-4 mb-3">
                        <a class="btn btn-primary" href="https://attivaa.me">
                            Back to App
                        </a>
                    </div>


                </div>
            </div>

        </div>



    </div>


</div>



<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>

</body>
</html>
