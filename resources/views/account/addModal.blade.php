<div class="modal fade" id="backDropModal" data-bs-backdrop="static" tabindex="-1">
    <div class="modal-dialog">
      <form class="modal-content" method="POST" action="{{ route('account.store') }}">
        @csrf
        <div class="modal-header">
          <h5 class="modal-title" id="backDropModalTitle">Add Account</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <div class="row">
            <div class="col mb-3">
              <label for="nameBackdrop" class="form-label">Name</label>
              <input type="text" name="name" id="nameBackdrop" class="form-control" placeholder="Enter Name"/>
            </div>
          </div>
          <div class="row g-2 d-none" id="emails">
            <div class="col mb-0">
              <div class="input-group input-group-merge">
                {{-- <span class="input-group-text"><i class="bx bx-envelope"></i></span> --}}
                <input type="text" id="emailBackdrop" class="form-control" readonly placeholder="xxxxx..." aria-label="email" name="name_email" aria-describedby="basic-icon-default-email2">
                <span id="basic-icon-default-email2" class="input-group-text">@cashier.app</span>
              </div>
              <input type="hidden" name="email" id="emailadd" value="{{ __('@cashier.app') }}" class="form-control" readonly/>
            </div>
          </div>
          <div class="row">
            <div class="col mb-3">
              <label for="password" class="form-label">Password</label>
              <input type="password" name="password" id="password" class="form-control" placeholder="Enter Password"/>
            </div>
          </div>
          <div class="row">
            <div class="col mb-3">
              <label for="confirm_password" class="form-label">Confirm password</label>
              <input type="password" name="confirm_password" id="confirm_password" class="form-control" placeholder="Confirm Password"/>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
            Close
          </button>
          <button type="submit" id="save-btn" class="btn btn-primary">Save</button>
        </div>
      </form>
    </div>
  </div>