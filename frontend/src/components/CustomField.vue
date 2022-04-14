<template>
    <div
        v-if="['string', 'number', 'date'].includes(props.field.type)"
        class="form-control w-full"
    >
        <label class="label">
            <span class="label-text">{{ props.field.title }}</span>
        </label>
        <input
            v-if="props.field.type == 'number'"
            type="number"
            class="input input-bordered"
            v-model="fieldValue"
            @keypress="isNumber"
            step="any"
        />
        <Datepicker
            v-else-if="props.field.type == 'date'"
            altPosition
            autoApply
            v-model="fieldValue"
            format="yyyy-MM-dd"
        ></Datepicker>
        <input
            v-else
            type="text"
            class="input input-bordered"
            v-model="fieldValue"
        />
    </div>
    <div v-else-if="props.field.type == 'boolean'" class="form-control">
        <label class="label cursor-pointer justify-start">
            <input
                type="checkbox"
                class="toggle toggle-accent"
                v-model="fieldValue"
                :true-value="1"
                :false-value="0"
            />
            <span class="label-text pl-2">{{ props.field.title }}</span>
        </label>
    </div>
</template>

<script setup>
import { computed } from "vue";

const props = defineProps({
    field: {
        type: Object,
        required: true,
    },
    modelValue: {
        type: [String, Number],
        default: "",
    },
});

const emit = defineEmits(["update:modelValue"]);

const fieldValue = computed({
    get() {
        return props.modelValue;
    },
    set(value) {
        if (props.field.type == "date") {
            return emit(
                "update:modelValue",
                value.getFullYear() +
                    "-" +
                    ("0" + (value.getMonth() + 1)).slice(-2) +
                    "-" +
                    ("0" + value.getDate()).slice(-2)
            );
        }
        return emit("update:modelValue", value);
    },
});

const isNumber = ($event) => {
    let keyCode = $event.keyCode ? $event.keyCode : $event.which;
    if ((keyCode < 48 || keyCode > 57) && keyCode !== 46) {
        // 46 is dot
        $event.preventDefault();
    }
};
</script>