@extends('errors.layout')
@section('content')
<div class="flex flex-col items-center justify-center relative">
    <img src="{{ BASE_URL }}public/images/illustration/flying-bees.gif" alt="bee"
        class="w-96 top-0 object-cover absolute">
    <img src="{{ BASE_URL }}public/images/illustration/404.png" alt="404" class="w-96">
    <p class="text-xl sm:text-3xl md:text-4xl  dark:text-white  my-5 text-center">Không tìm thấy trang </p>
    <p class="md:text-lg lg:text-xl sm:text-base text-sm dark:text-white text-center">Chúng tôi xin lỗi, nhưng
        trang bạn
        yêu
        cầu không được tìm thấy !
    </p>
    <a href="{{ BASE_URL }}"
        class="flex items-center space-x-2 bg-blue-600 hover:bg-blue-700 text-gray-100 px-4 py-2 mt-12 rounded transition duration-150"
        title="Return Home">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
            <path fill-rule="evenodd"
                d="M9.707 14.707a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 1.414L7.414 9H15a1 1 0 110 2H7.414l2.293 2.293a1 1 0 010 1.414z"
                clip-rule="evenodd"></path>
        </svg>
        <span>Về trang chủ</span>
    </a>
</div>
@endsection