@extends('layouts.app')




@section('content')
    <form action="/ProductImport" enctype="multipart/form-data" method="post">
        @csrf
        <label class="custom-uploader"
            for="file">Upload Your File</label> 
            <input id="file" name="ExcelFile" type="file" /> <button
            class="btn btn-success" name="submit" type="submit"> Upload File </button>
    </form>
@endsection
