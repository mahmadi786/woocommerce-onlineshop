<?php
/**
 * Woo Extra Product Options - Field Forms
 *
 * @author    ThemeHigh
 * @category  Admin
 */

if(!defined('WPINC')){	die; }

if(!class_exists('THWEPOF_Admin_Form_Field')):

class THWEPOF_Admin_Form_Field extends THWEPOF_Admin_Form{
	private $field_props = array();

	public function __construct() {
		parent::__construct();
		$this->init_constants();
	}

	private function init_constants(){
		$this->field_props = $this->get_field_form_props();
	}

	private function get_field_types(){
		return array(
			'inputtext' => 'Text', 'hidden' => 'Hidden', 'number' => 'Number', 'tel' => 'Telephone', 'password' => 'Password', 
			'textarea' => 'Textarea', 'select' => 'Select', 'checkbox' => 'Checkbox', 'checkboxgroup' => 'Checkbox Group', 
			'radio' => 'Radio Button', 'datepicker' => 'Date Picker', 'colorpicker' => 'Colorpicker', 'heading' => 'Heading', 
			'paragraph' => 'Paragraph'
		);
	}

	public function get_field_form_props(){
		$field_types = $this->get_field_types();
		$positions = $this->get_available_positions();
		
		$validators = array(
			'' => 'Select validation',
			'email' => 'Email',
			'number' => 'Number',
		);

		$title_positions = array(
			'left' => 'Left of the field',
			'above' => 'Above field',
		);
		
		return array(
			'name' 		  => array('type'=>'text', 'name'=>'name', 'label'=>'Name', 'required'=>1),
			'type' 		  => array('type'=>'select', 'name'=>'type', 'label'=>'Field Type', 'required'=>1, 'options'=>$field_types, 'onchange'=>'thwepofFieldTypeChangeListner(this)'),
			'value' 	  => array('type'=>'text', 'name'=>'value', 'label'=>'Default Value'),
			'options' 	  => array('type'=>'text', 'name'=>'options', 'label'=>'Options', 'placeholder'=>'separate options with pipe(|)'),
			'placeholder' => array('type'=>'text', 'name'=>'placeholder', 'label'=>'Placeholder'),
			'validator'   => array('type'=>'select', 'name'=>'validator', 'label'=>'Validation', 'placeholder'=>'Select validation', 'options'=>$validators),
			'cssclass'    => array('type'=>'text', 'name'=>'cssclass', 'label'=>'Wrapper Class', 'placeholder'=>'separate classes with comma'),
			'input_class'    => array('type'=>'text', 'name'=>'input_class', 'label'=>'Input Class', 'placeholder'=>'separate classes with comma'),
			'position' 	  => array('type'=>'select', 'name'=>'position', 'label'=>'Position', 'options'=>$positions),
			
			'minlength'   => array('type'=>'number', 'name'=>'minlength', 'label'=>'Min. Length', 'min'=>0, 'hint_text'=>'The minimum number of characters allowed'),
			'maxlength'   => array('type'=>'number', 'name'=>'maxlength', 'label'=>'Max. Length', 'min'=>0, 'hint_text'=>'The maximum number of characters allowed'),

			'step'   => array('type'=>'number', 'name'=>'step', 'label'=>'Step. Value', 'min'=>0, 'hint_text'=>'Specifies the legal number intervals'),

			'cols' => array('type'=>'text', 'name'=>'cols', 'label'=>'Cols', 'hint_text'=>'The visible width of a text area'),
			'rows' => array('type'=>'text', 'name'=>'rows', 'label'=>'Rows', 'hint_text'=>'The visible height of a text area'),
			
			'checked'  => array('type'=>'checkbox', 'name'=>'checked', 'label'=>'Checked by default', 'value'=>'yes', 'checked'=>0),

			'required' => array('type'=>'checkbox', 'name'=>'required', 'label'=>'Required', 'value'=>'yes', 'checked'=>0, 'status'=>1),
			'enabled'  => array('type'=>'checkbox', 'name'=>'enabled', 'label'=>'Enabled', 'value'=>'yes', 'checked'=>1, 'status'=>1),
			'readonly'  => array('type'=>'checkbox', 'name'=>'readonly', 'label'=>'Readonly', 'value'=>'yes', 'checked'=>0, 'status'=>1),
			'view_password'  => array('type'=>'checkbox', 'name'=>'view_password', 'label'=>'Show view password Icon', 'value'=>'yes', 'checked'=>0, 'status'=>1),
			
			'title'          => array('type'=>'text', 'name'=>'title', 'label'=>'Label'),
			'title_position' => array('type'=>'select', 'name'=>'title_position', 'label'=>'Label Position', 'options'=>$title_positions, 'value'=>'left'),
			'title_class'    => array('type'=>'text', 'name'=>'title_class', 'label'=>'Label Class', 'placeholder'=>'separate classes with comma'),

			'input_mask'   => array('type'=>'text', 'name'=>'input_mask', 'label'=>'Input Masking Pattern', 'hint_text'=>'Helps to ensure input to a predefined format like (999) 999-9999.'),
		);
	}

