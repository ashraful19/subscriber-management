<template>
    <div class="w-full bg-base-100 border-b-2 border-gray-200">
        <div class="py-5 flex justify-between max-w-7xl mx-auto items-center">
            <h1 class="text-xl font-bold">Create new subscriber</h1>
            <div class="flex gap-x-2">
                <button
                    v-on:click.prevent="$refs.subscriberCreateForm.formSubmitHandler"
                    class="
                        btn
                        bg-amber-600
                        border-0 border-b-2 border-amber-700
                        hover:bg-amber-600 hover:border-amber-700
                        normal-case
                    "
                >
                    Submit
                </button>
                <RouterLink
                    :to="{ name: 'subscribers.index' }"
                    class="btn btn-gray"
                    >Cancel</RouterLink
                >
            </div>
        </div>
    </div>
    <div class="w-full bg-base-200 min-h-screen">
        <div class="py-5 max-w-7xl mx-auto">
            <h1 class="text-xl font-bold mb-4">Subscriber Details</h1>
            <SubscriberCreateEditForm
                operationType="create"
                ref="subscriberCreateForm"
                @created="created"
            />
        </div>
    </div>
</template>

<script setup>
import SubscriberCreateEditForm from "../../components/SubscriberCreateEditForm.vue";
import { useRouter } from "vue-router";

const router = useRouter();
const created = () => {
    router.push({name: 'subscribers.index'});
};
</script>