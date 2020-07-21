@extends('layouts.master')

@section('page_title')
    {{__('Create New banner')}}
@endsection
@section('contentheader_title')
    {{__('Create New banner')}}
@endsection
@section('breadcrumbs')
    @parent
    <li class="breadcrumb-item"><a href="{{ route('banner.index') }}">{{__('Banner')}}</a></li>
    <li class="breadcrumb-item active">{{__('Create New banner')}}</li>
@endsection
@section('css')
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-tagsinput/0.8.0/bootstrap-tagsinput.css">
<link href="{{ asset('plugins/datetimepicker/jquery.datetimepicker.css') }}" rel="stylesheet" type="text/css" />
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/icheck-bootstrap@3.0.1/icheck-bootstrap.min.css">
@endsection

@section('main-content')
    <div class="row">
        <div class="col">
            <div class="card">
                <div class="card-header">
                    <a href="{{ route('banner.index') }}" class="text-warning text-decoration-none" title="Back"><i class="fa fa-arrow-left" aria-hidden="true"></i>&nbsp;</a>
                    {{__('Create New banner')}}
                </div>
                {!! Form::open(['url' => '/admin/banner', 'class' => 'form-horizontal', 'files' => true, 'id'=>'submitForm']) !!}
                <div class="card-body">
                    <div class="form-group ">
                        <label for="title" class="control-label">{{__('Category')}}:<span class="text-red">*</span></label>
                        <select class="form-control" name="cate_code_2">
                                <option value="">{{__('Please choose item')}}</option>
                            @if(!empty($codeMains) && is_countable($codeMains) && count($codeMains))
                                @foreach($codeMains as $key)
                                <option value="{{$key->cd_main}}">{{$key->cd_main_name}}</option>
                                @endforeach
                            @endif
                        </select>
                    </div>
                    <div class="" id="fileMulti">
                        <div class="custom-file w-75">
                            <input class="custom-file-input " id="attach_evidence_file_1" name="attach_evidence_file" type="file" accept="image/*">
                            <label class="custom-file-label" for="attach_evidence_file_1">{{ __('Choose file')}}</label>
                        </div>
                    </div>
                    <div class="form-group pt-3">
                        <label for="title" class="control-label">{{__('Title')}}:<span class="text-red">*</span></label>
                        <input class="form-control" name="banner_title" type="text" id="title" value="{{old('title')}}">
                    </div>
                    <div class="form-group row ml-0">
                        <label for="" class="control-label w-100">{{__('Time Visible')}}:<span class="text-red">*</span></label>
                        <div class="col-3 pl-0">
                            <input type="text" id="start" name="banner_start" class="form-control " data-inputmask-alias="datetime" data-inputmask-inputformat="dd/mm/yyyy" data-mask="" im-insert="false" placeholder="{{ __('Start date') }}">
                        </div>
                        <span class="d-flex justify-content-center pt-2 ">{{__('~')}}</span>
                        <div class="col-3">
                            <input type="text" id="end" name="banner_end" class="form-control" data-inputmask-alias="datetime" data-inputmask-inputformat="dd/mm/yyyy" data-mask="" im-insert="false" placeholder="{{ __('End date') }}">
                        </div>
                    </div>
                    <div class="form-group ">
                        <label  for="link_url" class="control-label">{{__('Link')}}:<span class="text-red">*</span></label>
                        <input class="form-control" name="link_url" type="text" id="link_url" value="{{old('link')}}" placeholder="banner url">
                    </div>
                        <select class="form-control mt-2" name="link_target">
                            <option value="1">{{__('_blank')}}</option>
                            <option value="2">{{__('_self')}}</option>
                        </select>
                    <div class="form-group ">
                        <label for="alt" class="control-label">{{__('alt')}}:<span class="text-red">*</span></label>
                        <input class="form-control" name="banner_text" type="text" id="alt" value="{{old('alt')}}">
                    </div>
                    <div class="form-group">
                        <input id="checkbox" type="checkbox" name="is_visible">
                        <label for="checkbox"  class="control-label">{{__('is Visible')}}:</label>
                    </div>
                </div>
                <div class="card-footer text-center">
                    <a href="{{route('banner.index')}}" class="btn btn-default">{{__('Cancel')}}</a>
                    <a class="btn btn-primary" id="submitBtn" href="javascript:void(0);">{{__('Create')}}</a>
                </div>
                {!! Form::close() !!}

            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-tagsinput/0.8.0/bootstrap-tagsinput.min.js"></script>
    <script type="text/javascript" src="{{ asset('plugins/datetimepicker/jquery.datetimepicker.full.min.js') }}"></script>
    <script type="text/javascript" src="{{asset('plugins/tinymce/tinymce.min.js')}}"></script>
    <script>
    $('.tip_tags').tagsinput({
            maxTags: 10
        });
        $("#submitForm").validate({
            rules: {
                banner_title: {
                    required:true,
                    maxlength:255,
                },
                cate_code_2: {
                    required:true,
                },
                banner_start: {
                    required:true,
                },
                banner_end: {
                    required:true,
                    // greaterThan: '#start',
                },
                banner_text: {
                    maxlength:255,
                    required:true,
                },
                link_url: {
                    required:true,
                    maxlength:255,
                },
                attach_evidence_file: {
                    required:true,
                },
            },
            messages: {
                    
            },
            submitHandler: function(form) {
                $('#submitBtn').addClass('disabled');
                $('#submitBtn').attr('disabled','disabled');
                $('#submitBtn').prepend('<i class="fas fa-spinner fa-spin"></i>');
                return true;
            }
        });
        $('#submitBtn').on('click',function(e){
            swal({
                title: "{{__('Confirmation')}}",
                text: "{{__('Do you want create banner?')}}",
                buttons: {
                    cancel: "{{__('Cancel')}}",
                    yes: true,
                },
            })
            .then((value) => {
              switch (value) {
                case "yes":
                    $('#submitForm').submit();
                    return true;
                    break;
                default:
                    return false;
              }
            });
            
        });
        function filePreview(input){
            if (input.files && input.files[0]) {
                var reader  = new FileReader();
                reader.onload = function(e){
                    $('.custom-file.w-75 +img').remove();
                    $('.custom-file.w-75').after('<img src="'+e.target.result+'" width="300" alt="">');
                };
                reader.readAsDataURL(input.files[0]);
            }
        }
        $('#attach_evidence_file_1').change(function() {
            /* Act on the event */
            // console.log('aaaaa');
            filePreview(this);
        });
        
        $('#start').datetimepicker({
            format:'Y-m-d',
            formatDate:'Y-m-d',
            // defaultDate:"{{date('Y-m-d',strtotime('-1 month'))}}",   
            timepickerScrollbar:false,
            timepicker:false,
            scrollMonth : false,
            scrollInput : false,
            scrollTime: false
        });
        $('#end').datetimepicker({
            format:'Y-m-d',
            formatDate:'Y-m-d',
            defaultDate:new Date(),
            timepickerScrollbar:false,
            timepicker:false,
            scrollMonth : false,
            scrollInput : false,
            scrollTime: false
        });
    </script>
@endsection