	public function output_field_forms(){
		$this->output_field_form_pp();
		$this->output_form_fragments();
	}

	private function output_field_form_pp(){
		?>
        <div id="thwepof_field_form_pp" class="thpladmin-modal-mask">
          <?php $this->output_popup_form_fields(); ?>
        </div>
        <?php
	}

	/*****************************************/
	/********** POPUP FORM WIZARD ************/
	/*****************************************/
	private function output_popup_form_fields(){
		?>
		<div class="thpladmin-modal">
			<div class="modal-container">
				<span class="modal-close" onclick="thwepofCloseModal(this)">×</span>
				<div class="modal-content">
					<div class="modal-body">
						<div class="form-wizard wizard">
							<aside>
								<side-title class="wizard-title">Save Field</side-title>
								<ul class="pp_nav_links">
									<li class="text-primary active first" data-index="0">
										<i class="dashicons dashicons-admin-generic text-primary"></i>Basic Info
										<i class="i i-chevron-right dashicons dashicons-arrow-right-alt2"></i>
									</li>
									<li class="text-primary" data-index="1">
										<i class="dashicons dashicons-art text-primary"></i>Display Styles
										<i class="i i-chevron-right dashicons dashicons-arrow-right-alt2"></i>
									</li>
									<li class="text-primary last" data-index="2">
										<i class="dashicons dashicons-filter text-primary"></i>Display Rules
										<i class="i i-chevron-right dashicons dashicons-arrow-right-alt2"></i>
									</li>
								</ul>
							</aside>
							<main class="form-container main-full">
								<form method="post" id="thwepof_field_form" action="">
									<input type="hidden" name="i_action" value="" >
									<!--<input type="hidden" name="i_rowid" value="" >-->
									<input type="hidden" name="i_name_old" value="" >
									<input type="hidden" name="i_rules" value="" >

									<div class="data-panel data_panel_0">
										<?php $this->render_form_tab_general_info(); ?>
									</div>
									<div class="data-panel data_panel_1">
										<?php $this->render_form_tab_display_details(); ?>
									</div>
									<div class="data-panel data_panel_2">
										<?php $this->render_form_tab_display_rules(); ?>
									</div>
									<?php wp_nonce_field( 'save_field_property', 'save_field_nonce' ); ?>
								</form>
							</main>
							<footer>
								<span class="Loader"></span>
								<div class="btn-toolbar">
									<button class="save-btn pull-right btn btn-primary" onclick="thwepofSaveField(this)">
										<span>Save & Close</span>
									</button>
									<button class="next-btn pull-right btn btn-primary-alt" onclick="thwepofWizardNext(this)">
										<span>Next</span><i class="i i-plus"></i>
									</button>
									<button class="prev-btn pull-right btn btn-primary-alt" onclick="thwepofWizardPrevious(this)">
										<span>Back</span><i class="i i-plus"></i>
									</button>
								</div>
							</footer>
						</div>
					</div>
				</div>
			</div>
		</div>
		<?php
	}

