<table class="wp-list-table widefat fixed striped testimonials">
    <thead>
        <tr>
            <th>Name</th>
            <th>Rating</th>
            <th>Description</th>
            <th>Image</th>
            <th>Status</th>
            <th>Page ID</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php if (!empty($testimonials)): ?>
            <?php foreach ($testimonials as $testimonial): ?>
                <tr>
                    <td><?php echo esc_html($testimonial->name); ?></td>
                    <td><?php echo esc_html($testimonial->rating); ?> ⭐</td>
                    <td title="<?php echo esc_attr($testimonial->description); ?>">
                        <?php echo esc_html(wp_trim_words($testimonial->description, 10, '...')); ?>
                    </td>
                    <td>
                        <?php if (!empty($testimonial->image)): ?>
                            <img src="<?php echo esc_url($testimonial->image); ?>" alt="Image" width="50" height="50" style="border-radius: 5px;">
                        <?php else: ?>
                            <span style="color: #999;">No Image</span>
                        <?php endif; ?>
                    </td>
                    <td>
                        <span class="<?php echo $testimonial->status === 'approved' ? 'status-approved' : 'status-pending'; ?>">
                            <?php echo esc_html(ucfirst($testimonial->status)); ?>
                        </span>
                    </td>
                    <td><?php echo esc_html($testimonial->page_id ?? 'N/A'); ?></td>
                    <td>
                        <a href="?page=testimonials&action=edit&id=<?php echo intval($testimonial->id); ?>" class="button button-primary">Edit</a>
                        <?php if ($testimonial->status !== 'approved'): ?>
                            <a href="?page=testimonials&action=approve&id=<?php echo intval($testimonial->id); ?>" 
                               class="button button-success" 
                               onclick="return confirm('Are you sure you want to approve this testimonial?');">
                               Approve
                            </a>
                        <?php endif; ?>
                        <?php if ($testimonial->status !== 'rejected'): ?>
                            <a href="?page=testimonials&action=reject&id=<?php echo intval($testimonial->id); ?>" 
                               class="button button-secondary" 
                               onclick="return confirm('Are you sure you want to reject this testimonial?');">
                               Reject
                            </a>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr>
                <td colspan="7" style="text-align: center; color: #777;">No testimonials found.</td>
            </tr>
        <?php endif; ?>
    </tbody>
</table>
