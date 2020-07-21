@if(isset($paginator) && $paginator->lastPage() > 1)
    <ul class="pagination justify-content-center m-4">
        @if($paginator->currentPage() == 1)
        <li class="disabled page-item"><span class="page-link">{{__('base.previous')}}</span></li> 
        @else
        <li class="page-item"><a class="page-link" href="{{str_replace('/?','?',$paginator->url($paginator->currentPage() - 1))}}">{{__('base.previous')}}</a></li>
        @endif
        @if($paginator->currentPage() - $sub_links >  1)
            <li class="page-item"><a class="page-link" href="{{str_replace('/?','?',$paginator->url(1))}}">1</a></li>
            @if($paginator->currentPage() - $sub_links >  2)
            <li class="disabled page-item"><span class="page-link">...</span></li>
            @endif
            @if($paginator->currentPage() + $sub_links < $paginator->lastPage())
                @for($i = $paginator->currentPage() - $sub_links; $i <= $paginator->currentPage() + $sub_links; $i++)                    
                    @if($paginator->currentPage() == $i)
                    <li class="page-item active"><span class="page-link">{{$i}}</span></li>
                    @else
                    <li class="page-item"><a class="page-link" href="{{str_replace('/?','?',$paginator->url($i))}}">{{$i}}</a></li>
                    @endif                    
                @endfor
            @else
                @for($i = $paginator->currentPage() - $sub_links; $i <= $paginator->lastPage(); $i++)                    
                    @if($paginator->currentPage() == $i)
                    <li class="page-item active"><span class="page-link">{{$i}}</span></li>
                    @else
                    <li class="page-item"><a class="page-link" href="{{str_replace('/?','?',$paginator->url($i))}}">{{$i}}</a></li>
                    @endif                    
                @endfor
            @endif
        @else                    
            @if($paginator->currentPage() + $sub_links < $paginator->lastPage())
                @for($i = 1; $i <= $paginator->currentPage() + $sub_links; $i++)                    
                    @if($paginator->currentPage() == $i)
                    <li class="page-item active"><span class="page-link">{{$i}}</span></li>
                    @else
                    <li class="page-item"><a class="page-link" href="{{str_replace('/?','?',$paginator->url($i))}}">{{$i}}</a></li>
                    @endif                    
                @endfor
            @else
                @for($i = 1; $i <= $paginator->lastPage(); $i++)                    
                    @if($paginator->currentPage() == $i)
                    <li class="page-item active"><span class="page-link">{{$i}}</span></li>
                    @else
                    <li class="page-item"><a class="page-link" href="{{str_replace('/?','?',$paginator->url($i))}}">{{$i}}</a></li>
                    @endif                    
                @endfor
            @endif
        @endif
        @if($paginator->currentPage() + $sub_links < $paginator->lastPage())
            @if($paginator->currentPage() + $sub_links < $paginator->lastPage() - 1)
            <li class="disabled page-item"><span class="page-link">...</span></li>
            @endif
            <li class="page-item"><a class="page-link" href="{{str_replace('/?','?',$paginator->url($paginator->lastPage()))}}">{{$paginator->lastPage()}}</a></li>
        @endif
        @if($paginator->currentPage() == $paginator->lastPage())
            <li class="disabled page-item"><span class="page-link">{{__('base.next')}}</span></li>
        @else
            <li class="page-item"><a class="page-link" href="{{str_replace('/?','?',$paginator->url($paginator->currentPage() + 1))}}" rel="next">{{__('base.next')}}</a></li>
        @endif
    </ul>
@endif