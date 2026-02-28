<?php
/**
 * Title: CTA-band
 * Slug: seniorbolaget/cta-band
 * Categories: seniorbolaget, call-to-action
 * Description: CTA-band med rubrik, knapp och bild i rundad box
 * Viewport Width: 1280
 */
?>
<!-- wp:html -->
<style>
@media (max-width: 768px) {
  .sb-cta-band-columns {
    flex-wrap: wrap !important;
  }
  .sb-cta-band-columns .wp-block-column {
    flex-basis: 100% !important;
    min-width: 100% !important;
  }
  .sb-cta-band-columns .wp-block-column[style*="flex-basis:60%"] {
    padding: 32px 24px !important;
  }
  .sb-cta-band-columns .wp-block-column[style*="flex-basis:40%"] {
    min-height: 200px;
  }
}
</style>
<!-- /wp:html -->

<!-- wp:group {"align":"full","style":{"spacing":{"padding":{"top":"80px","bottom":"80px","left":"clamp(24px, 5vw, 80px)","right":"clamp(24px, 5vw, 80px)"}}},"layout":{"type":"constrained"}} -->
<div class="wp-block-group alignfull">

	<!-- wp:group {"align":"wide","style":{"border":{"radius":"24px"},"spacing":{"padding":{"top":"0","bottom":"0","left":"0","right":"0"}}},"layout":{"type":"default"}} -->
	<div class="wp-block-group alignwide" style="background:radial-gradient(ellipse at 70% 50%, #5A6478 0%, #4A5568 60%);color:#ffffff;border-radius:24px;overflow:hidden">

		<!-- wp:columns {"verticalAlignment":"stretch","style":{"spacing":{"blockGap":{"left":"0"}}},"className":"sb-cta-band-columns"} -->
		<div class="wp-block-columns are-vertically-aligned-stretch sb-cta-band-columns">

			<!-- wp:column {"width":"60%","verticalAlignment":"center","style":{"spacing":{"padding":{"top":"60px","bottom":"60px","left":"60px","right":"40px"}}}} -->
			<div class="wp-block-column is-vertically-aligned-center" style="flex-basis:60%;padding:60px 40px 60px 60px">

				<!-- wp:heading {"level":2,"style":{"typography":{"fontWeight":"700","lineHeight":"1.15","fontSize":"clamp(1.75rem, 4vw, 2.5rem)"},"color":{"text":"#ffffff"}}} -->
				<h2 class="wp-block-heading" style="color:#ffffff;font-size:clamp(1.75rem, 4vw, 2.5rem);font-weight:700;line-height:1.15">Få tiden tillbaka, vi fixar det!</h2>
				<!-- /wp:heading -->

				<!-- wp:paragraph {"style":{"typography":{"fontSize":"var:preset|font-size|md","lineHeight":"1.6"},"color":{"text":"rgba(255,255,255,0.9)"},"spacing":{"margin":{"top":"var:preset|spacing|sm"}}}} -->
				<p style="color:rgba(255,255,255,0.9);font-size:var(--wp--preset--font-size--md);line-height:1.6;margin-top:1rem">Din vardag behöver inte fler måsten. Våra seniora proffs tar hand om det praktiska med omsorg och precision.</p>
				<!-- /wp:paragraph -->

				<!-- wp:buttons {"layout":{"type":"flex","justifyContent":"left","flexWrap":"wrap"},"style":{"spacing":{"blockGap":"var:preset|spacing|sm","margin":{"top":"var:preset|spacing|lg"}}}} -->
				<div class="wp-block-buttons">
					<!-- wp:button {"backgroundColor":"rod","textColor":"vit","style":{"border":{"radius":"50px"},"spacing":{"padding":{"top":"1rem","bottom":"1rem","left":"2.5rem","right":"2.5rem"}}},"className":"is-style-fill"} -->
					<div class="wp-block-button is-style-fill"><a class="wp-block-button__link has-rod-background-color has-vit-color has-text-color has-background wp-element-button" href="/kontakt" style="border-radius:50px;padding:1rem 2.5rem">Kontakta oss</a></div>
					<!-- /wp:button -->
				</div>
				<!-- /wp:buttons -->

			</div>
			<!-- /wp:column -->

			<!-- wp:column {"width":"40%","verticalAlignment":"stretch"} -->
			<div class="wp-block-column is-vertically-aligned-stretch" style="flex-basis:40%">
				<!-- wp:image {"id":54,"sizeSlug":"large","linkDestination":"none","style":{"layout":{"selfStretch":"fill"}},"className":"is-style-default"} -->
				<figure class="wp-block-image size-large is-style-default" style="height:100%"><img src="https://staging.seniorbolaget.se/wp-content/uploads/2026/02/cta-image.png" alt="Senior skottar snö" class="wp-image-54" style="width:100%;height:100%;object-fit:cover"/></figure>
				<!-- /wp:image -->
			</div>
			<!-- /wp:column -->

		</div>
		<!-- /wp:columns -->

	</div>
	<!-- /wp:group -->

</div>
<!-- /wp:group -->
