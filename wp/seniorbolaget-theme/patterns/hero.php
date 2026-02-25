<?php
/**
 * Title: Hero – Startsida
 * Slug: seniorbolaget/hero
 * Categories: seniorbolaget, banner, featured
 * Description: Stor hero-sektion med rubrik, undertext, CTA-knappar och bild
 * Viewport Width: 1280
 */
?>
<!-- wp:group {"align":"full","style":{"color":{"background":"var:preset|color|ljus-rosa-beige"},"spacing":{"padding":{"top":"100px","bottom":"100px","left":"20px","right":"20px"}}},"layout":{"type":"constrained"}} -->
<div class="wp-block-group alignfull has-ljus-rosa-beige-background-color has-background">

	<!-- wp:columns {"align":"wide","style":{"spacing":{"blockGap":{"left":"60px"}}}} -->
	<div class="wp-block-columns alignwide">

		<!-- wp:column {"width":"55%","verticalAlignment":"center"} -->
		<div class="wp-block-column is-vertically-aligned-center" style="flex-basis:55%">

			<!-- wp:heading {"level":1,"style":{"typography":{"fontWeight":"700","lineHeight":"1.1","fontSize":"clamp(2.5rem, 5vw, 3.75rem)"},"color":{"text":"var:preset|color|rod"},"spacing":{"margin":{"bottom":"0"}}}} -->
			<h1 class="wp-block-heading has-rod-color has-text-color" style="color:var(--wp--preset--color--rod);font-size:clamp(2.5rem, 5vw, 3.75rem);font-weight:700;line-height:1.1">Hemtjänster av erfarna seniorer – städning, trädgård &amp; hantverk</h1>
			<!-- /wp:heading -->

			<!-- wp:paragraph {"style":{"typography":{"fontSize":"var:preset|font-size|lg","lineHeight":"1.6"},"color":{"text":"var:preset|color|rod"},"spacing":{"margin":{"top":"var:preset|spacing|md"}}}} -->
			<p class="has-rod-color has-text-color" style="color:var(--wp--preset--color--rod);font-size:var(--wp--preset--font-size--lg);line-height:1.6;margin-top:2rem">Behöver du hjälp med städning, målning, tapetsering, byggprojekt eller trädgård och snöskottning? Seniorbolaget finns här för att göra vardagen enklare, tryggare och lite lättare.</p>
			<!-- /wp:paragraph -->

			<!-- wp:buttons {"layout":{"type":"flex","justifyContent":"left","flexWrap":"wrap"},"style":{"spacing":{"blockGap":"var:preset|spacing|sm","margin":{"top":"var:preset|spacing|lg"}}}} -->
			<div class="wp-block-buttons">
				<!-- wp:button {"backgroundColor":"rod","textColor":"vit","style":{"border":{"radius":"50px"},"spacing":{"padding":{"top":"0.875rem","bottom":"0.875rem","left":"2rem","right":"2rem"}}},"className":"is-style-fill"} -->
				<div class="wp-block-button is-style-fill"><a class="wp-block-button__link has-rod-background-color has-vit-color has-text-color has-background wp-element-button" href="/intresse-anmalan" style="border-radius:50px;padding-top:0.875rem;padding-bottom:0.875rem;padding-left:2rem;padding-right:2rem">Boka hjälp idag</a></div>
				<!-- /wp:button -->
			</div>
			<!-- /wp:buttons -->

			<!-- wp:group {"style":{"spacing":{"margin":{"top":"var:preset|spacing|lg"}}},"layout":{"type":"flex","flexWrap":"wrap","justifyContent":"left","gap":"var:preset|spacing|lg"}} -->
			<div class="wp-block-group" style="margin-top:3rem;display:flex;flex-wrap:wrap;justify-content:flex-start;gap:2rem">
				<!-- wp:paragraph {"style":{"typography":{"fontWeight":"600","fontSize":"0.9rem"}}} -->
				<p style="font-weight:600;font-size:0.9rem">📞 010-175 19 00</p>
				<!-- /wp:paragraph -->
				<!-- wp:paragraph {"style":{"typography":{"fontWeight":"600","fontSize":"0.9rem"}}} -->
				<p style="font-weight:600;font-size:0.9rem">⭐ 98% nöjda kunder</p>
				<!-- /wp:paragraph -->
				<!-- wp:paragraph {"style":{"typography":{"fontWeight":"600","fontSize":"0.9rem"}}} -->
				<p style="font-weight:600;font-size:0.9rem">📍 20+ orter i Sverige</p>
				<!-- /wp:paragraph -->
			</div>
			<!-- /wp:group -->

		</div>
		<!-- /wp:column -->

		<!-- wp:column {"width":"45%","verticalAlignment":"center"} -->
		<div class="wp-block-column is-vertically-aligned-center" style="flex-basis:45%">
			<!-- wp:image {"id":53,"sizeSlug":"large","linkDestination":"none","style":{"border":{"radius":"24px"}}} -->
			<figure class="wp-block-image size-large has-custom-border"><img src="http://localhost:8888/wp-content/uploads/hero.jpg" alt="Glad senior som städar" class="wp-image-53" style="border-radius:24px"/></figure>
			<!-- /wp:image -->
		</div>
		<!-- /wp:column -->

	</div>
	<!-- /wp:columns -->

</div>
<!-- /wp:group -->
