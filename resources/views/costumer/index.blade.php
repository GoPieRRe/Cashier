@extends('layouts.main')

@section('content')
<div class="card">
    <div class="card-header">
        <span><h2><i class="fas fa-users"></i> Costumer</h2></span>
    </div>
    <div class="card-body">
        <div class="col">
            <div class="nav-align-top mb-4">
              <ul class="nav nav-tabs nav-fill" role="tablist">
                <li class="nav-item">
                  <button type="button" class="nav-link active" role="tab" data-bs-toggle="tab" data-bs-target="#navs-justified-home" aria-controls="navs-justified-home" aria-selected="true">
                    <i class="fa-solid fa-utensils"></i> Ordered
                    <span class="badge rounded-pill badge-center h-px-20 w-px-20 bg-label-danger">3</span>
                  </button>
                </li>
                <li class="nav-item">
                  <button type="button" class="nav-link" role="tab" data-bs-toggle="tab" data-bs-target="#navs-justified-profile" aria-controls="navs-justified-profile" aria-selected="false">
                    <i class="fa-solid fa-spinner"></i> On Proggress
                  </button>
                </li>
                <li class="nav-item">
                  <button type="button" class="nav-link" role="tab" data-bs-toggle="tab" data-bs-target="#navs-justified-messages" aria-controls="navs-justified-messages" aria-selected="false">
                    <i class="fa-solid fa-flag-checkered"></i> Finish
                  </button>
                </li>
              </ul>
              <div class="tab-content">
                <div class="tab-pane fade show active" id="navs-justified-home" role="tabpanel">
                  {{-- isi ordered --}}
                </div>
                <div class="tab-pane fade" id="navs-justified-profile" role="tabpanel">
                  {{-- isi on proggress --}}
                </div>
                <div class="tab-pane fade" id="navs-justified-messages" role="tabpanel">
                  {{-- isi finish --}}
                </div>
              </div>
            </div>
          </div>
    </div>
</div>
@endsection