	/*----- TAB - General Info -----*/
	private function render_form_tab_general_info(){
		$this->render_form_tab_main_title('Basic Details');

		?>
		<div style="display: inherit;" class="data-panel-content">
			<?php
			$this->render_form_fragment_general();
			?>
			<table class="thwepof_field_form_tab_general_placeholder thwepof_pp_table"></table>
		</div>
		<?php
	}

	/*----- TAB - Display Details -----*/
	private function render_form_tab_display_details(){
		$this->render_form_tab_main_title('Display Settings');

		?>
		<div style="display: inherit;" class="data-panel-content">
			<table class="thwepof_pp_table compact">
				<?php
				$this->render_form_elm_row($this->field_props['cssclass']);
				//$this->render_form_elm_row($this->field_props['input_class']);
				$this->render_form_elm_row($this->field_props['title_class']);

				$this->render_form_elm_row($this->field_props['title_position']);
				//$this->render_form_elm_row($this->field_props['title_type']);
				//$this->render_form_elm_row($this->field_props['title_color']);

				//$this->render_form_elm_row_cb($this->field_props['hide_in_cart']);
				//$this->render_form_elm_row_cb($this->field_props['hide_in_checkout']);
				//$this->render_form_elm_row_cb($this->field_props['hide_in_order']);
				//$this->render_form_elm_row_cb($this->field_props['hide_in_order_admin']);
				?>
			</table>
		</div>
		<?php
	}

	/*----- TAB - Display Rules -----*/
	private function render_form_tab_display_rules(){
		$this->render_form_tab_main_title('Display Rules');

		?>
		<div style="display: inherit;" class="data-panel-content">
			<table class="thwepof_pp_table thwepof-display-rules">
				<?php
				$this->render_form_fragment_rules('field'); 
				?>
			</table>
		</div>
		<?php
	}

	/*-------------------------------*/
	/*------ Form Field Groups ------*/
	/*-------------------------------*/
	private function render_form_fragment_general($input_field = true){
		?>
		<div class="err_msgs"></div>
        <table class="thwepof_pp_table">
        	<?php
			$this->render_form_elm_row($this->field_props['type']);
			$this->render_form_elm_row($this->field_props['name']);
			?>
        </table>  
        <?php
	}

	private function output_form_fragments(){
		$this->render_form_field_inputtext();
		$this->render_form_field_hidden();
		$this->render_form_field_number();
		$this->render_form_field_tel();
		$this->render_form_field_password();
		$this->render_form_field_textarea();
		$this->render_form_field_select();
		$this->render_form_field_checkbox();
		$this->render_form_field_radio();

		$this->render_form_field_checkboxgroup();
		$this->render_form_field_datepicker();
		$this->render_form_field_colorpicker();
		$this->render_form_field_heading();
		$this->render_form_field_paragraph();
		
		$this->render_field_form_fragment_product_list();
		$this->render_field_form_fragment_category_list();
		$this->render_field_form_fragment_tag_list();
	}

	private function render_form_field_inputtext(){
		?>
        <table id="thwepof_field_form_id_inputtext" class="thwepo_pp_table" style="display:none;">
        	<?php
			$this->render_form_elm_row($this->field_props['title']);
			//$this->render_form_elm_row($this->field_props['title_position']);
			$this->render_form_elm_row($this->field_props['value']);
			$this->render_form_elm_row($this->field_props['placeholder']);
			$this->render_form_elm_row($this->field_props['minlength']);
			$this->render_form_elm_row($this->field_props['maxlength']);
			//$this->render_form_elm_row($this->field_props['cssclass']);
			//$this->render_form_elm_row($this->field_props['title_class']);
			$this->render_form_elm_row($this->field_props['validator']);
			$this->render_form_elm_row($this->field_props['input_mask']);

			$this->render_form_elm_row_cb($this->field_props['required']);
			$this->render_form_elm_row_cb($this->field_props['enabled']);
			?>
        </table>
        <?php   
	}

