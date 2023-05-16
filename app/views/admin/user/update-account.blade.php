@extends('admin.layouts.master')
@section('content')
	<main class="w-full h-full overflow-y-auto rounded-2xl hidden__scrollbar">
		<section class="flex w-full h-screen gap-1">
			<aside class="hidden h-full bg-white shadow-xs md:block whitespace-nowrap" aria-label="Sidebar">
				<div class="overflow-y-auto bg-white shadow-xs">
					<ul class="flex flex-col gap-1 p-3 list-sidebar">
						<li class="flex items-center gap-1 p-2 rounded-md">
							<a href="{{ route('admin/update-profile/' . $user->id) }}" class="flex items-center gap-2">
								<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
								     stroke-width="1.5"
								     stroke="currentColor" class="p-1 text-gray-600 bg-gray-200 rounded-full w-7 h-7">
									<path stroke-linecap="round" stroke-linejoin="round"
									      d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z"/>
								</svg>
								<span class="text-sm font-medium text-gray-700">Thông tin cá
                                    nhân</span>
							</a>
						</li>
						<li class="flex items-center gap-1 p-2 bg-gray-100 rounded-md">
							<a href="{{ route('admin/update-account/' . $user->id) }}" class="flex items-center gap-2">
								<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
								     stroke-width="1.5" stroke="currentColor"
								     class="p-0.5 text-gray-500 bg-gray-200 rounded-full w-7 h-7">
									<path stroke-linecap="round" stroke-linejoin="round"
									      d="M17.982 18.725A7.488 7.488 0 0012 15.75a7.488 7.488 0 00-5.982 2.975m11.963 0a9 9 0 10-11.963 0m11.963 0A8.966 8.966 0 0112 21a8.966 8.966 0 01-5.982-2.275M15 9.75a3 3 0 11-6 0 3 3 0 016 0z"/>
								</svg>
								
								<span class="text-sm font-medium text-gray-700">Thông tin tài khoản</span>
							</a>
						</li>
						<li class="flex items-center gap-1 p-2 rounded-md">
							<a href="{{ route('home') }}" class="flex items-center gap-2">
								<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
								     stroke-width="1.5" stroke="currentColor"
								     class="p-1 text-gray-500 bg-gray-200 rounded-full w-7 h-7">
									<path stroke-linecap="round" stroke-linejoin="round"
									      d="M14.857 17.082a23.848 23.848 0 005.454-1.31A8.967 8.967 0 0118 9.75v-.7V9A6 6 0 006 9v.75a8.967 8.967 0 01-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 01-5.714 0m5.714 0a3 3 0 11-5.714 0M3.124 7.5A8.969 8.969 0 015.292 3m13.416 0a8.969 8.969 0 012.168 4.5"/>
								</svg>
								
								<span class="text-sm font-medium text-gray-700">Thông báo</span>
							</a>
						</li>
						
						<li class="flex items-center gap-1 p-2 rounded-md">
							<a href="{{ route('home') }}" class="flex items-center gap-2">
								<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
								     stroke-width="1.5" stroke="currentColor"
								     class="p-1 text-gray-500 bg-gray-200 rounded-full w-7 h-7">
									<path stroke-linecap="round" stroke-linejoin="round"
									      d="M16.5 10.5V6.75a4.5 4.5 0 10-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25H6.75a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25z"/>
								</svg>
								<span class="text-sm font-medium text-gray-700">Quyền riêng tư</span>
							</a>
						</li>
						<li class="flex items-center gap-1 p-2 rounded-md">
							<a href="{{ route('home') }}" class="flex items-center gap-2">
								<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
								     stroke-width="1.5" stroke="currentColor"
								     class="p-1 text-gray-500 bg-gray-200 rounded-full w-7 h-7">
									<path stroke-linecap="round" stroke-linejoin="round"
									      d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5m-9-6h.008v.008H12v-.008zM12 15h.008v.008H12V15zm0 2.25h.008v.008H12v-.008zM9.75 15h.008v.008H9.75V15zm0 2.25h.008v.008H9.75v-.008zM7.5 15h.008v.008H7.5V15zm0 2.25h.008v.008H7.5v-.008zm6.75-4.5h.008v.008h-.008v-.008zm0 2.25h.008v.008h-.008V15zm0 2.25h.008v.008h-.008v-.008zm2.25-4.5h.008v.008H16.5v-.008zm0 2.25h.008v.008H16.5V15z"/>
								</svg>
								
								<span class="text-sm font-medium text-gray-700">Nhật kí hoạt động</span>
							</a>
						</li>
					</ul>
				</div>
			</aside>
			<article class="w-full h-full px-4 py-3 bg-white shadow-xs sm:px-5 sm:py-3">
				<section class="w-full h-full setting-user-info">
					<form action="{{ route('admin/save-update-account/' . $user->id) }}" method="post"
					      class="w-full h-full">
						<h1 class="my-4 text-xl font-semibold text-gray-700">Thông tin
							tài khoản
						</h1>
						<div class="grid grid-cols-1 gap-5 form-control sm:grid-cols-2">
							<div class="form-group">
								<label for="first_name" class="block text-sm font-medium text-gray-500 ">Họ...
								</label>
								<div class="relative flex items-center mt-2">
                                    <span class="absolute">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                             stroke-width="1.5" stroke="currentColor"
                                             class="w-6 h-6 mx-3 text-gray-400">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                  d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z"/>
                                        </svg>

                                    </span>
									<input type="text" placeholder="First Name..." name="first_name"
									       class="block w-full py-2.5 text-gray-700 placeholder-gray-400/70 bg-white border border-gray-200 rounded-lg pl-11 pr-5 rtl:pr-11 rtl:pl-5   focus:border-indigo-400 focus:ring-indborder-indigo-300 focus:outline-none focus:ring focus:ring-opacity-40"
									       value="@if (!empty($user->first_name)) {{ trim($user->first_name) }} @else {{ isset($_SESSION['valid_data']['first_name']) && isset($_GET['msg']) ? trim($_SESSION['valid_data']['first_name']) : null }} @endif">
								</div>
								<span class="mt-2 text-xs text-red-500">
                                 	@if(isset($_SESSION['errors']) && isset($_SESSION['errors']['first_name']) && count
                                 	($_SESSION['errors']['first_name']) > 0 && isset($_GET['msg']))
										{{ $_SESSION['errors']['first_name'][0] }}
									@endif
                                </span>
							</div>
							<div class="form-group">
								<label for="last_name" class="block text-sm font-medium text-gray-500 ">Tên
								</label>
								<div class="relative flex items-center mt-2">
                                    <span class="absolute">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                             stroke-width="1.5" stroke="currentColor"
                                             class="w-6 h-6 mx-3 text-gray-400">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                  d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z"/>
                                        </svg>

                                    </span>
									<input type="text" placeholder="Tên..." name="last_name"
									       class="block w-full py-2.5 text-gray-700 placeholder-gray-400/70 bg-white border border-gray-200 rounded-lg pl-11 pr-5 rtl:pr-11 rtl:pl-5   focus:border-indigo-400 focus:ring-indborder-indigo-300 focus:outline-none focus:ring focus:ring-opacity-40"
									       value="@if (!empty($user->last_name)) {{ trim($user->last_name) }} @else {{ isset($_SESSION['valid_data']['last_name']) && isset($_GET['msg']) ? trim($_SESSION['valid_data']['last_name']) : null }} @endif">
								</div>
								<span class="mt-2 text-xs text-red-500">
                                 	@if(isset($_SESSION['errors']) && isset($_SESSION['errors']['last_name']) && count
                                 	($_SESSION['errors']['last_name']) > 0 && isset($_GET['msg']))
										{{ $_SESSION['errors']['last_name'][0] }}
									@endif
                                </span>
							</div>
							<div class="form-group">
								<label for="username" class="block text-sm font-medium text-gray-500 ">Username
								</label>
								<div class="relative flex items-center mt-2">
                                    <span class="absolute">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                             stroke-width="1.5" stroke="currentColor"
                                             class="w-6 h-6 mx-3 text-gray-400">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                  d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z"/>
                                        </svg>

                                    </span>
									<input type="text" placeholder="Username..." name="username"
									       class="block w-full py-2.5 text-gray-700 placeholder-gray-400/70 bg-white border border-gray-200 rounded-lg pl-11 pr-5 rtl:pr-11 rtl:pl-5   focus:border-indigo-400 focus:ring-indborder-indigo-300 focus:outline-none focus:ring focus:ring-opacity-40"
									       value="@if (!empty($user->username)) {{ $user->username }} @else {{ isset($_SESSION['valid_data']['username']) ? $_SESSION['valid_data']['username'] : null }} @endif">
								</div>
								<span class="mt-2 text-xs text-red-500">
                                   	@if(isset($_SESSION['errors']) && isset($_SESSION['errors']['username']) && count
                                 	($_SESSION['errors']['username']) > 0 && isset($_GET['msg']))
										{{ $_SESSION['errors']['username'][0] }}
									@endif
                                </span>
							</div>
							<div class="form-group">
								<label for="email" class="block text-sm font-medium text-gray-500 ">Email
								</label>
								<div class="relative flex items-center mt-2">
                                    <span class="absolute">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                             stroke-width="1.5" stroke="currentColor"
                                             class="w-6 h-6 mx-3 text-gray-400">
                                            <path stroke-linecap="round"
                                                  d="M16.5 12a4.5 4.5 0 11-9 0 4.5 4.5 0 019 0zm0 0c0 1.657 1.007 3 2.25 3S21 13.657 21 12a9 9 0 10-2.636 6.364M16.5 12V8.25"/>
                                        </svg>
                                    </span>
									<input type="email" placeholder="Email..." name="email"
									       class="block w-full py-2.5 text-gray-700 placeholder-gray-400/70 bg-white border border-gray-200 rounded-lg pl-11 pr-5 rtl:pr-11 rtl:pl-5   focus:border-indigo-400 focus:ring-indborder-indigo-300 focus:outline-none focus:ring focus:ring-opacity-40"
									       value="@if (!empty($user->email)) {{ $user->email }} @else {{ isset($_SESSION['valid_data']['email']) && isset($_GET['msg']) ? $_SESSION['valid_data']['email'] : null }} @endif">
								</div>
								<span class="mt-2 text-xs text-red-500">
                                  	@if(isset($_SESSION['errors']) && isset($_SESSION['errors']['email']) && count
                                 	($_SESSION['errors']['email']) > 0 && isset($_GET['msg']))
										{{ $_SESSION['errors']['email'][0] }}
									@endif
                                </span>
							</div>
							
							<div class="form-group">
								<label for="phone_number" class="block text-sm font-medium text-gray-500 ">Số
									điện thoại
								</label>
								<div class="relative flex items-center mt-2">
                                    <span class="absolute">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                             stroke-width="1.5" stroke="currentColor"
                                             class="w-6 h-6 mx-3 text-gray-400">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                  d="M2.25 6.75c0 8.284 6.716 15 15 15h2.25a2.25 2.25 0 002.25-2.25v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106c-.44-.11-.902.055-1.173.417l-.97 1.293c-.282.376-.769.542-1.21.38a12.035 12.035 0 01-7.143-7.143c-.162-.441.004-.928.38-1.21l1.293-.97c.363-.271.527-.734.417-1.173L6.963 3.102a1.125 1.125 0 00-1.091-.852H4.5A2.25 2.25 0 002.25 4.5v2.25z"/>
                                        </svg>

                                    </span>
									<input type="number" min="0" placeholder="Số điện thoại..."
									       name="phone_number"
									       class="block w-full py-2.5 text-gray-700 placeholder-gray-400/70 bg-white border border-gray-200 rounded-lg pl-11 pr-5 rtl:pr-11 rtl:pl-5   focus:border-indigo-400 focus:ring-indborder-indigo-300 focus:outline-none focus:ring focus:ring-opacity-40"
									       value="{{ $user->phone_number }}">
								</div>
								<span class="mt-2 text-xs text-red-500">
                                   	@if(isset($_SESSION['errors']) && isset($_SESSION['errors']['phone']) && count
                                 	($_SESSION['errors']['phone']) > 0 && isset($_GET['msg']))
										{{ $_SESSION['errors']['phone'][0] }}
									@endif
                                </span>
							</div>
							<div class="form-group">
								<label for="role" class="block text-sm font-medium text-gray-500 ">Vai trò
								</label>
								<div class="relative flex items-center mt-2">
                                    <span class="absolute">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                             stroke-width="1.5" stroke="currentColor"
                                             class="w-6 h-6 mx-3 text-gray-400">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                  d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z"/>
                                        </svg>

                                    </span>
									<select name="role"
									        class="block w-full py-3 pr-5 text-gray-700 bg-white border border-gray-200 rounded-lg placeholder-gray-400/70 pl-11 rtl:pr-11 rtl:pl-5 focus:border-indigo-400 focus:ring-indborder-indigo-300 focus:outline-none focus:ring focus:ring-opacity-40">
										<option value="0" {{ $user->role == 0 ? 'selected' : '' }}>Người dùng
										</option>
										<option value="1" {{ $user->role == 1 ? 'selected' : '' }}>Admin
										</option>
									</select>
								</div>
							</div>
							<div class="form-group">
								<label for="first_name" class="block mb-2 text-sm font-medium text-gray-500">
									Mật khẩu
								</label>
								<a href="{{ route('admin/change-password/' . $user->id) }}"
								   class="btn btn-outline btn-info">Đổi
									mật
									khẩu</a>
							</div>
						</div>
						<div class="flex justify-center  gap-2 my-5 btn-group">
							<button type="reset" style="background-color: #ff0000"
							        class="w-32 px-4 py-2 font-medium text-white transition-all duration-300  rounded-xl hover:bg-red-500">
								Hủy
							</button>
							<button name="btn-save"
							        class="w-32 px-4 py-2 font-medium text-white transition-all duration-300 bg-green-600  rounded-xl hover:bg-green-500">
								Lưu
							</button>
						</div>
					</form>
				</section>
			</article>
		</section>
	</main>
@endsection
