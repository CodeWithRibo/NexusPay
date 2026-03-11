<script setup lang="ts">
import type { DateValue } from "@internationalized/date";
import {
    DateFormatter,
    getLocalTimeZone,
    today,
} from "@internationalized/date";

import { CalendarIcon } from "lucide-vue-next";
import { cn } from "@/lib/utils";
import { Button } from "@/components/ui/button";
import { Calendar } from "@/components/ui/calendar";
import {
    Popover,
    PopoverContent,
    PopoverTrigger,
} from "@/components/ui/popover";
const defaultPlaceholder = today(getLocalTimeZone());

const df = new DateFormatter("en-US", {
    dateStyle: "long",
});

const model = defineModel<DateValue>();
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
                        !model && 'text-muted-foreground',
                    ),
                ]"
            >
                <CalendarIcon />
                {{
                    model
                        ? df.format(model.toDate(getLocalTimeZone()))
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
        <p v-if="error" class="text-sm font-medium text-red-500 italic">
            {{ error }}
        </p>
    </Popover>
</template>
