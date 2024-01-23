<?php
error_reporting(0);
require '../mainconfig.php';
require '../lib/check_session.php';
require '../lib/header.php';
?>
<div class="card acard" style="padding-top:30px;">
                  <div class="card-header">
                    <h4 class="text-primary-d2 text-130 mb-0">
                      Halaman Lainnya
                    </h4>
                  </div>
                  </div>
<div class="row">

          <div class="col-md-4 grid-margin stretch-card">
            <div class="card">
              <div class="card-body d-flex flex-column align-items-center">
                <p class="card-description"><i data-feather="instagram"></i> Keuntungan</p>
                <a class="btn btn-primary" href="../pages/keuntungan">Click here!</a>
              </div>
            </div>
          </div>
          <div class="col-md-4 grid-margin stretch-card">
            <div class="card">
              <div class="card-body d-flex flex-column align-items-center">
                <p class="card-description"><i data-feather="shield"></i> Sewa Website SMM</p>
                <a class="btn btn-primary" href="../convert-pulsa/history">Click here!</a>
              </div>
            </div>
          </div>
          <div class="col-md-4 grid-margin stretch-card">
            <div class="card">
              <div class="card-body d-flex flex-column align-items-center">
                <p class="card-description"><i data-feather="credit-card"></i> Deposit Saldo</p>
                <a class="btn btn-primary" href="../deposit/history">Click here!</a>
              </div>
            </div>
          </div>
          <div class="col-md-4 grid-margin stretch-card">
            <div class="card">
              <div class="card-body d-flex flex-column align-items-center">
                <p class="card-description"><i data-feather="instagram"></i> Pesanan</p>
                <a class="btn btn-primary" href="../order/history">Click here!</a>
              </div>
            </div>
          </div>
          <div class="col-md-4 grid-margin stretch-card">
            <div class="card">
              <div class="card-body d-flex flex-column align-items-center">
                <p class="card-description"><i data-feather="shield"></i> Convert Pulsa</p>
                <a class="btn btn-primary" href="../convert-pulsa/history">Click here!</a>
              </div>
            </div>
          </div>
          <div class="col-md-4 grid-margin stretch-card">
            <div class="card">
              <div class="card-body d-flex flex-column align-items-center">
                <p class="card-description"><i data-feather="credit-card"></i> Deposit Saldo</p>
                <a class="btn btn-primary" href="../deposit/history">Click here!</a>
              </div>
            </div>
          </div>
</div>
<?php
require '../lib/footer.php';
?>