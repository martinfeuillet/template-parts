<?php

/**
 * Fonction utilisé pour obtenir le code HTML utilisé pour générer le dossier d'incription
 *
 * @param Int         $formation_id L'ID de la formation.
 * @param Student     $student Informations concernant l'élève.
 * @param Parents     $contact1 Informations concernant la mère de l'élève.
 * @param Parents     $contact2 Informations concernant le père.
 * @param Company     $company Information concerrnant l'entreprise.
 * @param BankAccount $bank Informations concernant le compte en banque.
 * @param array       $formations Liste des anciennes formations.
 * @param string      $modalite_nb Le numéro de la modalité de paiement choisi.
 * @param string      $free_option_nb Le numéro de l'option gratuite choisie (non par défaut).
 *
 * @return string Le code HTML du PDF
 *
 * @package WordPress
 * @subpackage Crea
 */

use WPML\TM\Menu\TranslationBasket\Strings;

function pdf_generate_html(int $formation_id, Student $student, Parents $contact1, Parents $contact2, Company $company, BankAccount $bank, array $formations, string $modalite_nb = '', string $free_option_nb) {

	// Check if we have a formation id.
	if (empty($formation_id)) {
		return esc_html__('Please enter a formation ID', 'crea');
	}

	// Check if formation type is part of accepted types.
	$formation_type       = get_post_type($formation_id);
	$formation_type_lists = array(
		'formation_continue',
		'master',
		'bachelor',
		'brevet_federal',
		'certificat',
	);

	if (!in_array($formation_type, $formation_type_lists, true)) {
		return __('Formation not valid', 'crea');
	}

	// Globals vars.
	$sesion_start_date        = get_field('session_start', $formation_id);
	$session_start_year       = wp_date('Y', strtotime($sesion_start_date));
	$session_start_month_year = ucfirst(wp_date('F Y', strtotime($sesion_start_date)));
	$session_end_date         = get_field('session_end', $formation_id);
	$session_end_year         = wp_date('Y', strtotime($session_end_date));
	$session_end_month_year   = ucfirst(wp_date('F Y', strtotime($session_end_date)));
	$base_pdf_path            = get_stylesheet_directory() . '/template-parts/registration/pdf';
	$padding_bottom           = '35mm';
	$section_number           = 1;
	$formation_name           = get_post_type_object($formation_type)->labels->singular_name;

	ob_start();
?>

	<link rel="stylesheet" href="<?php echo esc_url(get_stylesheet_directory() . '/template-parts/registration/pdf/crea-contract.css'); ?>" type="text/css"> <?php // phpcs:ignore 
																																								?>

<?php
	// Get pages.
	switch ($formation_type) {
		case 'bachelor':
			require $base_pdf_path . '/components/document/header.php';
			require $base_pdf_path . '/components/section/header.php';
			require $base_pdf_path . '/components/section/student-identity.php';
			require $base_pdf_path . '/bachelor/parents-identity.php';
			require $base_pdf_path . '/components/page/break.php'; // Pagebreak.
			require $base_pdf_path . '/components/section/student-bank.php';
			require $base_pdf_path . '/components/section/formations.php';
			require $base_pdf_path . '/components/section/documents.php';
			require $base_pdf_path . '/components/page/break.php'; // Pagebreak.
			require $base_pdf_path . '/components/section/registration.php';
			require $base_pdf_path . '/components/page/break.php'; // Pagebreak.
			require $base_pdf_path . '/bachelor/payment.php';
			require $base_pdf_path . '/components/page/break.php'; // Pagebreak.
			require $base_pdf_path . '/components/section/clause-withdrawal.php';
			require $base_pdf_path . '/components/section/clause-payment.php';
			require $base_pdf_path . '/components/section/clause-echec.php';
			require $base_pdf_path . '/components/section/clause-exceptional.php';
			require $base_pdf_path . '/components/section/clause-fired.php';
			require $base_pdf_path . '/components/section/clause-failed.php';
			require $base_pdf_path . '/components/page/break.php'; // Pagebreak.
			require $base_pdf_path . '/components/section/clause-adjournment.php';
			require $base_pdf_path . '/components/section/internship.php';
			require $base_pdf_path . '/components/section/exams.php';
			require $base_pdf_path . '/components/page/break.php'; // Pagebreak.
			require $base_pdf_path . '/components/section/period.php';
			require $base_pdf_path . '/components/section/final.php';
			require $base_pdf_path . '/components/page/break.php'; // Pagebreak.
			require $base_pdf_path . '/components/section/sign-student.php';
			require $base_pdf_path . '/components/section/sign-payer.php';
			require $base_pdf_path . '/bachelor/rules.php';
			require $base_pdf_path . '/components/document/footer.php';
			break;

		case 'master':
			require $base_pdf_path . '/components/document/header.php';
			require $base_pdf_path . '/components/section/header.php';
			require $base_pdf_path . '/components/section/student-identity.php';
			require $base_pdf_path . '/components/section/student-bank.php';
			require $base_pdf_path . '/components/page/break.php'; // Pagebreak.
			require $base_pdf_path . '/components/section/formations.php';
			require $base_pdf_path . '/components/section/documents.php';
			require $base_pdf_path . '/components/page/break.php'; // Pagebreak.
			require $base_pdf_path . '/components/section/registration.php';
			require $base_pdf_path . '/components/page/break.php'; // Pagebreak.
			require $base_pdf_path . '/master/payment.php';
			require $base_pdf_path . '/master/employer-identity.php';
			require $base_pdf_path . '/master/employer-bank.php';
			require $base_pdf_path . '/components/section/clause-withdrawal.php';
			require $base_pdf_path . '/components/section/clause-payment.php';
			require $base_pdf_path . '/components/section/clause-echec.php';
			require $base_pdf_path . '/components/section/clause-exceptional.php';
			require $base_pdf_path . '/components/section/clause-failed.php';
			require $base_pdf_path . '/components/section/clause-adjournment.php';
			require $base_pdf_path . '/components/section/internship.php';
			require $base_pdf_path . '/components/section/exams.php';
			require $base_pdf_path . '/components/section/period.php';
			require $base_pdf_path . '/components/section/final.php';
			require $base_pdf_path . '/components/page/break.php'; // Pagebreak.
			require $base_pdf_path . '/components/section/sign-student.php';
			require $base_pdf_path . '/components/section/sign-payer.php';
			require $base_pdf_path . '/master/sign-employer.php';
			require $base_pdf_path . '/master/rules.php';
			require $base_pdf_path . '/components/document/footer.php';
			break;

		case 'certificat':
			require $base_pdf_path . '/components/document/header.php';
			require $base_pdf_path . '/components/section/header.php';
			require $base_pdf_path . '/components/section/student-identity.php';
			require $base_pdf_path . '/components/section/student-bank.php';
			require $base_pdf_path . '/components/page/break.php'; // Pagebreak.
			require $base_pdf_path . '/components/section/formations.php';
			require $base_pdf_path . '/components/section/documents.php';
			require $base_pdf_path . '/components/page/break.php'; // Pagebreak.
			require $base_pdf_path . '/components/section/registration.php';
			require $base_pdf_path . '/certificat/payment.php';
			require $base_pdf_path . '/master/employer-identity.php';
			require $base_pdf_path . '/master/employer-bank.php';
			require $base_pdf_path . '/components/section/clause-withdrawal.php';
			require $base_pdf_path . '/components/section/clause-payment.php';
			require $base_pdf_path . '/components/section/clause-echec.php';
			require $base_pdf_path . '/components/section/clause-exceptional.php';
			require $base_pdf_path . '/components/section/clause-failed.php';
			require $base_pdf_path . '/components/section/clause-adjournment.php';
			require $base_pdf_path . '/components/section/final.php';
			require $base_pdf_path . '/components/page/break.php'; // Pagebreak.
			require $base_pdf_path . '/components/section/sign-student.php';
			require $base_pdf_path . '/components/section/sign-payer.php';
			require $base_pdf_path . '/certificat/rules.php';
			require $base_pdf_path . '/components/document/footer.php';
			break;

		case 'formation_continue':
			require $base_pdf_path . '/components/document/header.php';
			require $base_pdf_path . '/components/section/header.php';
			require $base_pdf_path . '/components/section/student-identity.php';
			require $base_pdf_path . '/components/section/student-bank.php';
			require $base_pdf_path . '/components/page/break.php'; // Pagebreak.
			require $base_pdf_path . '/components/section/formations.php';
			require $base_pdf_path . '/components/section/documents.php';
			require $base_pdf_path . '/components/page/break.php'; // Pagebreak.
			require $base_pdf_path . '/components/section/registration.php';
			require $base_pdf_path . '/formation-continue/payment.php';
			require $base_pdf_path . '/master/employer-identity.php';
			require $base_pdf_path . '/master/employer-bank.php';
			require $base_pdf_path . '/components/section/clause-withdrawal.php';
			require $base_pdf_path . '/components/section/clause-payment.php';
			require $base_pdf_path . '/components/section/clause-echec.php';
			require $base_pdf_path . '/components/section/clause-exceptional.php';
			require $base_pdf_path . '/components/section/clause-adjournment.php';
			require $base_pdf_path . '/components/section/final.php';
			require $base_pdf_path . '/components/page/break.php'; // Pagebreak.
			require $base_pdf_path . '/components/section/sign-student.php';
			require $base_pdf_path . '/components/section/sign-payer.php';
			require $base_pdf_path . '/master/sign-employer.php';
			require $base_pdf_path . '/formation-continue/rules.php';
			require $base_pdf_path . '/components/document/footer.php';
			break;

		case 'brevet_federal':
			require $base_pdf_path . '/components/document/header.php';
			require $base_pdf_path . '/components/section/header.php';
			require $base_pdf_path . '/components/section/student-identity.php';
			require $base_pdf_path . '/components/section/student-bank.php';
			require $base_pdf_path . '/components/page/break.php'; // Pagebreak.
			require $base_pdf_path . '/components/section/formations.php';
			require $base_pdf_path . '/components/section/documents.php';
			require $base_pdf_path . '/components/page/break.php'; // Pagebreak.
			require $base_pdf_path . '/brevet-federal/registration.php';
			require $base_pdf_path . '/master/payment.php';
			require $base_pdf_path . '/master/employer-identity.php';
			require $base_pdf_path . '/master/employer-bank.php';
			require $base_pdf_path . '/components/page/break.php'; // Pagebreak.
			require $base_pdf_path . '/components/section/clause-withdrawal.php';
			require $base_pdf_path . '/components/section/clause-payment.php';
			require $base_pdf_path . '/components/section/clause-echec.php';
			require $base_pdf_path . '/components/section/clause-exceptional.php';
			require $base_pdf_path . '/components/section/clause-adjournment.php';
			require $base_pdf_path . '/components/section/final.php';
			require $base_pdf_path . '/components/page/break.php'; // Pagebreak.
			require $base_pdf_path . '/components/section/sign-student.php';
			require $base_pdf_path . '/components/section/sign-payer.php';
			require $base_pdf_path . '/master/sign-employer.php';
			require $base_pdf_path . '/brevet-federal/rules.php';
			require $base_pdf_path . '/components/document/footer.php';
			break;
	}

	return ob_get_clean();
}
