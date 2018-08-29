<?php if ($field->isPartial()): ?>
<?php include_partial('sfGuardGroup/'.$name, array('type' => 'filter', 'form' => $form, 'attributes' => $attributes instanceof sfOutputEscaper ? $attributes->getRawValue() : $attributes)) ?>
<?php elseif ($field->isComponent()): ?>
<?php include_component('sfGuardGroup', $name, array('type' => 'filter', 'form' => $form, 'attributes' => $attributes instanceof sfOutputEscaper ? $attributes->getRawValue() : $attributes)) ?>
<?php else: ?>

    <div class="controls">
        <div class="span2" style="width: 147px;">
            <?php echo $form[$name]->renderLabel($label) ?>
        </div>

        <div class="span2">
            <?php echo $form[$name]->render($attributes instanceof sfOutputEscaper ? $attributes->getRawValue() : $attributes) ?>

            <?php echo $form[$name]->renderError() ?>

            <?php if ($help || $help = $form[$name]->renderHelp()): ?>
            <p class="help-block"><?php echo __($help, array(), 'messages') ?></p>
            <?php endif; ?>
        </div>
    </div>
<?php endif; ?>
