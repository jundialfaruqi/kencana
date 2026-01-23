<div>
    <livewire:landing-page::landing-page.hero-carousel />
    @island(name: 'banner-carousel', lazy: true)
        @placeholder
            <div class="mt-8 sm:mt-12">
                <div class="flex flex-col gap-4 sm:gap-6 animate-pulse">
                    <div class="px-2">
                        <div class="h-6 sm:h-8 bg-base-300 w-32 sm:w-48 rounded-lg"></div>
                        <div class="h-3 bg-base-300 w-48 sm:w-64 mt-1 rounded-lg"></div>
                    </div>
                    <div class="w-full aspect-video sm:aspect-21/9 bg-base-300 rounded-2xl sm:rounded-3xl"></div>
                </div>
            </div>
        @endplaceholder
        <livewire:landing-page::landing-page.banner-carousel />
    @endisland
</div>