	private function render_form_field_hidden(){
		?>
        <table id="thwepof_field_form_id_hidden" class="thwepo_pp_table" style="display:none;">
			<?php
			$this->render_form_elm_row($this->field_props['title']);
			$this->render_form_elm_row($this->field_props['value']);

			$this->render_form_elm_row_cb($this->field_props['required']);
			$this->render_form_elm_row_cb($this->field_props['enabled']);
			?>  
        </table>
        <?php   
	}

	private function render_form_field_number(){
		$min_attribute = $this->field_props['minlength'];
        $min_attribute['label'] = 'Min. Value';
		$min_attribute['hint_text'] = 'The minimum value allowed';

        $max_attribute = $this->field_props['maxlength'];
        $max_attribute['label'] = 'Max. Value';
		$max_attribute['hint_text'] = 'The maximum value allowed';

		?>
        <table id="thwepof_field_form_id_number" class="thwepo_pp_table" style="display:none;">
            <?php
			$this->render_form_elm_row($this->field_props['title']);
			//$this->render_form_elm_row($this->field_props['title_position']);
			$this->render_form_elm_row($this->field_props['value']);
			$this->render_form_elm_row($this->field_props['placeholder']);

			$this->render_form_elm_row($min_attribute);
			$this->render_form_elm_row($max_attribute);
			$this->render_form_elm_row($this->field_props['step']);
			//$this->render_form_elm_row($this->field_props['cssclass']);
			//$this->render_form_elm_row($this->field_props['title_class']);

			$this->render_form_elm_row_cb($this->field_props['required']);
			$this->render_form_elm_row_cb($this->field_props['enabled']);
			?>     
        </table>
        <?php   
	}

	private function render_form_field_tel(){
		?>
        <table id="thwepof_field_form_id_tel" class="thwepo_pp_table" style="display:none;">
            <?php
			$this->render_form_elm_row($this->field_props['title']);
			//$this->render_form_elm_row($this->field_props['title_position']);
			$this->render_form_elm_row($this->field_props['value']);
			$this->render_form_elm_row($this->field_props['placeholder']);
			//$this->render_form_elm_row($this->field_props['cssclass']);
			//$this->render_form_elm_row($this->field_props['title_class']);
			$this->render_form_elm_row($this->field_props['validator']);

			$this->render_form_elm_row_cb($this->field_props['required']);
			$this->render_form_elm_row_cb($this->field_props['enabled']);
			?>    
        </table>
        <?php   
	}

	private function render_form_field_password(){
		?>
        <table id="thwepof_field_form_id_password" class="thwepo_pp_table" style="display:none;">
            <?php
			$this->render_form_elm_row($this->field_props['title']);
			//$this->render_form_elm_row($this->field_props['title_position']);
			$this->render_form_elm_row($this->field_props['value']);
			$this->render_form_elm_row($this->field_props['placeholder']);
			//$this->render_form_elm_row($this->field_props['cssclass']);
			//$this->render_form_elm_row($this->field_props['title_class']);
			$this->render_form_elm_row($this->field_props['validator']);

			$this->render_form_elm_row_cb($this->field_props['required']);
			$this->render_form_elm_row_cb($this->field_props['enabled']);
			$this->render_form_elm_row_cb($this->field_props['view_password']);
			?>  
        </table>
        <?php   
	}
	
