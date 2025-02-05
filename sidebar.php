<div class="sidebar">
    <?php if (is_active_sidebar('sidebar-1')) : ?>
        <ul>
            <?php dynamic_sidebar('sidebar-1'); ?>
        </ul>
    <?php else : ?>
        <p>No widgets added yet.</p>
    <?php endif; ?>
</div>
