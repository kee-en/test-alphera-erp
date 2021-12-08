<?= link_tag('assets/custom/css/login.min.css') ?>

<div class="bg" style="background-image:url(assets/images/alphera/bg-login.jpg); background-repeat: no-repeat; background-size: cover; background-position: center center;position: relative;z-index: 0;">
    <div class="global-wrapper">
        <div class="global-box">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="text-center mb-3">
                                <img src="<?= base_url('assets/images/alphera/alphera_logo.png') ?>" alt="Alphera Marine Services Inc." width="250">
                            </div>

                            <h4 class="text-center text-default font-weight-medium font-24">Log In Your Account</h4>
                            <h5 class="text-muted global-text mb-3">Enter your email address / username and password to access admin panel.</h5>

                            <form action="javascript:void(0)" id="login_form" name="login_form">
                                <div class="form-group">
                                    <label>Email address or Username</label>
                                    <input class="form-control" type="text" id="email_address" name="email_address" placeholder="Enter your Email Address or Username" autofocus autocomplete="off">
                                </div>

                                <div class="form-group">
                                    <label>Password</label>
                                    <input class="form-control" type="password" id="password" name="password" placeholder="Enter your Password" autocomplete="off">
                                </div>

                                <div class="form-group">
                                    <button  type="submit" class="btn btn-alphera btn-block" id="btn_login"> Log In </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript" src="<?= base_url('assets/custom/js/login.min.js') ?>"></script>