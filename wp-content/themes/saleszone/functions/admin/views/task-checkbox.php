<label class="task-container__task-action-label task-container__task-action-label-check">
    <input type="checkbox"
           class="task-container__task-action-checkbox"
           data-set-task-state="<?php echo esc_attr($option_name); ?>"
        <?php echo $is_checked ? 'checked':''; ?>>
    <span class="task-container__task-action-checkbox-icon">
        <svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 91 63" xml:space="preserve"><g id="Shape_2"><g><polygon class="st0" points="91,5.5 85.5,0 33.8,52.1 5.5,23.5 0,29 33.7,63 33.8,62.8 34,63"></polygon></g></g></svg>
    </span>
</label>
