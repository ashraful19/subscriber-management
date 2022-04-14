<template>
    <div class="w-full bg-base-100 border-b-2 border-gray-200">
        <div class="py-5 flex justify-between max-w-7xl mx-auto items-center">
            <h1 class="text-xl font-bold">Fields</h1>
            <label
                v-on:click="operationType = 'create'"
                for="field-modal"
                class="
                    btn
                    bg-amber-600
                    border-0 border-b-2 border-amber-700
                    hover:bg-amber-600 hover:border-amber-700
                    normal-case
                "
                >Add New Field</label
            >
        </div>
    </div>
    <div class="w-full bg-base-200 min-h-screen">
        <div class="py-5 flex justify-center max-w-7xl mx-auto">
            <div class="overflow-x-auto w-full">
                <table class="table w-full">
                    <!-- head -->
                    <thead>
                        <tr>
                            <th>Title</th>
                            <th>Type</th>
                            <th>Tag</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(field, index) in fields" :key="index">
                            <td>{{ field.title }}</td>
                            <td>{{ field.type }}</td>
                            <td>{{ field.tag }}</td>
                            <td align="right">
                                <div class="flex justify-center gap-x-4">
                                    <label
                                        v-on:click="
                                            () => {
                                                Object.assign(fieldForm, field);
                                                operationType = 'update';
                                            }
                                        "
                                        for="field-modal"
                                        class="btn btn-gray btn-sm"
                                        >Rename</label
                                    >
                                    <button
                                        v-on:click.prevent="
                                            deleteField(field, index)
                                        "
                                        class="btn btn-gray btn-sm"
                                    >
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
                                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"
                                            />
                                        </svg>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        <tr v-if="fields.length == 0">
                            <td colspan="4" align="center">No Fields</td>
                        </tr>
                    </tbody>
                    <tfoot>
                        <tr>
                            <th>Title</th>
                            <th>Type</th>
                            <th>Tag</th>
                            <th></th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>

    <!-- Put this part before </body> tag -->
    <input
        v-model="fieldModalState"
        type="checkbox"
        id="field-modal"
        class="modal-toggle"
    />
    <div class="modal modal-bottom sm:modal-middle">
        <div class="modal-box">
            <h3 class="font-bold text-lg pb-3 border-b-2">
                {{
                    operationType.charAt(0).toUpperCase() +
                    operationType.slice(1)
                }}
                Field
            </h3>
            <form
                v-on:submit.prevent="fieldFormSubmitHandler"
                class="mt-4 w-full grid gap-y-4"
            >
                <ValidationError :errors="validationErrors" />
                <input
                    v-model="fieldForm.title"
                    type="text"
                    placeholder="Title"
                    class="input input-bordered w-full max-w-lg"
                />
                <select
                    v-if="operationType == 'create'"
                    v-model="fieldForm.type"
                    class="select select-bordered w-full max-w-lg"
                >
                    <option :value="undefined" disabled>Select type</option>
                    <option
                        v-for="(type, index) in fieldTypes"
                        :key="index"
                        :value="type"
                    >
                        {{ type }}
                    </option>
                </select>
            </form>
            <div class="modal-action pt-3 border-t-2">
                <button
                    v-on:click.prevent="fieldFormSubmitHandler"
                    class="btn btn-green"
                    :class="{ loading: fieldModalLoading }"
                >
                    Save
                </button>
                <label for="field-modal" class="btn btn-gray">Cancel</label>
            </div>
        </div>
    </div>
</template>

<script setup>
import ValidationError from "@/components/ValidationError.vue";
import Swal from "sweetalert2";
import { reactive, ref, onMounted, inject, watch } from "vue";

const axios = inject("axios");

const fields = ref([]);

const fieldTypes = ref(["date", "number", "string", "boolean"]);
const fieldModalState = ref(false);
const validationErrors = ref([]);

const fieldForm = reactive({});

const operationType = ref("");
const fieldModalLoading = ref(false);

const fieldFormSubmitHandler = async () => {
    validationErrors.value = [];
    fieldModalLoading.value = true;
    if (operationType.value == "create") {
        await createField();
    } else if (operationType.value == "update") {
        await updateField();
    }
    fieldModalLoading.value = false;
};

const createField = async () => {
    try {
        let { data: responseData } = await axios.post("fields", fieldForm);
        fields.value.push(responseData.data);
        fieldModalState.value = false;
        Swal.fire("Created!", "Field has been created successfully.", "success");
    } catch (error) {
        if (error.response.status === 422) {
            validationErrors.value = Object.values(
                error.response.data.errors
            ).flat();
        }
    }
};
const updateField = async () => {
    try {
        let { data: responseData } = await axios.patch(
            "fields/" + fieldForm.id,
            fieldForm
        );
        let itemIndex = fields.value.findIndex(
            (field) => field.id == fieldForm.id
        );
        fields.value.splice(itemIndex, 1, responseData.data);
        fieldModalState.value = false;
        Swal.fire("Updated!", "Field has been updated successfully.", "success");
    } catch (error) {
        if (error.response.status === 422) {
            validationErrors.value = Object.values(
                error.response.data.errors
            ).flat();
        }
    }
};

const deleteField = (field, index) => {
    Swal.fire({
        title: "Please Confirm",
        text: 'Do you really want to delete "' + field.title + '" field ?',
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#e74c3c",
        cancelButtonColor: "#ccc",
        confirmButtonText: "Delete",
    }).then(async (result) => {
        if (result.isConfirmed) {
            try {
                let { data: responseData } = await axios.delete('fields/' + field.id);
                if(responseData.status){
                    fields.value.splice(index, 1);
                    Swal.fire("Deleted!", "Field has been deleted successfully.", "success");
                }
            } catch (error) {}
        }
    });
};

const fetchFields = async () => {
    try {
        let { data: responseData } = await axios.get("fields");
        fields.value = responseData.data;
    } catch (error) {}
};
onMounted(() => {
    fetchFields();
});

watch(fieldModalState, (currentValue, oldValue) => {
    if (!currentValue) {
        fieldModalClosed();
    }
});

const fieldModalClosed = () => {
    operationType.value = "";
    fieldModalLoading.value = false;
    validationErrors.value = [];
    fieldModalLoading.value = false;

    Object.keys(fieldForm).forEach(key => delete fieldForm[key]);
};
</script>