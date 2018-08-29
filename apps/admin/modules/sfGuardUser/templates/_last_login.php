<?php
/**
 * Created by JetBrains PhpStorm.
 * User: OS_loilv4
 * Date: 4/22/13
 * Time: 2:12 PM
 * To change this template use File | Settings | File Templates.
 */
?>
<?php
  if($sf_guard_user->getLastLogin())
  {
    echo date("d/m/Y", strtotime($sf_guard_user->getLastLogin()));
  }
?>