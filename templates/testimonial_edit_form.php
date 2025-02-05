<form method="POST" enctype="multipart/form-data">
    <table class="form-table">
        <tr>
            <th><label for="testimonial_name">Name</label></th>
            <td><input type="text" name="testimonial_name" id="testimonial_name" value="<?php echo isset($testimonial->name) ? esc_attr($testimonial->name) : ''; ?>" required></td>
        </tr>
        <tr>
            <th><label for="testimonial_rating">Rating</label></th>
            <td><input type="number" name="testimonial_rating" id="testimonial_rating" value="<?php echo isset($testimonial->rating) ? esc_attr($testimonial->rating) : ''; ?>" min="1" max="5" required></td>
        </tr>
        <tr>
            <th><label for="testimonial_description">Description</label></th>
            <td>
                <textarea name="testimonial_description" id="testimonial_description" required><?php echo isset($testimonial->description) ? esc_textarea($testimonial->description) : ''; ?></textarea>
            </td>
        </tr>
        <tr>
            <th><label for="testimonial_image">Image</label></th>
            <td>
                <?php if (!empty($testimonial->image)): ?>
                    <img src="<?php echo esc_url($testimonial->image); ?>" alt="Current Image" width="100"><br>
                <?php endif; ?>
                <input type="file" name="testimonial_image" id="testimonial_image">
                <p class="description">Upload a new image to replace the existing one, or leave blank to retain the current image.</p>
            </td>
        </tr>
        <tr>
            <th><label for="testimonial_status">Status</label></th>
            <td>
                <select name="testimonial_status" id="testimonial_status">
                    <option value="pending" <?php echo isset($testimonial->status) && $testimonial->status === 'pending' ? 'selected' : ''; ?>>Pending</option>
                    <option value="approved" <?php echo isset($testimonial->status) && $testimonial->status === 'approved' ? 'selected' : ''; ?>>Approved</option>
                    <option value="rejected" <?php echo isset($testimonial->status) && $testimonial->status === 'rejected' ? 'selected' : ''; ?>>Rejected</option>
                </select>
            </td>
        </tr>
    </table>
    <input type="hidden" name="testimonial_id" value="<?php echo isset($testimonial->id) ? esc_attr($testimonial->id) : ''; ?>">
    <p class="submit">
        <input type="submit" name="save_testimonial" id="save_testimonial" class="button button-primary" value="Save Changes">
    </p>
</form>
