<?php
/*
Template Name: About Page
 */
?>
<?php
//Get the employee data
$employees = get_post_meta( $post->ID, 'about_page_employee_group', true );

?>

<?php get_header(); ?>

<?php get_template_part( 'parts/header', 'hero-image' ); ?>

<section class="content">
	<article class="main-article">
		<h3 class="title"><?= $post->post_title ?></h3>
		<h3 class="sub-header">
            <?= $post->post_content ?>
        </h3>
        <?php foreach ( $employees as $employee ) : ?>
            <?php
                $employee_phone_no_periods = str_replace( ".", "", $employee["phone"] );
            ?>
            <p class="clearfix">
                <img class="employee-thumbnail" src="<?= $employee["photo"] ?>" alt="" />
                <strong><?= $employee["name"] ?></strong><em> <?= $employee["title"] ?></em>
                <?= $employee["bio"] ?>
                <a href="mailto:<?=$employee["email"]?>"><?=$employee["email"]?></a> | <a href="tel:<?=$employee_phone_no_periods?>"><?=$employee["phone"]?></a>
            </p>
        <?php endforeach; ?>
	</article>

	<?php get_template_part('parts/components', 'image-slider'); ?>

</section>

<?php get_template_part( 'parts/footer', 'cta' ); ?>

<?php get_footer(); ?>


