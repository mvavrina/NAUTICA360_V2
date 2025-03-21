<header class="header sticky top-0 z-50">
  <nav class="bg-white border-gray-200 px-4 lg:px-6 py-2.5 dark:bg-gray-900 py-5">
      <div class="flex flex-wrap justify-between items-center mx-auto max-w-screen-xl">
          <a href="{{config('app.url')}}" class="flex items-center">
              <img src="{{asset('img/logo.png')}}" class="mr-3 h-3.5 sm:h-4" alt="Flowbite Logo" />
          </a>
          <div class="flex items-center lg:order-2 gap-4">
                <a href="https://www.facebook.com/nautica360/" target="_blank" class="social-button text-white" title="Page title" rel="nofollow noopener noreferrer"><span class="fab fa-facebook text-white"></span></a>
                <a href="https://www.instagram.com/nautica360cz/" target="_blank" class="text-white social-button" title="Page title" rel="nofollow noopener noreferrer"><span class="fab fa-instagram"></span></a>
                <a href="https://www.youtube.com/channel/UCoKfUNfEsyJiGyaUqTdU_bA" target="_blank" class="text-white social-button" title="Page title" rel="nofollow noopener noreferrer"><span class="fab fa-youtube"></span></a>


              <a href="{{route('yacht.search')}}" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-4 lg:px-5 py-2 lg:py-2.5 mr-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800 hidden xl:flex">Vyhledat loď</a>
              <button data-collapse-toggle="mobile-menu-2" type="button" class="inline-flex items-center p-2 ml-1 text-sm text-gray-500 rounded-lg lg:hidden hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200 dark:text-gray-400 dark:hover:bg-gray-700 dark:focus:ring-gray-600" aria-controls="mobile-menu-2" aria-expanded="false">
                  <span class="sr-only">Open main menu</span>
                  <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M3 5a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 10a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 15a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z" clip-rule="evenodd"></path></svg>
                  <svg class="hidden w-6 h-6" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
              </button>
          </div>
          <div class="hidden justify-between items-center w-full lg:flex lg:w-auto lg:order-1" id="mobile-menu-2">
                <x-filament-menu-builder::menu slug="header-menu" type="header"/>
          </div>
      </div>
  </nav>
</header>