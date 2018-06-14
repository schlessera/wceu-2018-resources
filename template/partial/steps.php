<?php declare( strict_types=1 );

use WordCampEurope\Resources\ContentStep;

/* @var $steps ContentStep[] */
?>

<?php foreach ( $steps as $n => $step ) : ?>
	<h2><?= esc_html( $n . '. ' . $step->get_title() ); ?></h2>

	<p>
		<?= wp_kses_post( $step->get_description() ); ?>
	</p>

	<?php if ( $step->get_image() ) : ?>
		<p>
			<a href="<?= esc_url_raw( $step->get_image() ); ?>">
				<img src="<?= esc_url_raw( $step->get_image() ); ?>" alt="Step <?= $n; ?>">
			</a>
		</p>
	<?php endif; ?>
<?php endforeach; ?>