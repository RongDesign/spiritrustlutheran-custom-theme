<?php
/* execute scheduled events */
function spiritrust_scheduled_events() {
	// CLEAR USED FOR TESTING (DO NOT UNCOMMENT FOR PROD)
	// wp_clear_scheduled_hook('spiritrust_hourly_event');

	if (!wp_next_scheduled('spiritrust_hourly_event')) {
		wp_schedule_event(time(), 'hourly', 'spiritrust_hourly_event');
	}
}
add_action('wp', 'spiritrust_scheduled_events');

/* scheduled event: hourly */
add_action('spiritrust_hourly_event', 'spiritrust_do_hourly');


function filter_divisions($jobTitle) {

	$jobDivision = '';

	if (strpos($jobTitle, 'Home Care & Hospice') !== false) {

		$jobDivision = 'Home Care & Hospice';

	} elseif (strpos($jobTitle, 'Home Office – Chambersburg') !== false) {

		$jobDivision = 'Home Office – Home Care & Hospice';

	} elseif (strpos($jobTitle, 'HOC') !== false) {

		$jobDivision = 'Home Office – SpiriTrust® Lutheran';
	} elseif (strpos($jobTitle, 'In-Home Support') !== false) {

		$jobDivision = 'In-Home Support';

	} elseif (strpos($jobTitle, 'LIFE Center') !== false) {

		$jobDivision = 'LIFE Center';

	} elseif(preg_match('(Counseling Services|Deaf Connections|Domestic Abuse Solutions|Financial Education & Coaching|Senior Companion Program|Stephen Ministry|Touch-a-life|Volunteer Income Tax Assistance)', $jobTitle) === 1) {
		
		$jobDivision = 'Life Enhancing Services';

	} elseif(preg_match('(Village at Gettysburg|Village at Kelly Dr|Village at Luther Ridge|Village at Shrewsbury|Village at Sprenkle Dr|Village at Utz Terrace)', $jobTitle) === 1) {

		$jobDivision = 'Senior Living';

	}

	return $jobDivision;

}

