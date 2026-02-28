<?php
/**
 * Title: Kundrecensioner
 * Slug: seniorbolaget/testimonials
 * Categories: seniorbolaget, testimonials
 * Description: Kundcitat i scrollande marquee
 * Viewport Width: 1280
 */
?>
<!-- wp:html -->
<section class="sb-marquee-section">

<style>
.sb-marquee-section {
    background: #FAFAF8;
    padding: 100px 0;
    overflow: hidden;
}
.sb-marquee-header {
    text-align: center;
    padding: 0 clamp(24px, 5vw, 80px);
    margin-bottom: 56px;
}
.sb-marquee-header .sb-label {
    font-family: Inter, sans-serif;
    font-size: 0.8rem;
    font-weight: 600;
    letter-spacing: 0.1em;
    text-transform: uppercase;
    color: #C91C22;
    display: block;
    margin-bottom: 12px;
}
.sb-marquee-header h2 {
    font-family: Rubik, sans-serif;
    font-size: clamp(1.75rem, 3vw, 2.5rem);
    font-weight: 700;
    color: #1F2937;
    margin: 0;
}

/* Marquee wrapper med fade-masker */
.sb-marquee-wrap {
    position: relative;
}
.sb-marquee-wrap::before,
.sb-marquee-wrap::after {
    content: '';
    position: absolute;
    top: 0;
    bottom: 0;
    width: clamp(60px, 10vw, 160px);
    z-index: 2;
    pointer-events: none;
}
.sb-marquee-wrap::before {
    left: 0;
    background: linear-gradient(to right, #FAFAF8 0%, transparent 100%);
}
.sb-marquee-wrap::after {
    right: 0;
    background: linear-gradient(to left, #FAFAF8 0%, transparent 100%);
}

/* Scrollande track */
.sb-marquee-track {
    display: flex;
    gap: 24px;
    width: max-content;
    animation: sb-marquee 50s linear infinite;
    padding: 16px 0 24px;
}
.sb-marquee-track:hover {
    animation-play-state: paused;
}

@keyframes sb-marquee {
    from { transform: translateX(0); }
    to   { transform: translateX(-50%); }
}

/* Kort */
.sb-review-card {
    width: 320px;
    flex-shrink: 0;
    background: #ffffff;
    border-radius: 16px;
    padding: 28px;
    box-shadow: 0 4px 24px -4px rgba(0,0,0,0.07);
    border: 1px solid rgba(0,0,0,0.05);
    cursor: default;
    transition: box-shadow 0.3s ease, transform 0.3s ease;
}
.sb-review-card:hover {
    box-shadow: 0 12px 40px -8px rgba(0,0,0,0.13);
    transform: translateY(-4px);
}

/* Stjärnor */
.sb-stars {
    display: flex;
    gap: 3px;
    color: #C91C22;
    margin-bottom: 16px;
}
.sb-stars svg {
    width: 18px;
    height: 18px;
    flex-shrink: 0;
}

/* Citat */
.sb-review-card blockquote {
    font-family: Inter, sans-serif;
    font-size: 0.9375rem;
    line-height: 1.7;
    color: #374151;
    font-style: italic;
    margin: 0 0 20px;
    padding: 0;
    border: none;
}

/* Avatar + namn */
.sb-review-author {
    display: flex;
    align-items: center;
    gap: 12px;
}
.sb-avatar {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    background: #C91C22;
    color: #fff;
    font-family: Rubik, sans-serif;
    font-size: 15px;
    font-weight: 700;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
}
.sb-author-name {
    font-family: Inter, sans-serif;
    font-size: 0.9rem;
    font-weight: 700;
    color: #C91C22;
    margin: 0;
    line-height: 1.3;
}
.sb-author-meta {
    font-family: Inter, sans-serif;
    font-size: 0.8rem;
    color: #9CA3AF;
    margin: 2px 0 0;
    line-height: 1.3;
}

/* CTA under marquee */
.sb-testimonial-cta {
    text-align: center;
    padding: 56px clamp(24px, 5vw, 80px) 0;
}
.sb-testimonial-cta p { margin: 0; }
.sb-testimonial-cta .sb-cta-title {
    font-family: Inter, sans-serif;
    font-size: 1.25rem;
    font-weight: 600;
    color: #1F2937;
    margin-bottom: 8px;
}
.sb-testimonial-cta .sb-cta-sub {
    font-family: Inter, sans-serif;
    font-size: 1rem;
    color: #6B7280;
    margin-bottom: 24px;
}
.sb-testimonial-cta a {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    background: #C91C22;
    color: #fff;
    font-family: Rubik, sans-serif;
    font-size: 1.0625rem;
    font-weight: 700;
    padding: 16px 32px;
    border-radius: 50px;
    text-decoration: none;
    box-shadow: 0 4px 20px rgba(201,28,34,0.35);
    transition: transform 0.2s, box-shadow 0.2s;
}
.sb-testimonial-cta a:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 28px rgba(201,28,34,0.45);
}
.sb-testimonial-cta .sb-cta-micro {
    font-family: Inter, sans-serif;
    font-size: 0.8125rem;
    color: #9CA3AF;
    margin-top: 16px;
}
</style>

<div class="sb-marquee-header">
    <span class="sb-label">Recensioner</span>
    <h2>Vad säger våra kunder om oss</h2>
</div>

<div class="sb-marquee-wrap">
    <div class="sb-marquee-track">

        <?php
        $star_svg = '<svg viewBox="0 0 24 24" fill="currentColor"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>';
        $stars = '<div class="sb-stars">' . str_repeat($star_svg, 5) . '</div>';

        $reviews = [
            [
                'initial' => 'A',
                'name'    => 'Anna',
                'meta'    => '52 år, Helsingborg',
                'quote'   => '"Ni gjorde ett toppenjobb med hemstädningen varje månad. Alltid punktliga, trevliga och lämnar lägenheten så fin att jag nästan själv vill fortsätta städa. Tack för att ni gör vardagen enklare!"',
            ],
            [
                'initial' => 'L',
                'name'    => 'Lars',
                'meta'    => '67 år, Trollhättan',
                'quote'   => '"Efter att vi anlitade Seniorbolaget för trädgårdsskötsel har vi kunnat njuta av vår uteplats istället för att känna att det måste fixas. Senioren som kommer är kunnig, lyhörd och gör jobbet med ett leende."',
            ],
            [
                'initial' => 'M',
                'name'    => 'Maria',
                'meta'    => '38 år, Malmö',
                'quote'   => '"Som fastighetsbolag uppskattar vi ramavtalet med Seniorbolaget — vi ringer in hjälp när vi behöver, utan lång väntan. Kvalitet och pålitlighet varje gång."',
            ],
            [
                'initial' => 'B',
                'name'    => 'Birgitta',
                'meta'    => '71 år, Göteborg',
                'quote'   => '"Senioren som kom till mig var så omtänksam och noggrann. Det kändes tryggt att öppna dörren — inte alls som att anlita ett stort anonymt städbolag."',
            ],
            [
                'initial' => 'K',
                'name'    => 'Karl-Erik',
                'meta'    => '64 år, Stockholm',
                'quote'   => '"ROT-avdraget gick smidigt, de skötte allt mot Skatteverket. Målningen blev proffsig och vi slapp stressen. Rekommenderar varmt!"',
            ],
            [
                'initial' => 'E',
                'name'    => 'Eva',
                'meta'    => '58 år, Helsingborg',
                'quote'   => '"Hjälpen med trädgården är guld värd. Senioren känner sig uppskattad och vi får en välskött trädgård — en riktig win-win!"',
            ],
        ];

        // Duplicera för sömlös loop (50% trick)
        $all = array_merge($reviews, $reviews);

        foreach ($all as $r) {
            echo '<div class="sb-review-card">';
            echo $stars;
            echo '<blockquote>' . esc_html($r['quote']) . '</blockquote>';
            echo '<div class="sb-review-author">';
            echo '<div class="sb-avatar">' . esc_html($r['initial']) . '</div>';
            echo '<div><p class="sb-author-name">' . esc_html($r['name']) . '</p><p class="sb-author-meta">' . esc_html($r['meta']) . '</p></div>';
            echo '</div>';
            echo '</div>';
        }
        ?>

    </div>
</div>

<div class="sb-testimonial-cta">
    <p class="sb-cta-title">Vill du också ha en enklare vardag?</p>
    <p class="sb-cta-sub">Gör en kostnadsfri intresseanmälan — vi återkommer inom 24h</p>
    <a href="/intresseanmalan/">Kom igång idag →</a>
    <p class="sb-cta-micro">✓ Kostnadsfritt · ✓ Utan bindning · ✓ Svar inom 24h</p>
</div>

</section>
<!-- /wp:html -->
