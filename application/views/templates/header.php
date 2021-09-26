<html>
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <!-- CSS  -->
        <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>/assets/css/style.css">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" integrity="sha512-iBBXm8fW90+nuLcSKlbmrPcLa0OT92xO1BIsZ+ywDWZCvqsWgccV3gFoRBv0z+8dLJgyAHIhR35VZc2oM/gI1w==" crossorigin="anonymous" />
        <script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.0.2/chart.min.js"></script>
    </head>
    <div id="overlay" class="grid">
        <button id="closeOverlay" class="close-overlay">&times;</button>
        <div class="overlay-menu">
            <ul class="overlay-items">
                <li><a href="<?php echo base_url();?>pages/home"><i class="fas fa-exchange-alt fa-2x"></i><p>Transaction</p></a></li>
                <li><a href="<?php echo base_url();?>pages/report"><i class="fas fa-chart-area fa-2x"></i><p>Report</p></a></li>
                <li><a href="<?php echo base_url();?>pages/wallet"><i class="fas fa-wallet fa-2x"></i><p>Wallet</p></a></li>
                <li><a href="<?php echo base_url();?>pages/chat"><i class="fas fa-wallet fa-2x"></i><p>chat</p></a></li>
                <li><a href="<?php echo base_url();?>pages/logout"><i class="fas fa-sign-out-alt fa-2x"></i><p>Sign Out</p></a></li>
            </ul>
        </div>
    </div>
</html>
