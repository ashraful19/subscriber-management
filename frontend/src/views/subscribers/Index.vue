<template>
    <div class="w-full bg-base-100 border-b-2 border-gray-200">
        <div class="py-5 flex justify-between max-w-7xl mx-auto items-center">
            <h1 class="text-xl font-bold">Subscribers</h1>
            <div class="flex gap-x-2">
                <div class="dropdown">
                    <label tabindex="0" class="btn btn-gray normal-case">
                        Toggle columns
                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            class="h-5 w-5"
                            viewBox="0 0 20 20"
                            fill="currentColor"
                        >
                            <path
                                fill-rule="evenodd"
                                d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                clip-rule="evenodd"
                            />
                        </svg>
                    </label>
                    <ul
                        tabindex="0"
                        class="
                            dropdown-content
                            menu
                            p-2
                            shadow
                            bg-base-100
                            rounded-box
                            w-52
                        "
                    >
                        <li v-for="(field, index) in fields" :key="index">
                            <div class="form-control items-start active:bg-green-100">
                                <label class="label cursor-pointer">
                                    <input
                                        v-model="field.selected"
                                        type="checkbox"
                                        class="checkbox"
                                    />
                                    <span class="label-text pl-2">{{ field.title }}</span>
                                </label>
                            </div>
                        </li>
                    </ul>
                </div>
                <RouterLink
                    :to="{ name: 'subscribers.create' }"
                    class="
                        btn
                        bg-amber-600
                        border-0 border-b-2 border-amber-700
                        hover:bg-amber-600 hover:border-amber-700
                        normal-case
                    "
                    >Add Subscriber</RouterLink
                >
            </div>
        </div>
    </div>
    <div class="w-full bg-base-200 min-h-screen">
        <div class="py-5 flex justify-center max-w-7xl mx-auto">
            <div class="overflow-x-auto w-full">
                <table class="table w-full">
                    <!-- head -->
                    <thead>
                        <tr>
                            <th>Email</th>
                            <th>Name</th>
                            <th>State</th>
                            <th>Subscribed</th>
                            <template v-for="(field, index) in fields">
                                <th v-if="field.selected">{{ field.title }}</th>
                            </template>
                        </tr>
                    </thead>
                    <tbody>
                        <tr
                            v-for="(subscriber, index) in subscribers"
                            :key="index"
                        >
                            <td class="sticky left-0 z-10">
                                <RouterLink
                                    :to="{
                                        name: 'subscribers.edit',
                                        params: { id: subscriber.id },
                                    }"
                                    class="
                                        text-green-500
                                        hover:underline hover:decoration-solid
                                    "
                                    >{{ subscriber.email }}</RouterLink
                                >
                                <div class="flex justify-start gap-x-1 mt-1">
                                    <button
                                        v-on:click.prevent="deleteSubscriber(subscriber, index)"
                                        class="
                                            btn btn-xs btn-error
                                            text-base-100
                                        "
                                    >
                                        <svg
                                            xmlns="http://www.w3.org/2000/svg"
                                            class="h-4 w-4"
                                            fill="none"
                                            viewBox="0 0 24 24"
                                            stroke="currentColor"
                                            stroke-width="2"
                                        >
                                            <path
                                                stroke-linecap="round"
                                                stroke-linejoin="round"
                                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"
                                            />
                                        </svg>
                                    </button>
                                    <RouterLink
                                        :to="{
                                            name: 'subscribers.edit',
                                            params: { id: subscriber.id },
                                        }"
                                        class="btn btn-xs btn-gray"
                                    >
                                        <svg
                                            xmlns="http://www.w3.org/2000/svg"
                                            class="h-4 w-4"
                                            fill="none"
                                            viewBox="0 0 24 24"
                                            stroke="currentColor"
                                            stroke-width="2"
                                        >
                                            <path
                                                stroke-linecap="round"
                                                stroke-linejoin="round"
                                                d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"
                                            />
                                        </svg>
                                        Edit</RouterLink
                                    >
                                </div>
                            </td>
                            <td>{{ subscriber.full_name }}</td>
                            <td>{{ subscriber.state }}</td>
                            <td>{{ subscriber.created_at }}</td>
                            <template v-for="(field, index) in fields">
                                <td v-if="field.selected">{{ subscriber.fields[field.id] ? subscriber.fields[field.id].value : '--' }}</td>
                            </template>
                        </tr>
                        <tr v-if="subscribers.length == 0">
                            <td colspan="4" align="center">No Subscribers</td>
                        </tr>
                    </tbody>
                    <!-- foot -->
                    <tfoot>
                        <tr>
                            <th>Email</th>
                            <th>Name</th>
                            <th>Subscribed</th>
                            <template v-for="(field, index) in fields">
                                <th v-if="field.selected">{{ field.title }}</th>
                            </template>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
</template>

<script setup>
import Swal from "sweetalert2";
import { ref, onMounted, inject } from "vue";

const axios = inject("axios");

const fields = ref([]);
const fetchFields = async () => {
    try {
        let { data: responseData } = await axios.get("fields");
        fields.value = responseData.data.map(element => ({...element, selected: false}));
    } catch (error) {}
};

const subscribers = ref([]);
const fetchSubscribers = async () => {
    try {
        let { data: responseData } = await axios.get("subscribers");
        subscribers.value = responseData.data.map(subscriber => {
            subscriber.fields = subscriber.fields.reduce((previousValue, currentValue) => {
                previousValue[currentValue.id] = currentValue;
                return previousValue;
            }, {});
            return subscriber;
        });
    } catch (error) {
        console.log(error);
    }
};
onMounted(() => {
    fetchSubscribers();
    fetchFields();
});

const deleteSubscriber = (subscriber, index) => {
    Swal.fire({
        title: "Please Confirm",
        text:
            'Do you really want to delete "' +
            subscriber.name +
            '" subscriber ?',
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#e74c3c",
        cancelButtonColor: "#ccc",
        confirmButtonText: "Delete",
    }).then(async (result) => {
        if (result.isConfirmed) {
            try {
                let { data: responseData } = await axios.delete(
                    "subscribers/" + subscriber.id
                );
                if (responseData.status) {
                    subscribers.value.splice(index, 1);
                    Swal.fire(
                        "Deleted!",
                        "Subscriber has been deleted successfully.",
                        "success"
                    );
                }
            } catch (error) {}
        }
    });
};
</script>