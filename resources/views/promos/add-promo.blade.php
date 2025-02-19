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
                <h5 class="m-0 font-weight-bold text-gray">{{ isset($promo) && count($promo) > 0 ? 'View Promo' : 'Add Promo' }}</h3>
            </div>
            <div class="card-body">
                <div id="promoForm" enctype="multipart/form-data">
                
                    <div class="form-group">
                        <input type="text" class="d-none" id="pID" value="{{ isset($promo[0]->promo_id) ? $promo[0]->promo_id : '' }}">
                        <br>
                        <label for="promoHeader">Add Promo Header</label>
                        <input type="text" class="form-control" id="promoHeader" name="promoHeader" placeholder="Input Header"
                            value="{{ isset($promo[0]->promo_header) ? $promo[0]->promo_header : '' }}">
                        <br>
                        <label for="promoType">Promo Type</label>
                        <input type="text" class="form-control" id="promoType" name="promoType" placeholder="Promo type"
                            value="{{ isset($promo[0]->promo_type) ? $promo[0]->promo_type : '' }}">
                        <br>
                        <label for="promoPrice">Add Promo Price</label>
                        <input type="number" class="form-control" id="promoPrice" name="promoPrice" placeholder="Input Price"
                            value="{{ isset($promo[0]->promo_price) ? $promo[0]->promo_price : '' }}">
                        <br>
                        <label for="promoLocation">Add Promo Location</label>
                        <input type="text" class="form-control" id="promoLocation" name="promoLocation" placeholder="Input Location"
                            value="{{ isset($promo[0]->promo_location) ? $promo[0]->promo_location : '' }}">
                        <br>
                        <label for="descriptionInput">Add Inclusion(s)</label>
                        <div class="input-group">
                            <input type="text" class="form-control desc" id="descriptionInput" placeholder="Enter description">
                            <div class="input-group-append">
                                <button class="btn btn-primary custom-btn" id="addDesc">
                                    <span class="btn-label">
                                        <i class="fa fa-plus"></i>
                                    </span>
                                    Add
                                </button>
                            </div>
                        </div>
                        <br>
                        <!-- Populate Descriptions if available -->
                        <div class="card-body">
                        <div class="table-responsive">
                                <table id="dataTable" class="table text-center table-bordered" style="width:100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>Inclusion</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody id="dtBody" data-data="{{ isset($promo) ? json_encode( $promo) : ''}}">
                                    </tbody>
                                    <tfoot>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                        <br>
                        <label for="exclusionInput">Add Exclusion(s)</label>
                        <div class="input-group">
                            <input type="text" class="form-control desc" id="exclusionInput" placeholder="Enter exclusions">
                            <div class="input-group-append">
                                <button class="btn btn-primary custom-btn" id="addExclusion">
                                    <span class="btn-label">
                                        <i class="fa fa-plus"></i>
                                    </span>
                                    Add
                                </button>
                            </div>
                        </div>
                        <br>
                        <!-- Populate Exclusions if available -->
                        <div class="card-body">
                        <div class="table-responsive">
                                <table id="exclusionTable" class="table text-center table-bordered" style="width:100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>Exclusion</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody id="exBody" data-data="{{ isset($promo) ? json_encode( $promo) : ''}}">
                                    </tbody>
                                    <tfoot>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                        <br>
                        <label for="img">Upload Promo Image</label>
                        <input id="img" type="file" accept=".jpg,.jpeg,.png" class="form-control file-loading" value="{{ isset($promo[0]->image_url) ? $promo[0]->image_url : '' }}">
                        <br>

                        <!-- Image Preview -->
                        @if(isset($promo[0]->image_url))
                            <img id="imagePreview" src="{{ asset($promo[0]->image_url) }}" width="100" height="100" />
                        @else
                            <img id="imagePreview" style="display:none;" width="100" height="100" />
                        @endif

                        <br>
                        <br>
                        <br>
                        <button class="btn {{ isset($promo) && count($promo) > 0 ? 'btnEdit d-none' : 'btnSubmit btn-success' }}">
                            {{ isset($promo) && count($promo) > 0 ? 'Save Promo' : 'Submit Promo' }}
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="../js/add-promo.js"></script>
@endsection