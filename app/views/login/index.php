<?php $this->start("head"); ?>
<?php $this->end(); ?>
<?php $this->start("body"); ?>
<div id="layoutAuthentication" style="zoom: 90%;">
    <div id="layoutAuthentication_content">
        <main>
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-5">
                        <div class="card shadow-lg border-0 rounded-lg mt-5">
                            <div class="card-header">
                                <h3 class="text-center font-weight-light my-4">Login</h3>
                                <?= $fb_msg;?>
                            </div>

                            <div class="card-body">
                                <form method="POST" action="">
                                    <div class="form-group"><label class="mb-1" for="inputEmailAddress">Username</label>
                                        <input class="form-control py-4" id="username" name="username" type="text"
                                            placeholder="Enter Username" />
                                    </div>
                                    <div class="form-group"><label class="mb-1" for="password">Password</label>
                                        <input class="form-control py-4" id="password" name="password" type="password"
                                            placeholder="Enter password" />
                                    </div>
                                    <div class="row form-group">
                                        <div class="col-sm-12">
                                            <button type="submit" name="login" id="login"
                                                class="form-control btn btn-lg btn-success mb-2">Login</button>
                                        </div>
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