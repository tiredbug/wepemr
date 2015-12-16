<table class="form-table">
	<tr>
		<th><label for="full_name"><?php _e("Name", "wpemr"); ?></label></th>
		<td><input type="text" name="full_name" id="full_name" value="<?php echo @get_post_meta($post->ID, 'full_name', true); ?>" class="regular-text"></td>
	</tr>
	<tr>
		<th><label for="sex"><?php _e("Sex", "wpemr"); ?></label></th>
		<td><label for="male">
        		<input type="radio" name="sex" id="male" value="Male" <?php checked( @get_post_meta($post->ID, 'sex', true), 'Male' ); ?>> Male
    		</label>
    		<label for="female">
        		<input type="radio" name="sex" id="female" value="Female" <?php checked( @get_post_meta($post->ID, 'sex', true), 'Female' ); ?>> Female
    		</label></td>
	</tr>
	<tr>
		<th><label for="birthdate"><?php _e("Birthdate", "wpemr"); ?></label></th>
		<td><input type="text" name="birthdate" class="birthdate" value="<?php echo @get_post_meta($post->ID, 'birthdate', true); ?>" class="regular-text"> (format: <i>yy-mm-dd</i>)</td>
	</tr>
	<tr>
		<th><label for="address"><?php _e("Address", "wpemr"); ?></label></th>
		<td><textarea name="address" id="address" class="large-text"><?php echo @get_post_meta($post->ID, 'address', true); ?></textarea></td>
	</tr>
	<tr>
		<th><label for="phone_number"><?php _e("Phone Number", "wpemr"); ?></label></th>
		<td><input type="text" name="phone_number" id="phone_number" value="<?php echo @get_post_meta($post->ID, 'phone_number', true); ?>" class="regular-text"></td>
	</tr>
	<tr>
		<th><label for="occupation"><?php _e("Occupation", "wpemr"); ?></label></th>
		<td><input type="text" name="occupation" id="occupation" value="<?php echo @get_post_meta($post->ID, 'occupation', true); ?>" class="regular-text"></td>
	</tr>
	<tr>
		<th><label for="marriage"><?php _e("Marriage", "wpemr"); ?></label></th>
		<td>
		<label for="single">
        		<input type="radio" name="marriage" id="single" value="Single" <?php checked( @get_post_meta($post->ID, 'marriage', true), 'Single' ); ?>> Single
    		</label>
    		<label for="married">
        		<input type="radio" name="marriage" id="married" value="Married" <?php checked( @get_post_meta($post->ID, 'marriage', true), 'Married' ); ?>> Married
    		</label>
		</td>
	</tr>
      	<tr>
		<th><label for="images"><?php _e("Images", "wpemr"); ?></label></th>
      		<td>
        		<a class="image-add button" href="#" data-uploader-title="Add image(s) to gallery" data-uploader-button-text="Add image(s)">Add image(s)</a>
        		<ul id="image-list">
        		<?php if (@get_post_meta($post->ID, 'images', true)) : foreach (@get_post_meta($post->ID, 'images', true) as $key => $value) : $image = wp_get_attachment_image_src($value); ?>
          			<li>
            				<input type="hidden" name="images[<?php echo $key; ?>]" value="<?php echo $value; ?>">
            				<img class="image-preview" src="<?php echo $image[0]; ?>">
            				<small><a class="remove-image" href="#">Remove image</a></small>
          			</li>
        		<?php endforeach; endif; ?>
        		</ul>
      		</td>
      	</tr>
</table>
