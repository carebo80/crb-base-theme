<?php get_header(); ?>

<main id="site-content">
  <div class="max-w-5xl mx-auto px-4 py-10">
    <?php if ( have_posts() ) : ?>
      <?php while ( have_posts() ) : the_post(); ?>
        <article <?php post_class('prose max-w-none'); ?>>
          <?php the_content(); ?>
        </article>
      <?php endwhile; ?>
    <?php else : ?>
      <p>Keine Beiträge gefunden.</p>
    <?php endif; ?>
  </div>
</main>

<?php get_footer(); ?>
