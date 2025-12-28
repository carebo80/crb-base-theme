<?php
$variant     = $args['variant']     ?? 'desktop';
$post_type   = $args['post_type']   ?? 'product';
$placeholder = $args['placeholder'] ?? __('Produkte suchen…', 'crb-base-theme');

$wrap_cls = 'sa-search sa-search--' . esc_attr($variant);
$input_id = 'sa-search-' . esc_attr($variant);
?>
<form role="search" method="get" class="<?php echo $wrap_cls; ?>" action="<?php echo esc_url(home_url('/')); ?>">
    <label class="sr-only" for="<?php echo $input_id; ?>"><?php esc_html_e('Suche', 'crb-base-theme'); ?></label>

    <input
        id="<?php echo $input_id; ?>"
        type="search"
        name="s"
        class="search-field"
        value="<?php echo esc_attr(get_search_query()); ?>"
        placeholder="<?php echo esc_attr($placeholder); ?>"
        autocomplete="off" />

    <?php if (!empty($post_type)): ?>
        <input type="hidden" name="post_type" value="<?php echo esc_attr($post_type); ?>" />
    <?php endif; ?>

    <button type="submit" class="search-submit" aria-label="<?php esc_attr_e('Suchen', 'crb-base-theme'); ?>">
        <?php echo function_exists('crb_heroicon') ? crb_heroicon('magnifying-glass', 'outline', 'h-4 w-4') : '🔎'; ?>
    </button>
</form>
