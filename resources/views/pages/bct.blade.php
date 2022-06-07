@extends('layouts.site')

@section('page-script-data')
    <!-- index page-script-data -->

@endsection

@section('content')
    <!-- index -->
    {!! $page->content !!}
@endsection
@section('page-script')
    <!-- index page-scrip -->
    <script>
        let page = @json($page,JSON_UNESCAPED_UNICODE);
        let pageData = @json($pageData,JSON_UNESCAPED_UNICODE);
        //window.AppStore.setPageData(@json($pageData));
    </script>
@endsection
