    <AppNav />

    <AppActions />

    <div class="relative bg-gray-800">
      <div class="h-56 bg-purple-600 sm:h-72 md:absolute md:left-0 md:h-full md:w-1/2">
        <img class="w-full h-full object-cover" src="https://images.unsplash.com/photo-1525130413817-d45c1d127c42?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=crop&w=1920&q=60&blend=6875F5&sat=-100&blend-mode=multiply" alt="Support team" />
      </div>
      <div class="relative max-w-screen-xl mx-auto px-4 py-12 sm:px-6 lg:px-8 lg:py-16">
        <div class="md:ml-auto md:w-1/2 md:pl-10">
          <div class="text-base leading-6 font-semibold uppercase tracking-wider text-gray-300">
            Award winning support
          </div>
          <h2 class="mt-2 text-white text-3xl leading-9 font-extrabold tracking-tight sm:text-4xl sm:leading-10">
            We’re here to help
          </h2>
          <p class="mt-3 text-lg leading-7 text-gray-300">
            Lorem ipsum dolor sit amet, consectetur adipiscing elit. Et, egestas tempus tellus etiam sed. Quam a scelerisque amet ullamcorper eu enim et fermentum, augue. Aliquet amet volutpat quisque ut interdum tincidunt duis.
          </p>
          <div class="mt-8">
            <div class="inline-flex rounded-md shadow">
              <a href="#" class="inline-flex items-center justify-center px-5 py-3 border border-transparent text-base leading-6 font-medium rounded-md text-gray-900 bg-white hover:text-gray-600 focus:outline-none focus:shadow-outline transition duration-150 ease-in-out">
                Visit the help center
                <svg class="-mr-1 ml-3 h-5 w-5 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                  <path fill-rule="evenodd" d="M11 3a1 1 0 100 2h2.586l-6.293 6.293a1 1 0 101.414 1.414L15 6.414V9a1 1 0 102 0V4a1 1 0 00-1-1h-5zM5 5a2 2 0 00-2 2v8a2 2 0 002 2h8a2 2 0 002-2v-3a1 1 0 10-2 0v3H5V7h3a1 1 0 000-2H5z" clip-rule="evenodd"/>
                </svg>
              </a>
            </div>
          </div>
        </div>
      </div>
    </div>

    <button
      type="button"
      class="
      inline-flex
      items-center
      px-4
      py-2
      border
      border-transparent
      text-base
      leading-6
      font-medium
      rounded-md
      text-white
      bg-purple-600
      hover:bg-purple-500
      focus:outline-none
      focus:border-purple-700
      focus:shadow-outline-purple
      active:bg-purple-700
      transition ease-in-out duration-150"
    >Button
    </button>

    <span class="relative z-0 inline-flex shadow-sm">
      <button type="button" class="relative inline-flex items-center px-4 py-2 rounded-l-md border border-gray-300 bg-white text-sm leading-5 font-medium text-gray-700 hover:text-gray-500 focus:z-10 focus:outline-none focus:border-blue-300 focus:shadow-outline-blue active:bg-gray-100 active:text-gray-700 transition ease-in-out duration-150">Save changes</button>
      <span class="-ml-px relative block">
        <button @click="open = !open" type="button" class="relative inline-flex items-center px-2 py-2 rounded-r-md border border-gray-300 bg-white text-sm leading-5 font-medium text-gray-500 hover:text-gray-400 focus:z-10 focus:outline-none focus:border-blue-300 focus:shadow-outline-blue active:bg-gray-100 active:text-gray-500 transition ease-in-out duration-150">
          <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20">
            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"/>
          </svg>
        </button>
        <div x-show="open" style="display: none;" class="origin-top-right absolute right-0 mt-2 -mr-1 w-56 rounded-md shadow-lg">
          <div class="rounded-md bg-white shadow-xs">
            <div class="py-1">
              <a href="#" class="block px-4 py-2 text-sm leading-5 text-gray-700 hover:bg-gray-100 hover:text-gray-900 focus:outline-none focus:bg-gray-100 focus:text-gray-900">
                Save and schedule
              </a>
              <a href="#" class="block px-4 py-2 text-sm leading-5 text-gray-700 hover:bg-gray-100 hover:text-gray-900 focus:outline-none focus:bg-gray-100 focus:text-gray-900">
                Save and publish
              </a>
              <a href="#" class="block px-4 py-2 text-sm leading-5 text-gray-700 hover:bg-gray-100 hover:text-gray-900 focus:outline-none focus:bg-gray-100 focus:text-gray-900">
                Export PDF
              </a>
            </div>
          </div>
        </div>
      </span>
    </span>

    <AppFaq />

    <LogoCloud />

    <AppFooter />
