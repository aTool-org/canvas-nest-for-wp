<div class="wrap">
    <h2>Canvas-nest.js Setting</h2>
    <form method="post" action="options.php"> 
        <?php @settings_fields('WP_Canvas_Nest-group'); ?>
        <?php @do_settings_fields('WP_Canvas_Nest-group', None); ?>

        <?php do_settings_sections('WP_Canvas_Nest'); ?>
        <?php @submit_button(); ?>
    </form>
    <hr />
    <form method="post" action="options.php"> 
        <?php @settings_fields('WP_Canvas_Nest-checkbox-group'); ?>
        <?php @do_settings_fields('WP_Canvas_Nest-checkbox-group', None); ?>

        <?php do_settings_sections('WP_Canvas_Nest_Checkbox'); ?>
        <?php @submit_button(); ?>
    </form>
</div>