<?php
include_partial('tmcTwitterBootstrap/assets');
include_component('tmcTwitterBootstrap', 'header');
?>
<?php if ($sf_user->isAuthenticated()): ?>
  <div class="container">
    <div class="alert alert-info">
      <?php if($sf_user->hasCredential('admin') ||$sf_user->hasCredential('adminCamera') || $sf_user->hasCredential('viewCamera')|| $sf_user->hasCredential('adminUserGroup')|| $sf_user->hasCredential('adminUser')):?>
        <h2><?php echo __('Chào mừng, ') . $sf_user->getGuardUser()->getUsername() ?>!</h2>
        <p><?php echo __('Nhấn vào các liên kết bên dưới để thực hiện các tác vụ.') ?></p>
      <?php else:?>
        <h2><?php echo __('Chào mừng, ') . $sf_user->getGuardUser()->getUsername() ?>!</h2>
        <p><?php echo __('Bạn chưa được phân quyền trong hệ thống. Hãy liên hệ với Administrator để được cấp quyền') ?></p>
      <?php endif;?>

    </div>
    <div class="row">
      <div class="span4">
        <div class="well sidebar">
          <p>
            <i>Copyright &copy; 2013 <b>TLDSEO</b></i> <br /><br />
<!--            <b></b> <br />  <i> Hỗ trợ kỹ thuật: iContact <br/>-->
<!--            Hotline: iContact </i>-->
          </p>
        </div>
      </div>
      <div class="span8">
        <?php foreach ($menus as $name => $menu): ?>
          <?php
          $credentials = isset($menu['credentials']) ? $menu['credentials'] : null;
          if ($credentials && !$sf_user->hasCredential($credentials)) {
            continue;
          }
          ?>
          <div class="row">
            <?php if (!array_key_exists('dropdown', $menu)): ?>
              <?php $route = $menu['route']; ?>
              <?php if (!array_key_exists($route, $routes)): ?>
                <?php continue; ?>
              <?php endif; ?>
              <div class="span8">
                <div class="widget widget-table">
                  <div class="widget-header">
                    <span class="icon-list-alt"></span>
                    <a href="<?php echo url_for('@' . $route); ?>"><h3><?php echo __($name) ?></h3></a>
                  </div>
                </div>
              </div>
            <?php else: ?>
              <?php $submenus = $menu['dropdown']; ?>
              <div class="span8">
                <div class="widget widget-table">
                  <div class="widget-header">
                    <span class="icon-list-alt"></span>
                    <h3><?php echo __($name) ?></h3>
                  </div>
                  <div class="widget-content">
                    <table class="table table-bordered table-striped">
                      <tbody>
                        <?php $rows = array() ?>
                        <?php foreach ($submenus as $name => $menu): ?>
                          <?php if (isset($menu['dropdown'])): ?>
                            <?php $submenus = $menu['dropdown']; ?>

                            <?php foreach ($submenus as $name => $menu): ?>


                              <?php $route = $menu['route']; ?>
                              <?php
                              $credentials = isset($menu['credentials']) ? $menu['credentials'] : null;
                              if ($credentials && !$sf_user->hasCredential($credentials)) {
                                continue;
                              }
                              ?>
                              <?php if (!array_key_exists($route, $routes)): ?>
                                <?php continue; ?>
                              <?php endif; ?>
                              <?php $rows[] = array('route' => $route, 'name' => $name); ?>
                            <?php endforeach; ?>


        <?php else: ?>
                            <?php $route = $menu['route']; ?>
                            <?php
                            $credentials = isset($menu['credentials']) ? $menu['credentials'] : null;
                            if ($credentials && !$sf_user->hasCredential($credentials)) {
                              continue;
                            }
                            ?>
                            <?php if (!array_key_exists($route, $routes)): ?>
                              <?php continue; ?>
                            <?php endif; ?>
                            <?php $rows[] = array('route' => $route, 'name' => $name); ?>
                          <?php endif; ?>
                        <?php endforeach; ?>

                        <?php $colspan = 3; ?>
                        <?php foreach (array_chunk($rows, $colspan) as $row): ?>
                          <tr>
                          <?php foreach ($row as $i => $value): ?>
                            <?php $c = count($row); ?>
                              <td<?php if ($c < $colspan && ($c - 1) == $i) echo ' colspan="' . ($colspan - $i) . '"' ?>>
                              <?php echo link_to(__($value['name']), '@' . $value['route']) ?>
                              </td>
                              <?php endforeach; ?>
                          </tr>
                          <?php endforeach; ?>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
    <?php endif; ?>
          </div>
          <?php endforeach; ?>
      </div>
    </div>
  </div>
  </div>
<?php endif; ?>
<?php include_component('tmcTwitterBootstrap', 'footer') ?>