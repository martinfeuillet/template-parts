<?php
/**
 * Past formations - registration PDF
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

<!-- Level 1 title -->
<?php
get_template_part(
	'template-parts/registration/pdf/components/section/title',
	null,
	array(
		'number' => $section_number++,
		'title'  => __( 'Formations antérieures', 'crea' ),
	),
);
?>

<!-- Formations antérieures -->
<?php
$nb_of_lines      = 2;
$nb_of_formations = count( $formations );
$empty_lines      = $nb_of_lines - (int) $nb_of_formations;
?>
<table class="border" cellspacing="0" valign="middle">
	<tr>
		<th style="width: 30%;">
			<?php esc_html_e( 'Nom de l\'école', 'crea' ); ?>
		</th>
		<th style="width: 25%;">
			<?php esc_html_e( 'Titre du diplôme / Année', 'crea' ); ?>
		</th>
		<th style="width: 30%;">
			<?php esc_html_e( 'Nom du diplôme', 'crea' ); ?>
		</th>
		<th style="width: 15%;">
			<?php esc_html_e( 'Diplôme obtenu', 'crea' ); ?>
		</th>
	</tr>
	<?php
	foreach ( $formations as $row ) {
		?>
		<tr>
			<td style="width: 30%;">
				<span style="color: #1155cc;"><?php echo esc_html( $row->get_school() ); ?></span>
			</td>
			<td style="width: 25%;">
				<span style="color: #1155cc;"><?php echo esc_html( $row->get_name() ); ?><br>
				<?php echo esc_html( $row->get_year() ); ?></span>
			</td>
			<td style="width: 30%;">
				<span style="color: #1155cc;"><?php echo esc_html( $row->get_level() ); ?></span>
			</td>
			<td style="width: 15%;">
				<span style="color: #1155cc;">
					<?php
					if ( $row->get_has_diploma() ) {
						esc_html_e( 'Oui', 'crea' );
					} elseif ( $row->get_is_in_progress() ) {
						esc_html_e( 'En cours', 'crea' );
					} else {
						esc_html_e( 'Non', 'crea' );
					}
					?>
				</span>
			</td>
		</tr>
		<?php
	}

	// Maybe fill in with empty lines.
	if ( $empty_lines > 0 ) {

		for ( $i = 0; $i < $empty_lines; $i++ ) {
			?>
			<tr>
				<td style="width: 30%; height: 60px;"></td>
				<td style="width: 25%; height: 60px;"></td>
				<td style="width: 30%; height: 60px;"></td>
				<td style="width: 15%; height: 60px;">
					<?php esc_html_e( 'Oui / Non', 'crea' ); ?>
				</td>
			</tr>
			<?php
		}
	}
	?>
</table>
