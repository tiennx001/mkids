<?php use_helper('I18N', 'Date') ?>
<?php include_partial('intro/assets') ?>
<?php include_partial('intro/header') ?>

<div class="container-fluid">
    <div class="row-fluid">

        <div class="span<?php echo $sidebar_status ? '10' : '12'; ?>">
            <h1><?php echo __('Introduction') ?></h1>

            <?php include_partial('intro/flashes') ?>

            <div id="sf_admin_container">

              <div id="sf_admin_header">
                <?php include_partial('intro/form_header', array('tld_introduction' => $tld_introduction, 'form' => $form, 'configuration' => $configuration)) ?>
              </div>

              <div id="sf_admin_content">
                <?php include_partial('intro/form', array('tld_introduction' => $tld_introduction, 'form' => $form, 'configuration' => $configuration, 'helper' => $helper, 'nearRecords' => null)) ?>
              </div>

              <div id="sf_admin_footer">
                <?php include_partial('intro/form_footer', array('tld_introduction' => $tld_introduction, 'form' => $form, 'configuration' => $configuration)) ?>
              </div>
            </div>
        </div>
    </div>
</div>

<?php include_partial('intro/footer') ?>