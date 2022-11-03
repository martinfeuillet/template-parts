<?php

/**
 * Template Name: Flow Registration
 *
 * Template utilisé pour vérifier la requête
 * et envoyer les information au générateur.
 *
 * @package WordPress
 * @subpackage CREA
 */

$formation_id   = ! empty( $_REQUEST['formation'] ) ? $_REQUEST['formation'] : null;
$is_ebs         = isset( $_REQUEST['isebs'] ) && (bool) $_REQUEST['isebs'] ? true : false;
$formation_type = get_post_type( $formation_id );

if ( $formation_type === 'formation_continue' ) {
	// Force page to be in french
	$current_language = apply_filters( 'wpml_current_language', null );
	do_action( 'wpml_switch_language', 'fr' );
}

require get_template_directory() . '/template-parts/registration/generator.php';
require get_template_directory() . '/template-parts/registration/display.php';

if ( ! empty( $formation_id ) ) {
	$payment_choosen = $_POST['modalite'] ?? '';

	// Config
	$school_email     = get_field( 'email_admin', 'option' );
	$school_ebs_email = 'contact@ebs-geneve.com';
	$school_name      = 'CREA';
	$school_ebs_name  = 'EBS Genève / CREA';
	$formation_city   = '';

	// Payment
	$payment_link = '';
	if ( $formation_type === 'formation_continue' && ! empty( $payment_choosen ) && (int) $payment_choosen === 3 ) {

		$product_id = get_post_meta( $formation_id, 'product', true );
		$product    = wc_get_product( $product_id );

		if ( $product->get_stock_status() == 'instock' ) {

			ob_start();
			?>

			<a href="<?php echo add_query_arg( 'add-to-cart', $product_id, get_permalink() ); ?>" class="btn buy" style="background-color: #3da9ed; -webkit-box-shadow: 0 2px 3px 0 rgba(0, 0, 0, 0.2); box-shadow: 0 2px 3px 0 rgba(0, 0, 0, 0.2); color: #fff; text-transform: uppercase; border: 0; border-radius: 30px; padding: 14px 23px; text-decoration: none; display: inline-block">
				<?php _e( 'Acheter la formation en ligne', 'crea' ); ?></span>
			</a>

			<?php
			$payment_link = ob_get_clean();

		}
	}

	//Get if contract is available
	$timezone              = new DateTimeZone( 'Europe/Zurich' );
	$today                 = new DateTime( 'today', $timezone );
	$filtered_formation_id = ( 'formation_continue' === $formation_type ? apply_filters( 'wpml_object_id', $formation_id, 'formation_continue', true ) : $formation_id );
	$contract_back         = get_field( 'contract_back', $filtered_formation_id );
	$contract_back_date    = ! empty( $contract_back ) ? new DateTime( $contract_back, $timezone ) : '';

	if ( $today <= $contract_back_date ) {

		// Get city of formation
		// only used when a formation takes place in several cities
		$formation_groupement = get_groupement( $formation_id );
		if ( ! empty( $formation_groupement ) ) :
			foreach ( $formation_groupement['formations'] as $other_formations ) :
				if ( (int) $other_formations['formation']->ID === (int) $formation_id ) {
					$formation_city = ' ' . ucfirst( esc_html( $other_formations['label'] ) );
				}
		endforeach;
endif;

		//Check if we have all values
		if ( $formation_type === 'bachelor' ) {
			$fieldsRequest = array(
				'countryISO',
				'titleSelect',
				'studentSurname',
				'studentName',
				'studentBirthday',
				'studentCivilState',
				'studentNationality',
				'studentOrigin',
				'studentAddress',
				'studentAddressNb',
				'studentCity',
				'studentCountry',
				'studentMail',
				'studentMobile',
				'contact1Surname',
				'contact1Name',
				'contact1Profession',
				'contact1Address',
				'contact1AddressNb',
				'contact1City',
				'contact1Mail',
				'accountHolder',
				'accountCity',
				'accountName',
				'accountIBAN',
				'accountSWIFT',
				'school1Name',
				'school1DiplomaName',
				'school1Level',
				'school1Level2',
				'school1DiplomaYear',
			);

			$fieldsEmail = array(
				'studentMail',
				'contact1Mail',
			);

			if ( isset( $_REQUEST['contact2Mail'] ) && ! empty( $_REQUEST['contact2Mail'] ) ) {
				$fieldsEmail[] = 'contact2Mail';
			}

			if ( ! isset( $_REQUEST['contact1Type'] ) || empty( $_REQUEST['contact1Type'] ) || $_REQUEST['contact1Type'] == '0' ) {
				crea_back_form_error( 'missing_value' );
			}

			// Check if applicant has more than 30 years old
			if (
				'formation_continue' !== $formation_type &&
				'master' !== $formation_type &&
				isset( $_REQUEST['studentBirthday'] ) &&
				! empty( $_REQUEST['studentBirthday'] )
			) {

				$tz  = new DateTimeZone( wp_timezone_string() );
				$age = DateTime::createFromFormat( 'd-m-Y', $_REQUEST['studentBirthday'], $tz )
					->diff( new DateTime( 'now', $tz ) )
					->y;

				if ( (int) $age > 30 ) {
					crea_back_form_error( 'too_old' );
				}
			}
		} elseif ( $formation_type === 'master' ) {

			$fieldsRequest = array(
				'countryISO',
				'titleSelect',
				'studentSurname',
				'studentName',
				'studentBirthday',
				'studentCivilState',
				'studentNationality',
				'studentOrigin',
				'studentAddress',
				'studentAddressNb',
				'studentCity',
				'studentCountry',
				'studentMail',
				'studentMobile',
				'accountHolder',
				'accountCity',
				'accountName',
				'accountIBAN',
				'accountSWIFT',
				'school1Name',
				'school1DiplomaName',
				'school1Level',
				'school1Level2',
				'school1DiplomaYear',
			);

			$fieldsEmail = array(
				'studentMail',
			);

			if ( isset( $_REQUEST['companyQuotepart'] ) ) {
				$companyQuote = (int) $_REQUEST['companyQuotepart'];
				if ( ! $companyQuote ) {
					$companyQuote = 0;
				}
			}
		} elseif ( $formation_type === 'formation_continue' ) {

			$fieldsRequest = array(
				'countryISO',
				'titleSelect',
				'studentSurname',
				'studentName',
				'studentBirthday',
				'studentCivilState',
				'studentNationality',
				'studentOrigin',
				'studentAddress',
				'studentAddressNb',
				'studentCity',
				'studentCountry',
				'studentMail',
				'studentMobile',
				'accountHolder',
				'accountCity',
				'accountName',
				'accountIBAN',
				'accountSWIFT',
			);

			$fieldsEmail = array(
				'studentMail',
			);

			$companyQuote = ! empty( $_REQUEST['companyQuotepart'] ) ? (int) $_REQUEST['companyQuotepart'] : 0;

		} elseif ( $formation_type === 'brevet_federal' ) {

			$fieldsRequest = array(
				'countryISO',
				'titleSelect',
				'studentSurname',
				'studentName',
				'studentBirthday',
				'studentCivilState',
				'studentNationality',
				'studentOrigin',
				'studentAddress',
				'studentAddressNb',
				'studentCity',
				'studentCountry',
				'studentMail',
				'studentMobile',
				'accountHolder',
				'accountCity',
				'accountName',
				'accountIBAN',
				'accountSWIFT',
				'school1Name',
				'school1DiplomaName',
				'school1Level',
				'school1Level2',
				'school1DiplomaYear',
			);

			$fieldsEmail = array(
				'studentMail',
			);

			$companyQuote = ! empty( $_REQUEST['companyQuotepart'] ) ? (int) $_REQUEST['companyQuotepart'] : 0;

		} elseif ( $formation_type === 'certificat' ) {

			$fieldsRequest = array(
				'countryISO',
				'titleSelect',
				'studentSurname',
				'studentName',
				'studentBirthday',
				'studentCivilState',
				'studentNationality',
				'studentOrigin',
				'studentAddress',
				'studentAddressNb',
				'studentCity',
				'studentCountry',
				'studentMail',
				'studentMobile',
				'accountHolder',
				'accountCity',
				'accountName',
				'accountIBAN',
				'accountSWIFT',
			);

			$fieldsEmail = array(
				'studentMail',
			);

			$companyQuote = ! empty( $_REQUEST['companyQuotepart'] ) ? (int) $_REQUEST['companyQuotepart'] : 0;

		}

		if ( ! isset( $_REQUEST['titleSelect'] ) || empty( $_REQUEST['titleSelect'] ) || $_REQUEST['titleSelect'] == '0' ) {
			crea_back_form_error( 'missing_value' );
		}

		foreach ( $fieldsRequest as $fieldRequest ) {
			if ( ! crea_check_request( $fieldRequest ) ) {
				crea_back_form_error( 'missing_value' );
			}
		}

		//Check e-mail

		foreach ( $fieldsEmail as $fieldEmail ) {
			if ( ! filter_var( $_REQUEST[ $fieldEmail ], FILTER_VALIDATE_EMAIL ) ) {
				crea_back_form_error( 'email_not_valid' );
			}
		}

		//Check files
		if ( $formation_type === 'formation_continue' ) {

			$filesRequest = array(
				'uploadCV',
				'uploadIDCard',
			);

		} elseif ( $formation_type === 'brevet_federal' ) {

			$filesRequest = array(
				'uploadCV',
				'uploadDiploma',
				'uploadIDCard',
				'uploadPayement',
				'uploadWork',
			);

		} elseif ( $formation_type === 'certificat' ) {

			$filesRequest = array(
				'uploadCV',
				'uploadIDCard',
				'uploadPayement',
			);

		} else {

			$filesRequest = array(
				'uploadLetter',
				'uploadCV',
				'uploadDiploma',
				'uploadIDCard',
				'uploadPayement',
			);

		}


		if ( isset( $_REQUEST['countryISO'] ) && $_REQUEST['countryISO'] == 'CH' ) {
			$filesRequest[] = 'uploadAVS';
		}

		foreach ( $filesRequest as $requestFile ) {
			if ( ! crea_check_file_request( $requestFile ) ) {
				crea_back_form_error( 'bad_files' );
			}
		}

		$uuid = wp_generate_uuid4();

		//Generate object
		$countryISO = $_REQUEST['countryISO'];
		if ( $countryISO == 'CH' ) {
			if ( ! crea_check_request( 'studentCanton' ) ) {
				crea_back_form_error( 'missing_value' );
			} else {
				$state = $_REQUEST['studentCanton'];
			}
		} elseif ( $countryISO == 'FR' ) {
			if ( ! crea_check_request( 'studentDepartment' ) ) {
				crea_back_form_error( 'missing_value' );
			} else {
				$state = $_REQUEST['studentDepartment'];
			}
		} else {
			$state = '';
		}

		//Save attachements
		$avatarFileUrl = '';
		if ( ! empty( $_FILES['uploadIdPhoto']['name'] ) ) {

			$check = crea_save_files_registration( 'uploadIdPhoto', $uuid, 'id-photo' );

			if ( ! $check ) {
				crea_back_form_error( 'bad_files' );
			} else {
				$avatarFileUrl = crea_save_applicant_photo( 'uploadIdPhoto', 100, null, false );
			}
		}

		if ( ! empty( $_FILES['uploadLetter']['name'] ) ) {

			$check = crea_save_files_registration( 'uploadLetter', $uuid, 'letter' );

			if ( ! $check ) {
				crea_back_form_error( 'bad_files' );
			}
		}

		if ( ! empty( $_FILES['uploadCV']['name'] ) ) {

			$check = crea_save_files_registration( 'uploadCV', $uuid, 'cv' );

			if ( ! $check ) {
				crea_back_form_error( 'bad_files' );
			}
		}

		if ( ! empty( $_FILES['uploadDiploma']['name'][0] ) ) {

			$check = crea_save_files_registration( 'uploadDiploma', $uuid, 'diploma' );

			if ( ! $check ) {
				crea_back_form_error( 'bad_files' );
			}
		}

		if ( ! empty( $_FILES['uploadIDCard']['name'][0] ) ) {

			$check = crea_save_files_registration( 'uploadIDCard', $uuid, 'id-card' );

			if ( ! $check ) {
				crea_back_form_error( 'bad_files' );
			}
		} else {
			crea_back_form_error( 'missing_value' );
		}

		if ( $formation_type !== 'formation_continue' ) {

			if ( ! empty( $_FILES['uploadPayement']['name'] ) ) {

				$check = crea_save_files_registration( 'uploadPayement', $uuid, 'payment' );

				if ( ! $check ) {
					crea_back_form_error( 'bad_files' );
				}
			} else {
				crea_back_form_error( 'missing_value' );
			}
		}

		if ( ! empty( $_FILES['uploadAVS']['name'][0] ) ) {

			$check = crea_save_files_registration( 'uploadAVS', $uuid, 'avs' );

			if ( ! $check ) {
				crea_back_form_error( 'bad_files' );
			}
		}

		if ( ! empty( $_FILES['uploadDiploma2']['name'][0] ) ) {

			$check = crea_save_files_registration( 'uploadDiploma2', $uuid, 'diploma2' );

			if ( ! $check ) {
				crea_back_form_error( 'bad_files' );
			}
		}

		if ( $formation_type === 'brevet_federal' ) {

			if ( ! empty( $_FILES['uploadWork']['name'][0] ) ) {

				$check = crea_save_files_registration( 'uploadWork', $uuid, 'work' );

				if ( ! $check ) {
					crea_back_form_error( 'bad_files' );
				}
			} else {
				crea_back_form_error( 'missing_value' );
			}
		}

		$student_address_nb  = ! empty( $_REQUEST['studentAddressNb'] ) ? $_REQUEST['studentAddressNb'] : '';
		$contact1_address_nb = ! empty( $_REQUEST['contact1AddressNb'] ) ? $_REQUEST['contact1AddressNb'] : '';
		$contact2_address_nb = ! empty( $_REQUEST['contact2AddressNb'] ) ? $_REQUEST['contact2AddressNb'] : '';

		$student = new Student( $_REQUEST['titleSelect'], $_REQUEST['studentName'], $_REQUEST['studentSurname'], $_REQUEST['studentBirthday'], $_REQUEST['studentCivilState'], '', '', $_REQUEST['studentMobile'], $_REQUEST['studentMobileCode'], $_REQUEST['studentAddress'] . ' ' . $student_address_nb, $_REQUEST['studentCity'], $_REQUEST['studentCountry'], $state, $countryISO, $_REQUEST['studentOrigin'], $_REQUEST['studentNationality'], $_REQUEST['studentAVS'], $_REQUEST['studentMail'], $avatarFileUrl );

		if ( $formation_type === 'bachelor' ) :

			$contact1 = new Parents( $_REQUEST['contact1Name'], $_REQUEST['contact1Surname'], $_REQUEST['contact1Tel'], $_REQUEST['contact1TelCode'], $_REQUEST['contact1Mobile'], $_REQUEST['contact1MobileCode'], $_REQUEST['contact1Address'] . ' ' . $contact1_address_nb, $_REQUEST['contact1City'], $_REQUEST['contact1Mail'], $_REQUEST['contact1Profession'], $_REQUEST['contact1Type'] );
			$contact2 = new Parents( $_REQUEST['contact2Name'], $_REQUEST['contact2Surname'], $_REQUEST['contact2Tel'], $_REQUEST['contact2TelCode'], $_REQUEST['contact2Mobile'], $_REQUEST['contact2MobileCode'], $_REQUEST['contact2Address'] . ' ' . $contact2_address_nb, $_REQUEST['contact2City'], $_REQUEST['contact2Mail'], $_REQUEST['contact2Profession'], $_REQUEST['contact2Type'] );

		else :

			$contact1 = new Parents();
			$contact2 = new Parents();

		endif;

		$bank        = new BankAccount( $_REQUEST['accountHolder'], $_REQUEST['accountCity'], $_REQUEST['accountName'], $_REQUEST['accountIBAN'], $_REQUEST['accountClearing'], $_REQUEST['accountSWIFT'] );
		$companyBank = new BankAccount( $_REQUEST['companyAccountHolder'], $_REQUEST['companyAccountCity'], $_REQUEST['companyAccountBank'], $_REQUEST['companyAccountIBAN'], $_REQUEST['companyAccountClearing'], $_REQUEST['companyAccountSwift'] );
		$company     = new Company( $_REQUEST['companyName'], $_REQUEST['companyStreet'], $_REQUEST['companyCity'], $_REQUEST['companyMail'], $_REQUEST['companyPhone'], $_REQUEST['companyMobile'], $companyQuote, $companyBank );
		$formations  = array();

		//Add old formations to the list
		if ( isset( $_REQUEST['school1Name'] ) && $_REQUEST['school1Name'] && $_REQUEST['school1DiplomaName'] && $_REQUEST['school1Level'] && $_REQUEST['school1DiplomaYear'] ) {

			$diplomaProgress = false;
			$hasDiploma      = false;
			if ( $_REQUEST['school1HasDiploma'] == 'yes' ) {
				$hasDiploma = true;
			} elseif ( $_REQUEST['school1HasDiploma'] == 'progress' ) {
				$diplomaProgress = true;
			}

			$school1_level = ! empty( $_REQUEST['school1Level2'] ) ? $_REQUEST['school1Level'] . ' - ' . $_REQUEST['school1Level2'] : $_REQUEST['school1Level'];
			$formations[]  = new OldFormation( $_REQUEST['school1DiplomaName'], $_REQUEST['school1Name'], $school1_level, $hasDiploma, $diplomaProgress, $_REQUEST['school1DiplomaYear'] );
		}

		if ( isset( $_REQUEST['school2Name'] ) && $_REQUEST['school2Name'] && $_REQUEST['school2DiplomaName'] && $_REQUEST['school2Level'] && $_REQUEST['school2DiplomaYear'] ) {
			if ( $_REQUEST['school2HasDiploma'] == 'yes' ) {
				$hasDiploma = true;
			} else {
				$hasDiploma      = false;
				$diplomaProgress = false;
				if ( $_REQUEST['school2HasDiploma'] == 'progress' ) {
					$diplomaProgress = true;
				}
			}
			$school2_level = ! empty( $_REQUEST['school2Level2'] ) ? $_REQUEST['school2Level'] . ' - ' . $_REQUEST['school2Level2'] : $_REQUEST['school2Level'];
			$formations[]  = new OldFormation( $_REQUEST['school2DiplomaName'], $_REQUEST['school2Name'], $school2_level, $hasDiploma, $diplomaProgress, $_REQUEST['school2DiplomaYear'] );
		}

		$modaliteNb   = ! empty( $_REQUEST['modalite'] ) ? $_REQUEST['modalite'] : '';
		$freeOptionNb = ! empty( $_REQUEST['free_option'] ) ? $_REQUEST['free_option'] : 2;

		//Generate PDF
		$pdf = get_pdf( $uuid, $formation_id, $student, $contact1, $contact2, $company, $bank, $formations, $modaliteNb, $freeOptionNb, true );

		// Add generated pdf to zip
		$zip         = new ZipArchive();
		$saveZipPath = $_SERVER['DOCUMENT_ROOT'] . '/wp-content/uploads/registrations/' . $uuid . '.zip';

		//Detect if archive for this registration already exist
		if ( ! file_exists( $saveZipPath ) ) {

			$zip->open( $saveZipPath, ZipArchive::CREATE );

		} else {

			$zip->open( $saveZipPath );

		}

		$check = $zip->addFile( untrailingslashit( get_home_path() ) . $pdf, 'contrat-' . $student->get_name() . '-' . $student->get_surname() . '.pdf' );
		$zip->close();

		//Save Data to db
		$registrationDB = new wpdb( DB2_USER, DB2_PASSWORD, DB2_NAME, DB_HOST );

		$session_start      = (string) get_field( 'session_start', $formation_id );
		$sesion_start_date  = strtotime( $session_start );
		$session_start_year = date( 'Y', $sesion_start_date );

		$session_end      = (string) get_field( 'session_end', $formation_id );
		$session_end_date = strtotime( $session_end );
		$session_end_year = date( 'Y', $session_end_date );

		$programmeSession = $session_start_year . ' - ' . $session_end_year;
		$programmeName    = get_the_title( $formation_id );

		//Start JSON encode
		if ( $formation_type == 'bachelor' ) {
			$otherData = array(
				'student'  => $student->get_raw(),
				'contact1' => $contact1->get_raw(),
				'contact2' => $contact2->get_raw(),
				'bank'     => $bank->get_raw(),
			);
		} else {
			$otherData = array(
				'student' => $student->get_raw(),
				'company' => $company->get_raw(),
				'bank'    => $bank->get_raw(),
			);
		}


		$formationCount = 1;
		foreach ( $formations as $row ) {
			$rowName               = 'formation' . $formationCount;
			$otherData[ $rowName ] = $row->get_raw();
			$formationCount        = $formationCount + 1;
		}

		$json = json_encode( $otherData );

		if ( $registrationDB->check_connection() ) {
			$registrationDB->insert(
				'registrations',
				array(
					'ID'        => $uuid,
					'lastname'  => $student->get_surname(),
					'firstname' => $student->get_name(),
					'mail'      => $student->get_mail(),
					'birthday'  => date( 'Y-m-d', strtotime( $student->get_birthday() ) ),
					'programme' => $programmeName,
					'session'   => $programmeSession,
					'pdflink'   => esc_url_raw( trailingslashit( get_site_url() ) . 'wp-content/uploads/registrations/' . $uuid . '.zip' ),
					'other'     => $json,
				)
			);

			/**
			 * PREPARE MAIL FOR STUDENT
			 */

			// Get singular post type name to display before program name in the confirmation email
			$diploma_post_type_object = get_post_type_object( get_post_type( $formation_id ) );
			$diploma_singular_name    = $diploma_post_type_object->labels->singular_name;

			$mail_content = file_get_contents( get_template_directory() . '/assets/mail-registration.html' );
			$mail_content = str_replace( '{title}', __( 'Merci pour votre inscription !', 'crea' ), $mail_content );

			$mail_text  = '<p style="font-size: 14px; color: #666666; font-family: Arial, sans-serif; margin-top: 16px; margin-bottom: 16px;">' . sprintf( __( 'Bonjour %s,', 'crea' ), $student->get_name() ) . '</p>';
			$mail_text .= '<p style="font-size: 14px; color: #666666; font-family: Arial, sans-serif; margin-top: 16px; margin-bottom: 16px;">' . __( 'Nous vous remercions pour l’intérêt que vous portez à notre établissement.', 'crea' ) . '</p>';
			$mail_text .= '<p style="font-size: 14px; color: #666666; font-family: Arial, sans-serif; margin-top: 16px; margin-bottom: 16px;">' . sprintf( __( 'Votre demande d\'inscription à bien été prise en compte et nous accusons bonne réception de votre dossier ainsi que vos pièces justificatives pour le %s.', 'crea ' ), '<strong>' . ucwords( esc_html( $diploma_singular_name . ' ' . $programmeName ) ) . '</strong>' ) . '</p>';
			if ( ! empty( $payment_link ) ) {
				$mail_text .= '<p style="margin-top: 16px; margin-bottom: 16px">' . $payment_link . '</p>';
			}
			$mail_text .= '<p style="font-size: 14px; color: #666666; font-family: Arial, sans-serif; font-weight: bold; margin-top: 16px; margin-bottom: 16px;">' . __( 'Merci de bien vouloir lire attentivement toutes les modalités du contrat et de nous le retourner daté et signé sous 10 jours ouvrés à compter de cette date.', 'crea' ) . '</p>';
			$mail_text .= '<p style="font-size: 14px; color: #666666; font-family: Arial, sans-serif; margin-top: 16px; margin-bottom: 16px;">' . __( 'Ce contrat d’admission est à envoyer par email à', 'crea' ) . ' <a href="mailto:' . ( $is_ebs ? $school_ebs_email : $school_email ) . '">' . ( $is_ebs ? $school_ebs_email : $school_email ) . '</a></p>';
			$mail_text .= '<p style="font-size: 14px; color: #666666; font-family: Arial, sans-serif; font-weight: bold; margin-top: 16px; margin-bottom: 16px;">' . __( 'Ou à l’adresse ci-dessous :', 'crea' ) . '</p>';
			$mail_text .= '<p style="font-size: 14px; color: #666666; font-family: Arial, sans-serif; margin-top: 16px; margin-bottom: 16px;">' . ( $is_ebs ? $school_ebs_name : $school_name ) . '<br />';
			$mail_text .= 'Route des Acacias 43<br />';
			$mail_text .= __( '1227 Genève – Acacias', 'crea' ) . '</p>';
			$mail_text .= '<p style="font-size: 14px; color: #666666; font-family: Arial, sans-serif; margin-top: 16px; margin-bottom: 16px;">' . __( 'L’équipe du Pôle Recrutement & Admissions vous contactera ensuite afin de vous communiquer la suite du processus.', 'crea' ) . '</p>';
			$mail_text .= '<p style="font-size: 14px; color: #666666; font-family: Arial, sans-serif; margin-top: 16px; margin-bottom: 16px;">' . sprintf( __( 'A bientôt à %s !', 'crea' ), ( $is_ebs ? $school_ebs_name : $school_name ) ) . '</p>';
			$mail_text .= '<p style="font-size: 14px; color: #666666; font-family: Arial, sans-serif; margin-top: 16px; margin-bottom: 16px;">Team Recrutement & Admissions </br>';
			$mail_text .= '<a style="margin: 0;" href="tel:+41223381393">D +41 22 338 13 93</a>';

			$mail_content = str_replace( '{content}', $mail_text, $mail_content );
			$mail_content = str_replace( '{pdf_link}', get_home_url() . '?action=getPDF&data=' . $uuid, $mail_content );
			$mail_content = str_replace( '{button_download}', __( 'Télécharger le contrat', 'crea' ), $mail_content );
			$mail_content = str_replace( '{schoolName}', ( $is_ebs ? $school_ebs_name : $school_name ), $mail_content );
			$mail_content = str_replace( '{schoolEmail}', ( $is_ebs ? $school_ebs_email : $school_email ), $mail_content );

			$mail_content = str_replace(
				array(
					'{images_path}',
					'{facebook}',
					'{twitter}',
					'{instagram}',
					'{vimeo}',
					'{header_img}',
					'{details}',
				),
				array(
					site_url( '/wp-content/themes/crea/assets' ),
					get_field( 'facebook', 'option' ),
					get_field( 'twitter', 'option' ),
					get_field( 'instagram', 'option' ),
					get_field( 'vimeo', 'option' ),
					get_template_directory_uri() . '/assets/pics/mail/top.jpg',
					'</br>',
				),
				$mail_content
			);
			//Send e-mail
			wp_mail( $student->get_name() . ' ' . $student->get_surname() . '<' . $student->get_mail() . '>', sprintf( __( 'Confirmation de votre inscription | %s', 'crea' ), html_entity_decode( get_the_title( $formation_id ) ) ), $mail_content, array( 'Content-Type: text/html; charset=UTF-8;', __( 'Crea Genève', 'crea' ) . '<' . get_field( 'email_admin', 'option' ) . '>' ), array() );

			/**
			 * PREPARE E-MAIL FOR CREA
			 */
			$admin_mail_content = file_get_contents( get_template_directory() . '/assets/mail-registration.html' );
			$admin_mail_content = str_replace( '{title}', __( 'Bonjour,', 'crea' ), $admin_mail_content );
			$admin_mail_content = str_replace( '{content}', '<p style="font-size: 14px; color: #666666; font-family: Arial, sans-serif; margin-top: 16px; margin-bottom: 16px;">' . __( 'Une nouvelle personne a rempli son dossier d\'inscription !', 'crea' ) . '</p>', $admin_mail_content );
			$admin_mail_array   = '
			<table>
				<tr>
					<td style="padding-right: 20px;">' . __( 'Nom', 'crea' ) . '</td>
					<td style="padding-left: 10px;">' . $student->get_surname() . '</td>
				</tr>
				<tr>
					<td style="padding-right: 20px;">' . __( 'Prénom', 'crea' ) . '</td>
					<td style="padding-left: 10px;">' . $student->get_name() . '</td>
				</tr>
				<tr>
					<td style="padding-right: 20px;">' . __( 'Formation', 'crea' ) . '</td>
					<td style="padding-left: 10px;">' . get_the_title( $formation_id ) . ' ' . esc_html( $formation_city ) . '</td>
				</tr>
			</table>
			';
			$admin_mail_content = str_replace( '{details}', $admin_mail_array, $admin_mail_content );
			$admin_mail_content = str_replace( '{pdf_link}', get_home_url() . '/wp-admin/admin.php?page=registrations_request', $admin_mail_content );
			$admin_mail_content = str_replace( '{button_download}', __( 'Accéder à l\'administration', 'crea' ), $admin_mail_content );
			$admin_mail_content = str_replace(
				array(
					'{images_path}',
					'{facebook}',
					'{twitter}',
					'{instagram}',
					'{vimeo}',
					'{header_img}',
				),
				array(
					site_url( '/wp-content/themes/crea/assets' ),
					get_field( 'facebook', 'option' ),
					get_field( 'twitter', 'option' ),
					get_field( 'instagram', 'option' ),
					get_field( 'vimeo', 'option' ),
					get_template_directory_uri() . '/assets/pics/mail/top.jpg',
				),
				$admin_mail_content
			);
			$admin_mail_content = str_replace( '{schoolName}', ( $is_ebs ? $school_ebs_name : $school_name ), $admin_mail_content );
			$admin_mail_content = str_replace( '{schoolEmail}', ( $is_ebs ? $school_ebs_email : $school_email ), $admin_mail_content );
			wp_mail( __( 'Crea Genève', 'crea' ) . '<' . get_field( 'email_admin', 'option' ) . '>', sprintf( __( 'Nouveau dossier d\'inscription | %s', 'crea' ), html_entity_decode( get_the_title( $formation_id ) ) ), $admin_mail_content, array( 'Content-Type: text/html; MIME-Version: 1.0; charset=UTF-8;', __( 'Crea Genève', 'crea' ) . '<' . get_field( 'email_admin', 'option' ) . '>' ), array() );
		}
	} else {
		$error = 'contract_unavailble';
	}
} else {
	$error = 'bad_request';
}

