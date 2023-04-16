@extends('admin.layouts.master')
@section('content')
    <main class="w-full px-3 mx-auto sm:px-5">
        <form method="get" action="{{ route('admin/search-user') }}"
            class="flex flex-wrap items-center justify-between mt-6">
            <div class="relative flex items-center form-group">
                <button type="submit" class="absolute" name="account">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="w-5 h-5 mx-3 text-gray-400 dark:text-gray-600">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" />
                    </svg>
                </button>
                <input type="text" placeholder="Tìm kiếm" name="keyword"
                    class="block w-full py-1.5 pr-5 text-gray-700 bg-white border border-gray-200 rounded-lg md:w-80 placeholder-gray-400/70 pl-11 rtl:pr-11 rtl:pl-5 dark:bg-gray-900 dark:text-gray-300 dark:border-gray-600 focus:border-blue-400 dark:focus:border-blue-300 focus:ring-blue-300 focus:outline-none focus:ring focus:ring-opacity-40" />
            </div>
            <a href="{{ route('admin/create-account') }}"
                class="flex items-center gap-2 px-3 py-2 text-xs font-medium text-white transition-all duration-300 bg-indigo-600 font-montserrat rounded-xl hover:bg-indigo-500"
                style="box-shadow: 0 15px 30px -5px rgba(79, 70, 229, 0.6);"><span class="hidden sm:block">Thêm
                    tài khoản</span> <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                    stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M19 7.5v3m0 0v3m0-3h3m-3 0h-3m-2.25-4.125a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zM4 19.235v-.11a6.375 6.375 0 0112.75 0v.109A12.318 12.318 0 0110.374 21c-2.331 0-4.512-.645-6.374-1.766z" />
                </svg>
            </a>
        </form>

        <div class="flex flex-col sm:mt-3">
            <div class="w-full overflow-x-auto hidden__scrollbar">
                <div class="inline-block min-w-full pt-2 align-middle">
                    <div class="overflow-hidden border border-gray-200 rounded-t-lg dark:border-gray-800">
                        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                            <thead class="text-gray-700 bg-gray-50 dark:text-white dark:bg-gray-800 whitespace-nowrap">
                                <tr>
                                    <th scope="col"
                                        class="py-3.5 px-4 text-sm font-normal text-left rtl:text-right text-gray-500 dark:text-gray-400">
                                        <div class="flex items-center gap-x-3 focus:outline-none">
                                            <span>Tên</span>
                                            <a
                                                href="{{ !empty($keyword) ? route('admin/search-account/' . $keyword . '/first_name/ASC') : route('admin/list-account/first_name/ASC') }}">
                                                <svg class="h-4 text-indigo-500 hover:text-indigo-900" viewBox="0 0 10 11"
                                                    fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <path
                                                        d="M2.13347 0.0999756H2.98516L5.01902 4.79058H3.86226L3.45549 3.79907H1.63772L1.24366 4.79058H0.0996094L2.13347 0.0999756ZM2.54025 1.46012L1.96822 2.92196H3.11227L2.54025 1.46012Z"
                                                        fill="currentColor" stroke="currentColor" stroke-width="0.1" />
                                                    <path
                                                        d="M0.722656 9.60832L3.09974 6.78633H0.811638V5.87109H4.35819V6.78633L2.01925 9.60832H4.43446V10.5617H0.722656V9.60832Z"
                                                        fill="currentColor" stroke="currentColor" stroke-width="0.1" />
                                                    <path
                                                        d="M8.45558 7.25664V7.40664H8.60558H9.66065C9.72481 7.40664 9.74667 7.42274 9.75141 7.42691C9.75148 7.42808 9.75146 7.42993 9.75116 7.43262C9.75001 7.44265 9.74458 7.46304 9.72525 7.49314C9.72522 7.4932 9.72518 7.49326 9.72514 7.49332L7.86959 10.3529L7.86924 10.3534C7.83227 10.4109 7.79863 10.418 7.78568 10.418C7.77272 10.418 7.73908 10.4109 7.70211 10.3534L7.70177 10.3529L5.84621 7.49332C5.84617 7.49325 5.84612 7.49318 5.84608 7.49311C5.82677 7.46302 5.82135 7.44264 5.8202 7.43262C5.81989 7.42993 5.81987 7.42808 5.81994 7.42691C5.82469 7.42274 5.84655 7.40664 5.91071 7.40664H6.96578H7.11578V7.25664V0.633865C7.11578 0.42434 7.29014 0.249976 7.49967 0.249976H8.07169C8.28121 0.249976 8.45558 0.42434 8.45558 0.633865V7.25664Z"
                                                        fill="currentColor" stroke="currentColor" stroke-width="0.3" />
                                                </svg>
                                            </a>
                                        </div>
                                    </th>
                                    <th scope="col"
                                        class="px-4 py-3.5 text-sm font-normal text-left rtl:text-right text-gray-500 dark:text-gray-400">
                                        Email
                                    </th>
                                    <th scope="col"
                                        class="px-4 py-3.5 text-sm font-normal text-left rtl:text-right text-gray-500 dark:text-gray-400">
                                        Số điện thoại
                                    </th>
                                    <th scope="col"
                                        class="px-4 py-3.5 text-sm font-normal text-left text-gray-500 rtl:text-right dark:text-gray-400">
                                        <div class="flex items-center gap-x-3 focus:outline-none">
                                            <a
                                                href="{{ !empty($keyword) ? route('admin/search-account/' . $keyword . '/created_at/ASC') : route('admin/list-account/created_at/ASC') }}">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                    stroke-width="1.5" stroke="currentColor"
                                                    class="h-4 font-bold text-indigo-500 hover:text-indigo-900">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="M19.5 13.5L12 21m0 0l-7.5-7.5M12 21V3" />
                                                </svg>
                                            </a>
                                            <span>Ngày tạo</span>
                                            <a
                                                href="{{ !empty($keyword) ? route('admin/search-account/' . $keyword . '/created_at/DESC') : route('admin/list-account/created_at/DESC') }}">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                    stroke-width="1.5" stroke="currentColor"
                                                    class="h-4 text-indigo-500 hover:text-indigo-900">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="M12 19.5v-15m0 0l-6.75 6.75M12 4.5l6.75 6.75" />
                                                </svg>
                                            </a>
                                            <input type="hidden" name="list_account">
                                        </div>
                                    </th>

                                    <th scope="col"
                                        class="px-4 py-3.5 text-sm font-normal text-left rtl:text-right text-gray-500 dark:text-gray-400">
                                        Vai trò
                                    </th>
                                    <th scope="col" class="relative py-3.5 px-4"></th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200 dark:divide-gray-700 dark:bg-gray-900">
                                @foreach ($users as $user)
                                    <tr>
                                        <td class="flex items-center gap-2 px-4 py-4 text-sm font-medium whitespace-nowrap">
                                            <div class="w-8 h-8">
                                                <img class="object-cover w-full h-full rounded-full"
                                                    src="{{ empty($user->avatar) ? AVATAR_PATH . 'default-avatar.jpg' : AVATAR_PATH . $user->avatar }}"
                                                    alt="Avatar" loading="lazy" />
                                            </div>
                                            <section>
                                                <h2 class="font-medium text-gray-800 dark:text-white">
                                                    {{ $user->first_name }} {{ $user->last_name }}
                                                </h2>
                                                <p class="text-xs font-normal text-gray-600 dark:text-gray-400">
                                                    {{ $user->username }}
                                                </p>
                                            </section>
                                        </td>

                                        <td class="p-4 text-sm whitespace-nowrap">
                                            <p class="text-gray-700 dark:text-white">
                                                {{ $user->email }}
                                            </p>
                                        </td>

                                        <td class="p-4 text-sm max-w-[220px] overflow-hidden truncate whitespace-nowrap">
                                            <p class="text-gray-700 dark:text-white">
                                                {{ $user->phone_number }}
                                            </p>
                                        </td>
                                        <td class="p-4 text-sm whitespace-nowrap">
                                            <p class="text-gray-900 dark:text-white">
                                                {{ $user->created_at }}
                                            </p>
                                        </td>
                                        <td class="p-4 text-sm font-medium whitespace-nowrap">
                                            <div
                                                class="text-sm text-gray-700 font-medium  {{ $user->role == 0 ? 'badge badge-success' : 'badge badge-error' }} ">
                                                {{ $user->role == 0 ? 'Người dùng' : 'Admin' }}
                                            </div>
                                        </td>
                                        <td class="px-4 py-4 text-sm whitespace-nowrap">
                                            <div class="dropdown dropdown-left dropdown-end">
                                                <button tabindex="0"
                                                    class="px-1 py-1 text-gray-500 transition-colors duration-200 rounded-lg dark:text-gray-300 hover:bg-gray-200 dark:hover:bg-slate-600">
                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                        viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                                        class="w-6 h-6">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            d="M12 6.75a.75.75 0 110-1.5.75.75 0 010 1.5zM12 12.75a.75.75 0 110-1.5.75.75 0 010 1.5zM12 18.75a.75.75 0 110-1.5.75.75 0 010 1.5z" />
                                                    </svg>
                                                </button>
                                                <ul tabindex="0"
                                                    class="flex flex-col gap-2 p-3 text-xs font-medium text-gray-700 rounded-lg shadow dropdown-content bg-gray-50 dark:bg-base-100 whitespace-nowrap dark:text-gray-100 sm:text-sm">
                                                    <li class="flex items-center justify-between gap-3">
                                                        <a href="{{ route('admin/detail-profile/' . $user->id) }}"
                                                            class="text-sm font-medium hover:text-indigo-500">Xem chi
                                                            tiết</a><svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                            viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                                            class="w-4 h-4">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z" />
                                                        </svg>
                                                    </li>
                                                    <li class="flex items-center justify-between gap-3">
                                                        <a href="{{ route('admin/update-account/' . $user->id) }}"
                                                            class="font-medium hover:text-indigo-500">Chỉnh
                                                            sửa hồ sơ</a><svg xmlns="http://www.w3.org/2000/svg"
                                                            fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                                            stroke="currentColor" class="w-4 h-4">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
                                                        </svg>
                                                    </li>
                                                    <li class="flex items-center justify-between gap-3">
                                                        <a href="{{ route('admin/delete-account/' . $user->id) }}"
                                                            data-id="{{ $user->id }}"
                                                            class="text-sm font-medium delete-account hover:text-indigo-500">Xóa
                                                            tài
                                                            khoản này</a><svg xmlns="http://www.w3.org/2000/svg"
                                                            fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                                            stroke="currentColor" class="w-4 h-4">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                d="M20.25 7.5l-.625 10.632a2.25 2.25 0 01-2.247 2.118H6.622a2.25 2.25 0 01-2.247-2.118L3.75 7.5m6 4.125l2.25 2.25m0 0l2.25 2.25M12 13.875l2.25-2.25M12 13.875l-2.25 2.25M3.375 7.5h17.25c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125z" />
                                                        </svg>
                                                    </li>
                                                </ul>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <!-------------------------------------- Pagination----------------------------------- -->
        <section
            class="flex justify-center items-center px-4 py-3 text-xs font-semibold tracking-wide text-gray-500 uppercase bg-white border border-gray-200 rounded-b-lg dark:bg-gray-800 dark:border-gray-800">
            <span class="flex col-span-4 sm:mt-auto sm:justify-end">
                <nav aria-label="Table navigation">
                    <ul class="inline-flex items-center">
                        <li>
                            <a
                                href="@if ($pagination['current_page'] > 1) ?page={{ $pagination['current_page'] - 1 }}@else # @endif">
                                <button
                                    class="px-3 py-1 rounded-md rounded-l-lg focus:outline-none focus:shadow-outline-purple"
                                    aria-label="Previous">
                                    <svg aria-hidden="true" class="w-4 h-4 fill-current" viewBox="0 0 20 20">
                                        <path
                                            d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z"
                                            clip-rule="evenodd" fill-rule="evenodd"></path>
                                    </svg>
                                </button>
                            </a>
                        </li>
                        @for ($i = 1; $i <= $pagination['total_pages']; $i++)
                            @if ($i == $pagination['current_page'])
                                <li>
                                    <button
                                        class="px-3 py-1 text-white transition-colors duration-150 bg-indigo-500 border border-r-0 border-indigo-500 rounded-md dark:bg-orange-600 dark:border-orange-600 focus:outline-none focus:shadow-outline-purple">
                                        {{ $i }}
                                    </button>
                                </li>
                            @else
                                <li>
                                    <button class="px-3 py-1 rounded-md focus:outline-none focus:shadow-outline-purple">
                                        <a href="?page={{ $i }}">{{ $i }}</a>
                                    </button>
                                </li>
                            @endif
                        @endfor

                        <li>
                            <a
                                href=" @if ($pagination['current_page'] < $pagination['total_pages']) ?page={{ $pagination['current_page'] + 1 }}@else # @endif">
                                <button
                                    class="px-3 py-1 rounded-md rounded-r-lg focus:outline-none focus:shadow-outline-purple"
                                    aria-label="Next">
                                    <svg class="w-4 h-4 fill-current" aria-hidden="true" viewBox="0 0 20 20">
                                        <path
                                            d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                                            clip-rule="evenodd" fill-rule="evenodd"></path>
                                    </svg>
                                </button>
                            </a>
                        </li>
                    </ul>
                </nav>
            </span>
        </section>
    </main>
@endsection
