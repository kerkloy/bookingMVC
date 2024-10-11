@extends('layouts.admin')

@section('content')
<style>
  .custom-btn {
    padding: 10px 8px; /* Adjust padding for desired size */
    font-size: 12px;    /* Adjust font size */
  }

  .list-group-item {
  display: flex;
  justify-content: space-between;
  align-items: center;
}

.delete-btn {
  color: red;
  cursor: pointer;
  font-weight: bold;
}


</style>


<div class="container">
    <div class="page-inner">
        <div class="card shadow mb-4">
            <div class="card-header">
                <h5 class="m-0 font-weight-bold text-gray">{{ isset($promo) && count($promo) > 0 ? 'Edit Promo' : 'Add Promo' }}</h3>
            </div>
            <div class="card-body">
                <form id="promoForm" enctype="multipart/form-data">
                @csrf
                    <div class="form-group">
                        <label for="promoHeader">Add Promo Header</label>
                        <input type="text" class="form-control" id="promoHeader" name="promoHeader" placeholder="Input Header"
                            value="{{ isset($promo[0]->promo_header) ? $promo[0]->promo_header : '' }}">
                        <br>

                        <label for="descriptionInput">Add Description(s)</label>
                        <div class="input-group">
                            <input type="text" class="form-control desc" id="descriptionInput" placeholder="Enter description">
                            <div class="input-group-append">
                                <button class="btn btn-primary custom-btn" onclick="addItem(); return false;">
                                    <span class="btn-label">
                                        <i class="fa fa-plus"></i>
                                    </span>
                                    Add
                                </button>
                            </div>
                        </div>
                        <br>
                        <!-- Populate Descriptions if available -->
                       

                        <ul class="list-group" id="itemList">
                            @if(isset($promo) && count($promo) > 0)
                                @foreach($promo as $item)
                                    <li class="list-group-item" id="description-{{ $item->id }}">
                                        {{ $item->description }}
                                        <button type="button" class="btn btn-danger btn-sm" onclick="deleteDescription({{ $item->id }})">Delete</button>
                                    </li>
                                @endforeach
                            @else
                                <li class="list-group-item">No descriptions added yet.</li>
                            @endif
                        </ul>
                        <br>
                        <label for="img">Upload Promo Image</label>
                        <input id="img" type="file" accept=".jpg,.jpeg,.png" class="form-control file-loading">
                        <br>

                        <!-- Image Preview -->
                        @if(isset($promo[0]->image_url))
                            <img id="imagePreview" src="{{ asset($promo[0]->image_url) }}" width="100" height="100" />
                        @else
                            <img id="imagePreview" style="display:none;" width="100" height="100" />
                        @endif

                        <br>
                        <button class="btn {{ isset($promo) && count($promo) > 0 ? 'btnEdit btn-primary' : 'btn-success' }}"
                                onclick="submitPromo(); return false;">
                            {{ isset($promo) && count($promo) > 0 ? 'Save Promo' : 'Submit Promo' }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="../js/add-promo.js"></script>
@endsection