@extends('admin.layouts.master')
@section('content')
	<main
			class="w-full h-full overflow-y-auto p-2 sm:p-5 rounded-2xl hidden__scrollbar"
	>
		<section class="w-full flex justify-center items-center">
			<!-- -----------------------list post----------------------- -->
			<section
					class="list-posts md:px-5 px-4 grid sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 sm:gap-5 md:gap-6 space-y-4 md:space-y-0"
			>
				<!-- --------------------------------posts------------------------------ -->
				<section
						class="posts-item max-w-sm bg-white dark:bg-boxdark px-4 pt-4 pb-1 rounded-xl shadow-lg transform hover:scale-105 transition duration-500"
				>
					<section class="relative infor__user flex gap-2 items-center">
						<!-- -------------------options posts------------------------- -->
						<section class="btn-options absolute top-0 right-0">
							<section class="relative">
								<button
										class="rounded-full motion-reduce:transition-none hover:bg-gray-200"
										type="button"
								>
									<svg
											xmlns="http://www.w3.org/2000/svg"
											viewBox="0 0 24 24"
											fill="currentColor"
											class="w-6 h-6"
									>
										<path
												fill-rule="evenodd"
												d="M10.5 6a1.5 1.5 0 113 0 1.5 1.5 0 01-3 0zm0 6a1.5 1.5 0 113 0 1.5 1.5 0 01-3 0zm0 6a1.5 1.5 0 113 0 1.5 1.5 0 01-3 0z"
												clip-rule="evenodd"
										/>
									</svg>
								</button>
								<!-- -------------dropdown post----------------- -->
							</section>
						</section>
						<img
								src="../../../resources/images/default-avatar.jpg"
								alt=""
								class="w-10 h-10 rounded-full object-cover"
						/>
						<section class="name-user dark:text-white text-gray-700">
							<a href="#">
								<h3 class="full-name text-base font-semibold">
									Lê Công Tiến
								</h3>
							</a>
							<p class="time text-sm dark:text-gray-200 text-gray-500">
								2 ngày trước
							</p>
						</section>
					</section>
					<div class="img__post my-3">
						<div class="swiper sliderPosts w-full rounded-xl">
							<div class="swiper-wrapper w-full rounded-xl">
								<div class="swiper-slide w-full rounded-xl">
									<img
											src="../../../resources/images/carousel/carousel-01.jpg"
											alt=""
											class="w-full min-h-[200px] max-h-[200px] object-cover rounded-xl"
									/>
								</div>
								<div class="swiper-slide w-full rounded-xl">
									<img
											src="../../../resources/images/carousel/carousel-01.jpg"
											alt=""
											class="w-full min-h-[200px] max-h-[200px] object-cover rounded-xl"
									/>
								</div>
							</div>
						</div>
					</div>
					
					<div class="content-post dark:text-white text-gray-900">
						<p class="text-xs sm:text-sm limited__content-3">
							Lorem ipsum dolor sit amet consectetur adipisicing elit.
							Quisquam, quod.Lorem ipsum dolor sit amet consectetur
							adipisicing elit. Quisquam, quod.
						</p>
					</div>
					<section
							class="interact-post p-2 border-t-2 border-dashed flex items-center justify-between mt-3"
					>
						<div class="count-like flex gap-1 items-center">
							<img
									src="../../../resources/images/icon/like-icon.png"
									alt=""
									class="w-6 h-6"
							/>
							<span
									class="text-xs sm:text-base font-extralight text-gray-900"
							>1</span
							>
						</div>
						<div class="count-like flex items-center gap-1">
                    <span
		                    class="text-xs sm:text-base font-extralight text-gray-900"
                    >1</span
                    >
							<img
									src="../../../resources/images/icon/comment-icon.png"
									alt=""
									class="w-6 h-6"
							/>
						</div>
						<div class="count-like flex items-center gap-1">
                    <span
		                    class="text-xs sm:text-base font-extralight text-gray-900"
                    >1</span
                    >
							<img
									src="../../../resources/images/icon/share-icon.png"
									alt=""
									class="w-6 h-6"
							/>
						</div>
					</section>
				</section>
				<!-- ------------------------------end post-------------------------------- -->
			</section>
		</section>
	</main>
@endsection