if ( $formation_type === 'formation_continue' ) {
	// Get back to original language
	do_action( 'wpml_switch_language', $current_language );
}

//Load a page if contract isn't available
get_header();

if ( $formation_type === 'formation_continue' ) {
	// Force page to be in french
	do_action( 'wpml_switch_language', 'fr' );
}

if ( isset( $error ) and ! empty( $error ) ) {
	$pageTitle = __( 'Une erreur est survenue', 'crea' );

	if ( $error == 'contract_unavailble' ) {
		$pageDescription = get_field( 'error_contract_unaviable', get_the_ID() );
	} else {
		$pageDescription = get_field( 'error_default', get_the_ID() );
	}
} else {
	$background_header_mp4    = get_field( 'background_header_mp4', htmlspecialchars( $_REQUEST['formation'] ) );
	$background_header_webm   = get_field( 'background_header_webm', htmlspecialchars( $_REQUEST['formation'] ) );
	$background_header_ogg    = get_field( 'background_header_ogg', htmlspecialchars( $_REQUEST['formation'] ) );
	$background_header_mobile = get_field( 'background_header_mobile', htmlspecialchars( $_REQUEST['formation'] ) );

	$pageTitle = get_field( 'thank_title', get_the_ID() );

	// Replace {name}
	$student_dear    = ( $student->get_gender() === 'man' ? esc_html__( 'Cher', 'crea' ) : esc_html__( 'Chère', 'crea' ) );
	$pageDescription = str_replace( '{name}', $student_dear . ' ' . $student->get_name(), (string) get_field( 'thank_content', get_the_ID() ) );

	// Replace {schoolName}
	$school_name     = ( $is_ebs ? $school_ebs_name : $school_name );
	$pageDescription = str_replace( '{schoolName}', $school_name, $pageDescription );

	// Replace {formation}
	switch ( get_post_type( $formation_id ) ) {
		case 'master':
			$formationType = __( 'Master', 'crea' );
			break;
		case 'bachelor':
			$formationType = __( 'Bachelor', 'crea' );
			break;
		case 'formation_continue':
			$formationType = __( 'Cycle Certifiant', 'crea' );
			break;
		case 'mba':
			$formationType = __( 'MBA', 'crea' );
			break;
		case 'brevet_federal':
			$formationType = __( 'Brevet fédéral', 'crea' );
			break;
	}

	$pageDescription = str_replace( '{formation}', $formationType . ' ' . get_the_title( $formation_id ) . $formation_city, $pageDescription );

	// replace {schoolEmail}
	$school_desc_email = ( $is_ebs ? '<a href="mailto:' . $school_ebs_email . '">' . $school_ebs_email . '</a>' : '<a href="mailto:' . $school_email . '">' . $school_email . '</a>' );
	$pageDescription   = str_replace( '{schoolEmail}', $school_desc_email, $pageDescription );

	// Replace {paymentLink}
	if ( $formation_type === 'formation_continue' ) {
		$pageDescription = str_replace( '{paymentLink}', '<div class="blue">' . $payment_link . '</div>', $pageDescription );
	} else {
		$pageDescription = str_replace( '{paymentLink}', '', $pageDescription );
	}

	// Add Datalayer
	?>
	<script>
		window.dataLayer = window.dataLayer || [];

		dataLayer.push(
			{
				'event': 'formation_registration_sent'
			}
		);
	</script>
	<?php
}

