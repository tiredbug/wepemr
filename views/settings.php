<div class="wrap">
    <h2>WordPress Medical Records</h2>
    <form method="post" action="options.php"> 
        <?php @settings_fields('wpemr_settings-group'); ?>
        <?php @do_settings_fields('wpemr_settings-group'); ?>

        <?php do_settings_sections('wpemr_settings'); ?>

        <?php @submit_button(); ?>
    </form>
</div>
