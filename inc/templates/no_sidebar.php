<?php
/*
Template Name: No Sidebars
*/

get_header(); ?>


<div id="primary" class="content-area wrap">
  <main id="main" class="site-main" role="main">

    <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
      <div class="no-sidebar-content">

        <?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
        <?php twentyseventeen_edit_link( get_the_ID() ); ?>
        <?php
          the_content();

          wp_link_pages( array(
            'before' => '<div class="page-links">' . __( 'Pages:', 'twentyseventeen' ),
            'after'  => '</div>',
          ) );
        ?>
      </div><!-- .entry-content -->
    </article><!-- #post-## -->
  </main>
</div>

<?php get_footer(); ?>
