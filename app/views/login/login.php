<?php $this->start("head"); ?>
<?php $this->end(); ?>
<?php $this->start("body"); ?>
<div id="layoutAuthentication">
    <div id="layoutAuthentication_content">
        <main>
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-5">
                        <div class="card shadow-lg border-0 rounded-lg mt-5">
                            <div class="card-header">
                                <h3 class="text-center font-weight-light my-4">Login</h3>
                            </div>
                            <div class="card-body">
                                <form method="POST" action="">
                                    <div class="form-group"><label class="small mb-1"
                                            for="inputEmailAddress">Username</label>
                                        <input class="form-control py-4" id="username" name="username" type="text"
                                            placeholder="Enter Username" />
                                    </div>
                                    <div class="form-group"><label class="small mb-1" for="password">Password</label>
                                        <input class="form-control py-4" id="password" name="password" type="password"
                                            placeholder="Enter password" />
                                    </div>
                                    <div class="form-group">
                                        <div class="custom-control custom-checkbox"><input class="custom-control-input"
                                                id="rememberPasswordCheck" type="checkbox" /><label
                                                class="custom-control-label" for="rememberPasswordCheck">Remember
                                                password</label></div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
    <?php $this->end(); ?>
    <?php $this->start("section_js"); ?>

    <?php $this->end(); ?>