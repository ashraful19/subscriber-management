<template>
    <ul class="menu">
        <li>
            <RouterLink :to="{name: 'dashboard'}" class="active:bg-green-700">
                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    class="h-6 w-6"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke="currentColor"
                    stroke-width="2"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M11 3.055A9.001 9.001 0 1020.945 13H11V3.055z"
                    />
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M20.488 9H15V3.512A9.025 9.025 0 0120.488 9z"
                    />
                </svg>
                Dashboard
            </RouterLink>
        </li>
        <li>
            <RouterLink :to="{name: 'subscribers.index'}" class="active:bg-green-700">
                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    class="h-6 w-6"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke="currentColor"
                    stroke-width="2"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"
                    />
                </svg>
                Subscribers
            </RouterLink>
        </li>
        <li>
            <RouterLink :to="{name: 'fields.index'}" class="active:bg-green-700">
                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    class="h-6 w-6"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke="currentColor"
                    stroke-width="2"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"
                    />
                </svg>
                Fields
            </RouterLink>
        </li>
    </ul>
</template>