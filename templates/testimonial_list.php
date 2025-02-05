<table class="wp-list-table widefat fixed striped testimonials">
    <thead>
        <tr>
            <th>Name</th>
            <th>Rating</th>
            <th>Description</th>
            <th>Image</th>
            <th>Status</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($testimonials as $testimonial): ?>
            <tr>
                <td><?php echo esc_html($testimonial->name); ?></td>
                <td><?php echo esc_html($testimonial->rating); ?></td>
                <td><?php echo esc_html($testimonial->description); ?></td>
                <td>
                    <?php if ($testimonial->image): ?>
                        <img src="<?php echo esc_url($testimonial->image); ?>" alt="Image" width="50">
                    <?php else: ?>
                        No Image
                    <?php endif; ?>
                </td>
                <td><?php echo esc_html($testimonial->status); ?></td>
                <td>
                    <a href="?page=testimonials&action=edit&id=<?php echo $testimonial->id; ?>">Edit</a> |
                    <a href="?page=testimonials&action=approve&id=<?php echo $testimonial->id; ?>">Approve</a> |
                    <a href="?page=testimonials&action=reject&id=<?php echo $testimonial->id; ?>">Reject</a>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>
