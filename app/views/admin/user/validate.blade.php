@extends('admin.layouts.master')
@section('content')
    <form method="post" action="{{ route('admin/post/create') }}" enctype="multipart/form-data">
        @csrf
        <label>
            <input name="text" type="text" />
        </label>
        @if (isset($_SESSION['errors']) &&
                isset($_SESSION['errors']['text']) &&
                count($_SESSION['errors']['text']) > 0 &&
                isset($_GET['msg']))
            <div class="alert alert-danger">
                <ul>
                    <li>{{ $_SESSION['errors']['text'][0] }}</li>
                </ul>
            </div>
        @endif
        <button name="send" type="submit" class="btn btn-primary">Submit</button>
    </form>
@endsection
