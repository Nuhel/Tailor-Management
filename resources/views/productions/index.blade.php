@extends('layout.layout')
@section('content')
    <div class="content-wrapper">
        <div class="content">
            <div class="container pt-5">
                <div class="">

                    <!-- Tabs content -->
                    <ul role="tablist" class="nav nav-tabs">
                        <li class="nav-item">
                            <a id="home-tab" data-toggle="tab" href="#pending-tab" role="tab" aria-controls="home" aria-selected="true" class="nav-link active show">পেন্ডিং</a></li>
                        <li class="nav-item">
                            <a id="profile-tab" data-toggle="tab" href="#processing-tab" role="tab" aria-controls="profile" aria-selected="false" class="nav-link">প্রসেসিং</a></li>
                        <li class="nav-item">
                            <a id="p-tab" data-toggle="tab" href="#home-3" role="tab" aria-controls="p" aria-selected="false" class="nav-link">রিসিভ</a></li>


                    </ul>
                    <!-- Tabs content -->
                    <div class="tab-content">
                        <div id="pending-tab" role="tabpanel" aria-labelledby="pending-tab" class="tab-pane fade active show">

                            @include('productions.datatables.pending',['heading' => 'Pendign',
                                'craftMans' => $craftMans,
                                'dataTable'=> $pendingDataTable->html(),
                                'datatableFilters' => collect($pendingDataTable->getFilters())->toJson(),
                                'datatableId' => $pendingDataTable->getId()
                                ])
                        </div>

                        <div id="processing-tab" role="tabpanel" aria-labelledby="processing-tab" class="tab-pane fade">
                            @include('productions.datatables.processing',['heading' => 'Processing',
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

@include('productions.datatables.assign-craftsman-modal',['craftMans' => $craftMans,'tableIds'=> [
            $pendingDataTable->getId(),
            $processingDataTable->getId()
        ],
    ]
)

@endsection

@section('css')
    @stack('inner-css')

    <link rel="stylesheet" type="text/css" href="{{asset('/vendor/datatables/css/datatable.css')}}"/>
    <style>
        .spacer{
            flex-basis: calc(100% - 268px) !important;
            background: transparent;
            border: none;
        }
        .spacer:hover,.spacer:active,.spacer:focus{
            background: transparent;
            pointer-events: none;
            border: none;
            box-shadow: none
        }
        .dt-buttons.btn-group.flex-wrap{
            width: 100%;
        }
    </style>
    <style>
        table{
            width: 100% !important;
        }
    </style>
@endsection


@section('script')
    <script src="{{asset('/vendor/datatables/datatable.js')}}"></script>
    <script src="{{asset('/vendor/datatables/buttons.js')}}"></script>
    <script src="{{asset('/vendor/datatables/buttons.server-side.js')}}"></script>
    @stack('inner-script')
@endsection
