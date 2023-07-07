<div class="modal fade" id="editMenu" data-bs-backdrop="static" tabindex="-1">
    <div class="modal-dialog modal-lg">
      <form class="modal-content" method="POST" action="{{ route('menu.store') }}" enctype="multipart/form-data">
        @csrf
        <div class="modal-header">
          <h5 class="modal-title" id="addMenuTitle">Edit Menu</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <div class="row">
                <div class="col-xl-12">
                    <div class="form-group">
                        <div id="imgs" class="d-none mb-2">
                            <img id="imagePreview" src="#" class="img-fluid" height="auto" width="auto">
                        </div>
                        <label for="imageInput">Image</label>
                        <input class="form-control" type="file" id="imageInput" name="image" accept="image/*">
                    </div>
                    <div class="form-group mb-2">
                        <label for="Nama" class="form-label">Name</label>
                        <input type="text" name="menu_name" placeholder="Name..." class="form-control" required>
                    </div>
                    <div class="form-group mb-2">
                        <label for="price" class="form-label">Price</label>
                        <input type="number" id="price" name="price" min="0" placeholder="Price..." class="form-control" required>
                    </div>
                    <div class="form-group mb-2 d-none" id="form-discount">
                        <label for="discount" class="form-label">Discount</label>
                        <select id="discount" class="form-control">
                            <option value="no">No</option>
                            <option value="yes">Yes</option>
                        </select>
                        <input type="number" placeholder="Discount..." min="0" max="100" name="discount" class="mt-2 form-control d-none" id="inputDiscount">
                    </div>
                    <div class="form-group mb-2 d-none" id="total">
                        <label for="total_harga">Total Price</label>
                        <input type="text" name="total_price" id="total-price" class="form-control" readonly>
                    </div>
                    <div class="form-group mb-2">
                        <label for="Nama" class="form-label">Type</label>
                        <select name="type" class="form-control" required>
                            <option>Choose</option>
                            <option value="foods">Food</option>
                            <option value="drinks">Drink</option>
                            <option value="desserts">Dessert</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="switch" class="form-label">status</label>
                        <label class="switch">
                            <input id="switch" type="checkbox" name="status" checked>
                            <span class="slider round"></span>
                        </label>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button type="submit"class="btn btn-primary">Save</button>
        </div>
    </form> 
    </div>
  </div>