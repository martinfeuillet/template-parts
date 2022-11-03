<?php
/**
 * Header of registration PDF
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

<!-- Header -->
<?php
$avatar_url  = $student->get_avatar_url();
$avatar_path = ! empty( $avatar_url ) ? WP_CONTENT_DIR . '/' . str_replace( '/wp-content/', '', wp_parse_url( $avatar_url, PHP_URL_PATH ) ) : '';
?>
<table valign="top">
	<tr>
		<td style="width: 60%;">
			<img class="mb-big" src="<?php echo esc_url( get_theme_file_path( '/assets/pics/logo.png' ) ); ?>" style="max-width: 110px; display: block;">
			<p style="font-size: 14px;">
				<?php esc_html_e( 'Contrat d\'admission', 'crea' ); ?><br>
				<?php esc_html_e( 'CREA ECOLE DE CREATION EN COMMUNICATION SA', 'crea' ); ?><br>
				(<?php esc_html_e( 'ci-après CREA', 'crea' ); ?>)
			</p>
		</td>
		<td style="width: 10%;"></td>
		<td style="width: 30%; text-align: right;">
			<?php if ( ! empty( $avatar_path ) ) { ?>
				<img src="<?php echo esc_url( $avatar_path ); ?>" alt="" style="max-width: 110px;">
			<?php } ?>
		</td>
	</tr>
</table>

<!-- Diploma title -->
<?php
// Get city of formation (only used when a formation takes place in several cities).
$formation_groupement = get_groupement( $formation_id );
$formation_city       = '';

if ( ! empty( $formation_groupement ) ) {
	foreach ( $formation_groupement['formations'] as $other_formations ) {
		if ( (int) $other_formations['formation']->ID === (int) $formation_id ) {
			$formation_city = $other_formations['label'];
		}
	}
}

if (
	empty( $formation_city ) &&
	'brevet_federal' === $formation_type
) {
	$formation_city = __( 'Lausanne', 'crea' );
}

$intro_extra = get_post_meta( $formation_id, 'cc_registration_intro_extra', true );
if (
	empty( $formation_city ) &&
	'formation_continue' === $formation_type &&
	! empty( $intro_extra )
) {
	$formation_city = $intro_extra;
}
?>

<h2 class="mt-small mb-0">
	<?php
	echo esc_html( get_post_type_object( $formation_type )->labels->singular_name ) .
		( 'certificat' !== $formation_type ? ' ' . esc_html__( 'en', 'crea' ) . ' ' : ' ' ) .
		esc_html( get_the_title( $formation_id ) ) .
		( ! empty( $formation_city ) ? ' (' . esc_html( $formation_city ) . ')' : '' );
	?>
	<br>
	<?php
	if (
		'certificat' === $formation_type ||
		'formation_continue' === $formation_type ||
		'brevet_federal' === $formation_type
	) {

		echo esc_html__( 'Session', 'crea' ) .
			' ' .
			esc_html( $session_start_month_year ) .
			' - ' .
			esc_html( $session_end_month_year );

	} else {

		echo esc_html__( 'Session', 'crea' ) .
			' ' .
			esc_html( $session_start_year ) .
			' - ' .
			esc_html( $session_end_year );
	}
	?>
</h2>
