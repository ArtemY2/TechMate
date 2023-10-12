<div id="editModal" class="modal">
    <div class="modal-content">
        <span class="close" onclick="closeModal()">&times;</span>
        <h2>Edit Product</h2>
        <form id="editForm" action="" method="POST">
            <input type="hidden" id="editProductId" name="id">
            <div class="form-group">
                <label for="editName">Name:</label>
                <input type="text" id="editName" name="name">
            </div>
            <div class="form-group">
                <label for="editDescription">Description:</label>
                <textarea id="editDescription" name="description"></textarea>
            </div>
            <div class="form-group">
                <label for="editPrice">Price:</label>
                <input type="text" id="editPrice" name="price">
            </div>
            <div class="form-group">
                <label for="editType">Type:</label>
                <select id="editType" name="type">
                    <option value="audio">Audio</option>
                    <option value="phone">Phone</option>
                    <option value="computer">Computer</option>
                    <option value="televisor">Televisor</option>
                </select>
            </div>
            <div class="form-group">
                <label for="editDiscount">Discount:</label>
                <input type="text" id="editDiscount" name="discount">
            </div>
            <div class="form-group">
                <label for="editImage">Image:</label>
                <input type="text" id="editImage" name="image">
            </div>
            <div class="form-group">
                <input type="submit" value="Update product">
            </div>
        </form>
    </div>
</div>
