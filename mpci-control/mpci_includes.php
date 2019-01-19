<?php 
/*
Project Name: 	MPCI-CORPORATE
Description:	MPCI-CORPORATE is new division of Midtown Printing Company Incorporated (MPCI) for creative task.
Developer:		Fil Elman
Version:		mpci-corporate 1.0
Website:		www.mpcicorporate.com
copyright:		@Copyright 2014
*/

# this will prevent from direct accessing of  this file
if( count(get_included_files()) == 1){
	die("Error, Contact webtoprint.midtown.com.ph");
}

# Class mpci_includes includes files from mpci-view
class mpci_includes{
    # this method include display the left side.
	public function mpci_left_left($result){
		include 'mpci-view/mpci_left.php';
	}
	
	# methods that display any message output from the process.
	public function mpci_message($message){
		include 'mpci-view/includes/mpci_message.php';
	}

	# methods that display forgot password form
	public function mpci_forgot_password(){
		include 'mpci-view/includes/mpci_forgot_password.php';
	}
	
	# method that include contact form.
	public function mpci_contact(){
		include 'mpci-view/includes/mpci_contact.php';
	}
	
	# method that display login form
	public function mpci_login(){
		include 'mpci-view/includes/mpci_login.php';
	}
	
	# method that display the sign up form.
	public function mpci_signup($data){
		include 'mpci-view/includes/mpci_signup.php';
	}
	
	# method that display the slider.
	public function mpci_slider($results){
		include 'mpci-view/includes/mpci_slider.php';
	}
	
	# method that display the title below the slider.
	public function mpci_title($title){
		include 'mpci-view/includes/mpci_title.php';
	}
	
	# method that display the featured product.
	public function mpci_featured($results, $query){
		include 'mpci-view/includes/mpci_featured.php';
	}
	
	# method that display list of products.
	public function mpci_productlist($path, $results, $product_category){
		include 'mpci-view/includes/mpci_products.php';
	}

	# method that display list of products.
	public function mpci_upload_design(){
		include 'mpci-view/includes/mpci_upload_design.php';
	}
	
	# method that display mpci corporate information.
	public function mpci_info($results,$category){
		include 'mpci-view/includes/mpci_info.php';
	}
	
	# method that display the location and map.
	public function mpci_location(){
		include 'mpci-view/includes/mpci_location.php';
	}
	
	# method that display the price table.
	public function mpci_price($results, $product, $number_rows){
		include 'mpci-view/includes/mpci_price_table.php';
	}
	
	# method that display the admin.
	public function mpci_admin($option, $email, $first_name, $last_name, $result, $current_url, $data){
		include 'mpci-view/includes/mpci_admin.php';
	}
	
	# method that display the editor.
	public function mpci_editor($id, $category, $title, $message, $option){
		include 'mpci-view/mpci_editor.php';
	}
	
	# view of password reset
	public function forgot_password(){
		include 'mpci-view/includes/mpci_password_reset.php';
	}
	
	# send email to client
	public function send_email_user($data){
		include 'mpci-view/includes/mpci-admin/mpci_send_email_user.php';
	}

	# edit product
	public function product_design($result){
		include 'mpci-view/includes/mpci_edit_product.php';
	}

	# display the remove page of the product category
	public function remove_product_list($list, $path, $remove_category){
		$remove_category = $this->model->encrypt($remove_category);
		include 'mpci-view/includes/mpci_remove_product_list.php';
	}
	
	# display the list of products
	public function display_products($result, $product_dir, $display_product){
		include 'mpci-view/includes/mpci_display.php';
	}
	
	# display the larger uploaded images
	public function display_large_images($link){
		include 'mpci-view/includes/mpci_display_large.php';
	}
	
	# confirmation of removing a category
	public function mpci_remove_confirmation($category){
		include 'mpci-view/includes/mpci_remove_confirmation.php';
	}

	# confirmation of deleting a row
	public function mpci_remove_price_row_confirmation($confirmation, $price_data){
		include 'mpci-view/includes/insert/mpci_remove_price_row_confirmation.php';
	}
}
?>
