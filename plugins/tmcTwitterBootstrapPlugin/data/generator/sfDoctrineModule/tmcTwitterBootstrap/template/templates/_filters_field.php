[?php if ($field->isPartial()): ?]
[?php include_partial('<?php echo $this->getModuleName() ?>/'.$name, array('type' => 'filter', 'form' => $form, 'attributes' => $attributes instanceof sfOutputEscaper ? $attributes->getRawValue() : $attributes)) ?]
[?php elseif ($field->isComponent()): ?]
[?php include_component('<?php echo $this->getModuleName() ?>', $name, array('type' => 'filter', 'form' => $form, 'attributes' => $attributes instanceof sfOutputEscaper ? $attributes->getRawValue() : $attributes)) ?]
[?php else: ?]

    <div class="controls">
        <div class="span2" style="width: 120px;">
            [?php echo $form[$name]->renderLabel($label) ?]
        </div>

        <div class="span2">
            [?php echo $form[$name]->render($attributes instanceof sfOutputEscaper ? $attributes->getRawValue() : $attributes) ?]

            [?php echo $form[$name]->renderError() ?]

            [?php if ($help || $help = $form[$name]->renderHelp()): ?]
            <p class="help-block">[?php echo __($help, array(), '<?php echo $this->getI18nCatalogue() ?>') ?]</p>
            [?php endif; ?]
        </div>
    </div>
<div class="clearfix"></div>
[?php endif; ?]
