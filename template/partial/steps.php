<?php declare( strict_types=1 );

use WordCampEurope\WorkshopAuth\PageStep;

/* @var $steps PageStep[] */
?>

<?php foreach ( $steps as $n => $step ) : ?>
	<h2><?= $n . '. ' . $step->get_title(); ?></h2>

	<?php if ( $step->get_image() ) : ?>
		<p>
			<a href="<?= $step->get_image(); ?>">
				<img src="<?= $step->get_image(); ?>" alt="Step <?= $n; ?>">
			</a>
		</p>
	<?php endif; ?>
	<p>
		<?= $step->get_description(); ?>
	</p>
<?php endforeach; ?>