<script setup>
import NavMenu from "@/components/layouts/NavMenu.vue";
</script>
<template>
    <div class="navbar bg-green-600 text-neutral-content lg:px-5">
        <div class="navbar-start">
            <div class="dropdown">
                <label tabindex="0" class="btn btn-ghost lg:hidden">
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        class="h-5 w-5"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke="currentColor"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M4 6h16M4 12h8m-8 6h16"
                        />
                    </svg>
                </label>
                <NavMenu
                    tabindex="0"
                    class="
                        menu-compact
                        dropdown-content
                        mt-3
                        p-2
                        shadow
                        bg-green-600
                        rounded-box
                        w-52
                    "
                />
            </div>
            <RouterLink :to="{name: 'dashboard'}" class="btn btn-ghost normal-case text-xl hidden lg:flex">Subscriber Management</RouterLink>
            <RouterLink :to="{name: 'dashboard'}" class="btn btn-ghost normal-case text-xl lg:hidden">Subscriber Manage.</RouterLink>
        </div>
        <div class="navbar-end hidden lg:flex">
            <NavMenu class="menu-horizontal p-0" />
        </div>
    </div>
</template>