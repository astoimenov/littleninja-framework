<?php $errors = \LittleNinja\Lib\Auth::getInstance()->errors; ?>
<div class="container-fluid">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Register</div>
                <div class="panel-body">
                    <form class="form-horizontal" role="form" method="POST" action="">
                        <input type="hidden" name="_token" value="" />

                        <div class="form-group">
                            <label for="name" class="col-md-4 control-label">Name</label>

                            <div class="col-md-6">
                                <input type="text" class="form-control" name="name" id="name"
                                       value="<?php if(isset($_POST['name'])) echo $_POST['name']; ?>" />
                                <?php if(isset($errors['name'])) : ?>
                                <div class="text-danger">
                                    <?= $errors['name'] ?>
                                </div>
                                <?php endif; ?>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="email" class="col-md-4 control-label">E-Mail Address</label>

                            <div class="col-md-6">
                                <input type="email" class="form-control" name="email" id="email"
                                       value="<?php if (isset($_POST['email'])) echo $_POST['email']; ?>"/>
                                <?php if (isset($errors['email'])) : ?>
                                    <div class="text-danger">
                                        <?= $errors['email'] ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="pass" class="col-md-4 control-label">Password</label>

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
                            <label for="password_confirmation" class="col-md-4 control-label">Confirm Password</label>

                            <div class="col-md-6">
                                <input type="password" class="form-control"
                                       name="password_confirmation" id="password_confirmation" />
                                <?php if (isset($errors['password_confirmation'])) : ?>
                                    <div class="text-danger">
                                        <?= $errors['password_confirmation'] ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <input type="submit" value="Register" class="btn btn-primary" name="submit" />
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
