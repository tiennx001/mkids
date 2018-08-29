  protected function getPager()
  {
    $query = $this->buildQuery();
    $pages = ceil($query->count() / $this->getMaxPerPage());
    $pager = $this->configuration->getPager('<?php echo $this->getModelClass() ?>');
    $pager->setQuery($query);
    $pager->setPage(($this->getPage() > $pages) ? $pages : $this->getPage());
    $pager->init();

    return $pager;
  }

  protected function setMaxPerPage($max_per_page)
  {
    $this->getUser()->setAttribute('<?php echo $this->getModuleName() ?>.max_per_page', (integer) $max_per_page, 'admin_module');
  }
  
  protected function getMaxPerPage()
  {
    return $this->getUser()->getAttribute('<?php echo $this->getModuleName() ?>.max_per_page', sfConfig::get('app_default_max_per_page', 20), 'admin_module');
  }

  protected function setPage($page)
  {
    $this->getUser()->setAttribute('<?php echo $this->getModuleName() ?>.page', $page, 'admin_module');
  }

  protected function getPage()
  {
    return $this->getUser()->getAttribute('<?php echo $this->getModuleName() ?>.page', 1, 'admin_module');
  }

  protected function buildQuery()
  {
    $tableMethod = $this->configuration->getTableMethod();
<?php if ($this->configuration->hasFilterForm()): ?>
    if (null === $this->filters)
    {
      $this->filters = $this->configuration->getFilterForm($this->getFilters());
    }

    $this->filters->setTableMethod($tableMethod);

    $query = $this->filters->buildQuery($this->getFilters());
<?php else: ?>
    $query = Doctrine_Core::getTable('<?php echo $this->getModelClass() ?>')
      ->createQuery('a');

    if ($tableMethod)
    {
      $query = Doctrine_Core::getTable('<?php echo $this->getModelClass() ?>')->$tableMethod($query);
    }
<?php endif; ?>

    $this->addSortQuery($query);

    $event = $this->dispatcher->filter(new sfEvent($this, 'admin.build_query'), $query);
    $query = $event->getReturnValue();

    return $query;
  }
