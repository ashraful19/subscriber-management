<template>
    <form
        v-on:submit.prevent="formSubmitHandler"
        class="grid grid-cols-2 gap-y-2 bg-base-100 p-5 pb-6 rounded"
    >
        <div class="grid gap-y-2">
            <div class="form-control w-full">
                <label class="label">
                    <span class="label-text">Name</span>
                </label>
                <div class="grid grid-cols-2 gap-x-2">
                    <input
                        v-model="subscriberForm.name"
                        type="text"
                        placeholder="First Name"
                        class="input input-bordered"
                    />
                    <input
                        v-model="subscriberForm.last_name"
                        type="text"
                        placeholder="Last Name"
                        class="input input-bordered"
                    />
                </div>
            </div>
            <div class="form-control w-full">
                <label class="label">
                    <span class="label-text">Email</span>
                </label>
                <input
                    v-model="subscriberForm.email"
                    type="text"
                    class="input input-bordered"
                />
            </div>
            <div class="form-control w-full">
                <label class="label">
                    <span class="label-text">State</span>
                </label>
                <select v-model="subscriberForm.state" class="select select-bordered w-full">
                    <option v-for="(state, index) in subscriberStates" :key="index" :value="state">{{ state }}</option>
                </select>
            </div>

            <div tabindex="0" class="collapse mt-2 w-full">
                <input type="checkbox" class="!p-0 !min-h-0" />
                <a
                    class="
                        collapse-title
                        text-sm
                        p-0
                        min-h-0
                        underline
                        decoration-solid
                    "
                >
                    Show more fields
                </a>
                <div class="collapse-content px-0 pt-3 grid gap-y-2">
                    <CustomField
                        v-for="(field, index) in fields"
                        :key="index"
                        :field="field"
                        v-model="subscriberForm.fields[field.id]"
                    />
                </div>
            </div>
        </div>
        <div class="px-12 flex items-center">
            <ValidationError :errors="validationErrors" />
        </div>
        <div class="col-span-2 text-center">
            <button
                type="submit"
                class="
                    btn
                    bg-amber-600
                    border-0 border-b-2 border-amber-700
                    hover:bg-amber-600 hover:border-amber-700
                    normal-case
                "
                :class="{ loading: loading }"
            >
                Submit
            </button>
        </div>
    </form>
</template>

<script setup>
import CustomField from "@/components/CustomField.vue";
import ValidationError from "@/components/ValidationError.vue";
import Swal from "sweetalert2";
import { reactive, ref, onMounted, inject } from "vue";
import { useRoute } from "vue-router";

const axios = inject("axios");

const subscriberStates = ref(['active', 'unsubscribed', 'junk', 'bounced', 'unconfirmed']);

const subscriberForm = reactive({ fields: {} });

const props = defineProps({
    operationType: {
        type: String,
        required: true,
    },
});

const route = useRoute();
const updateInit = async () => {
    try {
        let { data: responseData } = await axios.get(
            "subscribers/" + route.params.id + "/edit"
        );
        Object.assign(subscriberForm, responseData.data, {
            fields: responseData.data.fields.reduce(
                (previousValue, currentValue) => {
                    previousValue[currentValue.id] = currentValue.value;
                    return previousValue;
                },
                {}
            ),
        });
        // fields.value = responseData.data;
    } catch (error) {}
};

const formSubmitHandler = async () => {
    if (props.operationType == "create") {
        createSubscriber();
    } else if (props.operationType == "update") {
        updateSubscriber();
    }
};

const fields = ref([]);
const fetchFields = async () => {
    try {
        let { data: responseData } = await axios.get("fields");
        fields.value = responseData.data;
    } catch (error) {}
};

onMounted(() => {
    fetchFields();
    if (props.operationType == "update") {
        updateInit();
    }
});

defineExpose({
    formSubmitHandler,
});

const loading = ref(false);
const validationErrors = ref([]);
const emit = defineEmits(["created", "updated"]);
const createSubscriber = async () => {
    loading.value = true;
    try {
        let { data: responseData } = await axios.post(
            "subscribers",
            subscriberForm
        );
        Swal.fire(
            "Created!",
            "Field has been created successfully.",
            "success"
        );
        emit("created");
    } catch (error) {
        console.log(error);
        if (error.response.status === 422) {
            validationErrors.value = Object.values(
                error.response.data.errors
            ).flat();
        }
    }
    loading.value = false;
};

const updateSubscriber = async () => {
    loading.value = true;
    try {
        let { data: responseData } = await axios.put(
            "subscribers/" + route.params.id,
            subscriberForm
        );
        Swal.fire(
            "Updated!",
            "Field has been updated successfully.",
            "success"
        );
        emit("updated");
    } catch (error) {
        console.log(error);
        if (error.response.status === 422) {
            validationErrors.value = Object.values(
                error.response.data.errors
            ).flat();
        }
    }
    loading.value = false;
};
</script>