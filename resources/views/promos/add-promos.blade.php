@extends('layouts.admin')

@section('content')
<div class="container">
    <div class="page-inner">
        <div class="card shadow mb-4">
            <div class="card-header">
                <h5 class="m-0 font-weight-bold text-gray">Add Promos</h3>
            </div>
            <div class="card-body">
                <div class="container-fluid d-flex">
                    <div class="table-responsive">
                        <table id="tablePromo" class="tablePromo">
                            <thead>
                                <tr>
                                    <th>Promo ID</th>
                                    <th>Promo Title</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody id="imgDetails">
                                <tr>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>    
                </div>
            </div>
        </div>
    </div>

</div>

<script src="../js/promos.js"></script>
@endsection