	private function render_form_field_textarea(){
		?>
        <table id="thwepof_field_form_id_textarea" class="thwepo_pp_table" style="display:none;">
            <?php
			$this->render_form_elm_row($this->field_props['title']);
			//$this->render_form_elm_row($this->field_props['title_position']);
			$this->render_form_elm_row($this->field_props['value']);
			$this->render_form_elm_row($this->field_props['placeholder']);
			//$this->render_form_elm_row($this->field_props['cssclass']);
			//$this->render_form_elm_row($this->field_props['title_class']);
			$this->render_form_elm_row($this->field_props['cols']);
			$this->render_form_elm_row($this->field_props['rows']);
			$this->render_form_elm_row($this->field_props['minlength']);
			$this->render_form_elm_row($this->field_props['maxlength']);
			$this->render_form_elm_row($this->field_props['validator']);

			$this->render_form_elm_row_cb($this->field_props['required']);
			$this->render_form_elm_row_cb($this->field_props['enabled']);
			?>      
        </table>
        <?php   
	}
	
	private function render_form_field_select(){
		?>
        <table id="thwepof_field_form_id_select" class="thwepo_pp_table" style="display:none;">
            <?php
			$this->render_form_elm_row($this->field_props['title']);
			$this->render_form_elm_row($this->field_props['placeholder']);
			$this->render_form_elm_row($this->field_props['options']);
			$this->render_form_elm_row($this->field_props['value']);
			//$this->render_form_elm_row($this->field_props['cssclass']);
			//$this->render_form_elm_row($this->field_props['title_class']);
			//$this->render_form_elm_row($this->field_props['title_position']);

			$this->render_form_elm_row_cb($this->field_props['required']);
			$this->render_form_elm_row_cb($this->field_props['enabled']);
			?>
        </table>
        <?php   
	}
	
	private function render_form_field_radio(){
		?>
        <table id="thwepof_field_form_id_radio" class="thwepo_pp_table" style="display:none;">
            <?php
			$this->render_form_elm_row($this->field_props['title']);
			//$this->render_form_elm_row($this->field_props['title_position']);
			$this->render_form_elm_row($this->field_props['options']);
			$this->render_form_elm_row($this->field_props['value']);
			//$this->render_form_elm_row($this->field_props['cssclass']);
			//$this->render_form_elm_row($this->field_props['title_class']);

			$this->render_form_elm_row_cb($this->field_props['required']);
			$this->render_form_elm_row_cb($this->field_props['enabled']);
			?>
        </table>
        <?php   
	}
	
	private function render_form_field_checkbox(){
		$prop_value = $this->field_props['value'];
		$prop_value['label'] = 'Value';

		?>
        <table id="thwepof_field_form_id_checkbox" class="thwepo_pp_table" style="display:none;">
            <?php
			$this->render_form_elm_row($this->field_props['title']);
			$this->render_form_elm_row($prop_value);			
			//$this->render_form_elm_row($this->field_props['cssclass']);
			//$this->render_form_elm_row($this->field_props['title_class']);

			$this->render_form_elm_row_cb($this->field_props['checked']);
			$this->render_form_elm_row_cb($this->field_props['required']);
			$this->render_form_elm_row_cb($this->field_props['enabled']);
			?>
        </table>
        <?php   
	}
	
	private function render_form_field_checkboxgroup(){

		$min_checked = $this->field_props['minlength'];
        $min_checked['label'] = 'Min. Selections';
		$min_checked['hint_text'] = 'The minimum checked item';

        $max_checked = $this->field_props['maxlength'];
        $max_checked['label'] = 'Max. Selections';
		$max_checked['hint_text'] = 'The maximum checked item';

		?>
        <table id="thwepof_field_form_id_checkboxgroup" class="thwepo_pp_table" style="display:none;">
            <?php
			$this->render_form_elm_row($this->field_props['title']);
			//$this->render_form_elm_row($this->field_props['title_position']);
			$this->render_form_elm_row($this->field_props['options']);
			$this->render_form_elm_row($this->field_props['value']);

			$this->render_form_elm_row($min_checked);
			$this->render_form_elm_row($max_checked);
			//$this->render_form_elm_row($this->field_props['cssclass']);
			//$this->render_form_elm_row($this->field_props['title_class']);

			$this->render_form_elm_row_cb($this->field_props['required']);
			$this->render_form_elm_row_cb($this->field_props['enabled']);
			?>
        </table>
        <?php   
	}
	
