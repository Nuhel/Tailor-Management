@extends('layout.layout')
@section('content')
    <div class="content-wrapper">
        <div class="content pt-5">
            <div class="container">
                <div class="card mt-3">
                    <div class="card-header">
                        <h2><strong>Insert Bank</strong></h2>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('banks.store') }}">
                            @csrf
                            <div class="form-group ">
                                <label class="form-inline">Bank Name</label>
                                <input type="text" name="name" id="empName" class="form-control"
                                    placeholder="Enter Bank Name" value="{{old('name')}}">
                                @error('name')
                                    <div class="alert alert-danger mt-3">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label class="form-inline">Bank Type</label>
                                <select name="type" id="" class="form-control">
                                    <option value="General Bank" {{ old('type') == 'General Bank' ? 'selected' : '' }}>General
                                        Bank</option>
                                    <option value="Mobile Bank" {{ old('type') == 'Mobile Bank' ? 'selected' : '' }}>Mobile Bank
                                    </option>
                                </select>
                                @error('type')
                                    <div class="alert alert-danger mt-3">{{ $message }}</div>
                                @enderror
                            </div>



                            <div class="form-group">
                                <label class="form-inline">Bank Address</label>
                                <textarea name="address" id="address" class="form-control"
                                    placeholder="Enter Bank Address">{{old('address')}}</textarea>
                                @error('address')
                                    <div class="alert alert-danger mt-3">{{ $message }}</div>
                                @enderror
                            </div>


                            <div class="form-group text-center">
                                <button type="submit" class="btn btn-success mt-3" name="submit">Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
