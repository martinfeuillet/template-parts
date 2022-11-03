<?php
/**
 * Rules section - registration PDF
 *
 * @param string $formation_name
 * @param array  $rules
 *
 * @package WordPress
 * @subpackage Crea
 */

$formation_name = ! empty( $args['formation_name'] ) ? $args['formation_name'] : '';
$rules          = ! empty( $args['rules'] ) ? $args['rules'] : '';
?>

<?php
if ( ! empty( $rules ) ) {
	?>

	<p class="mt-0">
		<strong><?php esc_html_e( 'Règlement d\'admission', 'crea' ); ?> <?php echo esc_html( $formation_name ); ?></strong>
	</p>

	<?php
	foreach ( $rules as $index => $rule ) {
		?>
		<p class="mt-0" style="font-size: 11px; margin-bottom: 8px; line-height: 1.4;">
			<em><?php esc_html_e( 'Article', 'crea' ); ?> <?php echo ++$index; // phpcs:ignore ?></em> :
			<?php
			echo wp_kses(
				$rule['article'],
				array(
					'br' => array(),
				)
			);
			?>
		</p>
		<?php
	}
	?>

	<?php
}
?>
