<?php use_helper('I18N') ?>

<form class="form-horizontal" action="<?php echo url_for('@sf_guard_signin') ?>" method="post">
    <?php echo $form->renderHiddenFields() ?>

    <div class="control-group<?php echo $form['username']->hasError() ? ' error' : ''?>">
        <?php echo $form['username']->renderLabel(__('Username *', null, 'sf_guard'), array('class' => $form['username']->hasError() ? 'strong' : '')) ?>
        <?php echo $form['username']->render(array('class' => 'input-xlarge')) ?>
        <?php if ($form['username']->hasError()): ?>
        <span class="help-block"><?php echo $form['username']->renderError() ?></span>
        <?php endif ?>
    </div>
    <div class="control-group<?php echo $form['password']->hasError() ? ' error' : ''?>">
        <?php echo $form['password']->renderLabel(__('Password *', null, 'sf_guard'), array('class' => $form['password']->hasError() ? 'strong' : '')) ?>
        <?php echo $form['password']->render(array('class' => 'input-xlarge')) ?>
        <?php if ($form['password']->hasError()): ?>
        <span class="help-block"><?php echo $form['password']->renderError() ?></span>
        <?php endif ?>
    </div>
    <?php if ($change_password == 1): ?>
    <div class="control-group<?php echo $form['new_password']->hasError() ? ' error' : ''?>">
        <?php echo $form['new_password']->renderLabel(__('New Password *', null, 'sf_guard'), array('class' => $form['new_password']->hasError() ? 'strong' : '')) ?>
        <?php echo $form['new_password']->render(array('class' => 'input-xlarge')) ?>
        <?php if ($form['new_password']->hasError()): ?>
        <span class="help-block"><?php echo $form['new_password']->renderError() ?></span>
        <?php endif ?>
    </div>
    <div class="control-group<?php echo $form['repeat_password']->hasError() ? ' error' : ''?>">
        <?php echo $form['repeat_password']->renderLabel(__('Repeat Password *', null, 'sf_guard'), array('class' => $form['repeat_password']->hasError() ? 'strong' : '')) ?>
        <?php echo $form['repeat_password']->render(array('class' => 'input-xlarge')) ?>
        <?php if ($form['repeat_password']->hasError()): ?>
        <span class="help-block"><?php echo $form['repeat_password']->renderError() ?></span>
        <?php endif ?>
    </div>
    <?php endif ?>
    <div class="control-group<?php echo $form['captcha']->hasError() ? ' error' : ''?>">
        <?php echo $form['captcha']->renderLabel(__('Captcha *', null, 'sf_guard'), array('class' => $form['captcha']->hasError() ? 'strong' : '')) ?>
        <?php echo $form['captcha']->render(array('class' => 'input-xlarge', 'autocomplete' => 'off')) ?>
        <?php if ($form['captcha']->hasError()): ?>
        <span class="help-block"><?php echo $form['captcha']->renderError() ?></span>
        <?php endif ?>
    </div>
    <?php if (isset($form['remember'])): ?>
    <label class="checkbox">
        <?php echo $form['remember']->render() ?>
        <?php echo $form['remember']->renderLabelName() ?>
    </label>
    <?php endif; ?>

    <?php
    if ($form->hasGlobalErrors()) {
        echo $form->renderGlobalErrors();
    }
    ?>
    <div class="clearfix"></div>
    <input type="hidden" value="<?php echo $change_password ?>" name="change_password"/>
    <input class="btn" type="submit" value="<?php echo __(($change_password == 1) ? 'Save' : 'Signin', null, 'tmcTwitterBootstrapPlugin') ?>"/>
    <?php if ($change_password): ?>
        <a class="btn" href="<?php echo url_for('@sf_guard_signin');?>"><?php echo __('Cancel');?></a>
    <?php endif?>
</form>
<?php if (sfConfig::get('app_sfGuardPlugin_signin_links', false)): ?>
<div id="links">
    <?php if (!include_slot('signin_links')): ?>
    <ul>
        <?php if (isset($routes['sf_guard_forgot_password'])): ?>
        <li>
            <a href="<?php echo url_for('@sf_guard_forgot_password') ?>"><?php echo __('Forgot your password?', null, 'tmcTwitterBootstrapPlugin') ?></a>
        </li>
        <?php endif; ?>
        <?php if (isset($routes['sf_guard_register'])): ?>
        <li>
            <a href="<?php echo url_for('@sf_guard_register') ?>"><?php echo __('Want to register?', null, 'tmcTwitterBootstrapPlugin') ?></a>
        </li>
        <?php endif; ?>
    </ul>
    <?php endif ?>
    <div class="clear"></div>
</div>
<?php endif ?>