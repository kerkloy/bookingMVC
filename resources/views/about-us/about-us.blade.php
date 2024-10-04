@extends('layouts.admin')

@section('content')
<div class="container">
    <div class="page-inner">
        <div class="card shadow mb-4">
            <div class="card-header">
                <h5 class="m-0 font-weight-bold text-gray">Edit About-us</h3>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6 col-lg-6">
                        <div class="form-group">
                            <label for="title">About-us Header:</label> <small id="titleHelp" class="form-text text-muted">(This will be the header of the About-us page.)</small>
                            <input type="text" class="form-control" id="title" name="title" value="">
                            <br>
                            <label for="abtBody">Input Body Paragraph:</label> <small id="titleHelp" class="form-text text-muted">(This will be the body content of the About-us.)</small>
                            <textarea class="form-control" id="abtBody" name="abtBody" rows="5"></textarea>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-6">
                        <!-- <div class="form-group">
                            <label for="logo">Upload Logo:</label>
                            <input type="file" class="form-control-file" id="logo" name="logo">
                            <br>
                            <small id="logoHelp" class="form-text text-muted text-bold">(UPLOAD 2 IMAGES FOR ABOUT-US)</small>
                        </div> -->
                        <h5>About-us Images</h5>
                        <small id="logoHelp" class="form-text text-warning">(UPLOAD 2 IMAGES FOR ABOUT-US)</small>  
                        <div class="table-responsive">
                            <table id="tableUploads" class="tableUploads">
                                <thead>
                                    <tr>
                                        <th>Description</th>
                                        <th>Image</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody id="imgDetails">
                                    <tr>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td colspan="3" style="text-align: center;">
                                            <button type="button" id="addItem" class="btn btn-sm btn-success" style="border-radius:50%;" data-toggle="modal" data-target="#addItemModal">
                                                <i class="fa fa-plus text-white"></i>
                                            </button>
                                        </td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                        <div class="d-flex justify-content-end">
                            <button id="btnSave" type="submit" class="btn btn-primary">Save Changes</button>
                        </div>
                        <!-- <button type="reset" class="btn btn-secondary ml-2">Reset</button> -->
            
                    </div>
                </div>
            </div>
            
        </div>
    </div>


    <div id="addItemModal" class="modal fade animated" role="dialog">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <div class="modal-header">
                    <input type="hidden" name="selectedAttachmentRowId" id="selectedAttachmentRowId" value="">
                    <div class="attchModalTitle modal-title">Add Image(s)</div>
                    <button type="button" class="close attachmentCancelBtn" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <form id="uploadForm" enctype="multipart/form-data">
                        <div class="row">
                            <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12">
                                <div class="form-group row required">
                                    <label for="imgDesc" class="form-control-label col-md-3 col-12">Description</label>
                                    <div class="col-md-9 col-12">
                                        <input class="form-control" name="attachDescription" id="imgDesc" placeholder="Description"></input>
                                    </div>
                                </div>
                                
                                <div class="form-group row required">
                                    <label for="img" class="form-control-label col-md-3 col-12 attachment">Image</label>
                                    <div class="col-md-9 col-12">
                                        <input id="img" name="attachment[]" placeholder="Select image" maxlength="100" type="file" accept=".jpg,.jpeg,.png,.pdf" class="form-control file-loading" multiple/>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form> <!-- End of the form -->
                </div>      
                <div class="modal-footer">
                    <button type="button" class="btn btn-default attachmentCancelBtn" data-dismiss="modal">Cancel</button>
                    <button type="button" id="btnSaveItemModal" class="btn btn-success">Save</button>
                </div>
            </div>
        </div>
    </div>

</div>

<script src="../js/about-us.js"></script>
@endsection