<?php

defined('ABSPATH') || exit;

class Jobcircle_Custom_Taxonomy_Meta {
    
    public function __construct() {
        add_action('job_category_add_form_fields', array($this, 'add_meta_fields'));
		add_action('job_category_edit_form_fields', array($this, 'edit_meta_fields'));

		add_action('create_job_category', array($this, 'job_category_fields_saving'));
		add_action('edited_job_category', array($this, 'job_category_fields_saving'));
    }

    public function add_meta_fields() {
		wp_enqueue_media();

		$imge_id = 'cat-img-' . rand(10000000, 99999999);
		?>
		<div class="form-field">
			<label><?php esc_html_e('Icon', 'jobcircle-frame') ?></label>
			<div class="ffield-con">
				<input type="hidden" name="job_category_custom_fields" value="1">
				<?php echo jobcircle_icon_picker('cat_icon') ?>
			</div>
		</div>
		<div class="form-field">
			<label><?php esc_html_e('Image', 'jobcircle-frame') ?></label>
			<div class="ffield-con">
				<div class="bkimg-uploder-con">
					<div id="<?php echo ($imge_id) ?>-box" class="jobcircle-browse-med-image" style="display: none;">
						<a class="jobcircle-rem-media-b" data-id="<?php echo ($imge_id) ?>"><i class="dashicons-before dashicons-no-alt"></i></a>
						<img id="<?php echo ($imge_id) ?>-img" src="" alt="" />
					</div>
					<input type="hidden" id="<?php echo ($imge_id) ?>" name="cat_image" value="">
					<input type="button" class="jobcircle-upload-media jobcircle-bk-btn button" data-id="<?php echo ($imge_id) ?>" value="<?php esc_html_e('Browse', 'jobcircle-frame') ?>">
				</div>
			</div>
		</div>
		<?php
	}

    public function edit_meta_fields($term) {
		wp_enqueue_media();

		$term_id = $term->term_id;
		$term_meta = get_term_meta($term_id, 'job_category_custom_fields', true);

		$cat_icon = isset($term_meta['icon']) ? $term_meta['icon'] : '';
		$cat_image = isset($term_meta['image']) ? $term_meta['image'] : '';
		$imge_id = 'cat-img-' . rand(10000000, 99999999);
		?>
		<tr class="form-field">
            <th><label><?php esc_html_e('Icon', 'wp-jobsearch') ?></label></th>
            <td>
				<input type="hidden" name="job_category_custom_fields" value="1">
				<?php echo jobcircle_icon_picker('cat_icon', $cat_icon) ?>
            </td>
        </tr>
		<tr class="form-field">
            <th><label><?php esc_html_e('Image', 'wp-jobsearch') ?></label></th>
            <td>
				<div class="bkimg-uploder-con">
					<div id="<?php echo ($imge_id) ?>-box" class="jobcircle-browse-med-image"<?php echo ($cat_image == '' ? ' style="display: none;"' : '') ?>>
						<a class="jobcircle-rem-media-b" data-id="<?php echo ($imge_id) ?>"><i class="dashicons-before dashicons-no-alt"></i></a>
						<img id="<?php echo ($imge_id) ?>-img" src="<?php echo ($cat_image) ?>" alt="" />
					</div>
					<input type="hidden" id="<?php echo ($imge_id) ?>" name="cat_image" value="<?php echo ($cat_image) ?>">
					<input type="button" class="jobcircle-upload-media jobcircle-bk-btn button" data-id="<?php echo ($imge_id) ?>" value="<?php esc_html_e('Browse', 'jobcircle-frame') ?>">
				</div>
            </td>
        </tr>
		<?php
	}

	public function job_category_fields_saving($term_id) {
		if (isset($_POST['job_category_custom_fields']) && $_POST['job_category_custom_fields'] == '1') {
			$term_icon = isset($_POST['cat_icon']) ? $_POST['cat_icon'] : '';
			$term_image = isset($_POST['cat_image']) ? $_POST['cat_image'] : '';

			//
			$term_fields = array(
				'icon' => $term_icon,
				'image' => $term_image,
			);

			update_term_meta($term_id, 'job_category_custom_fields', $term_fields);
		}
	}
}

new Jobcircle_Custom_Taxonomy_Meta;
