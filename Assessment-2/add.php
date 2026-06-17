<?php include('includes/header.inc'); ?>
<?php include('includes/nav.inc'); ?>

<main>
    <div class="addpet">
        <h2>Add a pet</h2>
        <form action="process_add.php" method="POST" enctype="multipart/form-data">
            <div class="form-group">
                <label for="petname">Pet Name: <span class="required">*</span></label>
                <input type="text" id="petname" name="petname" required>
            </div>
            <div class="form-group">
                <label for="type">Type: <span class="required">*</span></label>
                <select id="type" name="type" required>
                    <option value="">--Choose an option--</option>
                    <option value="Dog">Dog</option>
                    <option value="Cat">Cat</option>
                    <option value="Other">Other</option>
                </select>
            </div>
            <div class="form-group">
                <label for="description">Description: <span class="required">*</span></label>
                <textarea id="description" name="description" rows="4" required></textarea>
            </div>
            <div class="form-group">
                <label for="image">Select an Image: <span class="required">*</span></label>
                <input type="file" id="image" name="image" accept="image/*" required>
                <small class="note">Max image size: 500KB</small>
            </div>
            <div class="form-group">
                <label for="caption">Image Caption: <span class="required">*</span></label>
                <input type="text" id="caption" name="caption" required>
            </div>
            <div class="form-group">
                <label for="age">Age (months): <span class="required">*</span></label>
                <input type="number" id="age" name="age" required>
            </div>
            <div class="form-group">
                <label for="location">Location: <span class="required">*</span></label>
                <input type="text" id="location" name="location" required>
            </div>
            <div class="form-buttons">
                <button type="submit">Submit</button>
                <button type="reset">Clear</button>
            </div>
        </form>
    </div>
</main>

<?php include('includes/footer.inc'); ?>