function spiritrust_do_hourly() {

	$url = "https://pm.healthcaresource.com/CareerSite/lutheran/RssHandler.ashx";

	/* create curl resource */
	$ch = curl_init();

	/* set url */
	curl_setopt($ch, CURLOPT_URL, "$url");

	/* return the transfer as a string */
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch,CURLOPT_SSL_VERIFYPEER, false);
	/* $output contains the output string */
	$output = curl_exec($ch);

	/* close curl resource to free up system resources */
	curl_close($ch);

	$xml   = simplexml_load_string($output,'SimpleXMLElement',LIBXML_NOCDATA);
	$json  = json_encode($xml);
	$array = json_decode($json,TRUE);
	$jobs  = $array['job'];
	$i     = 1;

	$emailMarkup  = "Host: " . $_SERVER['HTTP_HOST'] . "\n\n";
	$emailMarkup .= "Scheduled Task Executed On: " . current_time('mysql') . "\n\n";
	$emailMarkup .= "Scheduled Task Results:\n\n";

	//SET wpdb object as global - ties into native wordpress functionality.
	global $wpdb;

	$ref_array = array();
	foreach($jobs as $key=>$val) {

		$referenceNumber = $jobs[$key]['referencenumber'];

		array_push($ref_array, $referenceNumber);
		//THIS LOOP WILL PREFORM THE FOLLOWING.
		//Iterate through returned jobs.

		//Check existing records in DB to ensure that job with same reference number does not already exist.
		$does_job_exist = $wpdb->query("SELECT * FROM wp_posts JOIN wp_postmeta ON wp_posts.ID = wp_postmeta.post_id WHERE wp_postmeta.meta_key='reference_number' AND wp_postmeta.meta_value='".$jobs[$key]['referencenumber']."' ");

		if($does_job_exist){
			//JOB EXISTS, object above returns true.
			//Continue this loop for now, may need to add update logic in the future.
			//Update Post.

			$update_post_id = $wpdb->get_results("SELECT wp_posts.ID FROM wp_posts JOIN wp_postmeta ON wp_posts.ID = wp_postmeta.post_id WHERE wp_postmeta.meta_key='reference_number' AND wp_postmeta.meta_value='".$jobs[$key]['referencenumber']."' ");

			$updatePost = $update_post_id[0]->ID;

			//Title
			$jobTitle = $jobs[$key]['title'];

			$emailMarkup .= $i . " Updated: " . $jobTitle . "\n";

			//Date //FORMAT NUMBER.
			$dateEntered = date('Y-m-d H:i:s',strtotime($jobs[$key]['date']));

			//Reference No.
			$referenceNumber = $jobs[$key]['referencenumber'];

			//URL
			$jobURL = $jobs[$key]['url'];

			//Company
			$jobCompany = $jobs[$key]['company'];

			//City
			$jobCity = $jobs[$key]['city'];

			//State
			$jobState = $jobs[$key]['state'];

			//ZIP
			$jobPostalCode = $jobs[$key]['postalcode'];

			//Clean Description
			$jobs[$key]['description'] = strip_tags($jobs[$key]['description']);
			$jobDescription = $jobs[$key]['description'];

			//JOB Type part or Full time
			$jobType = $jobs[$key]['jobtype'];

			$new_address = "$jobCity,$jobState,$jobPostalCode";

			//Division
			$jobDivision = filter_divisions($jobTitle);

			//Category
			$jobCategory = $jobs[$key]['category'];


			//PERFORM INSERT INTO RELEVANT TABLES.  NEED TO ADD TO wp_posts then wp_postmeta with unique ID of new field.
			// Create post object
			$my_job = array();
			$my_job['ID'] = $updatePost;
			$my_job['post_title'] = $jobTitle;
			$my_job['post_content'] = '';
			$my_job['post_category'] = array(7);
			$my_job['post_status'] = 'publish';
			$my_job['post_author'] = 2; //the id of the CareerAdmin User author
			$my_job['comment_status'] = false;
			$my_job['post_type'] = 'careers';
			$my_job['post_date'] = $dateEntered;
			$my_job['post_date_gmt'] = $dateEntered;

			//Store to DB return post ID for insert into the wp_postMeta page.
			$post_id = wp_update_post($my_job,true);
			if (is_wp_error($post_id)) {
				$errors = $post_id->get_error_messages();
				foreach ($errors as $error) {
					echo $error;
				}
			}

			//Update Custom Field Values
			$wpdb->query("UPDATE wp_postmeta SET meta_value = '$referenceNumber' WHERE  wp_postmeta.meta_key = 'reference_number' AND wp_postmeta.post_id = '$post_id' LIMIT 1");
			$wpdb->query("UPDATE wp_postmeta SET meta_value = '$jobURL' WHERE  wp_postmeta.meta_key = 'url' AND wp_postmeta.post_id = '$post_id' LIMIT 1");
			$wpdb->query("UPDATE wp_postmeta SET meta_value = '$jobCompany' WHERE  wp_postmeta.meta_key = 'company' AND wp_postmeta.post_id = '$post_id' LIMIT 1");
			$wpdb->query("UPDATE wp_postmeta SET meta_value = '$jobCity' WHERE  wp_postmeta.meta_key = 'city' AND wp_postmeta.post_id = '$post_id' LIMIT 1");
			$wpdb->query("UPDATE wp_postmeta SET meta_value = '$jobState' WHERE  wp_postmeta.meta_key = 'state' AND wp_postmeta.post_id = '$post_id' LIMIT 1");
			$wpdb->query("UPDATE wp_postmeta SET meta_value = '$jobPostalCode' WHERE  wp_postmeta.meta_key = 'postal_code' AND wp_postmeta.post_id = '$post_id' LIMIT 1");
			$wpdb->query("UPDATE wp_postmeta SET meta_value = '$jobDescription' WHERE  wp_postmeta.meta_key = 'job_description' AND wp_postmeta.post_id = '$post_id' LIMIT 1");
			$wpdb->query("UPDATE wp_postmeta SET meta_value = '$jobType' WHERE  wp_postmeta.meta_key = 'job_type' AND wp_postmeta.post_id = '$post_id' LIMIT 1");
			$wpdb->query("UPDATE wp_postmeta SET meta_value = '$jobCategory' WHERE  wp_postmeta.meta_key = 'job_category' AND wp_postmeta.post_id = '$post_id' LIMIT 1");
			$wpdb->query("UPDATE wp_postmeta SET meta_value = '$jobDivision' WHERE  wp_postmeta.meta_key = 'job_division' AND wp_postmeta.post_id = '$post_id' LIMIT 1");

			$meta_desc = trim_text($jobDescription, '160', $ellipses = false, $strip_html = true);

			//RULES FOR SEO WORK
			$wpdb->query("UPDATE wp_postmeta SET meta_value = '$jobType $jobTitle - $jobCity, $jobState - $jobCompany' WHERE  wp_postmeta.meta_key = '_yoast_wpseo_focuskw_text_input' AND wp_postmeta.post_id = '$post_id' LIMIT 1");
			$wpdb->query("UPDATE wp_postmeta SET meta_value = '$jobType $jobTitle - $jobCity, $jobState - $jobCompany' WHERE  wp_postmeta.meta_key = '_yoast_wpseo_focuskw' AND wp_postmeta.post_id = '$post_id' LIMIT 1");
			$wpdb->query("UPDATE wp_postmeta SET meta_value = '$meta_desc' WHERE  wp_postmeta.meta_key = '_yoast_wpseo_medadesc' AND wp_postmeta.post_id = '$post_id' LIMIT 1");
			$wpdb->query("UPDATE wp_postmeta SET meta_value = '$jobType $jobTitle - $jobCity, $jobState - $jobCompany' WHERE  wp_postmeta.meta_key = '_yoast_wpseo_title' AND wp_postmeta.post_id = '$post_id' LIMIT 1");

			//Update Post End
		}else{
			//JOB DOES NOT EXIST, object above returns false.
			//FORMAT FIELD DATA

			//Title
			$jobTitle = $jobs[$key]['title'];

			$emailMarkup .= $i . " Inserted: " . $jobTitle . "\n";

			//Date //FORMAT NUMBER.
			$dateEntered = date('Y-m-d H:i:s',strtotime($jobs[$key]['date']));

			//Reference No.
			$referenceNumber = $jobs[$key]['referencenumber'];

			//URL
			$jobURL = $jobs[$key]['url'];

			//Company
			$jobCompany = $jobs[$key]['company'];

			//City
			$jobCity = $jobs[$key]['city'];

			//State
			$jobState = $jobs[$key]['state'];

			//ZIP
			$jobPostalCode = $jobs[$key]['postalcode'];

			//Clean Description
			$jobs[$key]['description'] = strip_tags($jobs[$key]['description']);
			$jobDescription = $jobs[$key]['description'];

			//JOB Type part or Full time
			$jobType = $jobs[$key]['jobtype'];

			$new_address = "$jobCity,$jobState,$jobPostalCode";

			//Category
			$jobCategory = $jobs[$key]['category'];

			//Division
			$jobDivision = filter_divisions($jobTitle);

			//PERFORM INSERT INTO RELEVANT TABLES.  NEED TO ADD TO wp_posts then wp_postmeta with unique ID of new field.
			// Create post object
			$my_job = array();
			$my_job['post_title'] = $jobTitle;
			$my_job['post_content'] = '';
			$my_job['post_category'] = array(7);
			$my_job['post_status'] = 'publish';
			$my_job['post_author'] = 2; //the id of the CareerAdmin User author
			$my_job['comment_status'] = false;
			$my_job['post_type'] = 'careers';
			$my_job['post_date'] = $dateEntered;
			$my_job['post_date_gmt'] = $dateEntered;

			//Store to DB return post ID for insert into the wp_postMeta page.
			$post_id = wp_insert_post($my_job);

			$wpdb->query("INSERT INTO wp_postmeta VALUES('','$post_id','_edit_last','2')");
			$wpdb->query("INSERT INTO wp_postmeta VALUES('','$post_id','_edit_lock','NULL')");
			$wpdb->query("INSERT INTO wp_postmeta VALUES('','$post_id','reference_number','$referenceNumber')");
			$wpdb->query("INSERT INTO wp_postmeta VALUES('','$post_id','_reference_number','field_570b9792a4d59')");
			$wpdb->query("INSERT INTO wp_postmeta VALUES('','$post_id','url','$jobURL')");
			$wpdb->query("INSERT INTO wp_postmeta VALUES('','$post_id','_url','field_570b97b9a4d5a')");
			$wpdb->query("INSERT INTO wp_postmeta VALUES('','$post_id','company','$jobCompany')");
			$wpdb->query("INSERT INTO wp_postmeta VALUES('','$post_id','_company','field_570b97fba4d5b')");
			$wpdb->query("INSERT INTO wp_postmeta VALUES('','$post_id','city','$jobCity')");
			$wpdb->query("INSERT INTO wp_postmeta VALUES('','$post_id','_city','field_570b9818a4d5c')");
			$wpdb->query("INSERT INTO wp_postmeta VALUES('','$post_id','state','$jobState')");
			$wpdb->query("INSERT INTO wp_postmeta VALUES('','$post_id','_state','field_570b982aa4d5d')");
			$wpdb->query("INSERT INTO wp_postmeta VALUES('','$post_id','postal_code','$jobPostalCode')");
			$wpdb->query("INSERT INTO wp_postmeta VALUES('','$post_id','_postal_code','field_570b996fa4d5e')");
			$wpdb->query("INSERT INTO wp_postmeta VALUES('','$post_id','job_description','$jobDescription')");
			$wpdb->query("INSERT INTO wp_postmeta VALUES('','$post_id','_job_description','field_570b9992a4d5f')");
			$wpdb->query("INSERT INTO wp_postmeta VALUES('','$post_id','job_type','$jobType')");
			$wpdb->query("INSERT INTO wp_postmeta VALUES('','$post_id','_job_type','field_570b99b6a4d60')");
			$wpdb->query("INSERT INTO wp_postmeta VALUES('','$post_id','job_category','$jobCategory')");
			$wpdb->query("INSERT INTO wp_postmeta VALUES('','$post_id','_job_category','field_570b99f8a4d61')");
			$wpdb->query("INSERT INTO wp_postmeta VALUES('','$post_id','job_division','$jobDivision')");
			$wpdb->query("INSERT INTO wp_postmeta VALUES('','$post_id','_job_division','field_59c123ca36b65')");
			$wpdb->query("INSERT INTO wp_postmeta VALUES('','$post_id','active_listing','1')");
			$wpdb->query("INSERT INTO wp_postmeta VALUES('','$post_id','_active_listing','field_570b9a1ca4d62')");
			$wpdb->query("INSERT INTO wp_postmeta VALUES('','$post_id','source_of_listing','Health Care Source')");
			$wpdb->query("INSERT INTO wp_postmeta VALUES('','$post_id','_source_of_listing','field_570b9a63a4d63')");

			$meta_desc = trim_text($jobDescription, '160', $ellipses = false, $strip_html = true);

			//RULES FOR SEO WORK
			$wpdb->query("INSERT INTO wp_postmeta VALUES('','$post_id','_yoast_wpseo_focuskw_text_input','$jobType $jobTitle - $jobCity, $jobState - $jobCompany')");
			$wpdb->query("INSERT INTO wp_postmeta VALUES('','$post_id','_yoast_wpseo_focuskw','$jobType $jobTitle - $jobCity, $jobState - $jobCompany')");
			$wpdb->query("INSERT INTO wp_postmeta VALUES('','$post_id','_yoast_wpseo_medadesc','$meta_desc')");
			$wpdb->query("INSERT INTO wp_postmeta VALUES('','$post_id','_yoast_wpseo_title','$jobType $jobTitle - $jobCity, $jobState - $jobCompany')");
		}
		$i++;
	}

	//Remove existing jobs, pass returned array from data feed to remove_jobs function
	//Query selects all posts from the DB that are not currently contained in the jobs feed or associated with ADP as the posting author.
	$no_longer_exists = $wpdb->get_results("SELECT wp_posts.ID FROM wp_posts JOIN wp_postmeta ON wp_posts.ID = wp_postmeta.post_id WHERE wp_postmeta.meta_key='reference_number' AND wp_postmeta.meta_value NOT IN (" . implode(",", $ref_array) . ") AND wp_postmeta.post_id NOT IN (SELECT wp_postmeta.post_id FROM wp_postmeta WHERE wp_postmeta.meta_key='source_of_listing' AND wp_postmeta.meta_value='ADP' ) ");

	foreach($no_longer_exists as $current){
		$emailMarkup .= $i . " Deleted ID: " . $current->ID . "\n";
		$i++;
		wp_delete_post($current->ID, true);
	}

	// EMAIL A COPY OF THE SCHEDULED TASK RESULTS (for testing only)
	// mail('dbryant@jplcreative.com', 'SpiriTrust Lutheran Hourly Scheduled Task', $emailMarkup);

}
?>
