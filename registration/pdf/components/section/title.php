<?php
/**
 * Registration pdf section title
 *
 * @param string $number
 * @param string $title
 *
 * @package WordPress
 * @subpackage Crea
 */

$number = ! empty( $args['number'] ) ? (int) $args['number'] : 1;
?>

<table class="mt-big mb" style="font-size: 14px; font-weight: bold;">
	<tr>
		<td style="width: 5%;"><?php echo esc_html( number_to_roman( $number ) ); ?></td>
		<td style="width: 95%;">
			<?php echo ! empty( $args['title'] ) ? esc_html( $args['title'] ) : ''; ?>
		</td>
	</tr>
</table>
