<?php
/**
 * Parents identity - registration PDF
 * Used for Bachelors
 *
 * @param int         $formation_id
 * @param string      $formation_type
 * @param string      $sesion_start_date Session start date formatted in date.
 * @param string      $session_start_year Session start date year.
 * @param string      $session_start_month_year Session start date month and year.
 * @param string      $sesion_end_date Session end date formatted in date.
 * @param string      $session_end_year Session end date year.
 * @param string      $session_end_month_year Session end date month and year.
 * @param string      $base_pdf_path Path of registration pdf files.
 * @param string      $padding_bottom Padding at the bottom of the page.
 * @param Student     $student
 * @param Parents     $contact1
 * @param Parents     $contact2
 * @param Company     $company
 * @param BankAccount $bank
 * @param array       $formations List of past formations.
 * @param string      $modalite_nb
 * @param string      $free_option_nb
 * @param string      $section_number
 * @param string      $formation_name
 *
 * @package WordPress
 * @subpackage Crea
 */

?>

<?php
$contact_1_link  = $contact1->get_other();
$contact_1_title = crea_get_contact_title( $contact_1_link );
$contact_2_link  = $contact2->get_other();
$contact_2_title = crea_get_contact_title( $contact_2_link );
?>
<table class="col col-2x mt-big" valign="top">
	<tr>
		<td>
			<strong><?php echo esc_html( $contact_1_title ); ?></strong>
		</td>
		<td>
			<strong><?php echo esc_html( $contact_2_title ); ?></strong>
		</td>
	</tr>
	<tr>
		<td>
			<?php esc_html_e( 'Nom et prénom', 'crea' ); ?> : <span style="color: #1155cc;"><?php echo esc_html( $contact1->get_identity() ); ?></span>
		</td>
		<td>
			<?php esc_html_e( 'Nom et prénom', 'crea' ); ?> : <span style="color: #1155cc;"><?php echo esc_html( $contact2->get_identity() ); ?></span>
		</td>
	</tr>
	<tr>
		<td>
			<?php esc_html_e( 'Profession', 'crea' ); ?> : <span style="color: #1155cc;"><?php echo esc_html( $contact1->get_profession() ); ?></span>
		</td>
		<td>
			<?php esc_html_e( 'Profession', 'crea' ); ?> : <span style="color: #1155cc;"><?php echo esc_html( $contact2->get_profession() ); ?></span>
		</td>
	</tr>
	<tr>
		<td>
			<?php esc_html_e( 'Rue', 'crea' ); ?> : <span style="color: #1155cc;"><?php echo esc_html( $contact1->get_address() ); ?></span>
		</td>
		<td>
			<?php esc_html_e( 'Rue', 'crea' ); ?> : <span style="color: #1155cc;"><?php echo esc_html( $contact2->get_address() ); ?></span>
		</td>
	</tr>
	<tr>
		<td>
			<?php esc_html_e( 'NPA et Ville', 'crea' ); ?> : <span style="color: #1155cc;"><?php echo esc_html( $contact1->get_city() ); ?></span>
		</td>
		<td>
			<?php esc_html_e( 'NPA et Ville', 'crea' ); ?> : <span style="color: #1155cc;"><?php echo esc_html( $contact2->get_city() ); ?></span>
		</td>
	</tr>
	<tr>
		<td>
			<?php esc_html_e( 'Mail', 'crea' ); ?> : <span style="color: #1155cc;"><?php echo esc_html( $contact1->get_mail() ); ?></span>
		</td>
		<td>
			<?php esc_html_e( 'Mail', 'crea' ); ?> : <span style="color: #1155cc;"><?php echo esc_html( $contact2->get_mail() ); ?></span>
		</td>
	</tr>
	<tr>
		<td>
			<?php esc_html_e( 'Mobile', 'crea' ); ?> : <span style="color: #1155cc;"><?php echo esc_html( $contact1->get_mobile() ); ?></span>
		</td>
		<td>
			<?php esc_html_e( 'Mobile', 'crea' ); ?> : <span style="color: #1155cc;"><?php echo esc_html( $contact2->get_mobile() ); ?></span>
		</td>
	</tr>
</table>
