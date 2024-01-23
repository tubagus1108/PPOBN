<?php
require '../mainconfig.php';
require '../lib/header.php';
?>
<style type="text/css">

element {

    display: block;

}
.content-body {

    margin-top: 40px;

}
.row {

    display: -ms-flexbox;
    display: flex;
    -ms-flex-wrap: wrap;
    flex-wrap: wrap;
    margin-right: -15px;
    margin-left: -15px;

}
.iq-card {
    background: var(--iq-light-card);
    -webkit-border-radius: 15px;
    -moz-border-radius: 15px;
    border-radius: 15px;
    margin-bottom: 30px;
    border: none;
    -webkit-box-shadow: 0px 4px 20px 0px rgba(44, 101, 144, 0.1);
    box-shadow: 0px 4px 20px 0px rgba(44, 101, 144, 0.1);
}
.p-0 {
    padding: 0 !important;
}
.cover-container {
    position: relative;
}
.rounded {
    border-radius: 15px !important;
}
.w-100 {
    width: 100% !important;
}
.rounded {
    border-radius: 50rem !important;
}
.rounded {
    border-radius: 15px !important;
}
.img-fluid {
    max-width: 100%;
    height: auto;
}
img {
    max-width: 100%;
}
img {
    vertical-align: middle;
    border-style: none;
}
.profile-info {
    font-size: 13px;
    line-height: 1.5em;
}
.iq-card-body {
    padding: 20px;
}
}
.align-items-center {
    -ms-flex-align: center !important;
    align-items: center !important;
}
.row {
    display: -ms-flexbox;
    display: flex;
    -ms-flex-wrap: wrap;
    flex-wrap: wrap;
    margin-right: -15px;
    margin-left: -15px;
}
.col-md-8 {
    -ms-flex: 0 0 66.666667%;
    flex: 0 0 66.666667%;
    max-width: 66.666667%;
}
.col-sm-12 {
    -ms-flex: 0 0 100%;
    flex: 0 0 100%;
    max-width: 100%;
}
.col, .col-1, .col-10, .col-11, .col-12, .col-2, .col-3, .col-4, .col-5, .col-6, .col-7, .col-8, .col-9, .col-auto, .col-lg, .col-lg-1, .col-lg-10, .col-lg-11, .col-lg-12, .col-lg-2, .col-lg-3, .col-lg-4, .col-lg-5, .col-lg-6, .col-lg-7, .col-lg-8, .col-lg-9, .col-lg-auto, .col-md, .col-md-1, .col-md-10, .col-md-11, .col-md-12, .col-md-2, .col-md-3, .col-md-4, .col-md-5, .col-md-6, .col-md-7, .col-md-8, .col-md-9, .col-md-auto, .col-sm, .col-sm-1, .col-sm-10, .col-sm-11, .col-sm-12, .col-sm-2, .col-sm-3, .col-sm-4, .col-sm-5, .col-sm-6, .col-sm-7, .col-sm-8, .col-sm-9, .col-sm-auto, .col-xl, .col-xl-1, .col-xl-10, .col-xl-11, .col-xl-12, .col-xl-2, .col-xl-3, .col-xl-4, .col-xl-5, .col-xl-6, .col-xl-7, .col-xl-8, .col-xl-9, .col-xl-auto {
    position: relative;
    width: 100%;
    padding-right: 15px;
    padding-left: 15px;
}
.align-items-center {
    -ms-flex-align: center !important;
    align-items: center !important;
}
.flex-wrap {
    -ms-flex-wrap: wrap !important;
    flex-wrap: wrap !important;
}
.d-flex {
    display: -ms-flexbox !important;
    display: flex !important;
}
.profile-img {
    margin-top: -80px;
}
.profile-img img {
    border-radius: 50%;
    -webkit-border-radius: 50%;
    border: 1px solid rgba(0, 0, 0, .1);
}
.avatar-130 {
    height: 130px;
    width: 130px;
    line-height: 130px;
}
.img-fluid {
    max-width: 100%;
    height: auto;
}
img {
    max-width: 100%;
}
img {
    vertical-align: middle;
    border-style: none;
}
.ml-3, .mx-3 {
    margin-left: 1rem !important;
}
.align-items-center {
    -ms-flex-align: center !important;
    align-items: center !important;
}
.line-height {
    line-height: normal !important;
}
.mt-2, .my-2 {
    margin-top: .5rem !important;
}
h4 {
    font-size: 1.400em;
}
h1, h2, h3, h4, h5, h6 {
    font-family: 'Poppins', sans-serif;
    font-weight: 500;
    margin: 0px;
        margin-top: 0px;
    line-height: 1.5;
    color: var(--iq-title-text);
}
.col-md-4 {
    -ms-flex: 0 0 33.333333%;
    flex: 0 0 33.333333%;
    max-width: 33.333333%;
}
.col-sm-12 {
    -ms-flex: 0 0 100%;
    flex: 0 0 100%;
    max-width: 100%;
}
.col, .col-1, .col-10, .col-11, .col-12, .col-2, .col-3, .col-4, .col-5, .col-6, .col-7, .col-8, .col-9, .col-auto, .col-lg, .col-lg-1, .col-lg-10, .col-lg-11, .col-lg-12, .col-lg-2, .col-lg-3, .col-lg-4, .col-lg-5, .col-lg-6, .col-lg-7, .col-lg-8, .col-lg-9, .col-lg-auto, .col-md, .col-md-1, .col-md-10, .col-md-11, .col-md-12, .col-md-2, .col-md-3, .col-md-4, .col-md-5, .col-md-6, .col-md-7, .col-md-8, .col-md-9, .col-md-auto, .col-sm, .col-sm-1, .col-sm-10, .col-sm-11, .col-sm-12, .col-sm-2, .col-sm-3, .col-sm-4, .col-sm-5, .col-sm-6, .col-sm-7, .col-sm-8, .col-sm-9, .col-sm-auto, .col-xl, .col-xl-1, .col-xl-10, .col-xl-11, .col-xl-12, .col-xl-2, .col-xl-3, .col-xl-4, .col-xl-5, .col-xl-6, .col-xl-7, .col-xl-8, .col-xl-9, .col-xl-auto {
    position: relative;
    width: 100%;
    padding-right: 15px;
    padding-left: 15px;
}
</style>
        <div class="col-sm-6 offset-lg-3" style="padding-top:30px;">
                     <div class="iq-card">
                        <div class="iq-card-body profile-page p-0">
                           <div class="profile-header">
                              <div class="cover-container">
                                 <img src="<?php echo $config['web']['base_url'] ?>dist/images/profile-bg.jpg" alt="profile-bg" class="rounded img-fluid w-100">
                              </div>
                              <div class="profile-info iq-card-body">
                                 <div class="row align-items-center">
                                    <div class="col-sm-12 col-md-8">
                                       <div class="user-detail">
                                          <div class="d-flex flex-wrap align-items-center">
                                             <div class="profile-img">
                                                <img src="<?php echo $config['web']['base_url'] ?>dist/images/contact.png" alt="profile-img" class="avatar-130 img-fluid"/>
                                             </div>
                                             <div class="profile-detail align-items-center ml-3">
                                                <h4 class="line-height mt-2">Kincai Payment</h4>
                                                <p> CEO & Founder</p>
                                             </div>
                                          </div>
                                       </div>
                                    </div>
                                    <div class="col-sm-12 col-md-4">
                                       <ul class="nav nav-pills d-flex align-items-end float-right profile-feed-items p-0 m-0">
                                        <li>
                                            <a href="https://facebook.com/mycodingxd" class="text-primary ml-2 mr-2" target="_blank">
                                            <i class="fab fa-facebook"></i>
                                        </a>
                                            <a href="https://api.whatsapp.com/send?phone=6282377823390" class="text-primary ml-2 mr-2" target="_blank">
                                            <i class="fab fa-whatsapp"></i>
                                        </a>
                                            <a href="https://instagram.com/mycodingxd" class="text-primary ml-2 mr-2" target="_blank">
                                            <i class="fab fa-instagram"></i>
                                        </a>
                                                                                 </li>
                                       </ul>
                                    </div>
                                 </div>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
<?php
require '../lib/footer.php';
?>