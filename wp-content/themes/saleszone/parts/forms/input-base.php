<?php
$required = isset($required) ? "required" : "";
$placeholder = isset($placeholder) ? "placeholder=\"". $placeholder ."\"" : "";
$fieldUniqueId = rand();
$atributes = isset($atributes) ? $atributes : "";
$type = isset($type) ? $type : 'text';
$modifier = isset($modifier) ? $modifier : '';
$controlModifier = isset($controlModifier) ? $controlModifier : '';
$description = isset($description) ? $description : '';
$value = isset($value) ? $value : '';
?>
<div class="form__field <?php echo esc_attr($modifier); ?>">
    <?php if( $label ): ?>
    <div class="form__label">
        <label for="field-<?php echo esc_attr($name); ?>-<?php echo esc_attr($fieldUniqueId); ?>">
            <?php echo esc_html($label); ?>
        </label>
        <?php if( $required ): ?>
        <i class="form__require-mark"></i>
        <?php endif; ?>
    </div>
    <?php endif; ?>
    <div class="form__inner">
        <input class="form-control <?php echo esc_attr($controlModifier); ?>"
               type="<?php echo esc_attr($type); ?>"
               name="<?php echo esc_attr($name); ?>"
               id="field-<?php echo esc_attr($name); ?>-<?php echo esc_attr($fieldUniqueId); ?>"
               value="<?php echo esc_attr(htmlspecialchars($value)); ?>"
            <?php echo esc_attr($placeholder); ?>
            <?php echo esc_attr($required); ?>
            <?php echo esc_attr($atributes); ?> />
        <?php if (trim(strip_tags($description)) != ""): ?>
            <div class="form__info form__info--help">
                <?php echo esc_html($description); ?>
            </div>
        <?php endif; ?>
    </div>
</div>