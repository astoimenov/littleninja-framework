<?php $errors = \LittleNinja\Lib\Auth::getInstance()->errors; ?>
<div class="container-fluid">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Login</div>
                <div class="panel-body">
                    <!-- Display errors here -->

                    <form class="form-horizontal" role="form" method="POST" action="">
                        <input type="hidden" name="_token" value=""/>

                        <div class="form-group">
                            <label for="email" class="col-md-4 control-label">E-Mail Address</label>

                            <div class="col-md-6">
                                <input type="email" class="form-control" name="email" id="email"
                                    value="<?php if (isset($_POST['email'])) echo $_POST['email']; ?>" />
                                <?php if (isset($errors['email'])) : ?>
                                    <div class="text-danger">
                                        <?= $errors['email'] ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="password" class="col-md-4 control-label">Password</label>

                            <div class="col-md-6">
                                <input type="password" class="form-control" name="password" id="password" />
                                <?php if (isset($errors['password'])) : ?>
                                    <div class="text-danger">
                                        <?= $errors['password'] ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <input type="submit" value="Login" class="btn btn-primary" name="submit"/>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
