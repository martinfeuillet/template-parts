<?php
/**
 * Footer - Registration pdf
 *
 * @package WordPress
 * @subpackage Crea
 */

?>

<pagefooter>

	<p class="mt-0 mb" style="font-size: 8px; text-align:center; font-weight: bold; color: #8c8c8c;">
		<span style="color:#f84f71">
			<?php esc_html_e( 'GENÈVE', 'crea' ); ?>
		</span>
		BAT43L - RTE DES ACACIAS 43  1227 GENÈVE  +41 22 338 15 80  /
		<span style="color:#f84f71">
			<?php esc_html_e( 'LAUSANNE', 'crea' ); ?>
		</span>
		41 AVENUE DE LA GARE  CH-1003 LAUSANNE  +41 21 601 16 10<br>
		info@creageneve.com  www.creageneve.com
	</p>
	<table valign="middle" style="font-size: 8px; color: #8c8c8c;">
		<tr>
			<td style="text-align: left; width: 20%; opacity: 0.5;">
				<?php echo esc_html( crea_get_month( wp_date( 'n' ) ) . ' ' . wp_date( 'Y' ) ); ?>
			</td>
			<td style="text-align: center; width: 60%;">
				<img src="<?php echo esc_url( get_theme_file_path( '/assets/pics/logo-omnes.jpeg' ) ); ?>" alt="" style="max-width: 90px;">
			</td>
			<td style="text-align: right; width: 20%;">
				{PAGENO}
			</td>
		</tr>
	</table>

</pagefooter>
