<script setup lang="ts">
import type { DateValue } from "@internationalized/date";
import {
    DateFormatter,
    getLocalTimeZone,
    today,
} from "@internationalized/date";

import { CalendarIcon } from "lucide-vue-next";
import { cn } from "@/lib/utils";
import { Calendar } from "@/components/ui/calendar";
import {
    Popover,
    PopoverContent,
    PopoverTrigger,
} from "@/components/ui/popover";
import { ref } from "vue";
import { Button } from "@/components/ui/button";

const defaultPlaceholder = today(getLocalTimeZone());
const date = ref();

const df = new DateFormatter("en-US", {
    dateStyle: "long",
});

const model = defineModel();

defineProps({
    error: String,
});
</script>

<template>
    <Popover v-slot="{ close }">
        <PopoverTrigger as-child>
            <Button
                variant="outline"
                :class="[
                    { 'border-red-500': error },
                    cn(
                        'w-full justify-start text-left font-normal',
                        !date && 'text-muted-foreground',
                    ),
                ]"
            >
                <CalendarIcon />
                {{
                    date
                        ? df.format(date.toDate(getLocalTimeZone()))
                        : "Pick a date"
                }}
            </Button>
        </PopoverTrigger>
        <PopoverContent class="w-auto p-0" align="start">
            <Calendar
                v-model="model"
                :default-placeholder="defaultPlaceholder"
                layout="month-and-year"
                initial-focus
                @update:model-value="close"
            />
        </PopoverContent>
    </Popover>
    <p v-if="error" class="text-sm font-medium text-red-500 italic">
        {{ error }}
    </p>
</template>
