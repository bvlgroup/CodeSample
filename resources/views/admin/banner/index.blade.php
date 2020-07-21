@extends('layouts.master')

@section('page_title')
    Banner
@endsection
@section('contentheader_title')
	Banner
@endsection
@section('breadcrumbs')
    @parent
    <li class="breadcrumb-item active">Banner</li>
@endsection
@section('css')
<link href="{{ asset('plugins/datetimepicker/jquery.datetimepicker.css') }}" rel="stylesheet" type="text/css" />
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/icheck-bootstrap@3.0.1/icheck-bootstrap.min.css">
@endsection
<!-- faqs -->
@section('main-content')
    <div class="row">
        <div class="col">
            <form method="GET" class="form-inline my-2">
                <div class="form-group">
                    <input type="text" id="start" name="start" class="form-control" data-inputmask-alias="datetime" data-inputmask-inputformat="dd/mm/yyyy" data-mask="" im-insert="false" value="{{ request('start')?request('start'):date('Y-m-d',strtotime('-1 month -1 day')) }}" placeholder="{{ __('Start date') }}">
                </div>
                <div class="form-group mx-sm-2">
                    <input type="text" id="end" name="end" class="form-control" data-inputmask-alias="datetime" data-inputmask-inputformat="dd/mm/yyyy" data-mask="" im-insert="false" value="{{ request('end')?request('end'):date('Y-m-d') }}" placeholder="{{ __('End date') }}">
                </div>
                <div class="form-group mx-sm-2">
                    <select class="form-control" name="category">
                        <option value="">{{__('All')}}</option>
                        @if(!empty($codeMains) && is_countable($codeMains) && count($codeMains))
                            @foreach($codeMains as $key)
                            <option value="{{$key->cd_main}}" {{request('category') ==$key->cd_main?'selected':'' }}>{{$key->cd_main_name}}</option>
                            @endforeach
                        @endif
                    </select>
                </div>
                <div class="form-group mx-sm-2">
                    <input type="text" class="form-control" name="title" placeholder="{{ __('Title') }}" value="{{ request('title') }}">
                </div>
                <div class="form-group mx-sm-1">
                    <button class="btn btn-primary" type="submit">
                        <i class="fa fa-search"></i>
                    </button>
                </div>
            </form>
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">{{ __('All') }} ({{ $banner->total() }})</h3>
                    <div class="card-tools">
                        
                        <a href="{{ route('banner.create') }}" class="btn btn-success btn-sm text-white"
                           title="Add New banner">
                            <i class="fa fa-plus" aria-hidden="true"></i> Add New
                        </a>
                    </div>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered m-0">
                            <thead>
                            <tr class="text-center">
                                <td width="10">
                                    <div class="icheck-primary d-inline">
                                        <input type="checkbox" id="item-checked-all" name="check_ids">
                                        <label for="item-checked-all">
                                        </label>
                                    </div>
                                </td>
                                <th class="text-center px-1">{{ __('No') }}</th>
                                <th>{{ __('category') }}</th>
                                <th>{{ __('thumbnail') }}</th>
                                <th>{{ __('title') }}</th>
                                <th>{{ __('time visible') }}</th>
                                <th width="100">{{ __('Visible') }}</th>
                                <th width="100">{{ __('Action') }}</th>
                            </tr>
                            </thead>
                            @if(!empty($banner) && is_countable($banner) && count($banner))
                            <tbody>
                            @foreach($banner as $index=>$item)
                                <tr class="parent-item">
                                    <td>
                                        <div class="icheck-primary d-inline">
                                            <input type="checkbox" id="item-checked-{{$item->id}}" class="deleteRow" name="item_id[]" value="{{ $item->id }}">
                                            <label for="item-checked-{{$item->id}}">
                                            </label>
                                        </div>
                                    </td>
                                    <td class="text-center px-1">{{ ($index+1) + ($banner->perPage() * ($banner->currentPage() - 1)) }}</td>
                                    <td class="text-center">{{ $item->cd_main_name}}
                                       <span>
                                            @if (isset($coutCate[$item->cate_code_2]))
                                            @php
                                                $coutCate[$item->cate_code_2]++;
                                            @endphp
                                            ({{ $coutCate[$item->cate_code_2] }})
                                             
                                            @else
                                            {{'(0)'}}
                                            @endif   
                                        </span>
                                    </td>
                                    <td class="text-center"><img src="{{asset($item->banner_thumb)}}" alt=""></td>
                                    <td><a href="{{route('banner.edit',$item->id)}}">{{$item->banner_title}}</a></td>
                                    <td class="text-center">{{  Carbon\Carbon::parse($item->banner_start)->format(config('constant.date_format_show')) }} ~ {{  Carbon\Carbon::parse($item->banner_end)->format(config('constant.date_format_show')) }}</td>
                                    <td class="is_visible_{{$item->id}}">{{$item->is_visible}}</td>
                                    <td class="text-center">
                                        <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-expanded="true">
                                          Action
                                        </button>
                                        <div class="dropdown-menu" x-placement="bottom-start">
                                            <a class="dropdown-item" tabindex="-1" href="{{route('banner.edit',$item->id)}}">{{__('Edit')}}</a>
                                            @if($item->is_visible != 'Y')
                                            <a class="dropdown-item toogle-active" data-url="{{route('admin.banner.toggleactive')}}" data-id="{{$item->id}}" tabindex="-1" href="javascript:void(0);" data-title="{{__('Do you want active it?')}}">{{__('Active')}}</a>
                                            @else
                                            <a class="dropdown-item text-red toogle-active" data-url="{{route('admin.banner.toggleactive')}}" data-id="{{$item->id}}" tabindex="-1" href="javascript:void(0);" data-title="{{__('Do you want deactive it?')}}">{{__('deactive')}}</a>
                                            @endif
                                            <div class="dropdown-divider"></div>
                                            <a class="dropdown-item text-red delete-item" data-url="{{route('banner.destroy',$item->id)}}" data-title="{{__('Do you want delete it?')}}" tabindex="-1" href="javascript:void(0);">{{__('Delete')}}</a>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                            @else
                            <tr>
                                <td colspan="8">{{__('No data result')}}</td>
                            </tr>
                            @endif
                        </table>

                    </div>

                </div>
                <div class="card-footer pb-0 clearfix">
                    <a href="javascript:void(0);" class="btn btn-danger mb-3 float-left delete_checked" data-url="{{route('admin.banner.delete-multiple')}}" data-title="{{__('Do you want to remove tip has ticked?')}}"><i class="fa fa-trash" aria-hidden="true"></i> {{__('Delete checked')}}</a>
                    <div
                        class="pagination justify-content-center"> {!! $banner->appends(['title' => Request::get('title'),'tag' => Request::get('tag'),'start' => Request::get('start'),'end' => Request::get('end')])->render() !!} </div>
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script type="text/javascript" src="{{ asset('plugins/datetimepicker/jquery.datetimepicker.full.min.js') }}"></script>
    
    <script>
        $('#start').datetimepicker({
            format:'Y-m-d',
            formatDate:'Y-m-d',
            defaultDate:"{{date('Y-m-d',strtotime('-1 month'))}}",
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