?>

<div class="registration-thanks">
	<header>
		<?php if ( $background_header_mp4 || $background_header_webm || $background_header_ogg ) : ?>
			<video width="1920" height="900" autoplay="true" loop class="background-header lazyloading">
				<source data-src="<?php echo $background_header_mp4; ?>" type="video/mp4" />
				<source data-src="<?php echo $background_header_webm; ?>" type="video/webm" />
				<source data-src="<?php echo $background_header_ogg; ?>" type="video/ogg" />
			</video>
		<?php else : ?>
			<img class="background-header" src="<?php echo esc_url( cb_image_resize( get_post_thumbnail_id( $formation_id ), 1920, 800, true ) ); ?>" alt="">
		<?php endif; ?>
		<?php if ( $background_header_mobile ) : ?>
			<picture>
				<source media="(min-width: 992px)" sizes="1px" srcset="data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///yH5BAEAAAAALAAAAAABAAEAAAIBRAA7 1w" />
				<img src="<?php echo $background_header_mobile['url']; ?>" class="background-header-mobile" />
			</picture>
		<?php endif; ?>

		<?php
		if ( $is_ebs ) {
			get_template_part( 'template-parts/header-ebs' );
		} else {
			get_template_part( 'template-parts/header' );
		}
		?>

		<div class="container">
			<div class="row page-meta">
				<div class="col-xs-12 col-md-7">
					<div class="encart-title">
						<h1><?php the_title(); ?></h1>
					</div>
				</div>
			</div>
		</div>
	</header>
	<div class="container content">
		<div class="col-xs-12 col-md-6">
			<h2><?php echo $pageTitle; ?></h2>
			<p><?php echo $pageDescription; ?></p>
		</div>
		<?php
		if ( ! isset( $error ) || empty( $error ) ) {
			$download_box_text = get_field( 'download_content' );

			// Replace {schoolEmail}
			$school_dl_email   = ( $is_ebs ? '<a href="mailto:' . $school_ebs_email . '">' . $school_ebs_email . '</a>' : '<a href="mailto:' . $school_email . '">' . $school_email . '</a>' );
			$download_box_text = str_replace( '{schoolEmail}', $school_dl_email, (string) $download_box_text );

			// Replace {schoolName}
			$school_name       = ( $is_ebs ? $school_ebs_name : $school_name );
			$download_box_text = str_replace( '{schoolName}', $school_name, $download_box_text );
			?>

			<div class="col-xs-12 col-md-6 highlight">
				<h3><?php the_field( 'download_title', get_the_ID() ); ?></h3>
				<p><?php echo wp_kses_post( $download_box_text ); ?></p>
				<a href="/?action=getPDF&data=<?php echo $uuid; ?>" target="_blank" class="btn"><?php the_field( 'download_button', get_the_ID() ); ?></a>
			</div>
			<?php
		}
		?>
	</div>
</div>

<?php
if ( $formation_type === 'formation_continue' ) {
	// Get back to original language
	do_action( 'wpml_switch_language', $current_language );
}

if ( $is_ebs ) {
	get_footer( 'ebs' );
} else {
	get_footer();
}
?>
