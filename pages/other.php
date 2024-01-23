<?php
require '../mainconfig.php';
require '../lib/check_session.php';
require '../lib/header.php';

$orders = mysqli_query($db, "SELECT SUM(orders.price) AS tamount, count(orders.id) AS tcount, orders.user_id, users.full_name FROM orders JOIN users ON orders.user_id = users.id WHERE MONTH(orders.created_at) = '".date('m')."' AND YEAR(orders.created_at) = '".date('Y')."' GROUP BY orders.user_id ORDER BY tamount DESC LIMIT 5");
$orders_mobile = mysqli_query($db, "SELECT SUM(orders_mobile.price) AS tamount, count(orders_mobile.id) AS tcount, orders_mobile.user, users.full_name FROM orders_mobile JOIN users ON orders_mobile.user = users.username WHERE MONTH(orders_mobile.date) = '".date('m')."' AND YEAR(orders_mobile.date) = '".date('Y')."' GROUP BY user ORDER BY tamount DESC LIMIT 5");
$orders_pascabayar = mysqli_query($db, "SELECT SUM(orders_pascabayar.price) AS tamount, count(orders_pascabayar.id) AS tcount, orders_pascabayar.user, users.full_name FROM orders_pascabayar JOIN users ON orders_pascabayar.user = users.username WHERE MONTH(orders_pascabayar.date) = '".date('m')."' AND YEAR(orders_pascabayar.date) = '".date('Y')."' GROUP BY user ORDER BY tamount DESC LIMIT 5");
$deposits = mysqli_query($db, "SELECT SUM(deposits.amount) AS tamount, count(deposits.id) AS tcount, deposits.user_id, users.full_name FROM deposits JOIN users ON deposits.user_id = users.id WHERE MONTH(deposits.created_at) = '".date('m')."' AND YEAR(deposits.created_at) = '".date('Y')."' AND deposits.status = 'Success' GROUP BY deposits.user_id ORDER BY tamount DESC LIMIT 5");
?>

<div class="card acard" style="padding-top:30px;">
                  <div class="card-header">
                    <h4 class="text-primary-d2 text-130 mb-0">
                      Halaman Lainnya
                    </h4>
                  </div>
                  </div>
<div class="row" style="padding-top: 10px;">

          <div class="col-md-4 grid-margin stretch-card">
            <div class="card">
              <div class="card-body d-flex flex-column align-items-center">
                <p class="card-description"><i data-feather="instagram"></i> Cara berbisnis</p>
                <a class="btn btn-primary" href="/pages/keuntungan">Klik Disini!</a>
              </div>
            </div>
          </div>
          <div class="col-md-4 grid-margin stretch-card">
            <div class="card">
              <div class="card-body d-flex flex-column align-items-center">
                <p class="card-description"><i data-feather="shield"></i> Sewa Website SMM & PPOB</p>
                <a class="btn btn-primary" href="/pages/buatsmm">Klik Disini!</a>
              </div>
            </div>
          </div>
          <div class="col-md-4 grid-margin stretch-card">
            <div class="card">
              <div class="card-body d-flex flex-column align-items-center">
                <p class="card-description"><i data-feather="credit-card"></i> Coming Soon</p>
                <a class="btn btn-primary" href="#">Klik Disini!</a>
              </div>
            </div>
          </div>
</div>

<?php
require '../lib/footer.php';
?>