	private function render_form_field_datepicker(){
		$prop_value = $this->field_props['value'];
		$prop_value['label'] = 'Default Date';
		//$prop_value['hint_text'] = 'Specify a date in the format mm/dd/yyyy.';
		//$prop_value['hint_text'] = "Specify a date in the format {month} {dd}, {year}, or number of days from today (e.g. +7) or a string of values and periods ('y' for years, 'm' for months, 'w' for weeks, 'd' for days, e.g. '+1m +7d'), or leave empty for today.";
		$prop_value['hint_text'] = 'Enter default date in the format {month} {dd}, {year}';

		?>
        <table id="thwepof_field_form_id_datepicker" class="thwepo_pp_table" width="100%" style="display:none;">
            <?php
			$this->render_form_elm_row($this->field_props['title']);
			//$this->render_form_elm_row($this->field_props['title_position']);
			$this->render_form_elm_row($prop_value);
			$this->render_form_elm_row($this->field_props['placeholder']);
			//$this->render_form_elm_row($this->field_props['cssclass']);
			//$this->render_form_elm_row($this->field_props['title_class']);

			$this->render_form_elm_row_cb($this->field_props['required']);
			$this->render_form_elm_row_cb($this->field_props['enabled']);
			$this->render_form_elm_row_cb($this->field_props['readonly']);
			?> 
        </table>
        <?php   
	}
	
	private function render_form_field_colorpicker(){
		$prop_value = $this->field_props['value'];
		$prop_value['label'] = 'Default Color';
		$prop_value['type'] = 'colorpicker';
		
		?>
        <table id="thwepof_field_form_id_colorpicker" class="thwepo_pp_table" width="100%" style="display:none;">
            <?php
			$this->render_form_elm_row($this->field_props['title']);
			$this->render_form_elm_row_cp($prop_value);
			//$this->render_form_elm_row($this->field_props['cssclass']);
			//$this->render_form_elm_row($this->field_props['title_class']);
			//$this->render_form_elm_row($this->field_props['title_position']);

			$this->render_form_elm_row_cb($this->field_props['required']);
			$this->render_form_elm_row_cb($this->field_props['enabled']);
			?> 
        </table>
        <?php   
	}
	
	private function render_form_field_heading(){
		$prop_value = $this->field_props['value'];
		$prop_value['label'] = 'Heading Text';

		?>
        <table id="thwepof_field_form_id_heading" class="thwepo_pp_table" style="display:none;">
			<?php
			$this->render_form_elm_row($prop_value);
			$this->render_form_elm_row($this->field_props['cssclass']);

			$this->render_form_elm_row_cb($this->field_props['enabled']);
			?>
        </table>
        <?php   
	}
	
	private function render_form_field_paragraph(){
		$prop_value = $this->field_props['value'];
		$prop_value['type'] = 'textarea';
		$prop_value['label'] = 'Content';

		?>
        <table id="thwepof_field_form_id_paragraph" class="thwepo_pp_table" style="display:none;">
			<?php
			$this->render_form_elm_row($prop_value);
			$this->render_form_elm_row($this->field_props['cssclass']);

			$this->render_form_elm_row_cb($this->field_props['enabled']);
			?>
        </table>
        <?php  
	}

