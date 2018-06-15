<p>
	For each iteration we will ask you to checkout a different Git branch.
</p>

<p>
	Do yourself a (huge) favor: switch using the command-line and don't peek ahead.
	It's like doing a puzzle: seeing the solution right away prevents you from the thought process.
</p>

<h2>The Branch-Menu For Today</h2>

<p>
	<?php foreach ( $branches as $branch ) : ?>
		<code><?= esc_html( $branch ); ?></code> <br>
	<?php endforeach; ?>
</p>

<p>
	To switch a branch, go into the wceu-2018-code folder using your terminal and type:
</p>

<p>
	<code>
		git checkout &lt;branch&gt;
	</code>
</p>

<p>
	For example:
</p>

<p>
	<code>
		git checkout <?= esc_html( $branches[0] ); ?>
	</code>
</p>