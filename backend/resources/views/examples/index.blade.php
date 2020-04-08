<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Examples</title>
    <link href="https://cominex.net/assets/css/utilities.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://rsms.me/inter/inter.css">
    <link href="/css/examples.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.0.1/dist/alpine.js" defer></script>
    <script src="/js/examples.js" defer></script>
    <style>
        .example {
            cursor: grab;
            background: radial-gradient(circle,
                rgba(245, 255, 147, 1) 0%,
                rgba(233, 253, 45, 1) 100%);
            }
    </style>
</head>

<body>
    <div id="app" class="example h-screen transition-all duration-300">
        <div class="relative flex flex-col min-h-screen">
            <!-- Navigation Component -->
            <div class="text-center p-2" style="background-color: #3c366b">
                <div role="alert"
                    class="p-2 bg-indigo-800 items-center text-indigo-100 leading-none lg:rounded-full flex lg:inline-flex">
                    <span class="flex rounded-full bg-indigo-500 uppercase px-2 py-1 text-xs font-bold mr-3">New</span>
                    <span class="font-semibold mr-2 text-left flex-auto">Get the coolest t-shirts from our brand new
                        store</span> <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                        class="fill-current opacity-75 h-4 w-4">
                        <path
                            d="M12.95 10.707l.707-.707L8 4.343 6.586 5.757 10.828 10l-4.242 4.243L8 15.657l4.95-4.95z">
                        </path>
                    </svg></div>
            </div>

            <nav id="app-nav" x-data="{ open: true}" class="bg-gray-800">
                <!--  -->

                <div class="max-w-7xl mx-auto px-2 sm:px-4 lg:px-8">
                    <div class="relative flex items-center justify-between h-16">
                        <!--  -->

                        <div class="flex items-center px-2 lg:px-0">
                            <div class="flex-shrink-0">

                                <!-- Branding -->
                                <div class="flex items-center flex-shrink-0 text-white">
                                    <img class="block h-8 w-auto mr-2"
                                        src="http://cominex.net/assets/img/logos/titan-mark.svg" alt="">
                                    <svg class="hidden lg:block h-8 w-auto text-white" width="80" height="24"
                                        viewBox="0 0 80 24">
                                        <path class="f"
                                            d="M1.71484 9.62109H2.94531L0.90625 23.25H5.27734L7.31641 9.62109H9.32031L9.80078 6.32812H7.72656L7.83203 5.57812C7.98438 4.62891 8.40625 4.26562 9.08594 4.26562C9.55469 4.26562 9.98828 4.34766 10.1875 4.38281L11.0547 1.16016C10.6914 1.05469 9.82422 0.84375 8.53516 0.84375C5.52344 0.84375 4.02344 2.41406 3.61328 5.19141L3.4375 6.32812H2.19531L1.71484 9.62109Z"
                                            fill="currentColor" />
                                        <path class="r1"
                                            d="M11.043 6.32812L9.29688 18H13.668L14.6875 11.168C15.5898 10.6289 16.9141 10.2891 17.875 10.2539L18.4961 6.09375C17.1602 6.10547 15.7422 6.96094 14.8164 7.67578L14.8281 6.32812H11.043Z"
                                            fill="currentColor" />
                                        <path class="o"
                                            d="M18.4375 13.1133C17.9336 16.4531 19.7031 18.2344 23.2891 18.2344C26.8633 18.2344 29.1836 16.4531 29.6758 13.1133L29.957 11.2266C30.4609 7.88672 28.6797 6.09375 25.1055 6.09375C21.5195 6.09375 19.2109 7.88672 18.7188 11.2266L18.4375 13.1133ZM23.1367 10.8867C23.2656 10.0078 23.793 9.42188 24.6133 9.42188C25.4336 9.42188 25.7734 10.0078 25.6328 10.8867L25.2461 13.4531C25.1172 14.3438 24.6016 14.9062 23.7812 14.9062C22.9609 14.9062 22.6211 14.3438 22.7617 13.4531L23.1367 10.8867Z"
                                            fill="currentColor" />
                                        <path class="n"
                                            d="M32.3945 6.32812L30.6484 18H35.0195L36.1562 10.4414C36.6484 10.1016 37.1875 9.89062 37.6211 9.89062C38.2539 9.89062 38.5117 10.2773 38.418 10.9453L37.3516 18H41.7227L42.9883 9.57422C43.3281 7.3125 42.3203 6.09375 40.1523 6.09375C38.7109 6.09375 37.2695 6.77344 36.2031 7.44141L36.1914 6.32812H32.3945Z"
                                            fill="currentColor" />
                                        <path class="t text-gray-300"
                                            d="M44.0195 9.62109H45.25C44.9453 11.707 44.4766 14.0859 44.5469 15.7617C44.6641 17.4609 45.7891 18.2344 47.8867 18.2344C49.2227 18.2344 50.2422 18.0352 50.6992 17.9062L50.9805 14.6953C50.7695 14.7188 50.207 14.8125 49.7383 14.8125C49.1406 14.8125 48.8945 14.5195 49.0117 13.7109L49.6211 9.62109H51.5664L52.0586 6.32812H50.0312C50.1953 5.23828 50.3594 4.16016 50.5117 3.07031H46.5625L45.8711 6.32812H44.5L44.0195 9.62109Z"
                                            fill="currentColor" />
                                        <path class="i text-gray-300"
                                            d="M53.7695 6.32812L52.0234 18H56.3945L58.1406 6.32812H53.7695ZM54.1328 3.42188C54.1328 4.60547 54.8359 5.14453 56.125 5.14453C57.8477 5.14453 58.7734 4.3125 58.7734 2.625C58.7734 1.45312 58.0703 0.902344 56.7578 0.902344C55.0469 0.902344 54.1328 1.73438 54.1328 3.42188Z"
                                            fill="currentColor" />
                                        <path class="e text-gray-300"
                                            d="M58.7617 13.2422C58.2695 16.5352 60.2383 18.2344 63.7188 18.2344C66.1094 18.2344 67.6797 17.8711 68.3359 17.6953L68.4648 14.5664C67.8203 14.6836 66.5078 14.9062 65.0547 14.9062C63.4258 14.9062 62.793 14.4258 62.9336 13.4531L62.9688 13.2539C63.4492 13.3359 64.0938 13.3945 64.7266 13.3945C67.1406 13.3945 69.8711 13.0195 69.8711 9.55078C69.8711 7.53516 68.3477 6.09375 65.3945 6.09375C61.8438 6.09375 59.5586 7.93359 59.0664 11.2617L58.7617 13.2422ZM63.3555 10.6406C63.4961 9.73828 63.9648 9.21094 64.7617 9.21094C65.4297 9.21094 65.7461 9.58594 65.7461 10.1133C65.7461 11.0039 65.1836 11.3086 64.2461 11.3086C63.9297 11.3086 63.5664 11.2617 63.2734 11.1914L63.3555 10.6406Z"
                                            fill="currentColor" />
                                        <path class="r2 text-gray-300"
                                            d="M71.957 6.32812L70.2109 18H74.582L75.6016 11.168C76.5039 10.6289 77.8281 10.2891 78.7891 10.2539L79.4102 6.09375C78.0742 6.10547 76.6562 6.96094 75.7305 7.67578L75.7422 6.32812H71.957Z"
                                            fill="currentColor" />
                                    </svg>
                                </div>
                            </div>
                            <div class="hidden lg:block lg:ml-6">
                                <div class="flex">
                                    <a href="#"
                                        class="px-3 py-2 rounded-md text-sm leading-5 font-medium text-white bg-gray-900 focus:outline-none focus:text-white focus:bg-gray-700 transition duration-150 ease-in-out">Dashboard</a>
                                    <a href="#"
                                        class="ml-4 px-3 py-2 rounded-md text-sm leading-5 font-medium text-gray-300 hover:text-white hover:bg-gray-700 focus:outline-none focus:text-white focus:bg-gray-700 transition duration-150 ease-in-out">Team</a>
                                    <a href="#"
                                        class="ml-4 px-3 py-2 rounded-md text-sm leading-5 font-medium text-gray-300 hover:text-white hover:bg-gray-700 focus:outline-none focus:text-white focus:bg-gray-700 transition duration-150 ease-in-out">Projects</a>
                                    <a href="#"
                                        class="ml-4 px-3 py-2 rounded-md text-sm leading-5 font-medium text-gray-300 hover:text-white hover:bg-gray-700 focus:outline-none focus:text-white focus:bg-gray-700 transition duration-150 ease-in-out">Calendar</a>
                                </div>
                            </div>
                        </div>

                        <!--  -->

                        <div class="flex-1 flex justify-center px-2 lg:ml-6 lg:justify-end">
                            <div class="max-w-lg w-full lg:max-w-xs">
                                <label for="search" class="sr-only">Search</label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <svg class="h-5 w-5 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd"
                                                d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z"
                                                clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                    <input id="search"
                                        class="block w-full pl-10 pr-3 py-2 border border-transparent rounded-md leading-5 bg-gray-700 placeholder-gray-400 focus:outline-none focus:bg-white sm:text-sm transition duration-150 ease-in-out"
                                        placeholder="Search" />
                                </div>
                            </div>
                        </div>

                        <!--  -->

                        <div class="flex lg:hidden">
                            <button @click="open = !open"
                                class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-white hover:bg-gray-700 focus:outline-none focus:bg-gray-700 focus:text-white transition duration-150 ease-in-out">
                                <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                                    <path :class="{'hidden': open, 'inline-flex': !open }" class="inline-flex"
                                        stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M4 6h16M4 12h16M4 18h16" />
                                    <path :class="{'hidden': !open, 'inline-flex': open }" class="hidden"
                                        stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                        </div>

                        <!--  -->

                        <div class="hidden lg:block lg:ml-4">
                            <div class="flex items-center">
                                <button
                                    class="flex-shrink-0 p-1 border-2 border-transparent text-gray-400 rounded-full hover:text-white focus:outline-none focus:text-white focus:bg-gray-700 transition duration-150 ease-in-out">
                                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                                    </svg>
                                </button>
                                <div @click.away="open = false" class="ml-4 relative flex-shrink-0"
                                    x-data="{ open: false }">
                                    <div>
                                        <button @click="open = !open"
                                            class="flex text-sm rounded-full text-white focus:outline-none focus:shadow-solid transition duration-150 ease-in-out">
                                            <img class="h-8 w-8 rounded-full"
                                                src="https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80"
                                                alt="" />
                                        </button>
                                    </div>
                                    <div x-show="open" x-transition:enter="transition ease-out duration-100"
                                        x-transition:enter-start="transform opacity-0 scale-95"
                                        x-transition:enter-end="transform opacity-100 scale-100"
                                        x-transition:leave="transition ease-in duration-75"
                                        x-transition:leave-start="transform opacity-100 scale-100"
                                        x-transition:leave-end="transform opacity-0 scale-95"
                                        class="origin-top-right absolute right-0 mt-2 w-48 rounded-md shadow-lg">
                                        <div class="py-1 rounded-md bg-white shadow-xs">
                                            <a href="#"
                                                class="block px-4 py-2 text-sm leading-5 text-gray-700 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 transition duration-150 ease-in-out">Your
                                                Profile</a>
                                            <a href="#"
                                                class="block px-4 py-2 text-sm leading-5 text-gray-700 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 transition duration-150 ease-in-out">Settings</a>
                                            <a href="#"
                                                class="block px-4 py-2 text-sm leading-5 text-gray-700 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 transition duration-150 ease-in-out">Sign
                                                out</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!--  -->

                <div :class="{'block': open, 'hidden': !open}" class="hidden lg:hidden">
                    <div class="px-2 pt-2 pb-3">
                        <a href="#"
                            class="block px-3 py-2 rounded-md text-base font-medium text-white bg-gray-900 focus:outline-none focus:text-white focus:bg-gray-700 transition duration-150 ease-in-out">Dashboard</a>
                        <a href="#"
                            class="mt-1 block px-3 py-2 rounded-md text-base font-medium text-gray-300 hover:text-white hover:bg-gray-700 focus:outline-none focus:text-white focus:bg-gray-700 transition duration-150 ease-in-out">Team</a>
                        <a href="#"
                            class="mt-1 block px-3 py-2 rounded-md text-base font-medium text-gray-300 hover:text-white hover:bg-gray-700 focus:outline-none focus:text-white focus:bg-gray-700 transition duration-150 ease-in-out">Projects</a>
                        <a href="#"
                            class="mt-1 block px-3 py-2 rounded-md text-base font-medium text-gray-300 hover:text-white hover:bg-gray-700 focus:outline-none focus:text-white focus:bg-gray-700 transition duration-150 ease-in-out">Calendar</a>
                    </div>
                    <div class="pt-4 pb-3 border-t border-gray-700">
                        <div class="flex items-center px-5">
                            <div class="flex-shrink-0">
                                <img class="h-10 w-10 rounded-full"
                                    src="https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80"
                                    alt="" />
                            </div>
                            <div class="ml-3">
                                <div class="text-base font-medium leading-6 text-white">Tom Cook</div>
                                <div class="text-sm font-medium leading-5 text-gray-400">tom@example.com</div>
                            </div>
                        </div>
                        <div class="mt-3 px-2">
                            <a href="#"
                                class="block px-3 py-2 rounded-md text-base font-medium text-gray-400 hover:text-white hover:bg-gray-700 focus:outline-none focus:text-white focus:bg-gray-700 transition duration-150 ease-in-out">Your
                                Profile</a>
                            <a href="#"
                                class="mt-1 block px-3 py-2 rounded-md text-base font-medium text-gray-400 hover:text-white hover:bg-gray-700 focus:outline-none focus:text-white focus:bg-gray-700 transition duration-150 ease-in-out">Settings</a>
                            <a href="#"
                                class="mt-1 block px-3 py-2 rounded-md text-base font-medium text-gray-400 hover:text-white hover:bg-gray-700 focus:outline-none focus:text-white focus:bg-gray-700 transition duration-150 ease-in-out">Sign
                                out</a>
                        </div>
                    </div>
                </div>
            </nav>

            <!-- CTW -->
            <svg height="512" viewBox="0 0 880 512" width="880" xmlns="http://www.w3.org/2000/svg">
                <g fill="none" fill-rule="evenodd">
                    <path d="m0 0h880v512h-880z" fill="#b2292e" />
                    <g fill="#fff" fill-rule="nonzero">
                        <path
                            d="m0 .53242893h77.5801297v289.30298207h-77.5801297v-17.393955h42.7743441v-254.5035807h-42.7743441z"
                            transform="translate(701.12798 129.522594)" />
                        <path
                            d="m7.66084788 34.7444988h2.35826432c3.6120898 0 4.8722993-1.363631 4.8722993-5.5273018v-17.3007481c0-4.16622446-1.2602095-5.53496262-4.8722993-5.53496262h-2.35826432zm-6.78623441-33.95160104h10.07273813c7.0096758 0 10.7379551 3.83297755 10.7379551 11.93815464v15.6638803c0 8.1077306-3.7282793 11.9407082-10.7379551 11.9407082h-10.07273813z"
                            transform="translate(627.544259 368.029047)" />
                        <path d="m0 39.5414663v-39.5414663h6.79006484v33.6272918h10.67666836v5.9141745z"
                            transform="translate(604.043331 368.823222)" />
                        <path
                            d="m7.66084788 18.9286783h2.40805982c3.6733766 0 5.0421147-1.370015 5.0421147-6.0801596 0-4.70631421-1.3687381-6.07505237-5.0421147-6.07505237h-2.40805982zm0 21.7976658h-6.78751122v-39.54146629h9.52881794c7.6084988 0 11.4976559 3.23543142 11.4976559 11.66364089 0 6.3572269-2.4565786 8.929995-4.761217 9.9680399l5.7494664 17.9097855h-6.9037008l-4.8148429-16.3750623c-.8784439.1110823-2.30336159.165985-3.50866832.165985z"
                            transform="translate(573.378234 367.637067)" />
                        <path
                            d="m7.66084788 31.5397107c0 2.9596409.87333666 4.3781746 3.61208982 4.3781746 2.7387531 0 3.6159202-1.4185337 3.6159202-4.3781746v-20.0471621c0-2.95581045-.8771671-4.3730673-3.6159202-4.3730673-2.73875316 0-3.61208982 1.41725685-3.61208982 4.3730673zm-6.79772568-20.2080399c0-5.58858851 3.29033416-10.13402491 10.4098155-10.13402491 7.1194813 0 10.4047082 4.5454364 10.4047082 10.13402491v20.374025c0 5.5834813-3.2852269 10.1276409-10.4047082 10.1276409-7.11948134 0-10.4098155-4.5441596-10.4098155-10.1276409z"
                            transform="translate(543.258334 367.077825)" />
                        <path
                            d="m15.3216958.03958105h5.5885885l4.6003391 25.18631425h.1110823l3.776798-25.18631425h6.3508429l-6.9509426 39.54146635h-5.6945636l-4.9323092-26.1222145h-.1110823l-4.6003392 26.1222145h-5.69328676l-7.50635411-39.54146635h6.35084289l4.16494768 25.18631425h.1110822z"
                            transform="translate(501.307531 368.782364)" />
                        <path
                            d="m0 39.5414663v-39.5414663h18.1842993v5.91417456h-11.39295765v10.18254364h8.75890275v5.9218354h-8.75890275v11.6087382h12.15648875v5.9141745z"
                            transform="translate(462.904978 368.823222)" />
                        <path
                            d="m0 39.5414663v-39.5414663h6.78751122v16.0967182h7.22673318v-16.0967182h6.7977257v39.5414663h-6.7977257v-17.5229127h-7.22673318v17.5229127z"
                            transform="translate(432.783801 368.823222)" />
                        <path
                            d="m7.66084788 6.76069825h-6.57173067v-5.91417456h19.93735659v5.91417456h-6.5717307v33.62729175h-6.79389522z"
                            transform="translate(405.019611 367.976698)" />
                        <path
                            d="m0 39.5414663v-39.5414663h18.1855761v5.91417456h-11.39423445v10.18254364h8.76528675v5.9218354h-8.76528675v11.6087382h12.16287285v5.9141745z"
                            transform="translate(366.788149 368.823222)" />
                        <path
                            d="m10.2144638 21.1541546h11.1235512v20.0471621h-3.2928878l-1.2576559-2.9545337c-2.0275711 2.4144439-3.6644389 3.5010075-6.84369075 3.5010075-5.36897756 0-9.09214963-3.8329775-9.09214963-10.1276409v-20.3727481c0-5.58986534 3.28778055-10.13530175 9.97059348-10.13530175 6.7862345 0 10.1838205 4.92592519 10.1838205 10.84137655v2.5242494h-6.4657556c0-5.91545139-1.1989227-7.44379054-3.8840499-7.44379054-1.64452868 0-3.00943641.98314215-3.00943641 4.32327184v20.3178454c0 2.5178653.81715711 4.1585636 3.17542141 4.1585636 2.7387532 0 3.7180649-1.529616 3.7180649-5.472399v-3.8329776h-4.3258255z"
                            transform="translate(335.812788 367.162095)" />
                        <path
                            d="m0 39.5414663v-39.5414663h6.30232419l8.26605491 22.6199302h.1110822v-22.6199302h6.1363392v39.5414663h-5.9141746l-8.65548126-24.6972967h-.1110823v24.6972967z"
                            transform="translate(306.540688 368.823222)" />
                        <path
                            d="m8.93765586 25.5170075h5.47367584l-2.6851272-16.98282296h-.1059751zm-2.19100249 14.6730773h-6.57300748l7.29057356-39.54146635h8.42565585l7.2905736 39.54146635h-6.5717307l-1.210414-8.7589028h-7.44379048z"
                            transform="translate(276.68381 368.173327)" />
                        <path
                            d="m0 39.5414663v-39.5414663h6.79389526v16.0967182h7.22800994v-16.0967182h6.7938953v39.5414663h-6.7938953v-17.5229127h-7.22800994v17.5229127z"
                            transform="translate(249.36395 368.823222)" />
                        <path
                            d="m14.0448878 14.9590823v-3.072c0-3.34140649-1.536-4.75866335-3.2865038-4.75866335-2.73875308 0-3.61208974 1.41725686-3.61208974 4.37306735v20.0471621c0 2.9596409.87333666 4.3794514 3.61208974 4.3794514 2.4642394 0 3.2865038-1.4198105 3.2865038-3.9938554v-4.7714314h6.7938952v4.5518204c0 5.5834813-3.2865037 10.1276409-10.080399 10.1276409-7.11820445 0-10.40470819-4.5441596-10.40470819-10.1276409v-20.3740249c0-5.58858855 3.28650374-10.13402496 10.40470819-10.13402496 6.7938953 0 10.080399 4.92592519 10.080399 10.84009976v2.912399z"
                            transform="translate(218.889097 367.067611)" />
                        <path
                            d="m84.2693267.62946633h29.9551923l21.65594 120.90605467h.718843l22.013446-121.26866813h38.977117l-44.749566 194.17057313h-32.479441l-22.0198306-122.7038001h-.7252269l-26.3367182 122.7038001h-32.4845486l-37.53432422-194.17057313h38.97711722l17.6876209 121.26866813h.7150125z"
                            transform="translate(480.616858 148.201017)" />
                        <path
                            d="m0 85.6789227v-33.2110524h22.3824439v-52.32997504h40.421187v52.32997504h27.0670524v33.2110524h-27.0670524v111.8854063c0 10.095721 4.3296559 15.870723 13.7090873 15.870723h13.3579651v34.651292c-5.412389 1.437686-10.1097656 2.162913-20.2131471 2.162913-30.3178055 0-47.2750923-14.076808-47.2750923-43.669387v-120.9009473z"
                            transform="translate(364.938055 96)" />
                        <path
                            d="m85.5461347 70.1631521v-5.0612668c0-22.3696758-7.9417457-31.7542145-22.3747831-31.7542145-14.435591 0-22.3786134 9.3845387-22.3786134 31.7542145v71.4629427c0 22.37606 7.9430224 31.761875 22.3786134 31.761875 14.4330374 0 22.3747831-9.385815 22.3747831-31.761875v-12.266294h40.4211873v5.048498c0 42.5841-16.602334 72.183063-62.7959704 72.183063-46.2012967 0-62.80235409-29.598963-62.80235409-72.183063v-57.022244c0-42.589207 16.60105739-72.1805087 62.80235409-72.1805087 45.4684094 0 62.0707434 28.5098454 62.7959704 70.0188728z"
                            transform="translate(200 144.719162)" />
                        <path
                            d="m77.8852868 17.46801h-42.7832818v254.503581h42.7832818v17.393955h-77.58651373v-289.30298241h77.58651373z"
                            transform="translate(96.975641 129.992459)" />
                    </g>
                </g>
            </svg>

            <!-- Background -->
            <svg width="100%" height="100%">
                <defs>
                    <pattern id="pattern" width="50" height="50" viewBox="0 0 40 40" patternUnits="userSpaceOnUse"
                        patternTransform="rotate(45)">
                        <rect id="pattern-background" x="0" y="0" width="400%" height="400%" fill="#2d3748"></rect>
                        <circle cx="34" cy="20" r="4" fill="#4a5568" stroke="#4a5568" stroke-width="0"></circle>
                        <circle cx="6" cy="20" r="4" fill="#4a5568" stroke="#4a5568" stroke-width="0"></circle>
                        <circle cx="20" cy="34" r="4" fill="#4a5568" stroke="#4a5568" stroke-width="0"></circle>
                        <circle cx="20" cy="6" r="4" fill="#4a5568" stroke="#4a5568" stroke-width="0"></circle>
                        <circle cx="34" cy="6" r="4" fill="#1a202c" stroke="#1a202c" stroke-width="0"></circle>
                        <circle cx="6" cy="34" r="4" fill="#1a202c" stroke="#1a202c" stroke-width="0"></circle>
                        <circle cx="34" cy="34" r="4" fill="#1a202c" stroke="#1a202c" stroke-width="0"></circle>
                        <circle cx="6" cy="6" r="4" fill="#1a202c" stroke="#1a202c" stroke-width="0"></circle>
                    </pattern>
                </defs>
                <rect fill="url(#pattern)" height="100%" width="100%" y="0" x="0"></rect>
            </svg>


            <!--  -->

            <div class="bg-gray-50 overflow-hidden rounded-lg">
                <div class="px-4 py-5 sm:p-6">
                    <!-- Content goes here -->
                    <!-- Jamstack SVG Logo -->
                    <svg class="h-6" width="204" height="34" viewBox="0 0 204 34">
                        <title>jamstack-logo</title>
                        <defs>
                            <linearGradient x1=".758%" y1="0%" x2="100%" y2="100%" id="linearGradient-1">
                                <stop stop-color="#20C6B7" offset="0%" />
                                <stop stop-color="#4D9ABF" offset="100%" />
                            </linearGradient>
                        </defs>
                        <g class="jamestack-frame" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                            <g class="jamstack-landing" transform="translate(-250.000000, -40.000000)">
                                <g class="jamstack-header" transform="translate(250.000000, 40.000000)">
                                    <g class="jamstack-logo">
                                        <path
                                            d="M13.0721615,0.773137905 L19.5562143,0.773137905 L19.5562143,23.364827 C19.5562143,26.5497056 18.635931,29.0759907 16.7953367,30.9437583 C14.9547424,32.8115258 12.6368504,33.7453956 9.84159106,33.7453956 C6.8172121,33.7453956 4.42294801,32.911982 2.65872695,31.2451296 C0.894505891,29.5782773 0.0429574176,27.1226835 0.104055982,23.8782745 L0.172791524,23.7443317 L6.51937321,23.7443317 C6.51937321,25.4558318 6.82868006,26.7059523 7.44730302,27.4947306 C8.06592599,28.283509 8.86401402,28.6778922 9.84159106,28.6778922 C10.7275203,28.6778922 11.4874223,28.209097 12.1213199,27.2714926 C12.7552175,26.3338882 13.0721615,25.0316793 13.0721615,23.364827 L13.0721615,0.773137905 Z M37.5921884,26.3785405 L28.7940391,26.3785405 L27.006915,33.2765957 L20.4312149,33.2765957 L29.8250722,0.773137905 L36.606979,0.773137905 L45.9779245,33.2765957 L39.4022244,33.2765957 L37.5921884,26.3785405 Z M30.1229262,21.2663895 L36.2633013,21.2663895 L33.2618493,9.7696307 L33.1243782,9.7696307 L30.1229262,21.2663895 Z M55.421956,0.773137905 L61.4019481,24.6372838 L61.5394192,24.6372838 L67.5881469,0.773137905 L76.0884422,0.773137905 L76.0884422,33.2765957 L69.6043894,33.2765957 L69.6043894,23.8336269 L70.1542738,11.1983541 L70.0168027,11.1760303 L63.6473091,33.2765957 L59.31697,33.2765957 L53.016212,11.3546207 L52.8787409,11.3769445 L53.4515371,23.8336269 L53.4515371,33.2765957 L46.9674843,33.2765957 L46.9674843,0.773137905 L55.421956,0.773137905 Z M101.61659,25.4855883 C101.61659,23.4466708 100.849051,21.8170494 99.3139497,20.5966754 C97.7788483,19.3763014 95.117282,18.2601223 91.329171,17.2481049 C87.5257853,16.25097 84.7420237,15.116188 82.9778027,13.8437248 C81.2135816,12.5712617 80.3314843,10.7146839 80.3314843,8.27393587 C80.3314843,5.84807043 81.3701443,3.91336014 83.4474955,2.46974697 C85.5248467,1.02613379 88.1749572,0.304338033 91.3979065,0.304338033 C94.6514051,0.304338033 97.3091528,1.18984005 99.3712294,2.96087064 C101.433306,4.73190124 102.43378,7.00890642 102.372681,9.7919545 L102.326858,9.92589732 L101.272913,9.92589732 C101.272913,7.50003189 100.356448,5.49090967 98.523491,3.89847039 C96.6905341,2.30603111 94.315363,1.50982342 91.3979065,1.50982342 C88.3735276,1.50982342 85.9792635,2.16836904 84.2150424,3.48548003 C82.4508213,4.80259102 81.568724,6.38384461 81.568724,8.22928826 C81.568724,10.0747319 82.2980772,11.6076178 83.7568055,12.8279918 C85.2155337,14.0483658 87.8541884,15.13478 91.6728487,16.0872671 C95.3693119,17.0397541 98.1607107,18.2043009 100.047129,19.5809423 C101.933547,20.9575838 102.876742,22.910897 102.876742,25.4409407 C102.876742,28.0156323 101.799896,30.0433575 99.6461715,31.5241772 C97.4924471,33.0049969 94.7965134,33.7453956 91.5582894,33.7453956 C88.213143,33.7453956 85.3339163,32.9826733 82.920523,31.4572058 C80.5071297,29.9317382 79.3386372,27.5319534 79.4150104,24.2577791 L79.4608341,24.1238363 L80.4918672,24.1238363 C80.4918672,27.0705931 81.6068993,29.2099362 83.8369969,30.5419298 C86.0670945,31.8739234 88.640833,32.5399102 91.5582894,32.5399102 C94.4910206,32.5399102 96.9005591,31.8850852 98.7869773,30.5754155 C100.673395,29.2657458 101.61659,27.5691537 101.61659,25.4855883 L101.61659,25.4855883 Z M126.804279,5.30573579 C126.804279,5.46835788 126.74169,5.6174259 126.616511,5.75294431 C126.491332,5.88846272 126.345291,5.95622091 126.178385,5.95622091 L116.497897,5.95622091 L116.497897,32.6667659 C116.497897,32.829388 116.428354,32.9716802 116.289265,33.0936468 C116.150177,33.2156134 115.997183,33.2765957 115.830277,33.2765957 C115.663371,33.2765957 115.510376,33.2223892 115.371288,33.1139745 C115.2322,33.0055597 115.162657,32.8564917 115.162657,32.6667659 L115.162657,5.95622091 L105.440442,5.95622091 C105.273536,5.95622091 105.127496,5.88846272 105.002316,5.75294431 C104.877137,5.6174259 104.814548,5.46835788 104.814548,5.30573579 C104.814548,5.1431137 104.870183,4.98726986 104.981453,4.83819961 C105.092724,4.68912936 105.245719,4.61459536 105.440442,4.61459536 L126.178385,4.61459536 C126.373109,4.61459536 126.526104,4.68912936 126.637374,4.83819961 C126.748645,4.98726986 126.804279,5.1431137 126.804279,5.30573579 L126.804279,5.30573579 Z M145.741175,23.5657412 L129.42794,23.5657412 L125.71622,33.2765957 L124.364421,33.2765957 L136.828466,0.773137905 L138.340648,0.773137905 L150.827605,33.2765957 L149.475806,33.2765957 L145.741175,23.5657412 Z M129.886177,22.3602559 L145.282938,22.3602559 L138.294825,4.05473701 L137.653293,2.22418513 L137.515822,2.22418513 L136.897202,4.05473701 L129.886177,22.3602559 Z M175.237423,23.3201794 L175.283247,23.4541222 C175.344345,26.7878269 174.309504,29.3364356 172.178691,31.1000249 C170.047879,32.8636142 167.241206,33.7453956 163.758588,33.7453956 C160.107948,33.7453956 157.182898,32.432025 154.98335,29.8052443 C152.783802,27.1784636 151.684044,23.7294705 151.684044,19.4581614 L151.684044,14.5915722 C151.684044,10.3351458 152.783802,6.88987322 154.98335,4.25565125 C157.182898,1.62142927 160.107948,0.304338033 163.758588,0.304338033 C167.241206,0.304338033 170.047879,1.18984005 172.178691,2.96087064 C174.309504,4.73190124 175.344345,7.261907 175.283247,10.5509638 L175.237423,10.6849066 L174.183478,10.6849066 C174.183478,7.75303246 173.24792,5.49090967 171.376777,3.89847039 C169.505633,2.30603111 166.966262,1.50982342 163.758588,1.50982342 C160.505089,1.50982342 157.885527,2.70785556 155.899824,5.10395578 C153.914121,7.500056 152.921284,10.6476808 152.921284,14.5469246 L152.921284,19.4581614 C152.921284,23.4020531 153.914121,26.5682809 155.899824,28.9569398 C157.885527,31.3455987 160.505089,32.5399102 163.758588,32.5399102 C166.966262,32.5399102 169.505633,31.7734673 171.376777,30.2405585 C173.24792,28.7076496 174.183478,26.4008797 174.183478,23.3201794 L175.237423,23.3201794 Z M186.747871,17.4043715 L181.638529,17.4043715 L181.638529,33.2765957 L180.401289,33.2765957 L180.401289,0.773137905 L181.638529,0.773137905 L181.638529,16.2212099 L187.091549,16.2212099 L201.25107,0.773137905 L202.717429,0.773137905 L202.763252,0.884756923 L188.122582,16.9802192 L203.817197,33.1426529 L203.748462,33.2765957 L202.305015,33.2765957 L186.747871,17.4043715 Z"
                                            id="JAMSTACK" fill="#4A4A4A" />
                                        <path
                                            d="M126.595648,1.36216978 C126.595648,1.52479187 126.533059,1.66708407 126.40788,1.78905064 C126.2827,1.91101721 126.13666,1.97199958 125.969754,1.97199958 L105.440442,1.97199958 C105.273536,1.97199958 105.127496,1.91101721 105.002316,1.78905064 C104.877137,1.66708407 104.814548,1.52479187 104.814548,1.36216978 C104.814548,1.19954769 104.877137,1.05725549 105.002316,0.935288923 C105.127496,0.813322354 105.273536,0.752339984 105.440442,0.752339984 L125.969754,0.752339984 C126.13666,0.752339984 126.2827,0.813322354 126.40788,0.935288923 C126.533059,1.05725549 126.595648,1.19954769 126.595648,1.36216978 L126.595648,1.36216978 Z"
                                            id="Path" fill="url(#linearGradient-1)" />
                                    </g>
                                </g>
                            </g>
                        </g>
                    </svg>
                </div>
            </div>

            <!-- -->

            <section class="flex items-center justify-center">
                <div class="demo demo1 t-5">
                    <h2>Animation 1</h2>
                    <p>Timing 5, Pop, and Entrance/Exit</p>
                </div>
                <div class="demo demo2 t-5">
                    <h2>Animation 2</h2>
                    <p>Timing 5, Pop, and Entrance Emphasis/Exit Emphasis</p>
                </div>
                <div class="demo demo3 t-1">
                    <h2>Animation 3</h2>
                    <p>Timing 1, Pop, and Entrance Emphasis/Exit Emphasis</p>
                </div>
            </section>

            <!--  -->

            <div class="mt-5 max-w-md mx-auto sm:flex sm:justify-center md:mt-8">
                <div class="rounded-full shadow">
                    <a href="#"
                        class="w-full flex items-center justify-center px-8 py-2 border border-transparent text-base leading-6 font-medium rounded-full text-white bg-primary-600 hover:bg-primary-500 focus:outline-none focus:shadow-outline transition duration-150 ease-in-out md:py-3 md:text-lg md:px-10">
                        Pledge Now
                    </a>
                </div>
                <div class="mt-3 sm:mt-0 sm:ml-3">
                    <a href="#"
                        class="w-full flex items-center justify-center px-8 py-2 border border-transparent text-base leading-6 font-medium rounded-full text-primary-700 bg-primary-100 hover:text-primary-600 hover:bg-primary-50 focus:outline-none focus:shadow-outline focus:border-primary-300 transition duration-150 ease-in-out md:py-3 md:text-lg md:px-10">
                        Pledge Now
                    </a>
                </div>
            </div>

            <!--  -->

            <div class="flex">
                <svg ref="icon-arrow-circle-right" class="h-6 w-6 fill-current text-gray-500" viewBox="0 0 512 512">
                    <path
                        d="M256 8C119 8 8 119 8 256s111 248 248 248 248-111 248-248S393 8 256 8zm148.3 265L271.6 405.6a23.9 23.9 0 0 1-33.9 0l-11-10.9a24 24 0 0 1 .4-34.3l75.5-72.4H120a23.94 23.94 0 0 1-24-24v-16a23.94 23.94 0 0 1 24-24h182.6l-75.5-72.4a24.15 24.15 0 0 1-.4-34.4l11-10.9a23.9 23.9 0 0 1 33.9 0l132.7 132.8a23.9 23.9 0 0 1 0 33.9z"
                        class="currentColor" />
                    <path
                        d="M226.7 117.2l11-10.9a23.9 23.9 0 0 1 33.9 0l132.7 132.8a23.9 23.9 0 0 1 0 33.9L271.6 405.6a23.9 23.9 0 0 1-33.9 0l-11-10.9a24 24 0 0 1 .4-34.3l75.5-72.4H120a23.94 23.94 0 0 1-24-24v-16a23.94 23.94 0 0 1 24-24h182.6l-75.5-72.4a24.15 24.15 0 0 1-.4-34.4z"
                        class="opacity-50" /></svg>
                <svg ref="icon-bars" class="h-6 w-6 fill-current text-gray-500" viewBox="0 0 448 512">
                    <path
                        d="M16 288h416a16 16 0 0 0 16-16v-32a16 16 0 0 0-16-16H16a16 16 0 0 0-16 16v32a16 16 0 0 0 16 16z"
                        class="currentColor" />
                    <path
                        d="M432 384H16a16 16 0 0 0-16 16v32a16 16 0 0 0 16 16h416a16 16 0 0 0 16-16v-32a16 16 0 0 0-16-16zm0-320H16A16 16 0 0 0 0 80v32a16 16 0 0 0 16 16h416a16 16 0 0 0 16-16V80a16 16 0 0 0-16-16z"
                        class="opacity-50" /></svg>
                <svg ref="icon-bold" class="h-6 w-6 fill-current text-gray-500" viewBox="0 0 384 512">
                    <path
                        d="M32 32h32v80H32a16 16 0 0 1-16-16V48a16 16 0 0 1 16-16zm32 368v80H32a16 16 0 0 1-16-16v-48a16 16 0 0 1 16-16z"
                        class="currentColor" />
                    <path
                        d="M332.53 237.78c12.86-15.8 24.9-44.81 26.93-65C366.85 96.48 306.81 32 232 32H64v448h183.62C322.94 480 384 419.11 384 344a135.36 135.36 0 0 0-51.47-106.22zM144 112h88a48 48 0 1 1 0 96h-88zm88 288h-88V288h88a56 56 0 1 1 0 112z"
                        class="opacity-50" /></svg>
                <svg ref="icon-books" class="h-6 w-6 fill-current text-gray-500" viewBox="0 0 576 512">
                    <path
                        d="M96 0H32A32 32 0 0 0 0 32v64h128V32A32 32 0 0 0 96 0zM0 384h128V128H0zm0 96a32 32 0 0 0 32 32h64a32 32 0 0 0 32-32v-64H0zm513.62-17.78L401.08 42.71l-60.26 16.14 112.35 418.8c.11.39.2.79.29 1.18l60.29-16.15c-.04-.15-.09-.3-.13-.46zM160 480a32 32 0 0 0 32 32h64a32 32 0 0 0 32-32v-64H160zM256 0h-64a32 32 0 0 0-32 32v64h124.79l-8-29.65a23.94 23.94 0 0 1 11.17-27V32A32 32 0 0 0 256 0zm-96 384h128V128H160z"
                        class="currentColor" />
                    <path
                        d="M0 416h128v-32H0zm0-288h128V96H0zm575.17 317.65L460.39 17.78a23.89 23.89 0 0 0-29.18-17h-.09L415.73 5a24 24 0 0 0-16.9 29.36l114.79 427.86a23.89 23.89 0 0 0 29.18 17h.09l15.38-4.22a24 24 0 0 0 16.9-29.35zM160 416h128v-32H160zM338.39 49.78a23.89 23.89 0 0 0-29.18-17h-.09L293.73 37a24 24 0 0 0-16.9 29.36l8 29.65H160v32h128V108l103.62 386.22a23.89 23.89 0 0 0 29.18 17h.09l15.38-4.22a24 24 0 0 0 16.9-29.33z"
                        class="opacity-50" /></svg>
                <svg ref="icon-cloud" class="h-6 w-6 fill-current text-gray-500" viewBox="0 0 640 512">
                    <path
                        d="M640 352a128 128 0 0 1-128 128H144a144 144 0 0 1-47.8-279.9c-.1-2.7-.2-5.4-.2-8.1a160 160 0 0 1 298.7-79.8A95.95 95.95 0 0 1 544 192a96.66 96.66 0 0 1-6.4 34.6A128 128 0 0 1 640 352z"
                        class="opacity-50" /></svg>
                <svg ref="icon-code-branch" class="h-6 w-6 fill-current text-gray-500" viewBox="0 0 384 512">
                    <path
                        d="M328 220.33V224c0 32-6.69 47.26-20 63.8-28.2 35-76 39.5-118.2 43.4-25.7 2.4-49.9 4.6-66.1 12.8-3.82 1.94-9.25 6.44-13.44 13.94A80.16 80.16 0 0 0 56 355.67V156.33a80.31 80.31 0 0 0 48 0v144c23.9-11.5 53.1-14.3 81.3-16.9 35.9-3.3 69.8-6.5 85.2-25.7 6.34-7.83 9.5-17.7 9.5-33.7v-3.67a80.31 80.31 0 0 0 48 0z"
                        class="currentColor" />
                    <path
                        d="M80 0a80 80 0 1 0 80 80A80 80 0 0 0 80 0zm0 96a16 16 0 1 1 16-16 16 16 0 0 1-16 16zm0 256a80 80 0 1 0 80 80 80 80 0 0 0-80-80zm0 96a16 16 0 1 1 16-16 16 16 0 0 1-16 16zM304 64a80 80 0 1 0 80 80 80 80 0 0 0-80-80zm0 96a16 16 0 1 1 16-16 16 16 0 0 1-16 16z"
                        class="opacity-50" /></svg>
                <svg ref="icon-code-commit" class="h-6 w-6 fill-current text-gray-500" viewBox="0 0 640 512">
                    <path
                        d="M628 224H509.4a189.29 189.29 0 0 1 2.6 32 200.23 200.23 0 0 1-2.6 32H628a12 12 0 0 0 12-12v-40a12 12 0 0 0-12-12zm-616 0a12 12 0 0 0-12 12v40a12 12 0 0 0 12 12h118.6a198.22 198.22 0 0 1 0-64z"
                        class="currentColor" />
                    <path
                        d="M320 96a160 160 0 1 0 160 160A160 160 0 0 0 320 96zm0 202a42 42 0 1 1 42-42 42 42 0 0 1-42 42z"
                        class="opacity-50" /></svg>
                <svg ref="icon-code-merge" class="h-6 w-6 fill-current text-gray-500" viewBox="0 0 640 512">
                    <path
                        d="M628 224H509.4a189.29 189.29 0 0 1 2.6 32 200.23 200.23 0 0 1-2.6 32H628a12 12 0 0 0 12-12v-40a12 12 0 0 0-12-12zm-616 0a12 12 0 0 0-12 12v40a12 12 0 0 0 12 12h118.6a198.22 198.22 0 0 1 0-64z"
                        class="currentColor" />
                    <path
                        d="M320 96a160 160 0 1 0 160 160A160 160 0 0 0 320 96zm0 202a42 42 0 1 1 42-42 42 42 0 0 1-42 42z"
                        class="opacity-50" /></svg>
                <svg ref="icon-code" class="h-6 w-6 fill-current text-gray-500" viewBox="0 0 640 512">
                    <path
                        d="M422.12 18.16a12 12 0 0 1 8.2 14.9l-136.5 470.2a12 12 0 0 1-14.89 8.2l-61-17.7a12 12 0 0 1-8.2-14.9l136.5-470.2a12 12 0 0 1 14.89-8.2z"
                        class="currentColor" />
                    <path
                        d="M636.23 247.26l-144.11-135.2a12.11 12.11 0 0 0-17 .5L431.62 159a12 12 0 0 0 .81 17.2L523 256l-90.59 79.7a11.92 11.92 0 0 0-.81 17.2l43.5 46.4a12 12 0 0 0 17 .6l144.11-135.1a11.94 11.94 0 0 0 .02-17.54zm-427.8-88.2l-43.5-46.4a12 12 0 0 0-17-.5l-144.11 135a11.94 11.94 0 0 0 0 17.5l144.11 135.1a11.92 11.92 0 0 0 17-.5l43.5-46.4a12 12 0 0 0-.81-17.2L117 256l90.6-79.7a11.92 11.92 0 0 0 .83-17.24z"
                        class="opacity-50" /></svg>
                <svg ref="icon-cog" class="h-6 w-6 fill-current text-gray-500" viewBox="0 0 512 512">
                    <path
                        d="M487.75 315.6l-42.6-24.6a192.62 192.62 0 0 0 0-70.2l42.6-24.6a12.11 12.11 0 0 0 5.5-14 249.2 249.2 0 0 0-54.7-94.6 12 12 0 0 0-14.8-2.3l-42.6 24.6a188.83 188.83 0 0 0-60.8-35.1V25.7A12 12 0 0 0 311 14a251.43 251.43 0 0 0-109.2 0 12 12 0 0 0-9.4 11.7v49.2a194.59 194.59 0 0 0-60.8 35.1L89.05 85.4a11.88 11.88 0 0 0-14.8 2.3 247.66 247.66 0 0 0-54.7 94.6 12 12 0 0 0 5.5 14l42.6 24.6a192.62 192.62 0 0 0 0 70.2l-42.6 24.6a12.08 12.08 0 0 0-5.5 14 249 249 0 0 0 54.7 94.6 12 12 0 0 0 14.8 2.3l42.6-24.6a188.54 188.54 0 0 0 60.8 35.1v49.2a12 12 0 0 0 9.4 11.7 251.43 251.43 0 0 0 109.2 0 12 12 0 0 0 9.4-11.7v-49.2a194.7 194.7 0 0 0 60.8-35.1l42.6 24.6a11.89 11.89 0 0 0 14.8-2.3 247.52 247.52 0 0 0 54.7-94.6 12.36 12.36 0 0 0-5.6-14.1zm-231.4 36.2a95.9 95.9 0 1 1 95.9-95.9 95.89 95.89 0 0 1-95.9 95.9z"
                        class="currentColor" />
                    <path d="M256.35 319.8a63.9 63.9 0 1 1 63.9-63.9 63.9 63.9 0 0 1-63.9 63.9z" class="opacity-50" />
                    </svg>
                <svg ref="icon-cog" class="h-6 w-6 fill-current text-gray-500" viewBox="0 0 512 512">
                    <path
                        d="M487.75 315.6l-42.6-24.6a192.62 192.62 0 0 0 0-70.2l42.6-24.6a12.11 12.11 0 0 0 5.5-14 249.2 249.2 0 0 0-54.7-94.6 12 12 0 0 0-14.8-2.3l-42.6 24.6a188.83 188.83 0 0 0-60.8-35.1V25.7A12 12 0 0 0 311 14a251.43 251.43 0 0 0-109.2 0 12 12 0 0 0-9.4 11.7v49.2a194.59 194.59 0 0 0-60.8 35.1L89.05 85.4a11.88 11.88 0 0 0-14.8 2.3 247.66 247.66 0 0 0-54.7 94.6 12 12 0 0 0 5.5 14l42.6 24.6a192.62 192.62 0 0 0 0 70.2l-42.6 24.6a12.08 12.08 0 0 0-5.5 14 249 249 0 0 0 54.7 94.6 12 12 0 0 0 14.8 2.3l42.6-24.6a188.54 188.54 0 0 0 60.8 35.1v49.2a12 12 0 0 0 9.4 11.7 251.43 251.43 0 0 0 109.2 0 12 12 0 0 0 9.4-11.7v-49.2a194.7 194.7 0 0 0 60.8-35.1l42.6 24.6a11.89 11.89 0 0 0 14.8-2.3 247.52 247.52 0 0 0 54.7-94.6 12.36 12.36 0 0 0-5.6-14.1zm-231.4 36.2a95.9 95.9 0 1 1 95.9-95.9 95.89 95.89 0 0 1-95.9 95.9z"
                        class="currentColor" />
                    <path d="M256.35 319.8a63.9 63.9 0 1 1 63.9-63.9 63.9 63.9 0 0 1-63.9 63.9z" class="opacity-50" />
                    </svg>
                <svg ref="icon-cookie-bite" class="h-6 w-6 fill-current text-gray-500" viewBox="0 0 512 512">
                    <path
                        d="M510.52 255.81A127.93 127.93 0 0 1 384.05 128 127.92 127.92 0 0 1 256.19 1.51a132 132 0 0 0-79.72 12.81l-69.13 35.22a132.32 132.32 0 0 0-57.79 57.81l-35.1 68.88a132.64 132.64 0 0 0-12.82 81l12.08 76.27a132.56 132.56 0 0 0 37.16 73l54.77 54.76a132.1 132.1 0 0 0 72.71 37.06l76.71 12.15a131.92 131.92 0 0 0 80.53-12.76l69.13-35.21a132.32 132.32 0 0 0 57.79-57.81l35.1-68.88a132.59 132.59 0 0 0 12.91-80zM176 368a32 32 0 1 1 32-32 32 32 0 0 1-32 32zm32-160a32 32 0 1 1 32-32 32 32 0 0 1-32 32zm160 128a32 32 0 1 1 32-32 32 32 0 0 1-32 32z"
                        class="currentColor" />
                    <path
                        d="M368 272a32 32 0 1 0 32 32 32 32 0 0 0-32-32zM208 144a32 32 0 1 0 32 32 32 32 0 0 0-32-32zm-32 160a32 32 0 1 0 32 32 32 32 0 0 0-32-32z"
                        class="opacity-50" /></svg>
                <svg ref="icon-copy" class="h-6 w-6 fill-current text-blue-500" viewBox="0 0 448 512">
                    <path d="M352 96V0H152a24 24 0 0 0-24 24v368a24 24 0 0 0 24 24h272a24 24 0 0 0 24-24V96z"
                        class="currentColor" />
                    <path
                        d="M96 392V96H24a24 24 0 0 0-24 24v368a24 24 0 0 0 24 24h272a24 24 0 0 0 24-24v-40H152a56.06 56.06 0 0 1-56-56zM441 73L375 7a24 24 0 0 0-17-7h-6v96h96v-6.06A24 24 0 0 0 441 73z"
                        class="opacity-50" /></svg>
                <svg ref="icon-copy" class="h-6 w-6 fill-current text-gray-500" viewBox="0 0 448 512">
                    <path d="M352 96V0H152a24 24 0 0 0-24 24v368a24 24 0 0 0 24 24h272a24 24 0 0 0 24-24V96z"
                        class="currentColor" />
                    <path
                        d="M96 392V96H24a24 24 0 0 0-24 24v368a24 24 0 0 0 24 24h272a24 24 0 0 0 24-24v-40H152a56.06 56.06 0 0 1-56-56zM441 73L375 7a24 24 0 0 0-17-7h-6v96h96v-6.06A24 24 0 0 0 441 73z"
                        class="opacity-50" /></svg>
                <svg ref="icon-copyright" class="h-6 w-6 fill-current text-gray-500" viewBox="0 0 512 512">
                    <path
                        d="M256 8C119 8 8 119 8 256s111 248 248 248 248-111 248-248S393 8 256 8zm117.13 346.75c-1.59 1.87-39.77 45.73-109.85 45.73-84.69 0-144.48-63.26-144.48-145.56 0-81.31 62-143.4 143.76-143.4 67 0 102 37.31 103.42 38.9a12 12 0 0 1 1.24 14.58l-22.38 34.7a12 12 0 0 1-16.59 3.57 11.79 11.79 0 0 1-1.64-1.27c-.24-.21-26.53-23.88-61.88-23.88-46.12 0-73.92 33.58-73.92 76.08 0 39.61 25.52 79.7 74.28 79.7 38.7 0 65.28-28.34 65.54-28.63a12 12 0 0 1 16.95-.73h.05a12.2 12.2 0 0 1 1.55 1.74l24.55 33.58a12 12 0 0 1-.6 14.85z"
                        class="currentColor" />
                    <path
                        d="M373.13 354.75c-1.59 1.87-39.77 45.73-109.85 45.73-84.69 0-144.48-63.26-144.48-145.56 0-81.31 62-143.4 143.76-143.4 67 0 102 37.31 103.42 38.9a12 12 0 0 1 1.24 14.58l-22.38 34.7a12 12 0 0 1-16.59 3.57 11.79 11.79 0 0 1-1.64-1.27c-.24-.21-26.53-23.88-61.88-23.88-46.12 0-73.92 33.58-73.92 76.08 0 39.61 25.52 79.7 74.28 79.7 38.7 0 65.28-28.34 65.54-28.63a12 12 0 0 1 16.95-.73h.05a12.2 12.2 0 0 1 1.55 1.74l24.55 33.58a12 12 0 0 1-.6 14.85z"
                        class="opacity-50" /></svg>
                <svg ref="icon-database" class="h-6 w-6 fill-current text-gray-500" viewBox="0 0 448 512">
                    <path
                        d="M447 73.14v45.72C447 159.14 346.67 192 223 192S-1 159.14-1 118.86V73.14C-1 32.86 99.33 0 223 0s224 32.86 224 73.14z"
                        class="currentColor" />
                    <path
                        d="M-1 336v102.86C-1 479.14 99.33 512 223 512s224-32.86 224-73.14V336c-48.13 33.14-136.21 48.57-224 48.57S47.12 369.14-1 336zm224-111.43c-87.79 0-175.88-15.43-224-48.57v102.86C-1 319.14 99.33 352 223 352s224-32.86 224-73.14V176c-48.13 33.14-136.21 48.57-224 48.57z"
                        class="opacity-50" /></svg>
                <svg ref="icon-debug" class="h-6 w-6 fill-current text-gray-500" viewBox="0 0 512 512">
                    <path
                        d="M159.12 338.69l24.8-16.54a78.87 78.87 0 0 1-6.77-22.72l-30.88 4.41a16 16 0 0 1-4.54-31.68l34.27-4.9v-.76l98.94 98.95a76.89 76.89 0 0 1-71.68-17.73l-26.39 17.59c-.15.11-.31.21-.47.31a16 16 0 0 1-17.28-26.93zm224.72-48.42a16 16 0 0 0-13.57-18.11l-34.27-4.9V244.9l34.27-4.9a16 16 0 1 0-4.54-31.68l-30.54 4.36a79.31 79.31 0 0 0-6.85-22.85l24.54-16.36a16 16 0 1 0-17.29-26.93l-.46.31-26 17.34a79.9 79.9 0 0 0-102.64-3l139.83 139.88 19.41 2.77a16 16 0 0 0 18.11-13.57z"
                        class="currentColor" />
                    <path
                        d="M256 8C119 8 8 119 8 256s111 248 248 248 248-111 248-248S393 8 256 8zm0 432c-101.46 0-184-82.54-184-184a182.84 182.84 0 0 1 33.38-105.37l256 256A182.86 182.86 0 0 1 256 440zm150.62-78.63l-256-256A182.84 182.84 0 0 1 256 72c101.46 0 184 82.54 184 184a182.84 182.84 0 0 1-33.38 105.37z"
                        class="opacity-50" /></svg>
                <svg ref="icon-debug" class="h-6 w-6 fill-current text-red-500" viewBox="0 0 512 512">
                    <path
                        d="M159.12 338.69l24.8-16.54a78.87 78.87 0 0 1-6.77-22.72l-30.88 4.41a16 16 0 0 1-4.54-31.68l34.27-4.9v-.76l98.94 98.95a76.89 76.89 0 0 1-71.68-17.73l-26.39 17.59c-.15.11-.31.21-.47.31a16 16 0 0 1-17.28-26.93zm224.72-48.42a16 16 0 0 0-13.57-18.11l-34.27-4.9V244.9l34.27-4.9a16 16 0 1 0-4.54-31.68l-30.54 4.36a79.31 79.31 0 0 0-6.85-22.85l24.54-16.36a16 16 0 1 0-17.29-26.93l-.46.31-26 17.34a79.9 79.9 0 0 0-102.64-3l139.83 139.88 19.41 2.77a16 16 0 0 0 18.11-13.57z"
                        class="currentColor" />
                    <path
                        d="M256 8C119 8 8 119 8 256s111 248 248 248 248-111 248-248S393 8 256 8zm0 432c-101.46 0-184-82.54-184-184a182.84 182.84 0 0 1 33.38-105.37l256 256A182.86 182.86 0 0 1 256 440zm150.62-78.63l-256-256A182.84 182.84 0 0 1 256 72c101.46 0 184 82.54 184 184a182.84 182.84 0 0 1-33.38 105.37z"
                        class="opacity-50" /></svg>
                <svg ref="icon-desktop" class="h-6 w-6 fill-current text-gray-500" viewBox="0 0 576 512">
                    <path
                        d="M528 0H48A48 48 0 0 0 0 48v320a48 48 0 0 0 48 48h480a48 48 0 0 0 48-48V48a48 48 0 0 0-48-48zm-16 352H64V64h448z"
                        class="currentColor" />
                    <path
                        d="M424 464h-72l-16-48h-96l-16 48h-72a24 24 0 0 0 0 48h272a24 24 0 0 0 0-48zM64 64v288h448V64z"
                        class="opacity-50" /></svg>
                <svg ref="icon-do-not-enter" class="h-6 w-6 fill-current text-gray-500" viewBox="0 0 496 512">
                    <path
                        d="M56,288V224a16,16,0,0,1,16-16H424a16,16,0,0,1,16,16v64a16,16,0,0,1-16,16H72A16,16,0,0,1,56,288Z"
                        class="currentColor" />
                    <path
                        d="M248,8C111,8,0,119,0,256S111,504,248,504,496,393,496,256,385,8,248,8ZM424,304H72a16,16,0,0,1-16-16V224a16,16,0,0,1,16-16H424a16,16,0,0,1,16,16v64A16,16,0,0,1,424,304Z"
                        class="opacity-50" /></svg>
                <svg ref="icon-download" class="h-6 w-6 fill-current text-gray-500" viewBox="0 0 512 512">
                    <path
                        d="M320 24v168h87.7c17.8 0 26.7 21.5 14.1 34.1L269.7 378.3a19.37 19.37 0 0 1-27.3 0L90.1 226.1c-12.6-12.6-3.7-34.1 14.1-34.1H192V24a23.94 23.94 0 0 1 24-24h80a23.94 23.94 0 0 1 24 24z"
                        class="currentColor" />
                    <path
                        d="M488 352H341.3l-49 49a51.24 51.24 0 0 1-72.6 0l-49-49H24a23.94 23.94 0 0 0-24 24v112a23.94 23.94 0 0 0 24 24h464a23.94 23.94 0 0 0 24-24V376a23.94 23.94 0 0 0-24-24zm-120 96a16 16 0 1 1 16-16 16 16 0 0 1-16 16zm64 0a16 16 0 1 1 16-16 16 16 0 0 1-16 16z"
                        class="opacity-50" /></svg>
                <svg ref="icon-edit" class="h-6 w-6 fill-current text-gray-500" viewBox="0 0 576 512">
                    <path
                        d="M564.6 60.2l-48.8-48.8a39.11 39.11 0 0 0-55.2 0l-35.4 35.4a9.78 9.78 0 0 0 0 13.8l90.2 90.2a9.78 9.78 0 0 0 13.8 0l35.4-35.4a39.11 39.11 0 0 0 0-55.2zM427.5 297.6l-40 40a12.3 12.3 0 0 0-3.5 8.5v101.8H64v-320h229.8a12.3 12.3 0 0 0 8.5-3.5l40-40a12 12 0 0 0-8.5-20.5H48a48 48 0 0 0-48 48v352a48 48 0 0 0 48 48h352a48 48 0 0 0 48-48V306.1a12 12 0 0 0-20.5-8.5z"
                        class="currentColor" />
                    <path
                        d="M492.8 173.3a9.78 9.78 0 0 1 0 13.8L274.4 405.5l-92.8 10.3a19.45 19.45 0 0 1-21.5-21.5l10.3-92.8L388.8 83.1a9.78 9.78 0 0 1 13.8 0z"
                        class="opacity-50" /></svg>
                <svg ref="icon-elipsis-v" class="h-6 w-6 fill-current text-gray-500" viewBox="0 0 192 512">
                    <path d="M96 184a72 72 0 1 0 72 72 72 72 0 0 0-72-72z" class="currentColor" />
                    <path d="M96 152a72 72 0 1 0-72-72 72 72 0 0 0 72 72zm0 208a72 72 0 1 0 72 72 72 72 0 0 0-72-72z"
                        class="opacity-50" /></svg>
                <svg ref="icon-ellipsis-h" class="h-6 w-6 fill-current text-gray-500" viewBox="0 0 512 512">
                    <path d="M256 184a72 72 0 1 0 72 72 72 72 0 0 0-72-72z" class="currentColor" />
                    <path d="M432 184a72 72 0 1 0 72 72 72 72 0 0 0-72-72zm-352 0a72 72 0 1 0 72 72 72 72 0 0 0-72-72z"
                        class="opacity-50" /></svg>
                <svg ref="icon-exclamation-circle" class="h-6 w-6 fill-current text-gray-500" viewBox="0 0 512 512">
                    <path
                        d="M256 8C119 8 8 119.08 8 256s111 248 248 248 248-111 248-248S393 8 256 8zm0 376a32 32 0 1 1 32-32 32 32 0 0 1-32 32zm38.24-238.41l-12.8 128A16 16 0 0 1 265.52 288h-19a16 16 0 0 1-15.92-14.41l-12.8-128A16 16 0 0 1 233.68 128h44.64a16 16 0 0 1 15.92 17.59z"
                        class="currentColor" />
                    <path
                        d="M278.32 128h-44.64a16 16 0 0 0-15.92 17.59l12.8 128A16 16 0 0 0 246.48 288h19a16 16 0 0 0 15.92-14.41l12.8-128A16 16 0 0 0 278.32 128zM256 320a32 32 0 1 0 32 32 32 32 0 0 0-32-32z"
                        class="opacity-50" /></svg>
                <svg ref="icon-file-archive" class="h-6 w-6 fill-current text-gray-500" viewBox="0 0 384 512">
                    <path
                        d="M272 128a16 16 0 0 1-16-16V0h-96v32h-32V0H24A23.94 23.94 0 0 0 0 23.88V488a23.94 23.94 0 0 0 23.88 24H360a23.94 23.94 0 0 0 24-23.88V128zM95.9 32h32v32h-32zm83.47 342.08a52.43 52.43 0 1 1-102.74-21L96 256v-32h32v-32H96v-32h32v-32H96V96h32V64h32v32h-32v32h32v32h-32v32h32v32h-32v32h22.33a12.08 12.08 0 0 1 11.8 9.7l17.3 87.7a52.54 52.54 0 0 1-.06 20.68z"
                        class="currentColor" />
                    <path
                        d="M377 105L279.1 7a24 24 0 0 0-17-7H256v112a16 16 0 0 0 16 16h112v-6.1a23.9 23.9 0 0 0-7-16.9zM127.9 32h-32v32h32zM96 160v32h32v-32zM160 0h-32v32h32zM96 96v32h32V96zm83.43 257.4l-17.3-87.7a12.08 12.08 0 0 0-11.8-9.7H128v-32H96v32l-19.37 97.1a52.43 52.43 0 1 0 102.8.3zm-51.1 36.6c-17.9 0-32.5-12-32.5-27s14.5-27 32.4-27 32.5 12.1 32.5 27-14.5 27-32.4 27zM160 192h-32v32h32zm0-64h-32v32h32zm0-64h-32v32h32z"
                        class="opacity-50" /></svg>
                <svg ref="icon-file-certificate" class="h-6 w-6 fill-current text-gray-500" viewBox="0 0 512 512">
                    <path
                        d="M512 128v360.12A23.94 23.94 0 0 1 488 512H224v-91.19a61.78 61.78 0 0 0 35.49-41.11c.38-1.42.72-2.72 1-3.94.66-2.56 1.4-5.39 1.89-7 1.14-1.23 3.12-3.24 4.92-5.06l2.91-2.94A62.5 62.5 0 0 0 286 301.38c-.37-1.41-.72-2.71-1-3.92-.69-2.61-1.46-5.5-1.84-7.16.38-1.68 1.16-4.6 1.86-7.25.31-1.18.65-2.45 1-3.83a62.45 62.45 0 0 0-15.63-59.28l-2.76-2.81c-1.85-1.88-3.9-3.95-5.05-5.2-.49-1.64-1.23-4.51-1.91-7.1q-.47-1.8-1-3.9a61.69 61.69 0 0 0-43.13-43.7h-.11l-3.75-1c-2.44-.66-5.13-1.39-6.75-1.88-1.23-1.18-3.22-3.21-5-5.05-.84-.86-1.73-1.78-2.71-2.77a60.88 60.88 0 0 0-59.47-16.31h-.05l-3.77 1c-2.4.66-5 1.39-6.69 1.79V23.88A23.94 23.94 0 0 1 152 0h232v112a16 16 0 0 0 16 16z"
                        class="currentColor" />
                    <path
                        d="M505 105L407.1 7a24 24 0 0 0-17-7H384v112a16 16 0 0 0 16 16h112v-6.1a23.9 23.9 0 0 0-7-16.9zM255 271.09a30.14 30.14 0 0 0-7.58-28.79c-14.86-15.12-13.42-12.61-18.86-33.3a29.57 29.57 0 0 0-20.71-21c-20.28-5.53-17.84-4.1-32.69-19.21a28.92 28.92 0 0 0-28.28-7.79c-20.32 5.54-17.46 5.53-37.75 0a28.94 28.94 0 0 0-28.28 7.71c-14.91 15.18-12.5 13.7-32.68 19.21A29.53 29.53 0 0 0 27.46 209c-5.46 20.74-4 18.13-18.87 33.27A30.15 30.15 0 0 0 1 271.09c5.45 20.71 5.42 17.79 0 38.41a30.12 30.12 0 0 0 7.58 28.78c14.86 15.11 13.42 12.61 18.88 33.27a29.52 29.52 0 0 0 20.71 21.07c14.3 3.9 11.52 3 15.83 5V512l64-32 64 32V397.63c4.31-2 1.52-1.1 15.84-5a29.53 29.53 0 0 0 20.7-21.07c5.47-20.74 4-18.13 18.88-33.27a30.12 30.12 0 0 0 7.58-28.78c-5.43-20.65-5.44-17.74 0-38.42zM128 352a64 64 0 1 1 64-64 64 64 0 0 1-64 64z"
                        class="opacity-50" /></svg>
                <svg ref="icon-file-image" class="h-6 w-6 fill-current text-gray-500" viewBox="0 0 384 512">
                    <path
                        d="M384 128H272a16 16 0 0 1-16-16V0H24A23.94 23.94 0 0 0 0 23.88V488a23.94 23.94 0 0 0 23.88 24H360a23.94 23.94 0 0 0 24-23.88V128zm-271.46 48a48 48 0 1 1-48 48 48 48 0 0 1 48-48zm208 240h-256l.46-48.48L104.51 328c4.69-4.69 11.8-4.2 16.49.48L160.54 368 264 264.48a12 12 0 0 1 17 0L320.54 304z"
                        class="currentColor" />
                    <path
                        d="M377 105L279.1 7a24 24 0 0 0-17-7H256v112a16 16 0 0 0 16 16h112v-6.1a23.9 23.9 0 0 0-7-16.9zM112.54 272a48 48 0 1 0-48-48 48 48 0 0 0 48 48zM264 264.45L160.54 368 121 328.48c-4.69-4.68-11.8-5.17-16.49-.48L65 367.52 64.54 416h256V304L281 264.48a12 12 0 0 0-17-.03z"
                        class="opacity-50" /></svg>
                <svg ref="icon-file-pdf" class="h-6 w-6 fill-current text-gray-500" viewBox="0 0 384 512">
                    <path
                        d="M86.1 428.1c0 .8 13.2-5.4 34.9-40.2-6.7 6.3-29.1 24.5-34.9 40.2zm93.8-218.9c-2.9 0-3 30.9 2 46.9 5.6-10 6.4-46.9-2-46.9zm80.2 142.1c37.1 15.8 42.8 9 42.8 9 4.1-2.7-2.5-11.9-42.8-9zm-79.9-48c-7.7 20.2-17.3 43.3-28.4 62.7 18.3-7 39-17.2 62.9-21.9-12.7-9.6-24.9-23.4-34.5-40.8zM272 128a16 16 0 0 1-16-16V0H24A23.94 23.94 0 0 0 0 23.88V488a23.94 23.94 0 0 0 23.88 24H360a23.94 23.94 0 0 0 24-23.88V128zm21.9 254.4c-16.9 0-42.3-7.7-64-19.5-24.9 4.1-53.2 14.7-79 23.2-25.4 43.8-43.2 61.8-61.1 61.8-5.5 0-15.9-3.1-21.5-10-19.1-23.5 27.4-54.1 54.5-68 .1 0 .1-.1.2-.1 12.1-21.2 29.2-58.2 40.8-85.8-8.5-32.9-13.1-58.7-8.1-77 5.4-19.7 43.1-22.6 47.8 6.8 5.4 17.6-1.7 45.7-6.2 64.2 9.4 24.8 22.7 41.6 42.7 53.8 19.3-2.5 59.7-6.4 73.6 7.2 11.5 11.4 9.5 43.4-19.7 43.4z"
                        class="currentColor" />
                    <path
                        d="M377 105L279.1 7a24 24 0 0 0-17-7H256v112a16 16 0 0 0 16 16h112v-6.1a23.9 23.9 0 0 0-7-16.9zM240 331.8c-20-12.2-33.3-29-42.7-53.8 4.5-18.5 11.6-46.6 6.2-64.2-4.7-29.4-42.4-26.5-47.8-6.8-5 18.3-.4 44.1 8.1 77-11.6 27.6-28.7 64.6-40.8 85.8-.1 0-.1.1-.2.1-27.1 13.9-73.6 44.5-54.5 68 5.6 6.9 16 10 21.5 10 17.9 0 35.7-18 61.1-61.8 25.8-8.5 54.1-19.1 79-23.2 21.7 11.8 47.1 19.5 64 19.5 29.2 0 31.2-32 19.7-43.4-13.9-13.6-54.3-9.7-73.6-7.2zM86.1 428.1c5.8-15.7 28.2-33.9 34.9-40.2-21.7 34.8-34.9 41-34.9 40.2zm93.8-218.9c8.4 0 7.6 36.9 2 46.9-5-16-4.9-46.9-2-46.9zM151.8 366c11.1-19.4 20.7-42.5 28.4-62.7 9.6 17.4 21.8 31.2 34.5 40.8-23.9 4.7-44.6 14.9-62.9 21.9zm151.1-5.7s-5.7 6.8-42.8-9c40.3-2.9 46.9 6.3 42.8 9z"
                        class="opacity-50" /></svg>
                <svg ref="icon-file-powerpoint" class="h-6 w-6 fill-current text-gray-500" viewBox="0 0 384 512">
                    <path
                        d="M384 128H272a16 16 0 0 1-16-16V0H24A23.94 23.94 0 0 0 0 23.88V488a23.94 23.94 0 0 0 23.88 24H360a23.94 23.94 0 0 0 24-23.88V128zM165.9 378.8V436a12 12 0 0 1-12 12h-30.8a12 12 0 0 1-12-12V236.2a12 12 0 0 1 12-12h81c44.5 0 72.9 32.8 72.9 77 0 90.3-88.8 77.6-111.1 77.6zm27.8-107.6h-27.9v60.7h26.9c9.2 0 16.2-2.9 21.1-8.5 10-11.4 9.8-33.2.2-44.1-4.8-5.4-11.5-8.1-20.3-8.1z"
                        class="currentColor" />
                    <path
                        d="M377 105L279.1 7a24 24 0 0 0-17-7H256v112a16 16 0 0 0 16 16h112v-6.1a23.9 23.9 0 0 0-7-16.9zM204.1 224.2h-81a12 12 0 0 0-12 12V436a12 12 0 0 0 12 12h30.8a12 12 0 0 0 12-12v-57.2c22.3 0 111.1 12.7 111.1-77.6 0-44.2-28.4-77-72.9-77zm9.7 99.2c-4.9 5.6-11.9 8.5-21.1 8.5h-26.9v-60.7h27.9c8.8 0 15.5 2.7 20.3 8.1 9.6 10.9 9.8 32.7-.2 44.1z"
                        class="opacity-50" /></svg>
                <svg ref="icon-file-video" class="h-6 w-6 fill-current text-gray-500" viewBox="0 0 384 512">
                    <path
                        d="M384 128H272a16 16 0 0 1-16-16V0H24A23.94 23.94 0 0 0 0 23.88V488a23.94 23.94 0 0 0 23.88 24H360a23.94 23.94 0 0 0 24-23.88V128zm-64 264c0 21.44-25.94 32-41 17l-55-55v38a24 24 0 0 1-24 24H88a24 24 0 0 1-24-24V280a24 24 0 0 1 24-24h112a24 24 0 0 1 24 24v38.06l55-55c15-15.06 41-4.5 41 16.94z"
                        class="currentColor" />
                    <path
                        d="M377 105L279.1 7a24 24 0 0 0-17-7H256v112a16 16 0 0 0 16 16h112v-6.1a23.9 23.9 0 0 0-7-16.9zm-98 158.06l-55 55V280a24 24 0 0 0-24-24H88a24 24 0 0 0-24 24v112a24 24 0 0 0 24 24h112a24 24 0 0 0 24-24v-38l55 55c15.06 15 41 4.44 41-17V280c0-21.44-26-32-41-16.94z"
                        class="opacity-50" /></svg>
                <svg ref="icon-file-video" class="icon-file-video h-6 w-6 fill-current text-red-500"
                    viewBox="0 0 384 512">
                    <path
                        d="M384 128H272a16 16 0 0 1-16-16V0H24A23.94 23.94 0 0 0 0 23.88V488a23.94 23.94 0 0 0 23.88 24H360a23.94 23.94 0 0 0 24-23.88V128zm-64 264c0 21.44-25.94 32-41 17l-55-55v38a24 24 0 0 1-24 24H88a24 24 0 0 1-24-24V280a24 24 0 0 1 24-24h112a24 24 0 0 1 24 24v38.06l55-55c15-15.06 41-4.5 41 16.94z"
                        class="currentColor" />
                    <path
                        d="M377 105L279.1 7a24 24 0 0 0-17-7H256v112a16 16 0 0 0 16 16h112v-6.1a23.9 23.9 0 0 0-7-16.9zm-98 158.06l-55 55V280a24 24 0 0 0-24-24H88a24 24 0 0 0-24 24v112a24 24 0 0 0 24 24h112a24 24 0 0 0 24-24v-38l55 55c15.06 15 41 4.44 41-17V280c0-21.44-26-32-41-16.94z"
                        class="opacity-50" /></svg>
                <svg ref="icon-file-word" class="h-6 w-6 fill-current text-gray-500" viewBox="0 0 384 512">
                    <path
                        d="M384 128H272a16 16 0 0 1-16-16V0H24A23.94 23.94 0 0 0 0 23.88V488a23.94 23.94 0 0 0 23.88 24H360a23.94 23.94 0 0 0 24-23.88V128zm-67.3 142.7l-38 168A11.9 11.9 0 0 1 267 448h-38a12 12 0 0 1-11.6-9.1c-25.8-103.5-20.8-81.2-25.6-110.5h-.5c-1.1 14.3-2.4 17.4-25.6 110.5a12 12 0 0 1-11.6 9.1H117a12 12 0 0 1-11.7-9.4l-37.8-168A12 12 0 0 1 79.2 256h24.5a12 12 0 0 1 11.8 9.7c15.6 78 20.1 109.5 21 122.2 1.6-10.2 7.3-32.7 29.4-122.7a11.9 11.9 0 0 1 11.7-9.1h29.1a12 12 0 0 1 11.7 9.2c24 100.4 28.8 124 29.6 129.4-.2-11.2-2.6-17.8 21.6-129.2a11.59 11.59 0 0 1 11.5-9.5H305a12 12 0 0 1 12 12 11.8 11.8 0 0 1-.3 2.7z"
                        class="currentColor" />
                    <path
                        d="M377 105L279.1 7a24 24 0 0 0-17-7H256v112a16 16 0 0 0 16 16h112v-6.1a23.9 23.9 0 0 0-7-16.9zm-72 151h-23.9a11.59 11.59 0 0 0-11.5 9.5c-24.2 111.4-21.8 118-21.6 129.2-.8-5.4-5.6-29-29.6-129.4a12 12 0 0 0-11.7-9.2h-29.1a11.9 11.9 0 0 0-11.7 9.1c-22.1 90-27.8 112.5-29.4 122.7-.9-12.7-5.4-44.2-21-122.2a12 12 0 0 0-11.8-9.7H79.2a12 12 0 0 0-11.7 14.6l37.8 168A12 12 0 0 0 117 448h37.1a12 12 0 0 0 11.6-9.1c23.2-93.1 24.5-96.2 25.6-110.5h.5c4.8 29.3-.2 7 25.6 110.5A12 12 0 0 0 229 448h38a11.9 11.9 0 0 0 11.7-9.3l38-168a11.8 11.8 0 0 0 .3-2.7 12 12 0 0 0-12-12z"
                        class="opacity-50" /></svg>
                <svg ref="icon-file" class="h-6 w-6 fill-current text-gray-500" viewBox="0 0 384 512">
                    <path
                        d="M256 0H24A23.94 23.94 0 0 0 0 23.88V488a23.94 23.94 0 0 0 23.88 24H360a23.94 23.94 0 0 0 24-23.88V128H272a16 16 0 0 1-16-16z"
                        class="currentColor" />
                    <path
                        d="M384 121.9v6.1H272a16 16 0 0 1-16-16V0h6.1a24 24 0 0 1 17 7l97.9 98a23.9 23.9 0 0 1 7 16.9z"
                        class="opacity-50" /></svg>
                <svg ref="icon-info-circle" class="h-6 w-6 fill-current text-gray-500" viewBox="0 0 512 512">
                    <path
                        d="M256 8C119 8 8 119.08 8 256s111 248 248 248 248-111 248-248S393 8 256 8zm0 110a42 42 0 1 1-42 42 42 42 0 0 1 42-42zm56 254a12 12 0 0 1-12 12h-88a12 12 0 0 1-12-12v-24a12 12 0 0 1 12-12h12v-64h-12a12 12 0 0 1-12-12v-24a12 12 0 0 1 12-12h64a12 12 0 0 1 12 12v100h12a12 12 0 0 1 12 12z"
                        class="currentColor" />
                    <path
                        d="M256 202a42 42 0 1 0-42-42 42 42 0 0 0 42 42zm44 134h-12V236a12 12 0 0 0-12-12h-64a12 12 0 0 0-12 12v24a12 12 0 0 0 12 12h12v64h-12a12 12 0 0 0-12 12v24a12 12 0 0 0 12 12h88a12 12 0 0 0 12-12v-24a12 12 0 0 0-12-12z"
                        class="opacity-50" /></svg>
                <svg ref="icon-mobile" class="h-6 w-6 fill-current text-gray-500" viewBox="0 0 320 512">
                    <path
                        d="M0 384v80a48 48 0 0 0 48 48h224a48 48 0 0 0 48-48v-80zm160 96a32 32 0 1 1 32-32 32 32 0 0 1-32 32z"
                        class="currentColor" />
                    <path d="M0 384V48A48 48 0 0 1 48 0h224a48 48 0 0 1 48 48v336z" class="opacity-50" /></svg>
                <svg ref="icon-paper-clip" class="h-6 w-6 fill-current text-gray-500" viewBox="0 0 448 512">
                    <path
                        d="M171.43 319.93c-4.94 5-5.24 13.43-.65 18.29a10.66 10.66 0 0 0 15.69.16l182.85-186.85a52.37 52.37 0 0 0 0-72.79 48 48 0 0 0-69.15 0L90.39 293.3c-34.76 35.56-35.3 93.12-1.19 128.31a85.28 85.28 0 0 0 123.06.28l172.06-176a16 16 0 0 1 22.62-.26L429.82 268a16 16 0 0 1 .26 22.63L258 466.63a149.21 149.21 0 0 1-214.77-.49c-58.43-60.29-57.35-157.51 1.38-217.58L254.39 34a111.9 111.9 0 0 1 160.67 0c43.89 44.89 43.95 117.33 0 162.28L232.21 383.13a74.61 74.61 0 0 1-108-1c-28.27-30-27.37-77.47 1.45-106.95l143.77-146.84a16 16 0 0 1 22.62-.24l22.86 22.38a16 16 0 0 1 .24 22.63z"
                        class="currentColor" /></svg>
                <svg ref="icon-pause-circle" class="h-6 w-6 fill-current text-gray-500" viewBox="0 0 512 512">
                    <path
                        d="M256 8C119 8 8 119 8 256s111 248 248 248 248-111 248-248S393 8 256 8zm-16 328a16 16 0 0 1-16 16h-48a16 16 0 0 1-16-16V176a16 16 0 0 1 16-16h48a16 16 0 0 1 16 16zm112 0a16 16 0 0 1-16 16h-48a16 16 0 0 1-16-16V176a16 16 0 0 1 16-16h48a16 16 0 0 1 16 16z"
                        class="currentColor" />
                    <path
                        d="M224 160h-48a16 16 0 0 0-16 16v160a16 16 0 0 0 16 16h48a16 16 0 0 0 16-16V176a16 16 0 0 0-16-16zm112 0h-48a16 16 0 0 0-16 16v160a16 16 0 0 0 16 16h48a16 16 0 0 0 16-16V176a16 16 0 0 0-16-16z"
                        class="opacity-50" /></svg>
                <svg ref="icon-play-circle" class="h-6 w-6 fill-current text-gray-500" viewBox="0 0 512 512">
                    <path
                        d="M256 8C119 8 8 119 8 256s111 248 248 248 248-111 248-248S393 8 256 8zm115.7 272l-176 101c-15.8 8.8-35.7-2.5-35.7-21V152c0-18.4 19.8-29.8 35.7-21l176 107c16.4 9.2 16.4 32.9 0 42z"
                        class="currentColor" />
                    <path
                        d="M371.7 280l-176 101c-15.8 8.8-35.7-2.5-35.7-21V152c0-18.4 19.8-29.8 35.7-21l176 107c16.4 9.2 16.4 32.9 0 42z"
                        class="opacity-50" /></svg>
                <svg ref="icon-plus-circle" class="h-6 w-6 fill-current text-gray-500" viewBox="0 0 512 512">
                    <path
                        d="M256 8C119 8 8 119 8 256s111 248 248 248 248-111 248-248S393 8 256 8zm144 276a12 12 0 0 1-12 12h-92v92a12 12 0 0 1-12 12h-56a12 12 0 0 1-12-12v-92h-92a12 12 0 0 1-12-12v-56a12 12 0 0 1 12-12h92v-92a12 12 0 0 1 12-12h56a12 12 0 0 1 12 12v92h92a12 12 0 0 1 12 12z"
                        class="currentColor" />
                    <path
                        d="M400 284a12 12 0 0 1-12 12h-92v92a12 12 0 0 1-12 12h-56a12 12 0 0 1-12-12v-92h-92a12 12 0 0 1-12-12v-56a12 12 0 0 1 12-12h92v-92a12 12 0 0 1 12-12h56a12 12 0 0 1 12 12v92h92a12 12 0 0 1 12 12z"
                        class="opacity-50" /></svg>
                <svg ref="icon-question-circle" class="h-6 w-6 fill-current text-gray-500" viewBox="0 0 512 512">
                    <path
                        d="M256 8C119 8 8 119.08 8 256s111 248 248 248 248-111 248-248S393 8 256 8zm0 422a46 46 0 1 1 46-46 46.05 46.05 0 0 1-46 46zm40-131.33V300a12 12 0 0 1-12 12h-56a12 12 0 0 1-12-12v-4c0-41.06 31.13-57.47 54.65-70.66 20.17-11.31 32.54-19 32.54-34 0-19.82-25.27-33-45.7-33-27.19 0-39.44 13.14-57.3 35.79a12 12 0 0 1-16.67 2.13L148.82 170a12 12 0 0 1-2.71-16.26C173.4 113 208.16 90 262.66 90c56.34 0 116.53 44 116.53 102 0 77-83.19 78.21-83.19 106.67z"
                        class="currentColor" />
                    <path
                        d="M256 338a46 46 0 1 0 46 46 46 46 0 0 0-46-46zm6.66-248c-54.5 0-89.26 23-116.55 63.76a12 12 0 0 0 2.71 16.24l34.7 26.31a12 12 0 0 0 16.67-2.13c17.86-22.65 30.11-35.79 57.3-35.79 20.43 0 45.7 13.14 45.7 33 0 15-12.37 22.66-32.54 34C247.13 238.53 216 254.94 216 296v4a12 12 0 0 0 12 12h56a12 12 0 0 0 12-12v-1.33c0-28.46 83.19-29.67 83.19-106.67 0-58-60.19-102-116.53-102z"
                        class="opacity-50" /></svg>
                <svg ref="icon-record-vinyl" class="h-6 w-6 fill-current text-gray-500" viewBox="0 0 512 512">
                    <path
                        d="M256 128a128 128 0 1 0 128 128 128 128 0 0 0-128-128zm0 152a24 24 0 1 1 24-24 24 24 0 0 1-24 24z"
                        class="currentColor" />
                    <path
                        d="M256 8C119 8 8 119 8 256s111 248 248 248 248-111 248-248S393 8 256 8zm0 376a128 128 0 1 1 128-128 128 128 0 0 1-128 128z"
                        class="opacity-50" /></svg>
                <svg ref="icon-search" class="h-6 w-6 fill-current text-gray-500" viewBox="0 0 512 512">
                    <path
                        d="M208 80a128 128 0 1 1-90.51 37.49A127.15 127.15 0 0 1 208 80m0-80C93.12 0 0 93.12 0 208s93.12 208 208 208 208-93.12 208-208S322.88 0 208 0z"
                        class="currentColor" />
                    <path
                        d="M504.9 476.7L476.6 505a23.9 23.9 0 0 1-33.9 0L343 405.3a24 24 0 0 1-7-17V372l36-36h16.3a24 24 0 0 1 17 7l99.7 99.7a24.11 24.11 0 0 1-.1 34z"
                        class="opacity-50" /></svg>
                <svg ref="icon-server" class="h-6 w-6 fill-current text-gray-500" viewBox="0 0 512 512">
                    <path
                        d="M432 120a24 24 0 1 0-24-24 24 24 0 0 0 24 24zm0 272a24 24 0 1 0 24 24 24 24 0 0 0-24-24zm48-200H32a32 32 0 0 0-32 32v64a32 32 0 0 0 32 32h448a32 32 0 0 0 32-32v-64a32 32 0 0 0-32-32zm-112 88a24 24 0 1 1 24-24 24 24 0 0 1-24 24zm64 0a24 24 0 1 1 24-24 24 24 0 0 1-24 24z"
                        class="currentColor" />
                    <path
                        d="M456 256a24 24 0 1 0-24 24 24 24 0 0 0 24-24zm24-224H32A32 32 0 0 0 0 64v64a32 32 0 0 0 32 32h448a32 32 0 0 0 32-32V64a32 32 0 0 0-32-32zm-112 88a24 24 0 1 1 24-24 24 24 0 0 1-24 24zm64 0a24 24 0 1 1 24-24 24 24 0 0 1-24 24zm48 232H32a32 32 0 0 0-32 32v64a32 32 0 0 0 32 32h448a32 32 0 0 0 32-32v-64a32 32 0 0 0-32-32zm-112 88a24 24 0 1 1 24-24 24 24 0 0 1-24 24zm64 0a24 24 0 1 1 24-24 24 24 0 0 1-24 24z"
                        class="opacity-50" /></svg>
                <svg ref="icon-sitemap" class="h-6 w-6 fill-current text-gray-500" viewBox="0 0 640 512">
                    <path
                        d="M104 320H56v-57.59A38.45 38.45 0 0 1 94.41 224H296v-64h48v64h201.59A38.46 38.46 0 0 1 584 262.41V320h-48v-48H344v48h-48v-48H104z"
                        class="currentColor" />
                    <path
                        d="M128 352H32a32 32 0 0 0-32 32v96a32 32 0 0 0 32 32h96a32 32 0 0 0 32-32v-96a32 32 0 0 0-32-32zM384 0H256a32 32 0 0 0-32 32v96a32 32 0 0 0 32 32h128a32 32 0 0 0 32-32V32a32 32 0 0 0-32-32zm224 352h-96a32 32 0 0 0-32 32v96a32 32 0 0 0 32 32h96a32 32 0 0 0 32-32v-96a32 32 0 0 0-32-32zm-240 0h-96a32 32 0 0 0-32 32v96a32 32 0 0 0 32 32h96a32 32 0 0 0 32-32v-96a32 32 0 0 0-32-32z"
                        class="opacity-50" /></svg>
                <svg ref="icon-sliders-h" class="h-6 w-6 fill-current text-gray-500" viewBox="0 0 512 512">
                    <path
                        d="M496 64H288v64h208a16 16 0 0 0 16-16V80a16 16 0 0 0-16-16zM16 128h176V64H16A16 16 0 0 0 0 80v32a16 16 0 0 0 16 16zm0 160h304v-64H16a16 16 0 0 0-16 16v32a16 16 0 0 0 16 16zm480-64h-80v64h80a16 16 0 0 0 16-16v-32a16 16 0 0 0-16-16zm0 160H160v64h336a16 16 0 0 0 16-16v-32a16 16 0 0 0-16-16zM0 400v32a16 16 0 0 0 16 16h48v-64H16a16 16 0 0 0-16 16z"
                        class="currentColor" />
                    <path
                        d="M272 32h-32a16 16 0 0 0-16 16v96a16 16 0 0 0 16 16h32a16 16 0 0 0 16-16V48a16 16 0 0 0-16-16zm128 160h-32a16 16 0 0 0-16 16v96a16 16 0 0 0 16 16h32a16 16 0 0 0 16-16v-96a16 16 0 0 0-16-16zM144 352h-32a16 16 0 0 0-16 16v96a16 16 0 0 0 16 16h32a16 16 0 0 0 16-16v-96a16 16 0 0 0-16-16z"
                        class="opacity-50" /></svg>
                <svg ref="icon-sliders-v" class="h-6 w-6 fill-current text-gray-500" viewBox="0 0 448 512">
                    <path
                        d="M80 0H48a16 16 0 0 0-16 16v80h64V16A16 16 0 0 0 80 0zm112 496a16 16 0 0 0 16 16h32a16 16 0 0 0 16-16v-48h-64zm-160 0a16 16 0 0 0 16 16h32a16 16 0 0 0 16-16V192H32zM240 0h-32a16 16 0 0 0-16 16v336h64V16a16 16 0 0 0-16-16zm112 496a16 16 0 0 0 16 16h32a16 16 0 0 0 16-16V320h-64zM400 0h-32a16 16 0 0 0-16 16v208h64V16a16 16 0 0 0-16-16z"
                        class="currentColor" />
                    <path
                        d="M112 96H16a16 16 0 0 0-16 16v32a16 16 0 0 0 16 16h96a16 16 0 0 0 16-16v-32a16 16 0 0 0-16-16zm320 128h-96a16 16 0 0 0-16 16v32a16 16 0 0 0 16 16h96a16 16 0 0 0 16-16v-32a16 16 0 0 0-16-16zM272 352h-96a16 16 0 0 0-16 16v32a16 16 0 0 0 16 16h96a16 16 0 0 0 16-16v-32a16 16 0 0 0-16-16z"
                        class="opacity-50" /></svg>
                <svg ref="icon-sort-down" class="h-6 w-6 fill-current text-gray-500" viewBox="0 0 320 512">
                    <path
                        d="M279.07 224.05h-238c-21.4 0-32.1-25.9-17-41l119-119a23.9 23.9 0 0 1 33.8-.1l.1.1 119.1 119c15.07 15.05 4.4 41-17 41z"
                        class="currentColor" />
                    <path
                        d="M296.07 329.05L177 448.05a23.9 23.9 0 0 1-33.8.1l-.1-.1-119-119c-15.1-15.1-4.4-41 17-41h238c21.37 0 32.04 25.95 16.97 41z"
                        class="opacity-50" /></svg>
                <svg ref="icon-sort-up" class="h-6 w-6 fill-current text-gray-500" viewBox="0 0 320 512">
                    <path
                        d="M41.05 288.05h238c21.4 0 32.1 25.9 17 41l-119 119a23.9 23.9 0 0 1-33.8.1l-.1-.1-119.1-119c-15.05-15.05-4.4-41 17-41z"
                        class="currentColor" />
                    <path
                        d="M24.05 183.05l119.1-119A23.9 23.9 0 0 1 177 64a.94.94 0 0 1 .1.1l119 119c15.1 15.1 4.4 41-17 41h-238c-21.45-.05-32.1-25.95-17.05-41.05z"
                        class="opacity-50" /></svg>
                <svg ref="icon-sort" class="h-6 w-6 fill-current text-gray-500" viewBox="0 0 320 512">
                    <path
                        d="M279.05 288.05h-238c-21.4 0-32.07 25.95-17 41l119.1 119 .1.1a23.9 23.9 0 0 0 33.8-.1l119-119c15.1-15.05 4.4-41-17-41zm-238-64h238c21.4 0 32.1-25.9 17-41l-119-119a.94.94 0 0 0-.1-.1 23.9 23.9 0 0 0-33.8.1l-119.1 119c-15.05 15.1-4.4 41 17 41z"
                        class="currentColor" /></svg>
                <svg ref="icon-sticky-note" class="h-6 w-6 fill-current text-gray-500" viewBox="0 0 448 512">
                    <path
                        d="M448 352H336a16 16 0 0 0-16 16v112H24a23.94 23.94 0 0 1-24-23.88V56a23.94 23.94 0 0 1 23.88-24H424a23.94 23.94 0 0 1 24 23.88V352z"
                        class="currentColor" />
                    <path d="M320 480V368a16 16 0 0 1 16-16h112v6.1a23.9 23.9 0 0 1-7 16.9l-98 98a24 24 0 0 1-17 7z"
                        class="opacity-50" /></svg>
                <svg ref="icon-tablet" class="h-6 w-6 fill-current text-gray-500" viewBox="0 0 448 512">
                    <path
                        d="M0 384v80a48 48 0 0 0 48 48h352a48 48 0 0 0 48-48v-80zm224 96a32 32 0 1 1 32-32 32 32 0 0 1-32 32z"
                        class="currentColor" />
                    <path d="M0 384V48A48 48 0 0 1 48 0h352a48 48 0 0 1 48 48v336z" class="opacity-50" /></svg>
                <svg ref="icon-tag" class="h-6 w-6 fill-current text-gray-500" viewBox="0 0 512 512">
                    <path
                        d="M497.94 225.94L286.06 14.06A48 48 0 0 0 252.12 0H48A48 48 0 0 0 0 48v204.12a48 48 0 0 0 14.06 33.94l211.88 211.88a48 48 0 0 0 67.88 0l204.12-204.12a48 48 0 0 0 0-67.88zM112 160a48 48 0 1 1 48-48 48 48 0 0 1-48 48z"
                        class="currentColor" /></svg>
                <svg ref="icon-tags" class="h-6 w-6 fill-current text-gray-500" viewBox="0 0 640 512">
                    <path
                        d="M497.94 225.94L286.06 14.06A48 48 0 0 0 252.12 0H48A48 48 0 0 0 0 48v204.12a48 48 0 0 0 14.06 33.94l211.88 211.88a48 48 0 0 0 67.88 0l204.12-204.12a48 48 0 0 0 0-67.88zM112 160a48 48 0 1 1 48-48 48 48 0 0 1-48 48z"
                        class="currentColor" />
                    <path
                        d="M625.94 293.82L421.82 497.94a48 48 0 0 1-67.88 0l-.36-.36 174.06-174.06a90 90 0 0 0 0-127.28L331.4 0h48.72a48 48 0 0 1 33.94 14.06l211.88 211.88a48 48 0 0 1 0 67.88z"
                        class="opacity-50" /></svg>
                <svg ref="icon-tally" class="h-6 w-6 fill-current text-gray-500" viewBox="0 0 640 512">
                    <path
                        d="M224 253.44V48a16 16 0 0 1 16-16h32a16 16 0 0 1 16 16v184.73zm-64 20.71V48a16 16 0 0 0-16-16h-32a16 16 0 0 0-16 16v246.86zm256-82.85V48a16 16 0 0 0-16-16h-32a16 16 0 0 0-16 16v164zm128-41.42V48a16 16 0 0 0-16-16h-32a16 16 0 0 0-16 16v122.59zM224 320.7V464a16 16 0 0 0 16 16h32a16 16 0 0 0 16-16V300zm256-82.85V464a16 16 0 0 0 16 16h32a16 16 0 0 0 16-16V217.14zM96 362.12V464a16 16 0 0 0 16 16h32a16 16 0 0 0 16-16V341.41zm256-82.85V464a16 16 0 0 0 16 16h32a16 16 0 0 0 16-16V258.56z"
                        class="currentColor" />
                    <path
                        d="M639.21 169.49a16 16 0 0 1-10.27 20.16L30.84 383.21a16 16 0 0 1-20.16-10.27L.79 342.51a16 16 0 0 1 10.27-20.16l598.1-193.56a16 16 0 0 1 20.16 10.27z"
                        class="opacity-50" /></svg>
                <svg ref="icon-tasks" class="h-6 w-6 fill-current text-gray-500" viewBox="0 0 512 512">
                    <path
                        d="M496 384H208a16 16 0 0 0-16 16v32a16 16 0 0 0 16 16h288a16 16 0 0 0 16-16v-32a16 16 0 0 0-16-16zm0-320H208a16 16 0 0 0-16 16v32a16 16 0 0 0 16 16h288a16 16 0 0 0 16-16V80a16 16 0 0 0-16-16zm0 160H208a16 16 0 0 0-16 16v32a16 16 0 0 0 16 16h288a16 16 0 0 0 16-16v-32a16 16 0 0 0-16-16z"
                        class="currentColor" />
                    <path
                        d="M139.61 35.5a12 12 0 0 0-17 0L58.93 98.81l-22.7-22.12a12 12 0 0 0-17 0L3.53 92.41a12 12 0 0 0 0 17l47.59 47.4a12.78 12.78 0 0 0 17.61 0l15.59-15.62L156.52 69a12.09 12.09 0 0 0 .09-17zm0 159.19a12 12 0 0 0-17 0l-63.68 63.72-22.7-22.1a12 12 0 0 0-17 0L3.53 252a12 12 0 0 0 0 17L51 316.5a12.77 12.77 0 0 0 17.6 0l15.7-15.69 72.2-72.22a12 12 0 0 0 .09-16.9zM64 368c-26.49 0-48.59 21.5-48.59 48S37.53 464 64 464a48 48 0 0 0 0-96z"
                        class="opacity-50" /></svg>
                <svg ref="icon-terminal" class="h-6 w-6 fill-current text-gray-500" viewBox="0 0 640 512">
                    <path
                        d="M640 421.34v32a24 24 0 0 1-24 24H312a24 24 0 0 1-24-24v-32a24 24 0 0 1 24-24h304a24 24 0 0 1 24 24z"
                        class="currentColor" />
                    <path
                        d="M29.7 464.66L7 442a24 24 0 0 1 0-33.9l154-154.76L7 98.6a24 24 0 0 1 0-33.9L29.7 42a24 24 0 0 1 33.94 0L258 236.37a24 24 0 0 1 0 33.94L63.64 464.66a24 24 0 0 1-33.94 0z"
                        class="opacity-50" /></svg>
                <svg ref="icon-times-circle" class="h-6 w-6 fill-current text-gray-500" viewBox="0 0 512 512">
                    <path
                        d="M256 8C119 8 8 119 8 256s111 248 248 248 248-111 248-248S393 8 256 8zm121.6 313.1a12 12 0 0 1 0 17L338 377.6a12 12 0 0 1-17 0L256 312l-65.1 65.6a12 12 0 0 1-17 0L134.4 338a12 12 0 0 1 0-17l65.6-65-65.6-65.1a12 12 0 0 1 0-17l39.6-39.6a12 12 0 0 1 17 0l65 65.7 65.1-65.6a12 12 0 0 1 17 0l39.6 39.6a12 12 0 0 1 0 17L312 256z"
                        class="currentColor" />
                    <path
                        d="M377.6 321.1a12 12 0 0 1 0 17L338 377.6a12 12 0 0 1-17 0L256 312l-65.1 65.6a12 12 0 0 1-17 0L134.4 338a12 12 0 0 1 0-17l65.6-65-65.6-65.1a12 12 0 0 1 0-17l39.6-39.6a12 12 0 0 1 17 0l65 65.7 65.1-65.6a12 12 0 0 1 17 0l39.6 39.6a12 12 0 0 1 0 17L312 256z"
                        class="opacity-50" /></svg>
                <svg ref="icon-toggle-off" class="h-6 w-6 fill-current text-gray-500" viewBox="0 0 576 512">
                    <path
                        d="M384 64H192C86 64 0 150 0 256s86 192 192 192h192c106 0 192-86 192-192S490 64 384 64zM192 384a128 128 0 1 1 128-128 127.93 127.93 0 0 1-128 128z"
                        class="currentColor" />
                    <path d="M192 384a128 128 0 1 1 128-128 127.93 127.93 0 0 1-128 128z" class="opacity-50" /></svg>
                <svg ref="icon-toggle-on" class="h-6 w-6 fill-current text-gray-500" viewBox="0 0 576 512">
                    <path d="M384 384a128 128 0 1 1 128-128 127.93 127.93 0 0 1-128 128z" class="currentColor" />
                    <path
                        d="M384 64H192C86 64 0 150 0 256s86 192 192 192h192c106 0 192-86 192-192S490 64 384 64zm0 320a128 128 0 1 1 128-128 127.93 127.93 0 0 1-128 128z"
                        class="opacity-50" /></svg>
                <svg ref="icon-trash-alt" class="h-6 w-6 fill-current text-gray-500" viewBox="0 0 512 512">
                    <path d="M318.29 488.85A16 16 0 0 1 304 512h-96a16 16 0 0 1-14.31-23.16L224 440.45V384h64v56.45z"
                        class="currentColor" />
                    <path
                        d="M28 356Q0 328 0 288a93.5 93.5 0 0 1 16-53 92.4 92.4 0 0 1 43-35q-14-24-10.5-49.5a79.43 79.43 0 0 1 20.5-44A81.51 81.51 0 0 1 110.5 82q24.5-6 49.5 5 4-37 31.5-62T256 0q37 0 64.5 25T352 87q25-11 49.5-5a81.51 81.51 0 0 1 41.5 24.5 79.43 79.43 0 0 1 20.5 44Q467 176 454 200h-1a92.4 92.4 0 0 1 43 35 93.5 93.5 0 0 1 16 53q0 40-28 68t-68 28H96q-40 0-68-28z"
                        class="opacity-50" /></svg>
                <svg ref="icon-trash" class="h-6 w-6 fill-current text-gray-500" viewBox="0 0 448 512">
                    <path d="M53.2 467L32 96h384l-21.2 371a48 48 0 0 1-47.9 45H101.1a48 48 0 0 1-47.9-45z"
                        class="currentColor" />
                    <path
                        d="M0 80V48a16 16 0 0 1 16-16h120l9.4-18.7A23.72 23.72 0 0 1 166.8 0h114.3a24 24 0 0 1 21.5 13.3L312 32h120a16 16 0 0 1 16 16v32a16 16 0 0 1-16 16H16A16 16 0 0 1 0 80z"
                        class="opacity-50" /></svg>
                <svg ref="icon-user" class="h-6 w-6 fill-current text-gray-500" viewBox="0 0 448 512">
                    <path d="M352 128A128 128 0 1 1 224 0a128 128 0 0 1 128 128z" class="currentColor" />
                    <path
                        d="M313.6 288h-16.7a174.1 174.1 0 0 1-145.8 0h-16.7A134.43 134.43 0 0 0 0 422.4V464a48 48 0 0 0 48 48h352a48 48 0 0 0 48-48v-41.6A134.43 134.43 0 0 0 313.6 288z"
                        class="opacity-50" /></svg>
                <svg ref="icon-users" class="h-6 w-6 fill-current text-gray-500" viewBox="0 0 640 512">
                    <path
                        d="M96 224a64 64 0 1 0-64-64 64.06 64.06 0 0 0 64 64zm480 32h-64a63.81 63.81 0 0 0-45.1 18.6A146.27 146.27 0 0 1 542 384h66a32 32 0 0 0 32-32v-32a64.06 64.06 0 0 0-64-64zm-512 0a64.06 64.06 0 0 0-64 64v32a32 32 0 0 0 32 32h65.9a146.64 146.64 0 0 1 75.2-109.4A63.81 63.81 0 0 0 128 256zm480-32a64 64 0 1 0-64-64 64.06 64.06 0 0 0 64 64z"
                        class="currentColor" />
                    <path
                        d="M396.8 288h-8.3a157.53 157.53 0 0 1-68.5 16c-24.6 0-47.6-6-68.5-16h-8.3A115.23 115.23 0 0 0 128 403.2V432a48 48 0 0 0 48 48h288a48 48 0 0 0 48-48v-28.8A115.23 115.23 0 0 0 396.8 288zM320 256a112 112 0 1 0-112-112 111.94 111.94 0 0 0 112 112z"
                        class="opacity-50" /></svg>
                <svg ref="icon-window-alt" class="h-6 w-6 fill-current text-gray-500" viewBox="0 0 512 512">
                    <path
                        d="M464 32H48A48 48 0 0 0 0 80v80h512V80a48 48 0 0 0-48-48zm-240 96a32 32 0 1 1 32-32 32 32 0 0 1-32 32zm96 0a32 32 0 1 1 32-32 32 32 0 0 1-32 32zm96 0a32 32 0 1 1 32-32 32 32 0 0 1-32 32z"
                        class="currentColor" />
                    <path
                        d="M320 128a32 32 0 1 0-32-32 32 32 0 0 0 32 32zm96 0a32 32 0 1 0-32-32 32 32 0 0 0 32 32zM0 160v272a48 48 0 0 0 48 48h416a48 48 0 0 0 48-48V160z"
                        class="opacity-50" /></svg>
                <svg ref="icon-window" class="h-6 w-6 fill-current text-gray-500" viewBox="0 0 512 512">
                    <path
                        d="M464 32H48A48 48 0 0 0 0 80v80h512V80a48 48 0 0 0-48-48zm-240 96a32 32 0 1 1 32-32 32 32 0 0 1-32 32zm96 0a32 32 0 1 1 32-32 32 32 0 0 1-32 32zm96 0a32 32 0 1 1 32-32 32 32 0 0 1-32 32z"
                        class="currentColor" />
                    <path
                        d="M320 128a32 32 0 1 0-32-32 32 32 0 0 0 32 32zm96 0a32 32 0 1 0-32-32 32 32 0 0 0 32 32zM0 160v272a48 48 0 0 0 48 48h416a48 48 0 0 0 48-48V160z"
                        class="opacity-50" /></svg>
            </div>

            <!--  -->
            <div class="mt-5 max-w-md mx-auto sm:flex sm:justify-center md:mt-8">
                <div class="rounded-full shadow">
                    <a href="#"
                        class="w-full flex items-center justify-center px-8 py-3 border border-transparent text-base leading-6 font-medium rounded-full text-white bg-primary-600 hover:bg-primary-500 focus:outline-none focus:shadow-outline-primary transition duration-150 ease-in-out md:py-4 md:text-lg md:px-10">
                        Enter Pledge
                    </a>
                </div>
                <div class="mt-3 rounded-full shadow sm:mt-0 sm:ml-3">
                    <a href="#"
                        class="w-full flex items-center justify-center px-8 py-3 border border-transparent text-base leading-6 font-medium rounded-full text-primary-600 bg-white hover:text-primary-500 focus:outline-none focus:shadow-outline-blue transition duration-150 ease-in-out md:py-4 md:text-lg md:px-10">
                        Live Demo
                    </a>
                </div>
            </div>

            <!--  -->
            <div class="bg-white overflow-hidden shadow rounded-lg">
                <div class="border-b border-gray-200 px-4 py-5 sm:px-6">
                    <!-- Card Header w/avatar and actions-->
                    <div class="bg-white px-4 py-5 border-b border-gray-200 sm:px-6">
                        <div class="-ml-4 -mt-4 flex justify-between items-center flex-wrap sm:flex-no-wrap">
                            <div class="ml-4 mt-4">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0">
                                        <img src="//www.gravatar.com/avatar/bff5a87e189e209845ed9b042d09e900?s=80&amp;d=retro&amp;r=g"
                                            alt="Avatar" class="h-8 w-8 rounded-full">
                                    </div>
                                    <div class="ml-4">
                                        <h3 class="text-lg leading-6 font-medium text-gray-900">
                                            Victor Tolbert
                                        </h3>
                                        <p class="text-sm leading-5 text-gray-500">
                                            <a href="#">
                                                @design_coder
                                            </a>
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <div class="ml-4 mt-4 flex-shrink-0 flex">
                                <span class="inline-flex rounded-md shadow-sm">
                                    <button type="button"
                                        class="relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm leading-5 font-medium rounded-md text-gray-700 bg-white hover:text-gray-500 focus:outline-none focus:shadow-outline-blue focus:border-blue-300 active:bg-gray-50 active:text-gray-800">
                                        <svg class="-ml-1 mr-2 h-5 w-5 text-gray-500" fill="currentColor"
                                            viewBox="0 0 20 20">
                                            <path
                                                d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z" />
                                        </svg>
                                        <span>
                                            Edit
                                        </span>
                                    </button>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="px-4 py-5 sm:p-6">
                    <!-- Content goes here -->
                </div>
                <div class="border-t border-gray-200 px-4 py-4 sm:px-6">
                    <!-- Content goes here -->
                    <!-- We use less vertical padding on card footers at all sizes than on headers or body sections -->
                </div>
            </div>
        </div>
    </div>
</body>

</html>