@extends('layout.layout')
@section('content')
    <div class="content-wrapper">
        <div class="content">
            <div class="container pt-5">
                <div class="">

                    <!-- Tabs content -->
                    <ul role="tablist" class="nav nav-tabs">
                        <li class="nav-item">
                            <a id="home-tab" data-toggle="tab" href="#home-1" role="tab" aria-controls="home" aria-selected="true" class="nav-link active show">পেন্ডিং</a></li>
                        <li class="nav-item">
                            <a id="profile-tab" data-toggle="tab" href="#home-2" role="tab" aria-controls="profile" aria-selected="false" class="nav-link">প্রসেসিং</a></li>
                        <li class="nav-item">
                            <a id="p-tab" data-toggle="tab" href="#home-3" role="tab" aria-controls="p" aria-selected="false" class="nav-link">রিসিভ</a></li>


                    </ul>
                    <!-- Tabs content -->
                    <div class="tab-content">
                        <div id="home-1" role="tabpanel" aria-labelledby="home-tab" class="tab-pane fade active show">

                            @include('components.datatable.base',['heading' => 'Pendign',
                                'dataTable'=> $pendingDataTable->html(),
                                'datatableFilters' => collect($pendingDataTable->getFilters())->toJson(),
                                'datatableId' => $pendingDataTable->getId()
                                ])
                        </div>

                        <div id="home-2" role="tabpanel" aria-labelledby="home-tab" class="tab-pane fade">
                            @include('components.datatable.base',['heading' => 'Processing',
                                'dataTable'=> $processingDataTable->html(),
                                'datatableFilters' => collect($processingDataTable->getFilters())->toJson(),
                                'datatableId' => $processingDataTable->getId()
                                ])
                        </div>

                        <div id="home-3" role="tabpanel" aria-labelledby="home-tab" class="tab-pane fade">

                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

@endsection
@section('css')
    @stack('inner-css')
    <style>
        table{
            width: 100% !important;
        }
    </style>
@endsection


@section('script')
    @stack('inner-script')
@endsection
