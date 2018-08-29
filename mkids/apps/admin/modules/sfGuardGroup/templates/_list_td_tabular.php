        <td class="sf_admin_text sf_admin_list_td_order_no">
        <?php echo $orderNo; ?>
      </td>
    
  <td class="sf_admin_text sf_admin_list_td_name" field="name" title="<?php echo $sf_guard_group->getName(); ?>"><?php echo link_to( VtHelper::truncate($sf_guard_group->getName(), 35, '...', true) , 'sf_guard_group_edit', $sf_guard_group) ?></td>
  <td class="sf_admin_text sf_admin_list_td_description" field="description" title="<?php echo $sf_guard_group->getDescription(); ?>"><?php echo  VtHelper::truncate($sf_guard_group->getDescription(), 35, '...', true)  ?></td>