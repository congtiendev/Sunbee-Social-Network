@extends('admin.layouts.master')
@section('content')
    <main class="w-full h-full p-2 overflow-y-auto sm:p-5 rounded-2xl hidden__scrollbar">
        <!-- ------------------------wrapper title & fill  -->
        <div class="flex items-center justify-between mb-1 title__list-user">
            <!-- ----------------------Title account------------------------ -->
            <h2 class="flex items-center gap-2 pb-1 text-xs font-semibold sm:gap-3 sm:text-lg">
                <img class="w-6 h-6" src="{{ BASE_URL }}resources/images/list-icon.png" alt="" />
                Danh sách tài khoản
            </h2>
            <!-- --------------------Fillter account---------------------- -->
            <section class="flex items-center gap-2 mb-3">
                <form class="flex gap-2 fillter__accounts item-center" action="{{ route('sort-account') }}" method="POST">
                    <select id="countries" name="sort_account"
                        class="block w-full p-1 text-xs text-gray-900 bg-white border rounded-md sm:p-2 focus:ring-blue-500 focus:border-blue-500dark:focus:border-blue-500 focus:outline-indigo-500">
                        <option class="p-1 sm:p-2" selected value="">
                            Sắp xếp theo
                        </option>
                        <option value="sort_by_name">Tên</option>
                        <option value="sort_by_latest">Mới nhất</option>
                        <option value="sort_by_oldest">Cũ nhất</option>
                    </select>
                    <button type="submit" name="btn-sort-account" data-te-ripple-init data-te-ripple-color="light"
                        class="flex gap-3 items-center rounded-lg bg-indigo-500 sm:p-2 p-1 text-xs font-medium uppercase leading-normal text-white transition duration-150 ease-in-out hover:bg-indigo-700 hover:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.3),0_4px_18px_0_rgba(59,113,202,0.2)] focus:bg-primary-600 focus:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.3),0_4px_18px_0_rgba(59,113,202,0.2)] focus:outline-none focus:ring-0 active:bg-indigo-700 active:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.3),0_4px_18px_0_rgba(59,113,202,0.2)]">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                            class="w-5 h-5 text-white">
                            <path fill-rule="evenodd"
                                d="M3.792 2.938A49.069 49.069 0 0112 2.25c2.797 0 5.54.236 8.209.688a1.857 1.857 0 011.541 1.836v1.044a3 3 0 01-.879 2.121l-6.182 6.182a1.5 1.5 0 00-.439 1.061v2.927a3 3 0 01-1.658 2.684l-1.757.878A.75.75 0 019.75 21v-5.818a1.5 1.5 0 00-.44-1.06L3.13 7.938a3 3 0 01-.879-2.121V4.774c0-.897.64-1.683 1.542-1.836z"
                                clip-rule="evenodd" />
                        </svg>
                    </button>
                </form>
                <a href="{{ route('create-account') }}">
                    <button name="btn-add-account" type="button" data-te-ripple-init data-te-ripple-color="light"
                        class="flex gap-3 items-center rounded-lg bg-indigo-500 sm:p-2 p-1 text-xs font-medium uppercase leading-normal text-white transition duration-150 ease-in-out hover:bg-indigo-700 hover:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.3),0_4px_18px_0_rgba(59,113,202,0.2)] focus:bg-primary-600 focus:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.3),0_4px_18px_0_rgba(59,113,202,0.2)] focus:outline-none focus:ring-0 active:bg-indigo-700 active:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.3),0_4px_18px_0_rgba(59,113,202,0.2)]">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="w-5 h-5">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M19 7.5v3m0 0v3m0-3h3m-3 0h-3m-2.25-4.125a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zM4 19.235v-.11a6.375 6.375 0 0112.75 0v.109A12.318 12.318 0 0110.374 21c-2.331 0-4.512-.645-6.374-1.766z" />
                        </svg>
                    </button>
                </a>
            </section>
        </div>
        <section class="w-full overflow-x-auto">
            <!-- ------------------------list account---------------------- -->
            <table class="w-full overflow-hidden whitespace-no-wrap bg-white border rounded-t-lg list-accoumt">
                <thead class="border border-gray-200">
                    <tr class="text-xs font-semibold tracking-wide text-left text-gray-700 uppercase whitespace-nowrap">
                        <th class="px-4 py-3">ID</th>
                        <th class="px-4 py-3">Tên</th>
                        <th class="px-4 py-3">Giới tính</th>
                        <th class="px-4 py-3">Ngày sinh</th>
                        <th class="px-4 py-3">Địa chỉ</th>
                        <th class="px-4 py-3">Tiểu sử</th>
                        <th class="px-4 py-3">Thao tác</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    <!-- --------------------------row---------------------------- -->
                    @foreach ($users as $user)
                        <tr class="hover:bg-gray-100">
                            <td class="px-4 py-3 text-xs sm:text-sm whitespace-nowrap">
                                <p class="font-semibold whitespace-nowrap">#{{ $user->id }}</p>
                            </td>
                            <td class="py-3">
                                <div class="flex items-center">
                                    <div class="hidden mr-3 rounded-full w-9 h-9 md:block">
                                        <img class="object-cover w-full h-full rounded-full"
                                            src="{{ empty($user->avatar) ? BASE_URL . 'resources/images/default-avatar.jpg' : BASE_URL . 'public/uploads/avatar/' . $user->avatar }}"
                                            alt="" loading="lazy" />
                                    </div>
                                    <div>
                                        <p class="text-sm font-semibold text-gray-700 whitespace-nowrap full__name">
                                            {{ $user->first_name }} {{ $user->last_name }}
                                        </p>
                                        <p class="text-xs text-gray-500 whitespace-nowrap user__name">
                                            {{ $user->username }}
                                        </p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-4 py-3 text-xs font-medium text-gray-700 sm:text-sm email whitespace-nowrap">
                                {{ ($user->gender == 0 ? 'Nữ' : $user->gender == 1) ? 'Nam' : 'Khác' }}
                            </td>
                            <td class="px-4 py-3 text-xs font-medium text-gray-700 sm:text-sm">
                                {{ date('d/m/Y', strtotime($user->birthday)) }}
                            </td>
                            <td
                                class="px-4 py-3 overflow-hidden text-xs text-gray-700 truncate sm:text-sm whitespace-nowrap">
                                {{ $user->address }}
                            </td>
                            <td
                                class="px-4 py-3 overflow-hidden text-xs text-gray-700 truncate sm:text-sm whitespace-nowrap">
                                {{ $user->bio }}
                            </td>
                            <td class="py-3 ">
                                <!-- -----------------------Action mobile------------------------- -->
                                <section class="flex items-center justify-center">
                                    <div class="flex justify-center">
                                        <div class="relative" data-te-dropdown-position="dropstart">
                                            <button
                                                class="rounded-full motion-reduce:transition-none md:hidden hover:bg-gray-200"
                                                type="button" id="dropdownMenuButton1s" data-te-dropdown-toggle-ref
                                                aria-expanded="false" data-te-ripple-init>
                                                <img class="w-7 h-7"
                                                    src="{{ BASE_URL }}resources/images/opiton-menu-icon.png"
                                                    alt="" />
                                            </button>
                                            <ul class="absolute p-2 z-[1000] float-left m-0 hidden min-w-max list-none
                                overflow-hidden rounded-lg border-none bg-white border bg-clip-padding text-left text-xs text-gray-600 shadow-lg [&[data-te-dropdown-show]]:block"
                                                aria-labelledby="dropdownMenuButton1s" data-te-dropdown-menu-ref>
                                                <li class="mb-2">
                                                    <a class="flex items-center w-full gap-2 text-xs bg-transparent whitespace-nowrap hover:bg-neutral-100 active:text-neutral-800 active:no-underline disabled:pointer-events-none disabled:bg-transparent"
                                                        href="#" data-te-dropdown-item-ref>Chi tiết
                                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                                            fill="currentColor" class="w-3 h-3 text-gray-400">
                                                            <path fill-rule="evenodd"
                                                                d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-8-5a.75.75 0 01.75.75v4.5a.75.75 0 01-1.5 0v-4.5A.75.75 0 0110 5zm0 10a1 1 0 100-2 1 1 0 000 2z"
                                                                clip-rule="evenodd" />
                                                        </svg>
                                                    </a>
                                                </li>
                                                <li class="mb-2">
                                                    <a class="flex items-center w-full gap-2 bg-transparent whitespace-nowrap hover:bg-neutral-100 active:text-neutral-800 active:no-underline disabled:pointer-events-none disabled:bg-transparent"
                                                        href="{{ route('update-profile/' . $user->id) }}"
                                                        data-te-dropdown-item-ref>Chỉnh sửa
                                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                                            fill="currentColor" class="w-3 h-3 text-gray-400">
                                                            <path
                                                                d="M5.433 13.917l1.262-3.155A4 4 0 017.58 9.42l6.92-6.918a2.121 2.121 0 013 3l-6.92 6.918c-.383.383-.84.685-1.343.886l-3.154 1.262a.5.5 0 01-.65-.65z" />
                                                            <path
                                                                d="M3.5 5.75c0-.69.56-1.25 1.25-1.25H10A.75.75 0 0010 3H4.75A2.75 2.75 0 002 5.75v9.5A2.75 2.75 0 004.75 18h9.5A2.75 2.75 0 0017 15.25V10a.75.75 0 00-1.5 0v5.25c0 .69-.56 1.25-1.25 1.25h-9.5c-.69 0-1.25-.56-1.25-1.25v-9.5z" />
                                                        </svg>
                                                    </a>
                                                </li>
                                                <li>
                                                    <a data-id="{{ $user->id }}"
                                                        class="flex items-center w-full gap-2 bg-transparent whitespace-nowrap hover:bg-neutral-100 active:text-neutral-800 active:no-underline disabled:pointer-events-none disabled:bg-transparent"
                                                        href="{{ route('delete-account/' . $user->id) }}"
                                                        data-te-dropdown-item-ref>Xóa
                                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                                            fill="currentColor" class="w-3 h-3 text-gray-400">
                                                            <path fill-rule="evenodd"
                                                                d="M8.75 1A2.75 2.75 0 006 3.75v.443c-.795.077-1.584.176-2.365.298a.75.75 0 10.23 1.482l.149-.022.841 10.518A2.75 2.75 0 007.596 19h4.807a2.75 2.75 0 002.742-2.53l.841-10.52.149.023a.75.75 0 00.23-1.482A41.03 41.03 0 0014 4.193V3.75A2.75 2.75 0 0011.25 1h-2.5zM10 4c.84 0 1.673.025 2.5.075V3.75c0-.69-.56-1.25-1.25-1.25h-2.5c-.69 0-1.25.56-1.25 1.25v.325C8.327 4.025 9.16 4 10 4zM8.58 7.72a.75.75 0 00-1.5.06l.3 7.5a.75.75 0 101.5-.06l-.3-7.5zm4.34.06a.75.75 0 10-1.5-.06l-.3 7.5a.75.75 0 101.5.06l.3-7.5z"
                                                                clip-rule="evenodd" />
                                                        </svg>
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                    <!-- -----------------------Action pc ------------------------------->
                                    <section class="items-center hidden gap-2 text-xs crud__user-pc md:flex">
                                        <a href="" class="flex items-center">
                                            <img class="min-w-5 min-h-5 max-w-5 max-h-5"
                                                src="{{ BASE_URL }}resources/images/detail-btn.png"
                                                alt="" />
                                        </a>
                                        <a href="{{ route('update-profile/' . $user->id) }}" class="flex items-center">
                                            <img class="min-w-5 min-h-5 max-w-5 max-h-5"
                                                src="{{ BASE_URL }}resources/images/edit-btn.png" alt="" />
                                        </a>
                                        <a data-id="{{ $user->id }}"
                                            href="{{ route('delete-account/' . $user->id) }}"
                                            class="flex items-center delete-account">
                                            <img class="min-w-5 min-h-5 max-w-5 max-h-5"
                                                src="{{ BASE_URL }}resources/images/delete-btn.png"
                                                alt="" />
                                        </a>
                                    </section>
                                </section>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </section>
        <!-- Phân trang -->
        <section
            class="grid px-4 py-3 text-xs font-semibold tracking-wide text-gray-500 uppercase bg-white border-t rounded-b-lg sm:grid-cols-9">
            <span class="flex items-center col-span-3 text-xs whitespace-nowrap">
                Hiển thị 1 đến {{ $pagination['offset'] }} trong {{ $pagination['total'] }} bản ghi
            </span>
            <span class="col-span-2"></span>
            <!-- Pagination -->
            <span class="flex col-span-4 mt-2 sm:mt-auto sm:justify-end">
                <nav aria-label="Table navigation">
                    <ul class="inline-flex items-center">
                        @if ($pagination['current_page'] > 1)
                            <li>
                                <a href="?page={{ $pagination['current_page'] - 1 }}">
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
                        @endif
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
                            <span class="px-3 py-1">...</span>
                        </li>

                        @if ($pagination['current_page'] < $pagination['total_pages'])
                            <li>
                                <a href="?page={{ $pagination['current_page'] + 1 }}">
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
                        @endif
                    </ul>
                </nav>
            </span>
        </section>
    </main>
@endsection