	/*
	private function render_form_fragment_options(){
		?>
		<tr>
			<td class="sub-title"><?php _e('Options', 'woo-extra-product-options'); ?></td>
			<?php $this->render_form_fragment_tooltip(); ?>
			<td></td>
		</tr>
		<tr>
			<td colspan="3" class="p-0">
				<table border="0" cellpadding="0" cellspacing="0" class="thwepo-option-list thpladmin-options-table"><tbody>
					<tr>
						<td class="key"><input type="text" name="i_options_key[]" placeholder="Option Value"></td>
						<td class="value"><input type="text" name="i_options_text[]" placeholder="Option Text"></td>
						<td class="price"><input type="text" name="i_options_price[]" placeholder="Price"></td>
						<td class="price-type">    
							<select name="i_options_price_type[]">
								<option selected="selected" value="">Fixed</option>
								<option value="percentage">Percentage</option>
							</select>
						</td>
						<td class="action-cell">
							<a href="javascript:void(0)" onclick="thwepoAddNewOptionRow(this)" class="btn btn-tiny btn-primary" title="Add new option">+</a><a href="javascript:void(0)" onclick="thwepoRemoveOptionRow(this)" class="btn btn-tiny btn-danger" title="Remove option">x</a><span class="btn btn-tiny sort ui-sortable-handle"></span>
						</td>
					</tr>
				</tbody></table>            	
			</td>
		</tr>
        <?php
	}
	*/


	function notusing(){
		?>
		<!--<div class="container-fluid">
				<div class="row">
				    <div class="col-sm-1">
				    	<img src="http://localhost/thpro/wp-content/plugins/woocommerce-email-customizer/admin/assets/images/header.svg" alt="Header">
				      	<p>Text</p>
				    </div>
				    <div class="col-sm-1">
				    	<img src="http://localhost/thpro/wp-content/plugins/woocommerce-email-customizer/admin/assets/images/header.svg" alt="Header">
				      <p>Hidden</p>
				    </div>
				    <div class="col-sm-1">
				    	<img src="http://localhost/thpro/wp-content/plugins/woocommerce-email-customizer/admin/assets/images/header.svg" alt="Header">
				      <p>Number</p>
				    </div>
				    <div class="col-sm-1">
				    	<img src="http://localhost/thpro/wp-content/plugins/woocommerce-email-customizer/admin/assets/images/header.svg" alt="Header">
				      <p>Telephone</p>
				    </div>
				    <div class="col-sm-1">
				    	<img src="http://localhost/thpro/wp-content/plugins/woocommerce-email-customizer/admin/assets/images/header.svg" alt="Header">
				      <p>Password</p>
				    </div>
				    <div class="col-sm-1">
				    	<img src="http://localhost/thpro/wp-content/plugins/woocommerce-email-customizer/admin/assets/images/header.svg" alt="Header">
				      <p>Textarea</p>
				    </div>
				    <div class="col-sm-1">
				    	<img src="http://localhost/thpro/wp-content/plugins/woocommerce-email-customizer/admin/assets/images/header.svg" alt="Header">
				      	<p>Text</p>
				    </div>
				    <div class="col-sm-1">
				    	<img src="http://localhost/thpro/wp-content/plugins/woocommerce-email-customizer/admin/assets/images/header.svg" alt="Header">
				      <p>Hidden</p>
				    </div>
				    <div class="col-sm-1">
				    	<img src="http://localhost/thpro/wp-content/plugins/woocommerce-email-customizer/admin/assets/images/header.svg" alt="Header">
				      <p>Number</p>
				    </div>
				    <div class="col-sm-1">
				    	<img src="http://localhost/thpro/wp-content/plugins/woocommerce-email-customizer/admin/assets/images/header.svg" alt="Header">
				      <p>Telephone</p>
				    </div>
				    <div class="col-sm-1">
				    	<img src="http://localhost/thpro/wp-content/plugins/woocommerce-email-customizer/admin/assets/images/header.svg" alt="Header">
				      <p>Password</p>
				    </div>
				    <div class="col-sm-1">
				    	<img src="http://localhost/thpro/wp-content/plugins/woocommerce-email-customizer/admin/assets/images/header.svg" alt="Header">
				      <p>Textarea</p>
				    </div>
				</div>
			</div>
			-->
		<?php
	}
}

endif;